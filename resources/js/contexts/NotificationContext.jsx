import React, { createContext, useContext, useState, useEffect } from 'react';
import { notificationAPI } from '../services/api';

const NotificationContext = createContext();

export const useNotifications = () => {
    const context = useContext(NotificationContext);
    if (!context) {
        throw new Error('useNotifications must be used within a NotificationProvider');
    }
    return context;
};

export const NotificationProvider = ({ children }) => {
    const [notifications, setNotifications] = useState([]);
    const [unreadCount, setUnreadCount] = useState(0);

    useEffect(() => {
        if (localStorage.getItem('token')) {
            fetchNotifications();
            fetchUnreadCount();
        }
    }, []);

    const fetchNotifications = async () => {
        try {
            const response = await notificationAPI.getAll();
            setNotifications(response.data.data || response.data);
        } catch (error) {
            console.error('Failed to fetch notifications:', error);
        }
    };

    const fetchUnreadCount = async () => {
        try {
            const response = await notificationAPI.getUnreadCount();
            setUnreadCount(response.data.unread_count);
        } catch (error) {
            console.error('Failed to fetch unread count:', error);
        }
    };

    const addNotification = (notification) => {
        setNotifications(prev => [notification, ...prev]);
        setUnreadCount(prev => prev + 1);
    };

    const markAsRead = async (notificationId) => {
        try {
            await notificationAPI.markAsRead(notificationId);
            setNotifications(prev => 
                prev.map(n => 
                    n.id === notificationId ? { ...n, is_read: true } : n
                )
            );
            setUnreadCount(prev => Math.max(0, prev - 1));
        } catch (error) {
            console.error('Failed to mark notification as read:', error);
        }
    };

    const markAllAsRead = async () => {
        try {
            await notificationAPI.markAllAsRead();
            setNotifications(prev => 
                prev.map(n => ({ ...n, is_read: true }))
            );
            setUnreadCount(0);
        } catch (error) {
            console.error('Failed to mark all notifications as read:', error);
        }
    };

    const deleteNotification = async (notificationId) => {
        try {
            await notificationAPI.delete(notificationId);
            setNotifications(prev => 
                prev.filter(n => n.id !== notificationId)
            );
            const deleted = notifications.find(n => n.id === notificationId);
            if (deleted && !deleted.is_read) {
                setUnreadCount(prev => Math.max(0, prev - 1));
            }
        } catch (error) {
            console.error('Failed to delete notification:', error);
        }
    };

    const value = {
        notifications,
        unreadCount,
        fetchNotifications,
        addNotification,
        markAsRead,
        markAllAsRead,
        deleteNotification,
    };

    return (
        <NotificationContext.Provider value={value}>
            {children}
        </NotificationContext.Provider>
    );
};
