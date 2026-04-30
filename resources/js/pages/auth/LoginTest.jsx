import React from 'react';

const LoginTest = () => {
    return (
        <div style={{ 
            minHeight: '100vh', 
            backgroundColor: '#f9fafb', 
            display: 'flex', 
            alignItems: 'center', 
            justifyContent: 'center',
            padding: '2rem'
        }}>
            <div style={{ 
                width: '100%', 
                maxWidth: '448px',
                backgroundColor: '#ffffff',
                padding: '2rem',
                borderRadius: '0.5rem',
                boxShadow: '0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)'
            }}>
                <h2 style={{ 
                    textAlign: 'center', 
                    fontSize: '1.875rem', 
                    fontWeight: '800', 
                    color: '#111827',
                    marginBottom: '0.5rem'
                }}>
                    Sign in to GPTFMS
                </h2>
                <p style={{ 
                    textAlign: 'center', 
                    fontSize: '0.875rem', 
                    color: '#6b7280',
                    marginBottom: '2rem'
                }}>
                    Group Project Team Formation and Management System
                </p>
                
                <form style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
                    <div>
                        <label style={{ 
                            display: 'block', 
                            fontSize: '0.875rem', 
                            fontWeight: '500', 
                            color: '#374151', 
                            marginBottom: '0.25rem'
                        }}>
                            Email Address
                        </label>
                        <input
                            type="email"
                            placeholder="Email Address"
                            style={{
                                display: 'block',
                                width: '100%',
                                padding: '0.5rem 0.75rem',
                                border: '1px solid #d1d5db',
                                borderRadius: '0.375rem',
                                fontSize: '0.875rem',
                                color: '#111827',
                                backgroundColor: '#ffffff'
                            }}
                        />
                    </div>

                    <div>
                        <label style={{ 
                            display: 'block', 
                            fontSize: '0.875rem', 
                            fontWeight: '500', 
                            color: '#374151', 
                            marginBottom: '0.25rem'
                        }}>
                            Password
                        </label>
                        <input
                            type="password"
                            placeholder="Password"
                            style={{
                                display: 'block',
                                width: '100%',
                                padding: '0.5rem 0.75rem',
                                border: '1px solid #d1d5db',
                                borderRadius: '0.375rem',
                                fontSize: '0.875rem',
                                color: '#111827',
                                backgroundColor: '#ffffff'
                            }}
                        />
                    </div>

                    <button
                        type="submit"
                        style={{
                            display: 'flex',
                            justifyContent: 'center',
                            width: '100%',
                            padding: '0.5rem 1rem',
                            border: '1px solid transparent',
                            fontSize: '0.875rem',
                            fontWeight: '500',
                            borderRadius: '0.375rem',
                            color: '#ffffff',
                            backgroundColor: '#2563eb',
                            cursor: 'pointer',
                            marginTop: '1rem'
                        }}
                    >
                        Sign in
                    </button>
                </form>

                <div style={{ marginTop: '1.5rem', textAlign: 'center' }}>
                    <div style={{ 
                        position: 'relative', 
                        textAlign: 'center', 
                        marginBottom: '1rem' 
                    }}>
                        <div style={{ 
                            position: 'absolute', 
                            top: '50%', 
                            left: '0', 
                            right: '0', 
                            height: '1px', 
                            backgroundColor: '#e5e7eb' 
                        }}></div>
                        <span style={{ 
                            position: 'relative', 
                            backgroundColor: '#ffffff', 
                            padding: '0 0.5rem', 
                            fontSize: '0.875rem', 
                            color: '#6b7280' 
                        }}>
                            New to our platform?
                        </span>
                    </div>
                    <a href="/register" style={{ 
                        fontSize: '0.875rem', 
                        fontWeight: '500', 
                        color: '#2563eb', 
                        textDecoration: 'none' 
                    }}>
                        Create an account
                    </a>
                </div>
            </div>
        </div>
    );
};

export default LoginTest;
