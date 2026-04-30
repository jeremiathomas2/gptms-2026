// @vitejs/plugin-react preamble
import React, { createContext, useContext, useState, useEffect } from 'react';
import { authAPI } from '../services/api';

const AuthContext = createContext();

export const useAuth = () => {
    const context = useContext(AuthContext);
    if (!context) {
        throw new Error('useAuth must be used within an AuthProvider');
    }
    return context;
};

export const AuthProvider = ({ children }) => {
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);
    const [token, setToken] = useState(localStorage.getItem('token'));

    useEffect(() => {
        const initAuth = async () => {
            const storedToken = localStorage.getItem('token');
            if (storedToken) {
                try {
                    const response = await authAPI.getProfile();
                    setUser(response.data);
                    setToken(storedToken);
                } catch (error) {
                    localStorage.removeItem('token');
                    setToken(null);
                }
            }
            setLoading(false);
        };

        initAuth();
    }, []);

    const login = async (credentials) => {
        try {
            const response = await authAPI.login(credentials);
            const { user: userData, token: userToken } = response.data;
            
            localStorage.setItem('token', userToken);
            setToken(userToken);
            setUser(userData);
            
            return { success: true };
        } catch (error) {
            return { 
                success: false, 
                error: error.response?.data?.error || 'Login failed' 
            };
        }
    };

    const register = async (userData) => {
        try {
            const response = await authAPI.register(userData);
            const { user: newUser, token: userToken } = response.data;
            
            localStorage.setItem('token', userToken);
            setToken(userToken);
            setUser(newUser);
            
            return { success: true };
        } catch (error) {
            return { 
                success: false, 
                error: error.response?.data?.errors || 'Registration failed' 
            };
        }
    };

    const logout = async () => {
        try {
            await authAPI.logout();
        } catch (error) {
            // Continue with logout even if API call fails
        } finally {
            localStorage.removeItem('token');
            setToken(null);
            setUser(null);
        }
    };

    const updateProfile = async (profileData) => {
        try {
            const response = await authAPI.updateProfile(profileData);
            setUser(response.data.user);
            return { success: true };
        } catch (error) {
            return { 
                success: false, 
                error: error.response?.data?.errors || 'Profile update failed' 
            };
        }
    };

    const value = {
        user,
        token,
        loading,
        login,
        register,
        logout,
        updateProfile,
        isAuthenticated: !!user,
        isAdmin: user?.roles?.[0]?.name === 'admin',
        isSupervisor: user?.roles?.[0]?.name === 'supervisor',
        isStudent: user?.roles?.[0]?.name === 'student',
    };

    return (
        <AuthContext.Provider value={value}>
            {children}
        </AuthContext.Provider>
    );
};
