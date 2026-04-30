import React from 'react';
import { User, Settings, Award, Mail } from 'lucide-react';

const Profile = () => {
  return React.createElement('div', {
    style: {
      padding: '2rem',
      backgroundColor: 'white',
      borderRadius: '0.75rem',
      boxShadow: '0 1px 3px 0 rgba(0, 0, 0, 0.1)'
    }
  },
    React.createElement('h2', {
      style: {
        fontSize: '1.5rem',
        fontWeight: 'bold',
        color: '#1f2937',
        marginBottom: '1rem'
      }
    }, 'User Profile'),
    React.createElement('p', {
      style: {
        color: '#6b7280'
      }
    }, 'Manage your profile information and preferences...')
  );
};

export default Profile;
