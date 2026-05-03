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
                <div class="conversations-list divide-y divide-gray-200">
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
                            <div class="chat-header-avatar">
                                <img src="https://picsum.photos/seed/user1/40/40.jpg" alt="John" class="w-10 h-10 rounded-full">
                            </div>
                            <div>
                                <p class="chat-header-name text-sm font-medium text-gray-900">John Doe</p>
                                <p class="chat-header-group text-xs text-gray-500">Web Development Squad</p>
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
                <div class="chat-area flex-1 overflow-y-auto p-4 space-y-4">
                    <div class="messages-container">
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
                               class="message-input flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button class="p-2 text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1a4 4 0 015.656 5.656l-1.414 1.414a4 4 0 01-5.656 0l-1.414-1.414A4 4 0 0110 10v1a4 4 0 01-.172 3.828"/>
                            </svg>
                        </button>
                        <button class="send-button px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
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
// Messages functionality
let currentConversation = 1;
let conversations = [
    {
        id: 1,
        name: 'John Doe',
        avatar: 'https://picsum.photos/seed/user1/40/40.jpg',
        group: 'Web Development Squad',
        lastMessage: 'Hey, can you review the project proposal?',
        time: '2:30 PM',
        unread: 0,
        online: true,
        messages: [
            { id: 1, sender: 'John', text: 'Hey, can you review the project proposal when you get a chance?', time: '2:30 PM', sent: false },
            { id: 2, sender: 'You', text: 'Sure! I\'ll take a look at it right now. Is there anything specific you\'d like me to focus on?', time: '2:32 PM', sent: true },
            { id: 3, sender: 'John', text: 'Mainly the technical requirements and timeline. I want to make sure we\'re not overcommitting.', time: '2:33 PM', sent: false },
            { id: 4, sender: 'You', text: 'Got it. I\'ll pay special attention to those areas and give you my feedback within the hour.', time: '2:35 PM', sent: true },
            { id: 5, sender: 'John', text: 'Thanks! I really appreciate your help with this.', time: '2:36 PM', sent: false }
        ]
    },
    {
        id: 2,
        name: 'Jane Smith',
        avatar: 'https://picsum.photos/seed/user2/40/40.jpg',
        group: 'Data Science Research',
        lastMessage: 'The meeting has been rescheduled to 3 PM',
        time: '1:45 PM',
        unread: 2,
        online: true,
        messages: [
            { id: 1, sender: 'Jane', text: 'The meeting has been rescheduled to 3 PM', time: '1:45 PM', sent: false }
        ]
    },
    {
        id: 3,
        name: 'Mike Johnson',
        avatar: 'https://picsum.photos/seed/user3/40/40.jpg',
        group: 'Mobile App Team',
        lastMessage: 'Thanks for the update on the project timeline',
        time: '11:30 AM',
        unread: 0,
        online: false,
        messages: [
            { id: 1, sender: 'Mike', text: 'Thanks for the update on the project timeline', time: '11:30 AM', sent: false }
        ]
    },
    {
        id: 4,
        name: 'Sarah Davis',
        avatar: 'https://picsum.photos/seed/user4/40/40.jpg',
        group: 'E-commerce Platform',
        lastMessage: 'Can you send me the latest design mockups?',
        time: 'Yesterday',
        unread: 0,
        online: false,
        messages: [
            { id: 1, sender: 'Sarah', text: 'Can you send me the latest design mockups?', time: 'Yesterday', sent: false }
        ]
    },
    {
        id: 5,
        name: 'Alice Wilson',
        avatar: 'https://picsum.photos/seed/user5/40/40.jpg',
        group: 'UI/UX Design Team',
        lastMessage: 'The new designs are ready for review',
        time: '10:15 AM',
        unread: 1,
        online: true,
        messages: [
            { id: 1, sender: 'Alice', text: 'The new designs are ready for review', time: '10:15 AM', sent: false }
        ]
    },
    {
        id: 6,
        name: 'Bob Chen',
        avatar: 'https://picsum.photos/seed/user6/40/40.jpg',
        group: 'Backend Development',
        lastMessage: 'API endpoints are now live',
        time: '9:30 AM',
        unread: 0,
        online: true,
        messages: [
            { id: 1, sender: 'Bob', text: 'API endpoints are now live', time: '9:30 AM', sent: false }
        ]
    },
    {
        id: 7,
        name: 'Emma Thompson',
        avatar: 'https://picsum.photos/seed/user7/40/40.jpg',
        group: 'Project Management',
        lastMessage: 'Sprint planning meeting tomorrow',
        time: 'Yesterday',
        unread: 0,
        online: false,
        messages: [
            { id: 1, sender: 'Emma', text: 'Sprint planning meeting tomorrow', time: 'Yesterday', sent: false }
        ]
    },
    {
        id: 8,
        name: 'David Martinez',
        avatar: 'https://picsum.photos/seed/user8/40/40.jpg',
        group: 'Quality Assurance',
        lastMessage: 'Test cases completed successfully',
        time: '2 days ago',
        unread: 0,
        online: true,
        messages: [
            { id: 1, sender: 'David', text: 'Test cases completed successfully', time: '2 days ago', sent: false }
        ]
    },
    {
        id: 9,
        name: 'Lisa Anderson',
        avatar: 'https://picsum.photos/seed/user9/40/40.jpg',
        group: 'Marketing Team',
        lastMessage: 'Campaign launch next week',
        time: '3 days ago',
        unread: 0,
        online: false,
        messages: [
            { id: 1, sender: 'Lisa', text: 'Campaign launch next week', time: '3 days ago', sent: false }
        ]
    },
    {
        id: 10,
        name: 'Tom Wilson',
        avatar: 'https://picsum.photos/seed/user10/40/40.jpg',
        group: 'DevOps Team',
        lastMessage: 'Deployment completed successfully',
        time: '4 days ago',
        unread: 0,
        online: true,
        messages: [
            { id: 1, sender: 'Tom', text: 'Deployment completed successfully', time: '4 days ago', sent: false }
        ]
    },
    {
        id: 11,
        name: 'Rachel Green',
        avatar: 'https://picsum.photos/seed/user11/40/40.jpg',
        group: 'Human Resources',
        lastMessage: 'New onboarding documents uploaded',
        time: '5 days ago',
        unread: 1,
        online: false,
        messages: [
            { id: 1, sender: 'Rachel', text: 'New onboarding documents uploaded', time: '5 days ago', sent: false }
        ]
    },
    {
        id: 12,
        name: 'James Brown',
        avatar: 'https://picsum.photos/seed/user12/40/40.jpg',
        group: 'Security Team',
        lastMessage: 'Security audit completed',
        time: '1 week ago',
        unread: 0,
        online: true,
        messages: [
            { id: 1, sender: 'James', text: 'Security audit completed', time: '1 week ago', sent: false }
        ]
    },
    {
        id: 13,
        name: 'Maria Garcia',
        avatar: 'https://picsum.photos/seed/user13/40/40.jpg',
        group: 'Finance Department',
        lastMessage: 'Budget approved for Q3',
        time: '1 week ago',
        unread: 0,
        online: false,
        messages: [
            { id: 1, sender: 'Maria', text: 'Budget approved for Q3', time: '1 week ago', sent: false }
        ]
    },
    {
        id: 14,
        name: 'Kevin Lee',
        avatar: 'https://picsum.photos/seed/user14/40/40.jpg',
        group: 'Customer Support',
        lastMessage: 'Customer satisfaction report ready',
        time: '2 weeks ago',
        unread: 0,
        online: true,
        messages: [
            { id: 1, sender: 'Kevin', text: 'Customer satisfaction report ready', time: '2 weeks ago', sent: false }
        ]
    },
    {
        id: 15,
        name: 'Amy Chen',
        avatar: 'https://picsum.photos/seed/user15/40/40.jpg',
        group: 'Data Analytics',
        lastMessage: 'Monthly analytics report is ready',
        time: '3 weeks ago',
        unread: 0,
        online: false,
        messages: [
            { id: 1, sender: 'Amy', text: 'Monthly analytics report is ready', time: '3 weeks ago', sent: false }
        ]
    },
    {
        id: 16,
        name: 'Robert Taylor',
        avatar: 'https://picsum.photos/seed/user16/40/40.jpg',
        group: 'Legal Department',
        lastMessage: 'Contract review completed',
        time: '1 month ago',
        unread: 0,
        online: true,
        messages: [
            { id: 1, sender: 'Robert', text: 'Contract review completed', time: '1 month ago', sent: false }
        ]
    },
    {
        id: 17,
        name: 'Sophie Martin',
        avatar: 'https://picsum.photos/seed/user17/40/40.jpg',
        group: 'Product Management',
        lastMessage: 'Product roadmap updated',
        time: '1 month ago',
        unread: 0,
        online: false,
        messages: [
            { id: 1, sender: 'Sophie', text: 'Product roadmap updated', time: '1 month ago', sent: false }
        ]
    },
    {
        id: 18,
        name: 'Daniel White',
        avatar: 'https://picsum.photos/seed/user18/40/40.jpg',
        group: 'Infrastructure Team',
        lastMessage: 'Server maintenance scheduled',
        time: '2 months ago',
        unread: 0,
        online: true,
        messages: [
            { id: 1, sender: 'Daniel', text: 'Server maintenance scheduled', time: '2 months ago', sent: false }
        ]
    },
    {
        id: 19,
        name: 'Web Development Squad',
        avatar: 'group',
        group: 'Group Chat',
        lastMessage: 'Alice: I\'ve completed the frontend changes',
        time: '2 days ago',
        unread: 3,
        online: true,
        isGroup: true,
        messages: [
            { id: 1, sender: 'Alice', text: 'I\'ve completed the frontend changes', time: '2 days ago', sent: false }
        ]
    },
    {
        id: 20,
        name: 'All Teams',
        avatar: 'all-users',
        group: 'Company-wide Chat',
        lastMessage: 'John: Great work everyone!',
        time: '1 hour ago',
        unread: 5,
        online: true,
        isGroup: true,
        messages: [
            { id: 1, sender: 'John', text: 'Great work everyone!', time: '1 hour ago', sent: false }
        ]
    }
];

function openNewMessageModal() {
    document.getElementById('new-message-modal').classList.remove('hidden');
}

function closeNewMessageModal() {
    document.getElementById('new-message-modal').classList.add('hidden');
}

function switchConversation(conversationId) {
    currentConversation = conversationId;
    const conversation = conversations.find(c => c.id === conversationId);
    
    if (conversation) {
        // Update conversation list styling
        document.querySelectorAll('.conversation-item').forEach(item => {
            item.classList.remove('border-l-4', 'border-blue-500', 'bg-blue-50');
        });
        
        const activeItem = document.querySelector(`[data-conversation="${conversationId}"]`);
        if (activeItem) {
            activeItem.classList.add('border-l-4', 'border-blue-500', 'bg-blue-50');
        }
        
        // Update chat header
        updateChatHeader(conversation);
        
        // Update messages
        updateMessages(conversation);
        
        // Clear unread count
        conversation.unread = 0;
        updateConversationList();
    }
}

function updateChatHeader(conversation) {
    const headerName = document.querySelector('.chat-header-name');
    const headerGroup = document.querySelector('.chat-header-group');
    const headerAvatar = document.querySelector('.chat-header-avatar');
    
    if (headerName) headerName.textContent = conversation.name;
    if (headerGroup) headerGroup.textContent = conversation.group;
    if (headerAvatar) {
        if (conversation.isGroup) {
            if (conversation.avatar === 'all-users') {
                headerAvatar.innerHTML = `
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                `;
            } else {
                headerAvatar.innerHTML = `
                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                `;
            }
        } else {
            headerAvatar.innerHTML = `<img src="${conversation.avatar}" alt="${conversation.name}" class="w-10 h-10 rounded-full">`;
        }
    }
}

function updateMessages(conversation) {
    const messagesContainer = document.querySelector('.messages-container');
    if (!messagesContainer) return;
    
    let messagesHTML = '';
    conversation.messages.forEach(message => {
        if (message.sent) {
            messagesHTML += `
                <div class="flex items-start space-x-3 justify-end">
                    <div class="max-w-xs">
                        <div class="bg-blue-600 text-white rounded-lg p-3">
                            <p class="text-sm">${message.text}</p>
                        </div>
                        <p class="text-xs text-gray-500 mt-1 text-right">${message.time}</p>
                    </div>
                </div>
            `;
        } else {
            messagesHTML += `
                <div class="flex items-start space-x-3">
                    <img src="${conversation.avatar}" alt="${conversation.name}" class="w-8 h-8 rounded-full">
                    <div class="max-w-xs">
                        <div class="bg-gray-100 rounded-lg p-3">
                            <p class="text-sm text-gray-900">${message.text}</p>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">${message.time}</p>
                    </div>
                </div>
            `;
        }
    });
    
    messagesContainer.innerHTML = messagesHTML;
    
    // Scroll to bottom
    const chatArea = document.querySelector('.chat-area');
    if (chatArea) {
        chatArea.scrollTop = chatArea.scrollHeight;
    }
}

function sendMessage() {
    const input = document.querySelector('.message-input');
    const messageText = input.value.trim();
    
    if (!messageText) return;
    
    const conversation = conversations.find(c => c.id === currentConversation);
    if (!conversation) return;
    
    // Add new message
    const newMessage = {
        id: conversation.messages.length + 1,
        sender: 'You',
        text: messageText,
        time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
        sent: true
    };
    
    conversation.messages.push(newMessage);
    conversation.lastMessage = messageText;
    conversation.time = newMessage.time;
    
    // Clear input
    input.value = '';
    
    // Update UI
    updateMessages(conversation);
    updateConversationList();
    
    // Simulate typing indicator and response
    setTimeout(() => {
        showTypingIndicator(conversation);
        setTimeout(() => {
            hideTypingIndicator();
            simulateResponse(conversation);
        }, 2000);
    }, 1000);
}

function showTypingIndicator(conversation) {
    const messagesContainer = document.querySelector('.messages-container');
    if (!messagesContainer) return;
    
    const typingHTML = `
        <div id="typing-indicator" class="flex items-start space-x-3">
            <img src="${conversation.avatar}" alt="${conversation.name}" class="w-8 h-8 rounded-full">
            <div class="bg-gray-100 rounded-lg p-3">
                <div class="flex space-x-1">
                    <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce"></div>
                    <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                    <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                </div>
            </div>
        </div>
    `;
    
    messagesContainer.insertAdjacentHTML('beforeend', typingHTML);
    
    const chatArea = document.querySelector('.chat-area');
    if (chatArea) {
        chatArea.scrollTop = chatArea.scrollHeight;
    }
}

function hideTypingIndicator() {
    const typingIndicator = document.getElementById('typing-indicator');
    if (typingIndicator) {
        typingIndicator.remove();
    }
}

function simulateResponse(conversation) {
    const responses = [
        "That sounds great! Let me know if you need any help.",
        "I'll look into that and get back to you soon.",
        "Thanks for the update! Keep me posted.",
        "Perfect! I agree with your approach.",
        "Let's discuss this in our next meeting."
    ];
    
    const responseText = responses[Math.floor(Math.random() * responses.length)];
    
    const newMessage = {
        id: conversation.messages.length + 1,
        sender: conversation.name,
        text: responseText,
        time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
        sent: false
    };
    
    conversation.messages.push(newMessage);
    conversation.lastMessage = responseText;
    conversation.time = newMessage.time;
    
    updateMessages(conversation);
    updateConversationList();
}

function updateConversationList() {
    const listContainer = document.querySelector('.conversations-list');
    if (!listContainer) return;
    
    let listHTML = '';
    conversations.forEach(conversation => {
        const unreadBadge = conversation.unread > 0 ? 
            `<span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full ml-2">${conversation.unread}</span>` : '';
        
        const onlineIndicator = conversation.online ? 
            `<span class="w-2 h-2 bg-green-500 rounded-full ml-2"></span>` : '';
        
        listHTML += `
            <div class="conversation-item p-4 hover:bg-gray-50 cursor-pointer border-l-4 ${conversation.id === currentConversation ? 'border-blue-500 bg-blue-50' : 'border-transparent'}" 
                 data-conversation="${conversation.id}" onclick="switchConversation(${conversation.id})">
                <div class="flex items-start space-x-3">
                    ${conversation.isGroup ? `
                        ${conversation.avatar === 'all-users' ? `
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                        ` : `
                            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                        `}
                    ` : `
                        <img src="${conversation.avatar}" alt="${conversation.name}" class="w-10 h-10 rounded-full">
                    `}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900 truncate">${conversation.name}</p>
                            <span class="text-xs text-gray-500">${conversation.time}</span>
                        </div>
                        <p class="text-sm text-gray-600 truncate">${conversation.lastMessage}</p>
                        <div class="flex items-center mt-1">
                            <span class="text-xs text-gray-500">${conversation.group}</span>
                            ${onlineIndicator}
                            ${unreadBadge}
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    
    listContainer.innerHTML = listHTML;
}

// Search functionality
function searchConversations(query) {
    const filteredConversations = conversations.filter(conv => 
        conv.name.toLowerCase().includes(query.toLowerCase()) ||
        conv.group.toLowerCase().includes(query.toLowerCase()) ||
        conv.lastMessage.toLowerCase().includes(query.toLowerCase())
    );
    
    const listContainer = document.querySelector('.conversations-list');
    if (!listContainer) return;
    
    if (filteredConversations.length === 0) {
        listContainer.innerHTML = `
            <div class="p-8 text-center text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <p>No conversations found</p>
                <p class="text-sm mt-2">Try searching for a different user or group</p>
            </div>
        `;
        return;
    }
    
    let listHTML = '';
    filteredConversations.forEach(conversation => {
        const unreadBadge = conversation.unread > 0 ? 
            `<span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full ml-2">${conversation.unread}</span>` : '';
        
        const onlineIndicator = conversation.online ? 
            `<span class="w-2 h-2 bg-green-500 rounded-full ml-2"></span>` : '';
        
        listHTML += `
            <div class="conversation-item p-4 hover:bg-gray-50 cursor-pointer border-l-4 ${conversation.id === currentConversation ? 'border-blue-500 bg-blue-50' : 'border-transparent'}" 
                 data-conversation="${conversation.id}" onclick="switchConversation(${conversation.id})">
                <div class="flex items-start space-x-3">
                    ${conversation.isGroup ? `
                        ${conversation.avatar === 'all-users' ? `
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                        ` : `
                            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                        `}
                    ` : `
                        <img src="${conversation.avatar}" alt="${conversation.name}" class="w-10 h-10 rounded-full">
                    `}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900 truncate">${conversation.name}</p>
                            <span class="text-xs text-gray-500">${conversation.time}</span>
                        </div>
                        <p class="text-sm text-gray-600 truncate">${conversation.lastMessage}</p>
                        <div class="flex items-center mt-1">
                            <span class="text-xs text-gray-500">${conversation.group}</span>
                            ${onlineIndicator}
                            ${unreadBadge}
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    
    listContainer.innerHTML = listHTML;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateConversationList();
    switchConversation(1);
    
    // Add event listeners
    const sendButton = document.querySelector('.send-button');
    const messageInput = document.querySelector('.message-input');
    const searchInput = document.querySelector('input[placeholder="Search conversations..."]');
    
    if (sendButton) {
        sendButton.addEventListener('click', sendMessage);
    }
    
    if (messageInput) {
        messageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
    }
    
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            searchConversations(e.target.value);
        });
        
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Escape') {
                e.target.value = '';
                updateConversationList();
            }
        });
    }
});

// Close modal when clicking outside
document.getElementById('new-message-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeNewMessageModal();
    }
});
</script>
@endsection
