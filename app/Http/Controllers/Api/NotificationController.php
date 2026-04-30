<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Notification::where('user_id', Auth::id());

        // Filter by type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filter by priority
        if ($request->has('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter by read status
        if ($request->has('is_read')) {
            $query->where('is_read', $request->boolean('is_read'));
        }

        $notifications = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json($notifications);
    }

    public function store(Request $request)
    {
        // This would typically be used by system to create notifications
        // For manual notification creation (admin feature)
        if (!Auth::user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'type' => 'required|in:task,deadline,message,evaluation,system,project',
            'priority' => 'required|in:low,medium,high,urgent',
            'action_url' => 'nullable|url',
            'data' => 'nullable|array',
        ]);

        $notification = Notification::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->type,
            'priority' => $request->priority,
            'action_url' => $request->action_url,
            'data' => $request->data,
        ]);

        return response()->json([
            'message' => 'Notification created successfully',
            'notification' => $notification
        ], 201);
    }

    public function show(Notification $notification)
    {
        // Check if notification belongs to user
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($notification);
    }

    public function update(Request $request, Notification $notification)
    {
        // Check if notification belongs to user
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'is_read' => 'required|boolean',
        ]);

        $notification->update([
            'is_read' => $request->is_read,
            'read_at' => $request->is_read ? now() : null,
        ]);

        return response()->json([
            'message' => 'Notification updated successfully',
            'notification' => $notification->fresh()
        ]);
    }

    public function destroy(Notification $notification)
    {
        // Check if notification belongs to user
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->delete();

        return response()->json(['message' => 'Notification deleted successfully']);
    }

    public function unread()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->unread()
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($notifications);
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return response()->json(['message' => 'All notifications marked as read']);
    }

    public function markAsRead(Notification $notification)
    {
        // Check if notification belongs to user
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return response()->json(['message' => 'Notification marked as read']);
    }

    public function getUnreadCount()
    {
        $count = Notification::where('user_id', Auth::id())
            ->unread()
            ->count();

        return response()->json(['unread_count' => $count]);
    }
}
