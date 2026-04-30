import React, { useState, useEffect } from 'react';
import { useAuth } from '../contexts/AuthContext';
import { authAPI } from '../services/api';
import { 
    UserIcon, 
    BellIcon, 
    ShieldCheckIcon,
    AcademicCapIcon,
    DocumentTextIcon,
    Cog6ToothIcon
} from '@heroicons/react/24/outline';

const Settings = () => {
    const { user, updateProfile } = useAuth();
    const [activeTab, setActiveTab] = useState('profile');
    const [formData, setFormData] = useState({
        first_name: user?.first_name || '',
        last_name: user?.last_name || '',
        email: user?.email || '',
        phone: user?.phone || '',
        bio: user?.student_profile?.bio || '',
    });
    const [notificationSettings, setNotificationSettings] = useState({
        email_notifications: true,
        push_notifications: false,
        task_reminders: true,
        message_notifications: true,
    });
    const [loading, setLoading] = useState(false);
    const [message, setMessage] = useState('');

    useEffect(() => {
        if (user) {
            setFormData({
                first_name: user.first_name || '',
                last_name: user.last_name || '',
                email: user.email || '',
                phone: user.phone || '',
                bio: user.student_profile?.bio || '',
            });
        }
    }, [user]);

    const handleProfileUpdate = async (e) => {
        e.preventDefault();
        setLoading(true);
        setMessage('');

        const result = await updateProfile(formData);
        
        if (result.success) {
            setMessage('Profile updated successfully!');
        } else {
            setMessage(result.error || 'Failed to update profile');
        }
        
        setLoading(false);
    };

    const handleInputChange = (field, value) => {
        setFormData(prev => ({
            ...prev,
            [field]: value
        }));
    };

    const handleNotificationChange = (field, value) => {
        setNotificationSettings(prev => ({
            ...prev,
            [field]: value
        }));
    };

    const tabs = [
        { id: 'profile', name: 'Profile', icon: UserIcon },
        { id: 'notifications', name: 'Notifications', icon: BellIcon },
        { id: 'security', name: 'Security', icon: ShieldCheckIcon },
        { id: 'preferences', name: 'Preferences', icon: Cog6ToothIcon },
    ];

    return (
        <div className="px-4 sm:px-6 lg:px-8 py-8">
            <div className="max-w-4xl mx-auto">
                <h1 className="text-2xl font-bold text-gray-900 mb-8">Settings</h1>

                <div className="bg-white shadow rounded-lg">
                    {/* Tabs */}
                    <div className="border-b border-gray-200">
                        <nav className="-mb-px flex space-x-8" aria-label="Tabs">
                            {tabs.map((tab) => {
                                const Icon = tab.icon;
                                return (
                                    <button
                                        key={tab.id}
                                        onClick={() => setActiveTab(tab.id)}
                                        className={`py-4 px-1 border-b-2 font-medium text-sm ${
                                            activeTab === tab.id
                                                ? 'border-blue-500 text-blue-600'
                                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                                        }`}
                                    >
                                        <Icon className="h-5 w-5 mr-2" />
                                        {tab.name}
                                    </button>
                                );
                            })}
                        </nav>
                    </div>

                    {/* Tab Content */}
                    <div className="p-6">
                        {message && (
                            <div className="mb-4 p-4 bg-green-50 border border-green-200 rounded-md">
                                <p className="text-sm text-green-800">{message}</p>
                            </div>
                        )}

                        {activeTab === 'profile' && (
                            <form onSubmit={handleProfileUpdate} className="space-y-6">
                                <div>
                                    <h2 className="text-lg font-medium text-gray-900 mb-4">Profile Information</h2>
                                    
                                    <div className="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                        <div>
                                            <label htmlFor="first_name" className="block text-sm font-medium text-gray-700">
                                                First Name
                                            </label>
                                            <input
                                                type="text"
                                                id="first_name"
                                                value={formData.first_name}
                                                onChange={(e) => handleInputChange('first_name', e.target.value)}
                                                className="input-field"
                                                required
                                            />
                                        </div>

                                        <div>
                                            <label htmlFor="last_name" className="block text-sm font-medium text-gray-700">
                                                Last Name
                                            </label>
                                            <input
                                                type="text"
                                                id="last_name"
                                                value={formData.last_name}
                                                onChange={(e) => handleInputChange('last_name', e.target.value)}
                                                className="input-field"
                                                required
                                            />
                                        </div>
                                    </div>

                                    <div className="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                        <div>
                                            <label htmlFor="email" className="block text-sm font-medium text-gray-700">
                                                Email Address
                                            </label>
                                            <input
                                                type="email"
                                                id="email"
                                                value={formData.email}
                                                onChange={(e) => handleInputChange('email', e.target.value)}
                                                className="input-field"
                                                required
                                            />
                                        </div>

                                        <div>
                                            <label htmlFor="phone" className="block text-sm font-medium text-gray-700">
                                                Phone Number
                                            </label>
                                            <input
                                                type="tel"
                                                id="phone"
                                                value={formData.phone}
                                                onChange={(e) => handleInputChange('phone', e.target.value)}
                                                className="input-field"
                                            />
                                        </div>
                                    </div>

                                    <div>
                                        <label htmlFor="bio" className="block text-sm font-medium text-gray-700">
                                                    Bio
                                                </label>
                                        <textarea
                                            id="bio"
                                            rows={4}
                                            value={formData.bio}
                                            onChange={(e) => handleInputChange('bio', e.target.value)}
                                            className="input-field"
                                            placeholder="Tell us about yourself..."
                                        />
                                    </div>
                                </div>

                                <div className="flex justify-end">
                                    <button
                                        type="submit"
                                        disabled={loading}
                                        className="btn-primary disabled:opacity-50"
                                    >
                                        {loading ? 'Saving...' : 'Save Changes'}
                                    </button>
                                </div>
                            </form>
                        )}

                        {activeTab === 'notifications' && (
                            <div className="space-y-6">
                                <h2 className="text-lg font-medium text-gray-900 mb-4">Notification Preferences</h2>
                                
                                <div className="space-y-4">
                                    <div className="flex items-center justify-between">
                                        <div>
                                            <h3 className="text-sm font-medium text-gray-900">Email Notifications</h3>
                                            <p className="text-sm text-gray-500">Receive email updates about your projects and tasks</p>
                                        </div>
                                        <button
                                            onClick={() => handleNotificationChange('email_notifications', !notificationSettings.email_notifications)}
                                            className={`relative inline-flex h-6 w-11 items-center rounded-full transition-colors ${
                                                notificationSettings.email_notifications
                                                    ? 'bg-blue-600'
                                                    : 'bg-gray-200'
                                            }`}
                                        >
                                            <span className="sr-only">Email notifications</span>
                                            <span
                                                className={`inline-block h-4 w-4 rounded-full bg-white transition-transform ${
                                                    notificationSettings.email_notifications ? 'translate-x-5' : 'translate-x-0'
                                                }`}
                                            />
                                        </button>
                                    </div>

                                    <div className="flex items-center justify-between">
                                        <div>
                                            <h3 className="text-sm font-medium text-gray-900">Push Notifications</h3>
                                            <p className="text-sm text-gray-500">Receive browser push notifications</p>
                                        </div>
                                        <button
                                            onClick={() => handleNotificationChange('push_notifications', !notificationSettings.push_notifications)}
                                            className={`relative inline-flex h-6 w-11 items-center rounded-full transition-colors ${
                                                notificationSettings.push_notifications
                                                    ? 'bg-blue-600'
                                                    : 'bg-gray-200'
                                            }`}
                                        >
                                            <span className="sr-only">Push notifications</span>
                                            <span
                                                className={`inline-block h-4 w-4 rounded-full bg-white transition-transform ${
                                                    notificationSettings.push_notifications ? 'translate-x-5' : 'translate-x-0'
                                                }`}
                                            />
                                        </button>
                                    </div>

                                    <div className="flex items-center justify-between">
                                        <div>
                                            <h3 className="text-sm font-medium text-gray-900">Task Reminders</h3>
                                            <p className="text-sm text-gray-500">Get reminded about upcoming deadlines</p>
                                        </div>
                                        <button
                                            onClick={() => handleNotificationChange('task_reminders', !notificationSettings.task_reminders)}
                                            className={`relative inline-flex h-6 w-11 items-center rounded-full transition-colors ${
                                                notificationSettings.task_reminders
                                                    ? 'bg-blue-600'
                                                    : 'bg-gray-200'
                                            }`}
                                        >
                                            <span className="sr-only">Task reminders</span>
                                            <span
                                                className={`inline-block h-4 w-4 rounded-full bg-white transition-transform ${
                                                    notificationSettings.task_reminders ? 'translate-x-5' : 'translate-x-0'
                                                }`}
                                            />
                                        </button>
                                    </div>

                                    <div className="flex items-center justify-between">
                                        <div>
                                            <h3 className="text-sm font-medium text-gray-900">Message Notifications</h3>
                                            <p className="text-sm text-gray-500">Get notified about new messages</p>
                                        </div>
                                        <button
                                            onClick={() => handleNotificationChange('message_notifications', !notificationSettings.message_notifications)}
                                            className={`relative inline-flex h-6 w-11 items-center rounded-full transition-colors ${
                                                notificationSettings.message_notifications
                                                    ? 'bg-blue-600'
                                                    : 'bg-gray-200'
                                            }`}
                                        >
                                            <span className="sr-only">Message notifications</span>
                                            <span
                                                className={`inline-block h-4 w-4 rounded-full bg-white transition-transform ${
                                                    notificationSettings.message_notifications ? 'translate-x-5' : 'translate-x-0'
                                                }`}
                                            />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        )}

                        {activeTab === 'security' && (
                            <div className="space-y-6">
                                <h2 className="text-lg font-medium text-gray-900 mb-4">Security Settings</h2>
                                
                                <div className="space-y-4">
                                    <div className="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                                        <div className="flex">
                                            <ShieldCheckIcon className="h-5 w-5 text-yellow-600 mr-2" />
                                            <div>
                                                <h3 className="text-sm font-medium text-yellow-800">Two-Factor Authentication</h3>
                                                <p className="text-sm text-yellow-700">
                                                    Add an extra layer of security to your account
                                                </p>
                                            </div>
                                        </div>
                                        <button className="btn-secondary text-sm mt-2">
                                            Enable 2FA
                                        </button>
                                    </div>

                                    <div>
                                        <h3 className="text-sm font-medium text-gray-900">Change Password</h3>
                                        <button className="btn-secondary text-sm">
                                            Change Password
                                        </button>
                                    </div>

                                    <div>
                                        <h3 className="text-sm font-medium text-gray-900">Login History</h3>
                                        <div className="text-sm text-gray-500">
                                            Last login: {user?.last_login_at ? new Date(user.last_login_at).toLocaleString() : 'Never'}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        )}

                        {activeTab === 'preferences' && (
                            <div className="space-y-6">
                                <h2 className="text-lg font-medium text-gray-900 mb-4">Preferences</h2>
                                
                                <div className="space-y-4">
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">
                                            Theme
                                        </label>
                                        <select className="input-field">
                                            <option>Light</option>
                                            <option>Dark</option>
                                            <option>System</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">
                                            Language
                                        </label>
                                        <select className="input-field">
                                            <option>English</option>
                                            <option>Spanish</option>
                                            <option>French</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">
                                            Time Zone
                                        </label>
                                        <select className="input-field">
                                            <option>UTC</option>
                                            <option>EST</option>
                                            <option>PST</option>
                                            <option>CST</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">
                                            Date Format
                                        </label>
                                        <select className="input-field">
                                            <option>MM/DD/YYYY</option>
                                            <option>DD/MM/YYYY</option>
                                            <option>YYYY-MM-DD</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Settings;
