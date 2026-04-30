import React from 'react';
import { Routes, Route } from 'react-router-dom';
import Login from './pages/auth/Login';

function App() {
    return (
        <div style={{ minHeight: '100vh', backgroundColor: '#f9fafb' }}>
            <Routes>
                <Route path="/" element={<Login />} />
                <Route path="/login" element={<Login />} />
            </Routes>
        </div>
    );
}

export default App;
