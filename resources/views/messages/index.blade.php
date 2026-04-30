@extends('layouts.app')

@section('title', 'Messages - GPTFMS')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Messages</h1>
            <p class="text-gray-500">Communicate with your team and groups</p>
        </div>
        <div class="flex space-x-3">
            <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span>Inbox</span>
            </button>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>New Message</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Conversations List -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow">
                <div class="p-4 border-b border-gray-200">
                    <div class="relative">
                        <input type="text" placeholder="Search conversations..." 
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="divide-y divide-gray-200">
                    <!-- Conversation 1 -->
                    <div class="p-4 hover:bg-gray-50 cursor-pointer border-l-4 border-blue-500 bg-blue-50">
                        <div class="flex items-start space-x-3">
                            <img src="https://picsum.photos/seed/user1/40/40.jpg" alt="John" class="w-10 h-10 rounded-full">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900 truncate">John Doe</p>
                                    <span class="text-xs text-gray-500">2:30 PM</span>
                                </div>
                                <p class="text-sm text-gray-600 truncate">Hey, can you review the project proposal?</p>
                                <div class="flex items-center mt-1">
                                    <span class="text-xs text-gray-500">Web Development Squad</span>
                                    <span class="w-2 h-2 bg-blue-500 rounded-full ml-2"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Conversation 2 -->
                    <div class="p-4 hover:bg-gray-50 cursor-pointer">
                        <div class="flex items-start space-x-3">
                            <img src="https://picsum.photos/seed/user2/40/40.jpg" alt="Jane" class="w-10 h-10 rounded-full">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900 truncate">Jane Smith</p>
                                    <span class="text-xs text-gray-500">1:45 PM</span>
                                </div>
                                <p class="text-sm text-gray-600 truncate">The meeting has been rescheduled to 3 PM</p>
                                <div class="flex items-center mt-1">
                                    <span class="text-xs text-gray-500">Data Science Research</span>
                                    <span class="w-2 h-2 bg-green-500 rounded-full ml-2"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Conversation 3 -->
                    <div class="p-4 hover:bg-gray-50 cursor-pointer">
                        <div class="flex items-start space-x-3">
                            <img src="https://picsum.photos/seed/user3/40/40.jpg" alt="Mike" class="w-10 h-10 rounded-full">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900 truncate">Mike Johnson</p>
                                    <span class="text-xs text-gray-500">11:30 AM</span>
                                </div>
                                <p class="text-sm text-gray-600 truncate">Thanks for the update on the project timeline</p>
                                <div class="flex items-center mt-1">
                                    <span class="text-xs text-gray-500">Mobile App Team</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Conversation 4 -->
                    <div class="p-4 hover:bg-gray-50 cursor-pointer">
                        <div class="flex items-start space-x-3">
                            <img src="https://picsum.photos/seed/user4/40/40.jpg" alt="Sarah" class="w-10 h-10 rounded-full">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900 truncate">Sarah Davis</p>
                                    <span class="text-xs text-gray-500">Yesterday</span>
                                </div>
                                <p class="text-sm text-gray-600 truncate">Can you send me the latest design mockups?</p>
                                <div class="flex items-center mt-1">
                                    <span class="text-xs text-gray-500">E-commerce Platform</span>
                                    <span class="w-2 h-2 bg-yellow-500 rounded-full ml-2"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Conversation 5 -->
                    <div class="p-4 hover:bg-gray-50 cursor-pointer">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900 truncate">Web Development Squad</p>
                                    <span class="text-xs text-gray-500">2 days ago</span>
                                </div>
                                <p class="text-sm text-gray-600 truncate">Alice: I've completed the frontend changes</p>
                                <div class="flex items-center mt-1">
                                    <span class="text-xs text-gray-500">Group Chat</span>
                                    <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full ml-2">3</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow h-[600px] flex flex-col">
                <!-- Chat Header -->
                <div class="p-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <img src="https://picsum.photos/seed/user1/40/40.jpg" alt="John" class="w-10 h-10 rounded-full">
                            <div>
                                <p class="text-sm font-medium text-gray-900">John Doe</p>
                                <p class="text-xs text-gray-500">Web Development Squad</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="p-2 text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </button>
                            <button class="p-2 text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </button>
                            <button class="p-2 text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Messages -->
                <div class="flex-1 overflow-y-auto p-4 space-y-4">
                    <!-- Received Message -->
                    <div class="flex items-start space-x-3">
                        <img src="https://picsum.photos/seed/user1/32/32.jpg" alt="John" class="w-8 h-8 rounded-full">
                        <div class="max-w-xs">
                            <div class="bg-gray-100 rounded-lg p-3">
                                <p class="text-sm text-gray-900">Hey, can you review the project proposal when you get a chance?</p>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">2:30 PM</p>
                        </div>
                    </div>

                    <!-- Sent Message -->
                    <div class="flex items-start space-x-3 justify-end">
                        <div class="max-w-xs">
                            <div class="bg-blue-600 text-white rounded-lg p-3">
                                <p class="text-sm">Sure! I'll take a look at it right now. Is there anything specific you'd like me to focus on?</p>
                            </div>
                            <p class="text-xs text-gray-500 mt-1 text-right">2:32 PM</p>
                        </div>
                    </div>

                    <!-- Received Message -->
                    <div class="flex items-start space-x-3">
                        <img src="https://picsum.photos/seed/user1/32/32.jpg" alt="John" class="w-8 h-8 rounded-full">
                        <div class="max-w-xs">
                            <div class="bg-gray-100 rounded-lg p-3">
                                <p class="text-sm text-gray-900">Mainly the technical requirements and timeline. I want to make sure we're not overcommitting.</p>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">2:33 PM</p>
                        </div>
                    </div>

                    <!-- Sent Message -->
                    <div class="flex items-start space-x-3 justify-end">
                        <div class="max-w-xs">
                            <div class="bg-blue-600 text-white rounded-lg p-3">
                                <p class="text-sm">Got it. I'll pay special attention to those areas and give you my feedback within the hour.</p>
                            </div>
                            <p class="text-xs text-gray-500 mt-1 text-right">2:35 PM</p>
                        </div>
                    </div>

                    <!-- Received Message -->
                    <div class="flex items-start space-x-3">
                        <img src="https://picsum.photos/seed/user1/32/32.jpg" alt="John" class="w-8 h-8 rounded-full">
                        <div class="max-w-xs">
                            <div class="bg-gray-100 rounded-lg p-3">
                                <p class="text-sm text-gray-900">Thanks! I really appreciate your help with this.</p>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">2:36 PM</p>
                        </div>
                    </div>

                    <!-- Typing Indicator -->
                    <div class="flex items-start space-x-3">
                        <img src="https://picsum.photos/seed/user1/32/32.jpg" alt="John" class="w-8 h-8 rounded-full">
                        <div class="bg-gray-100 rounded-lg p-3">
                            <div class="flex space-x-1">
                                <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce"></div>
                                <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                                <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Message Input -->
                <div class="p-4 border-t border-gray-200">
                    <div class="flex items-center space-x-2">
                        <button class="p-2 text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                            </svg>
                        </button>
                        <input type="text" placeholder="Type a message..." 
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button class="p-2 text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1a4 4 0 015.656 5.656l-1.414 1.414a4 4 0 01-5.656 0l-1.414-1.414A4 4 0 0110 10v1a4 4 0 01-.172 3.828"/>
                            </svg>
                        </button>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Message Modal -->
    <div id="new-message-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">New Message</h3>
            </div>
            <div class="p-6">
                <form class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">To</label>
                        <input type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Search for users or groups">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                        <input type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Enter subject">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                        <textarea class="w-full border border-gray-300 rounded-lg px-3 py-2" rows="6" placeholder="Type your message here"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Attachments</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                            <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="text-sm text-gray-600">Drop files here or click to browse</p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="p-6 border-t border-gray-200 flex justify-end space-x-3">
                <button onclick="closeNewMessageModal()" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Send Message</button>
            </div>
        </div>
    </div>
</div>

<script>
function openNewMessageModal() {
    document.getElementById('new-message-modal').classList.remove('hidden');
}

function closeNewMessageModal() {
    document.getElementById('new-message-modal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('new-message-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeNewMessageModal();
    }
});
</script>
@endsection
