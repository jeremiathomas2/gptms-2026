import React, { useState, useEffect } from 'react';
import { Routes, Route, Link } from 'react-router-dom';
import { useAuth } from '../contexts/AuthContext';
import { messageAPI } from '../services/api';
import { 
    ChatBubbleLeftRightIcon, 
    MagnifyingGlassIcon,
    UserGroupIcon,
    UserIcon,
    PaperAirplaneIcon,
    BellIcon
} from '@heroicons/react/24/outline';

const Messages = () => {
    const { user } = useAuth();
    const [conversations, setConversations] = useState([]);
    const [selectedConversation, setSelectedConversation] = useState(null);
    const [messages, setMessages] = useState([]);
    const [newMessage, setNewMessage] = useState('');
    const [loading, setLoading] = useState(true);
    const [searchTerm, setSearchTerm] = useState('');

    useEffect(() => {
        fetchConversations();
    }, []);

    useEffect(() => {
        if (selectedConversation) {
            fetchMessages(selectedConversation.id);
        }
    }, [selectedConversation]);

    const fetchConversations = async () => {
        try {
            const response = await messageAPI.conversations();
            setConversations(response.data.data || response.data);
        } catch (error) {
            console.error('Failed to fetch conversations:', error);
        } finally {
            setLoading(false);
        }
    };

    const fetchMessages = async (userId) => {
        try {
            const response = await messageAPI.conversation(userId);
            setMessages(response.data.data || response.data);
        } catch (error) {
            console.error('Failed to fetch messages:', error);
        }
    };

    const sendMessage = async () => {
        if (!newMessage.trim() || !selectedConversation) return;

        try {
            await messageAPI.sendMessage({
                receiver_id: selectedConversation.id,
                content: newMessage.trim(),
                type: 'text'
            });
            
            setNewMessage('');
            fetchMessages(selectedConversation.id); // Refresh messages
            fetchConversations(); // Refresh conversations list
        } catch (error) {
            console.error('Failed to send message:', error);
        }
    };

    const filteredConversations = conversations.filter(conv => {
        const otherUser = conv.sender_id === user.id ? conv.receiver : conv.sender;
        return otherUser?.first_name?.toLowerCase().includes(searchTerm.toLowerCase()) ||
               otherUser?.last_name?.toLowerCase().includes(searchTerm.toLowerCase()) ||
               otherUser?.email?.toLowerCase().includes(searchTerm.toLowerCase());
    });

    if (loading) {
        return (
            <div className="flex items-center justify-center h-64">
                <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
            </div>
        );
    }

    return (
        <div className="flex h-screen bg-gray-50">
            {/* Conversations Sidebar */}
            <div className="w-80 bg-white border-r border-gray-200 flex flex-col">
                <div className="p-4 border-b border-gray-200">
                    <h2 className="text-lg font-semibold text-gray-900">Messages</h2>
                    <div className="mt-4 relative">
                        <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <MagnifyingGlassIcon className="h-5 w-5 text-gray-400" />
                        </div>
                        <input
                            type="text"
                            placeholder="Search conversations..."
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                            className="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                    </div>
                </div>

                <div className="flex-1 overflow-y-auto">
                    {filteredConversations.map((conversation) => {
                        const otherUser = conversation.sender_id === user.id ? conversation.receiver : conversation.sender;
                        const isSelected = selectedConversation?.id === otherUser?.id;
                        
                        return (
                            <div
                                key={conversation.id}
                                onClick={() => setSelectedConversation(otherUser)}
                                className={`p-4 border-b border-gray-200 cursor-pointer hover:bg-gray-50 ${
                                    isSelected ? 'bg-blue-50 border-l-4 border-l-blue-500' : ''
                                }`}
                            >
                                <div className="flex items-center space-x-3">
                                    <div className="flex-shrink-0 h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                        <UserIcon className="h-6 w-6 text-gray-600" />
                                    </div>
                                    <div className="flex-1 min-w-0">
                                        <div className="flex items-center justify-between">
                                            <p className="text-sm font-medium text-gray-900 truncate">
                                                {otherUser?.first_name} {otherUser?.last_name}
                                            </p>
                                            {!conversation.is_read && (
                                                <div className="h-2 w-2 bg-blue-600 rounded-full"></div>
                                            )}
                                        </div>
                                        <p className="text-xs text-gray-500 truncate">
                                            {conversation.content}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        );
                    })}
                </div>

                {filteredConversations.length === 0 && (
                    <div className="flex-1 flex items-center justify-center p-8">
                        <ChatBubbleLeftRightIcon className="h-12 w-12 text-gray-400 mb-4" />
                        <h3 className="text-lg font-medium text-gray-900 mb-2">No conversations</h3>
                        <p className="text-gray-500 text-center">
                            {searchTerm ? 'Try adjusting your search terms' : 'Start a conversation to see it here'}
                        </p>
                    </div>
                )}
            </div>

            {/* Messages Area */}
            <div className="flex-1 flex flex-col">
                {selectedConversation ? (
                    <>
                        {/* Conversation Header */}
                        <div className="bg-white border-b border-gray-200 p-4">
                            <div className="flex items-center space-x-3">
                                <div className="flex-shrink-0 h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                    <UserIcon className="h-6 w-6 text-gray-600" />
                                </div>
                                <div>
                                    <h3 className="text-lg font-medium text-gray-900">
                                        {selectedConversation.first_name} {selectedConversation.last_name}
                                    </h3>
                                    <p className="text-sm text-gray-500">{selectedConversation.email}</p>
                                </div>
                            </div>
                        </div>

                        {/* Messages List */}
                        <div className="flex-1 overflow-y-auto p-4 space-y-4">
                            {messages.map((message, index) => {
                                const isOwn = message.sender_id === user.id;
                                const showDate = index === 0 || 
                                    new Date(message.created_at).toDateString() !== 
                                    new Date(messages[index - 1]?.created_at).toDateString();

                                return (
                                    <div key={message.id} className={`flex ${isOwn ? 'justify-end' : 'justify-start'}`}>
                                        <div className={`max-w-xs lg:max-w-md ${isOwn ? 'order-2' : 'order-1'}`}>
                                            {showDate && (
                                                <div className="text-center text-xs text-gray-500 mb-2">
                                                    {new Date(message.created_at).toLocaleDateString()}
                                                </div>
                                            )}
                                            <div className={`flex ${isOwn ? 'justify-end' : 'justify-start'} mb-2`}>
                                                <div className={`flex-shrink-0 h-8 w-8 rounded-full flex items-center justify-center ${isOwn ? 'order-2' : 'order-1'}`}>
                                                    <UserIcon className="h-5 w-5 text-gray-600" />
                                                </div>
                                                <div className={`mx-2 max-w-xs lg:max-w-sm px-4 py-2 rounded-lg ${
                                                    isOwn ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-900'
                                                }`}>
                                                    <p className="text-sm">{message.content}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                );
                            })}
                        </div>

                        {/* Message Input */}
                        <div className="bg-white border-t border-gray-200 p-4">
                            <div className="flex space-x-2">
                                <input
                                    type="text"
                                    value={newMessage}
                                    onChange={(e) => setNewMessage(e.target.value)}
                                    onKeyPress={(e) => {
                                        if (e.key === 'Enter' && !e.shiftKey) {
                                            e.preventDefault();
                                            sendMessage();
                                        }
                                    }}
                                    placeholder="Type a message..."
                                    className="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                />
                                <button
                                    onClick={sendMessage}
                                    disabled={!newMessage.trim()}
                                    className="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    <PaperAirplaneIcon className="h-5 w-5" />
                                </button>
                            </div>
                        </div>
                    </>
                ) : (
                    <div className="flex-1 flex items-center justify-center">
                        <ChatBubbleLeftRightIcon className="h-16 w-16 text-gray-400 mb-4" />
                        <h3 className="text-xl font-medium text-gray-900 mb-2">Select a conversation</h3>
                        <p className="text-gray-500 text-center">
                            Choose a conversation from the left to start messaging
                        </p>
                    </div>
                )}
            </div>
        </div>
    );
};

export default Messages;
