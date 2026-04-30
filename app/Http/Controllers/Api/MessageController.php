<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $query = Message::with(['sender', 'receiver', 'group']);

        // Filter by type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filter by user (sent or received)
        if ($request->has('user_id')) {
            $query->where(function ($q) use ($request) {
                $q->where('sender_id', $request->user_id)
                  ->orWhere('receiver_id', $request->user_id);
            });
        }

        $messages = $query->orderBy('created_at', 'desc')->paginate(50);

        return response()->json($messages);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receiver_id' => 'nullable|exists:users,id',
            'group_id' => 'nullable|exists:groups,id',
            'content' => 'required|string|max:2000',
            'type' => 'nullable|in:text,file,image,system',
            'attachments' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Validate that either receiver_id or group_id is provided
        if (!$request->receiver_id && !$request->group_id) {
            return response()->json(['error' => 'Either receiver_id or group_id is required'], 422);
        }

        // Check if user is member of group if sending to group
        if ($request->group_id) {
            $group = Group::findOrFail($request->group_id);
            $isMember = $group->activeMembers()->where('user_id', Auth::id())->exists();
            if (!$isMember) {
                return response()->json(['error' => 'You are not a member of this group'], 403);
            }
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'group_id' => $request->group_id,
            'content' => $request->content,
            'type' => $request->type ?? 'text',
            'attachments' => $request->attachments,
            'message_id' => Str::uuid(),
        ]);

        // Create notification for receiver
        if ($request->receiver_id && $request->receiver_id !== Auth::id()) {
            $receiver = \App\Models\User::find($request->receiver_id);
            $receiver->notifications()->create([
                'title' => 'New Message',
                'message' => "You have a new message from {$message->sender->full_name}",
                'type' => 'message',
                'action_url' => "/messages/{$message->id}",
            ]);
        }

        // Create notifications for group members
        if ($request->group_id) {
            $group = Group::find($request->group_id);
            foreach ($group->activeMembers as $member) {
                if ($member->user_id !== Auth::id()) {
                    $member->user->notifications()->create([
                        'title' => 'New Group Message',
                        'message' => "New message in group {$group->name}",
                        'type' => 'message',
                        'action_url' => "/groups/{$group->id}/messages",
                    ]);
                }
            }
        }

        activity()
            ->causedBy(Auth::user())
            ->performedOn($message)
            ->log('Sent message');

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => $message->load(['sender', 'receiver', 'group'])
        ], 201);
    }

    public function show(Message $message)
    {
        // Check if user has permission to view this message
        $isAuthorized = $message->sender_id === Auth::id() || 
                       $message->receiver_id === Auth::id() ||
                       ($message->group_id && $message->group->activeMembers()->where('user_id', Auth::id())->exists());

        if (!$isAuthorized) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message->load(['sender', 'receiver', 'group']);

        return response()->json($message);
    }

    public function conversations()
    {
        // Get all conversations for the current user
        $conversations = Message::where(function ($query) {
                $query->where('sender_id', Auth::id())
                      ->orWhere('receiver_id', Auth::id());
            })
            ->whereNull('group_id') // Only direct messages
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($message) {
                return $message->sender_id === Auth::id() 
                    ? $message->receiver_id 
                    : $message->sender_id;
            })
            ->map(function ($messages) {
                return $messages->first();
            })
            ->values();

        return response()->json($conversations);
    }

    public function conversation($userId)
    {
        $messages = Message::betweenUsers(Auth::id(), $userId)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        Message::where('receiver_id', Auth::id())
            ->where('sender_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:2000',
            'type' => 'nullable|in:text,file,image,system',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
            'type' => $request->type ?? 'text',
            'message_id' => Str::uuid(),
        ]);

        // Create notification
        $receiver = \App\Models\User::find($request->receiver_id);
        $receiver->notifications()->create([
            'title' => 'New Message',
            'message' => "You have a new message from {$message->sender->full_name}",
            'type' => 'message',
            'action_url' => "/messages/conversation/{$Auth::id()}",
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($message)
            ->log('Sent direct message');

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => $message->load(['sender', 'receiver'])
        ], 201);
    }

    public function groupMessages(Group $group)
    {
        // Check if user is member of group
        $isMember = $group->activeMembers()->where('user_id', Auth::id())->exists();
        if (!$isMember) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $messages = $group->messages()
            ->with(['sender'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    public function sendGroupMessage(Request $request, Group $group)
    {
        // Check if user is member of group
        $isMember = $group->activeMembers()->where('user_id', Auth::id())->exists();
        if (!$isMember) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:2000',
            'type' => 'nullable|in:text,file,image,system',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'group_id' => $group->id,
            'content' => $request->content,
            'type' => $request->type ?? 'text',
            'message_id' => Str::uuid(),
        ]);

        // Create notifications for group members
        foreach ($group->activeMembers as $member) {
            if ($member->user_id !== Auth::id()) {
                $member->user->notifications()->create([
                    'title' => 'New Group Message',
                    'message' => "New message in group {$group->name}",
                    'type' => 'message',
                    'action_url' => "/groups/{$group->id}/messages",
                ]);
            }
        }

        activity()
            ->causedBy(Auth::user())
            ->performedOn($message)
            ->log('Sent group message');

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => $message->load(['sender', 'group'])
        ], 201);
    }

    public function markAsRead(Message $message)
    {
        // Check if user is receiver
        if ($message->receiver_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return response()->json(['message' => 'Message marked as read']);
    }
}
