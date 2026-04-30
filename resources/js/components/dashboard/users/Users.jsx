import React, { useState, useEffect } from 'react';
import { Search, Filter, Plus, Edit, Trash2, Download, UserPlus, Shield, Users as UsersIcon, Star, MoreVertical, Eye, Mail, Lock, Unlock, UserCheck, UserX, AlertCircle, Calendar, Clock, Award, BarChart3, Settings as SettingsIcon, Key, Crown, Briefcase, GraduationCap, Activity, TrendingUp, Archive, RefreshCw } from 'lucide-react';

const Users = () => {
  const [users, setUsers] = useState([]);
  const [searchTerm, setSearchTerm] = useState('');
  const [filterRole, setFilterRole] = useState('all');
  const [filterStatus, setFilterStatus] = useState('all');
  const [filterDepartment, setFilterDepartment] = useState('all');
  const [sortBy, setSortBy] = useState('name');
  const [viewMode, setViewMode] = useState('grid'); // grid or list
  const [selectedUsers, setSelectedUsers] = useState([]);
  const [showCreateModal, setShowCreateModal] = useState(false);
  const [showAdvancedFilters, setShowAdvancedFilters] = useState(false);
  const [dropdownOpen, setDropdownOpen] = useState(null);

  useEffect(() => {
    // Enhanced mock data with comprehensive user details
    setUsers([
      {
        id: 1,
        name: 'John Doe',
        email: 'john.doe@university.edu',
        username: 'johndoe',
        role: 'student',
        status: 'active',
        department: 'Computer Science',
        groups: 3,
        rating: 4.8,
        joinedAt: '2024-01-15',
        lastActive: '2 hours ago',
        permissions: ['view_own_profile', 'join_groups', 'submit_assignments'],
        avatar: null,
        phone: '+1-555-0123',
        location: 'New York, USA',
        timezone: 'EST',
        languages: ['English', 'Spanish'],
        skills: ['JavaScript', 'React', 'Node.js', 'Python'],
        experience: 2,
        projects: 5,
        completedTasks: 23,
        pendingTasks: 4,
        attendance: 95,
        performance: 'excellent',
        lastLogin: '2024-01-23T10:30:00Z',
        loginCount: 145,
        deviceUsage: {
          desktop: 65,
          mobile: 25,
          tablet: 10
        },
        activity: {
          loginsThisWeek: 12,
          messagesSent: 34,
          filesUploaded: 8,
          timeSpent: 45 // hours
        }
      },
      {
        id: 2,
        name: 'Jane Smith',
        email: 'jane.smith@university.edu',
        username: 'janesmith',
        role: 'supervisor',
        status: 'active',
        department: 'Data Science',
        groups: 5,
        rating: 4.9,
        joinedAt: '2024-01-10',
        lastActive: '1 hour ago',
        permissions: ['manage_groups', 'review_assignments', 'view_reports', 'manage_users'],
        avatar: null,
        phone: '+1-555-0124',
        location: 'San Francisco, USA',
        timezone: 'PST',
        languages: ['English', 'Mandarin'],
        skills: ['Machine Learning', 'Python', 'TensorFlow', 'Data Analysis'],
        experience: 5,
        projects: 12,
        completedTasks: 67,
        pendingTasks: 8,
        attendance: 98,
        performance: 'outstanding',
        lastLogin: '2024-01-23T11:15:00Z',
        loginCount: 289,
        deviceUsage: {
          desktop: 80,
          mobile: 15,
          tablet: 5
        },
        activity: {
          loginsThisWeek: 18,
          messagesSent: 56,
          filesUploaded: 23,
          timeSpent: 78
        }
      },
      {
        id: 3,
        name: 'Mike Johnson',
        email: 'mike.johnson@university.edu',
        username: 'mikejohnson',
        role: 'student',
        status: 'inactive',
        department: 'Computer Science',
        groups: 2,
        rating: 4.2,
        joinedAt: '2024-02-01',
        lastActive: '3 days ago',
        permissions: ['view_own_profile', 'join_groups', 'submit_assignments'],
        avatar: null,
        phone: '+1-555-0125',
        location: 'Chicago, USA',
        timezone: 'CST',
        languages: ['English'],
        skills: ['Java', 'Spring Boot', 'MySQL'],
        experience: 1,
        projects: 2,
        completedTasks: 8,
        pendingTasks: 6,
        attendance: 72,
        performance: 'average',
        lastLogin: '2024-01-20T14:20:00Z',
        loginCount: 67,
        deviceUsage: {
          desktop: 45,
          mobile: 40,
          tablet: 15
        },
        activity: {
          loginsThisWeek: 3,
          messagesSent: 12,
          filesUploaded: 2,
          timeSpent: 12
        }
      },
      {
        id: 4,
        name: 'Sarah Wilson',
        email: 'sarah.wilson@university.edu',
        username: 'sarahwilson',
        role: 'admin',
        status: 'active',
        department: 'System Administration',
        groups: 8,
        rating: 4.7,
        joinedAt: '2023-12-01',
        lastActive: '30 minutes ago',
        permissions: ['all_access', 'manage_system', 'manage_users', 'view_reports', 'manage_groups', 'system_config'],
        avatar: null,
        phone: '+1-555-0126',
        location: 'Boston, USA',
        timezone: 'EST',
        languages: ['English', 'French'],
        skills: ['System Administration', 'Security', 'Cloud Computing', 'DevOps'],
        experience: 8,
        projects: 25,
        completedTasks: 156,
        pendingTasks: 12,
        attendance: 99,
        performance: 'exceptional',
        lastLogin: '2024-01-23T12:45:00Z',
        loginCount: 456,
        deviceUsage: {
          desktop: 90,
          mobile: 8,
          tablet: 2
        },
        activity: {
          loginsThisWeek: 25,
          messagesSent: 89,
          filesUploaded: 34,
          timeSpent: 120
        }
      },
      {
        id: 5,
        name: 'Dr. Alice Chen',
        email: 'alice.chen@university.edu',
        username: 'alicechen',
        role: 'supervisor',
        status: 'active',
        department: 'Artificial Intelligence',
        groups: 4,
        rating: 4.9,
        joinedAt: '2023-11-15',
        lastActive: '45 minutes ago',
        permissions: ['manage_groups', 'review_assignments', 'view_reports', 'manage_students'],
        avatar: null,
        phone: '+1-555-0127',
        location: 'Seattle, USA',
        timezone: 'PST',
        languages: ['English', 'Mandarin', 'Cantonese'],
        skills: ['AI Research', 'Machine Learning', 'Neural Networks', 'Computer Vision'],
        experience: 10,
        projects: 18,
        completedTasks: 98,
        pendingTasks: 7,
        attendance: 96,
        performance: 'outstanding',
        lastLogin: '2024-01-23T11:30:00Z',
        loginCount: 324,
        deviceUsage: {
          desktop: 85,
          mobile: 12,
          tablet: 3
        },
        activity: {
          loginsThisWeek: 20,
          messagesSent: 67,
          filesUploaded: 28,
          timeSpent: 95
        }
      },
      {
        id: 6,
        name: 'Tom Anderson',
        email: 'tom.anderson@university.edu',
        username: 'tomanderson',
        role: 'student',
        status: 'active',
        department: 'Web Development',
        groups: 2,
        rating: 4.1,
        joinedAt: '2024-01-20',
        lastActive: '1 day ago',
        permissions: ['view_own_profile', 'join_groups', 'submit_assignments'],
        avatar: null,
        phone: '+1-555-0128',
        location: 'Austin, USA',
        timezone: 'CST',
        languages: ['English'],
        skills: ['HTML', 'CSS', 'JavaScript', 'Vue.js'],
        experience: 1,
        projects: 3,
        completedTasks: 12,
        pendingTasks: 8,
        attendance: 88,
        performance: 'good',
        lastLogin: '2024-01-22T16:20:00Z',
        loginCount: 34,
        deviceUsage: {
          desktop: 55,
          mobile: 35,
          tablet: 10
        },
        activity: {
          loginsThisWeek: 5,
          messagesSent: 18,
          filesUploaded: 4,
          timeSpent: 22
        }
      }
    ]);
  }, []);

  const filteredUsers = users.filter(user => {
    const matchesSearch = user.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                         user.email.toLowerCase().includes(searchTerm.toLowerCase()) ||
                         user.username.toLowerCase().includes(searchTerm.toLowerCase()) ||
                         user.skills.some(skill => skill.toLowerCase().includes(searchTerm.toLowerCase()));
    const matchesRole = filterRole === 'all' || user.role === filterRole;
    const matchesStatus = filterStatus === 'all' || user.status === filterStatus;
    const matchesDepartment = filterDepartment === 'all' || user.department === filterDepartment;
    return matchesSearch && matchesRole && matchesStatus && matchesDepartment;
  });

  const sortedUsers = [...filteredUsers].sort((a, b) => {
    switch (sortBy) {
      case 'name':
        return a.name.localeCompare(b.name);
      case 'role':
        const roleOrder = { admin: 3, supervisor: 2, student: 1 };
        return roleOrder[b.role] - roleOrder[a.role];
      case 'rating':
        return b.rating - a.rating;
      case 'joined':
        return new Date(b.joinedAt) - new Date(a.joinedAt);
      case 'lastActive':
        return new Date(b.lastLogin) - new Date(a.lastLogin);
      case 'activity':
        return b.activity.loginsThisWeek - a.activity.loginsThisWeek;
      default:
        return 0;
    }
  });

  const getRoleColor = (role) => {
    switch (role) {
      case 'admin':
        return { bg: '#fef2f2', color: '#991b1b', icon: Crown };
      case 'supervisor':
        return { bg: '#f0f9ff', color: '#1e40af', icon: Shield };
      case 'student':
        return { bg: '#f0fdf4', color: '#166534', icon: GraduationCap };
      default:
        return { bg: '#f3f4f6', color: '#374151', icon: User };
    }
  };

  const getStatusColor = (status) => {
    switch (status) {
      case 'active':
        return { bg: '#dcfce7', color: '#166534', icon: UserCheck };
      case 'inactive':
        return { bg: '#f3f4f6', color: '#374151', icon: UserX };
      case 'suspended':
        return { bg: '#fef3c7', color: '#92400e', icon: AlertCircle };
      default:
        return { bg: '#f3f4f6', color: '#374151', icon: AlertCircle };
    }
  };

  const getPerformanceColor = (performance) => {
    switch (performance) {
      case 'exceptional':
        return { bg: '#fef2f2', color: '#991b1b' };
      case 'outstanding':
        return { bg: '#dcfce7', color: '#166534' };
      case 'excellent':
        return { bg: '#dbeafe', color: '#1d4ed8' };
      case 'good':
        return { bg: '#f3f4f6', color: '#374151' };
      case 'average':
        return { bg: '#fef3c7', color: '#92400e' };
      default:
        return { bg: '#f3f4f6', color: '#374151' };
    }
  };

  const handleUserAction = (action, userId) => {
    const user = users.find(u => u.id === userId);
    switch (action) {
      case 'view':
        console.log(`Viewing user: ${user.name}`);
        break;
      case 'edit':
        console.log(`Editing user: ${user.name}`);
        break;
      case 'delete':
        if (window.confirm(`Are you sure you want to delete "${user.name}"?`)) {
          setUsers(users.filter(u => u.id !== userId));
        }
        break;
      case 'suspend':
        console.log(`Suspending user: ${user.name}`);
        break;
      case 'activate':
        console.log(`Activating user: ${user.name}`);
        break;
      case 'resetPassword':
        console.log(`Resetting password for user: ${user.name}`);
        break;
      case 'sendEmail':
        console.log(`Sending email to user: ${user.name}`);
        break;
      case 'changeRole':
        console.log(`Changing role for user: ${user.name}`);
        break;
      default:
        console.log(`${action} user ${userId}`);
    }
  };

  const toggleUserSelection = (userId) => {
    setSelectedUsers(prev => 
      prev.includes(userId) 
        ? prev.filter(id => id !== userId)
        : [...prev, userId]
    );
  };

  const toggleAllUsers = () => {
    if (selectedUsers.length === sortedUsers.length) {
      setSelectedUsers([]);
    } else {
      setSelectedUsers(sortedUsers.map(u => u.id));
    }
  };

  const renderUserCard = (user) => {
    const roleColors = getRoleColor(user.role);
    const statusColors = getStatusColor(user.status);
    const performanceColors = getPerformanceColor(user.performance);
    
    return React.createElement('div', {
      key: user.id,
      style: {
        backgroundColor: 'white',
        border: '1px solid #e5e7eb',
        borderRadius: '1rem',
        padding: '1.5rem',
        position: 'relative',
        transition: 'transform 0.2s ease, box-shadow 0.2s ease',
        cursor: 'pointer'
      },
      onMouseEnter: (e) => {
        e.currentTarget.style.transform = 'translateY(-2px)';
        e.currentTarget.style.boxShadow = '0 8px 16px rgba(0, 0, 0, 0.1)';
      },
      onMouseLeave: (e) => {
        e.currentTarget.style.transform = 'translateY(0)';
        e.currentTarget.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
      }
    },
      // Selection Checkbox
      React.createElement('div', {
        style: {
          position: 'absolute',
          top: '1rem',
          left: '1rem'
        }
      },
        React.createElement('input', {
          type: 'checkbox',
          checked: selectedUsers.includes(user.id),
          onChange: (e) => {
            e.stopPropagation();
            toggleUserSelection(user.id);
          },
          style: {
            width: '16px',
            height: '16px'
          }
        })
      ),
      // Role Badge
      React.createElement('div', {
        style: {
          position: 'absolute',
          top: '1rem',
          right: '1rem'
        }
      },
        React.createElement('span', {
          style: {
            display: 'inline-flex',
            alignItems: 'center',
            gap: '0.25rem',
            padding: '0.25rem 0.5rem',
            borderRadius: '0.25rem',
            fontSize: '0.625rem',
            fontWeight: '500',
            backgroundColor: roleColors.bg,
            color: roleColors.color
          }
        },
          React.createElement(roleColors.icon, { size: 12 }),
          user.role.toUpperCase()
        )
      ),
      // User Header
      React.createElement('div', {
        style: {
          display: 'flex',
          alignItems: 'center',
          gap: '1rem',
          marginBottom: '1rem',
          paddingLeft: '2rem'
        }
      },
        React.createElement('div', {
          style: {
            width: '48px',
            height: '48px',
            borderRadius: '50%',
            backgroundColor: '#e5e7eb',
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center'
          }
        },
          React.createElement(User, { size: 24, color: '#6b7280' })
        ),
        React.createElement('div', {
          style: {
            flex: 1
          }
        },
          React.createElement('h3', {
            style: {
              fontSize: '1rem',
              fontWeight: '600',
              color: '#1f2937',
              marginBottom: '0.25rem'
            }
          }, user.name),
          React.createElement('div', {
            style: {
              fontSize: '0.75rem',
              color: '#6b7280',
              marginBottom: '0.25rem'
            }
          }, user.email),
          React.createElement('div', {
            style: {
              fontSize: '0.75rem',
              color: '#6b7280'
            }
          }, user.department)
        )
      ),
      // User Stats
      React.createElement('div', {
        style: {
          display: 'grid',
          gridTemplateColumns: 'repeat(2, 1fr)',
          gap: '1rem',
          marginBottom: '1rem'
        }
      },
        React.createElement('div', {
          style: {
            display: 'flex',
            alignItems: 'center',
            gap: '0.5rem'
          }
        },
          React.createElement(UsersIcon, { size: 16, color: '#6b7280' }),
          React.createElement('div', null,
            React.createElement('div', {
              style: {
                fontSize: '0.875rem',
                fontWeight: '500',
                color: '#1f2937'
              }
            }, user.groups),
            React.createElement('div', {
              style: {
                fontSize: '0.75rem',
                color: '#6b7280'
              }
            }, 'Groups')
          )
        ),
        React.createElement('div', {
          style: {
            display: 'flex',
            alignItems: 'center',
            gap: '0.5rem'
          }
        },
          React.createElement(Star, { size: 16, color: '#fbbf24', fill: '#fbbf24' }),
          React.createElement('div', null,
            React.createElement('div', {
              style: {
                fontSize: '0.875rem',
                fontWeight: '500',
                color: '#1f2937'
              }
            }, user.rating.toFixed(1)),
            React.createElement('div', {
              style: {
                fontSize: '0.75rem',
                color: '#6b7280'
              }
            }, 'Rating')
          )
        )
      ),
      // Performance and Activity
      React.createElement('div', {
        style: {
          display: 'flex',
          justifyContent: 'space-between',
          alignItems: 'center',
          marginBottom: '1rem'
        }
      },
        React.createElement('span', {
          style: {
            display: 'inline-flex',
            alignItems: 'center',
            gap: '0.25rem',
            padding: '0.25rem 0.5rem',
            borderRadius: '0.25rem',
            fontSize: '0.625rem',
            fontWeight: '500',
            backgroundColor: performanceColors.bg,
            color: performanceColors.color
          }
        }, user.performance.replace('-', ' ').toUpperCase()),
        React.createElement('span', {
          style: {
            fontSize: '0.75rem',
            color: '#6b7280'
          }
        }, `Last active: ${user.lastActive}`)
      ),
      // Skills
      React.createElement('div', {
        style: {
          marginBottom: '1rem'
        }
      },
        React.createElement('div', {
          style: {
            fontSize: '0.75rem',
            fontWeight: '500',
            color: '#374151',
            marginBottom: '0.5rem'
          }
        }, 'Skills'),
        React.createElement('div', {
          style: {
            display: 'flex',
            flexWrap: 'wrap',
            gap: '0.25rem'
          }
        },
          user.skills.slice(0, 3).map(skill => 
            React.createElement('span', {
              key: skill,
              style: {
                padding: '0.125rem 0.375rem',
                backgroundColor: '#f3f4f6',
                borderRadius: '0.25rem',
                fontSize: '0.625rem',
                color: '#374151'
              }
            }, skill)
          ),
          user.skills.length > 3 && React.createElement('span', {
            style: {
              fontSize: '0.625rem',
              color: '#6b7280'
            }
          }, `+${user.skills.length - 3} more`)
        )
      ),
      // Activity Chart
      React.createElement('div', {
        style: {
          marginBottom: '1rem'
        }
      },
        React.createElement('div', {
          style: {
            fontSize: '0.75rem',
            fontWeight: '500',
            color: '#374151',
            marginBottom: '0.5rem'
          }
        }, 'Device Usage'),
        React.createElement('div', {
          style: {
            display: 'flex',
            gap: '0.5rem',
            height: '6px'
          }
        },
          React.createElement('div', {
            style: {
              flex: user.deviceUsage.desktop,
              backgroundColor: '#3b82f6',
              borderRadius: '3px'
            }
          }),
          React.createElement('div', {
            style: {
              flex: user.deviceUsage.mobile,
              backgroundColor: '#10b981',
              borderRadius: '3px'
            }
          }),
          React.createElement('div', {
            style: {
              flex: user.deviceUsage.tablet,
              backgroundColor: '#f59e0b',
              borderRadius: '3px'
            }
          })
        ),
        React.createElement('div', {
          style: {
            display: 'flex',
            justifyContent: 'space-between',
            fontSize: '0.625rem',
            color: '#6b7280',
            marginTop: '0.25rem'
          }
        },
          React.createElement('span', null, `Desktop ${user.deviceUsage.desktop}%`),
          React.createElement('span', null, `Mobile ${user.deviceUsage.mobile}%`),
          React.createElement('span', null, `Tablet ${user.deviceUsage.tablet}%`)
        )
      ),
      // Action Menu
      React.createElement('div', {
        style: {
          position: 'relative'
        }
      },
        React.createElement('button', {
          onClick: (e) => {
            e.stopPropagation();
            setDropdownOpen(dropdownOpen === user.id ? null : user.id);
          },
          style: {
            padding: '0.5rem',
            backgroundColor: 'transparent',
            border: '1px solid #e5e7eb',
            borderRadius: '0.375rem',
            cursor: 'pointer',
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center',
            width: '100%'
          }
        },
          React.createElement(MoreVertical, { size: 16, color: '#6b7280' })
        ),
        dropdownOpen === user.id && React.createElement('div', {
          style: {
            position: 'absolute',
            top: '100%',
            right: 0,
            backgroundColor: 'white',
            border: '1px solid #e5e7eb',
            borderRadius: '0.375rem',
            boxShadow: '0 4px 6px rgba(0, 0, 0, 0.1)',
            zIndex: 10,
            minWidth: '150px'
          }
        },
          React.createElement('button', {
            onClick: (e) => {
              e.stopPropagation();
              handleUserAction('view', user.id);
              setDropdownOpen(null);
            },
            style: {
              width: '100%',
              padding: '0.5rem 0.75rem',
              backgroundColor: 'transparent',
              border: 'none',
              textAlign: 'left',
              fontSize: '0.875rem',
              color: '#374151',
              cursor: 'pointer',
              display: 'flex',
              alignItems: 'center',
              gap: '0.5rem'
            }
          },
            React.createElement(Eye, { size: 14 }),
            'View Details'
          ),
          React.createElement('button', {
            onClick: (e) => {
              e.stopPropagation();
              handleUserAction('edit', user.id);
              setDropdownOpen(null);
            },
            style: {
              width: '100%',
              padding: '0.5rem 0.75rem',
              backgroundColor: 'transparent',
              border: 'none',
              textAlign: 'left',
              fontSize: '0.875rem',
              color: '#374151',
              cursor: 'pointer',
              display: 'flex',
              alignItems: 'center',
              gap: '0.5rem'
            }
          },
            React.createElement(Edit, { size: 14 }),
            'Edit'
          ),
          React.createElement('button', {
            onClick: (e) => {
              e.stopPropagation();
              handleUserAction('sendEmail', user.id);
              setDropdownOpen(null);
            },
            style: {
              width: '100%',
              padding: '0.5rem 0.75rem',
              backgroundColor: 'transparent',
              border: 'none',
              textAlign: 'left',
              fontSize: '0.875rem',
              color: '#374151',
              cursor: 'pointer',
              display: 'flex',
              alignItems: 'center',
              gap: '0.5rem'
            }
          },
            React.createElement(Mail, { size: 14 }),
            'Send Email'
          ),
          React.createElement('button', {
            onClick: (e) => {
              e.stopPropagation();
              handleUserAction('resetPassword', user.id);
              setDropdownOpen(null);
            },
            style: {
              width: '100%',
              padding: '0.5rem 0.75rem',
              backgroundColor: 'transparent',
              border: 'none',
              textAlign: 'left',
              fontSize: '0.875rem',
              color: '#374151',
              cursor: 'pointer',
              display: 'flex',
              alignItems: 'center',
              gap: '0.5rem'
            }
          },
            React.createElement(Key, { size: 14 }),
            'Reset Password'
          ),
          React.createElement('button', {
            onClick: (e) => {
              e.stopPropagation();
              handleUserAction(user.status === 'active' ? 'suspend' : 'activate', user.id);
              setDropdownOpen(null);
            },
            style: {
              width: '100%',
              padding: '0.5rem 0.75rem',
              backgroundColor: 'transparent',
              border: 'none',
              textAlign: 'left',
              fontSize: '0.875rem',
              color: user.status === 'active' ? '#f59e0b' : '#10b981',
              cursor: 'pointer',
              display: 'flex',
              alignItems: 'center',
              gap: '0.5rem'
            }
          },
            user.status === 'active' ? React.createElement(Lock, { size: 14 }) : React.createElement(Unlock, { size: 14 }),
            user.status === 'active' ? 'Suspend' : 'Activate'
          ),
          React.createElement('button', {
            onClick: (e) => {
              e.stopPropagation();
              handleUserAction('delete', user.id);
              setDropdownOpen(null);
            },
            style: {
              width: '100%',
              padding: '0.5rem 0.75rem',
              backgroundColor: 'transparent',
              border: 'none',
              textAlign: 'left',
              fontSize: '0.875rem',
              color: '#dc2626',
              cursor: 'pointer',
              display: 'flex',
              alignItems: 'center',
              gap: '0.5rem'
            }
          },
            React.createElement(Trash2, { size: 14 }),
            'Delete'
          )
        )
      )
    );
  };

  return React.createElement('div', {
    style: {
      padding: '2rem',
      backgroundColor: 'white',
      borderRadius: '1rem',
      boxShadow: '0 4px 6px -1px rgba(0, 0, 0, 0.1)'
    }
  },
    // Advanced Header
    React.createElement('div', {
      style: {
        display: 'flex',
        justifyContent: 'space-between',
        alignItems: 'flex-start',
        marginBottom: '2rem'
      }
    },
      React.createElement('div', null,
        React.createElement('h2', {
          style: {
            fontSize: '2rem',
            fontWeight: 'bold',
            color: '#1f2937',
            marginBottom: '0.5rem'
          }
        }, 'User Management'),
        React.createElement('div', {
          style: {
            display: 'flex',
            alignItems: 'center',
            gap: '1rem',
            color: '#6b7280',
            fontSize: '0.875rem'
          }
        },
          React.createElement('span', null, `Showing ${sortedUsers.length} of ${users.length} users`),
          React.createElement('span', {
            style: {
              display: 'flex',
              alignItems: 'center',
              gap: '0.25rem',
              padding: '0.25rem 0.5rem',
              backgroundColor: '#dcfce7',
              color: '#166534',
              borderRadius: '0.25rem',
              fontWeight: '500'
            }
          },
            React.createElement(UserCheck, { size: 14 }),
            `${users.filter(u => u.status === 'active').length} Active`
          ),
          React.createElement('span', {
            style: {
              display: 'flex',
              alignItems: 'center',
              gap: '0.25rem',
              padding: '0.25rem 0.5rem',
              backgroundColor: '#dbeafe',
              color: '#1d4ed8',
              borderRadius: '0.25rem',
              fontWeight: '500'
            }
          },
            React.createElement(BarChart3, { size: 14 }),
            `${users.reduce((sum, u) => sum + u.activity.loginsThisWeek, 0)} Logins This Week`
          )
        )
      ),
      React.createElement('div', {
        style: {
          display: 'flex',
          gap: '0.75rem',
          alignItems: 'center'
        }
      },
        // View Mode Toggle
        React.createElement('div', {
          style: {
            display: 'flex',
            backgroundColor: '#f3f4f6',
            borderRadius: '0.375rem',
            padding: '0.25rem'
          }
        },
          React.createElement('button', {
            onClick: () => setViewMode('grid'),
            style: {
              padding: '0.375rem 0.75rem',
              backgroundColor: viewMode === 'grid' ? '#2563eb' : 'transparent',
              color: viewMode === 'grid' ? 'white' : '#374151',
              border: 'none',
              borderRadius: '0.25rem',
              fontSize: '0.75rem',
              fontWeight: '500',
              cursor: 'pointer'
            }
          }, 'Grid'),
          React.createElement('button', {
            onClick: () => setViewMode('list'),
            style: {
              padding: '0.375rem 0.75rem',
              backgroundColor: viewMode === 'list' ? '#2563eb' : 'transparent',
              color: viewMode === 'list' ? 'white' : '#374151',
              border: 'none',
              borderRadius: '0.25rem',
              fontSize: '0.75rem',
              fontWeight: '500',
              cursor: 'pointer'
            }
          }, 'List')
        ),
        // Action Buttons
        React.createElement('button', {
          onClick: () => setShowAdvancedFilters(!showAdvancedFilters),
          style: {
            display: 'flex',
            alignItems: 'center',
            gap: '0.5rem',
            padding: '0.5rem 1rem',
            backgroundColor: showAdvancedFilters ? '#2563eb' : '#f3f4f6',
            color: showAdvancedFilters ? 'white' : '#374151',
            border: '1px solid #d1d5db',
            borderRadius: '0.375rem',
            fontSize: '0.875rem',
            fontWeight: '500',
            cursor: 'pointer'
          }
        },
          React.createElement(Filter, { size: 16 }),
          'Advanced Filters'
        ),
        React.createElement('button', {
          onClick: () => setShowCreateModal(true),
          style: {
            display: 'flex',
            alignItems: 'center',
            gap: '0.5rem',
            padding: '0.5rem 1rem',
            backgroundColor: '#2563eb',
            color: 'white',
            border: 'none',
            borderRadius: '0.375rem',
            fontSize: '0.875rem',
            fontWeight: '500',
            cursor: 'pointer'
          }
        },
          React.createElement(UserPlus, { size: 16 }),
          'Add User'
        )
      )
    ),

    // Advanced Filters Panel
    showAdvancedFilters && React.createElement('div', {
      style: {
        padding: '1.5rem',
        backgroundColor: '#f9fafb',
        border: '1px solid #e5e7eb',
        borderRadius: '0.5rem',
        marginBottom: '1.5rem'
      }
    },
      React.createElement('div', {
        style: {
          display: 'grid',
          gridTemplateColumns: 'repeat(auto-fit, minmax(200px, 1fr))',
          gap: '1rem'
        }
      },
        React.createElement('div', null,
          React.createElement('label', {
            style: {
              display: 'block',
              fontSize: '0.875rem',
              fontWeight: '500',
              color: '#374151',
              marginBottom: '0.5rem'
            }
          }, 'Search'),
          React.createElement('div', {
            style: {
              position: 'relative'
            }
          },
            React.createElement(Search, {
              size: 16,
              color: '#6b7280',
              style: {
                position: 'absolute',
                left: '0.75rem',
                top: '50%',
                transform: 'translateY(-50%)'
              }
            }),
            React.createElement('input', {
              type: 'text',
              placeholder: 'Search users, skills, departments...',
              value: searchTerm,
              onChange: (e) => setSearchTerm(e.target.value),
              style: {
                width: '100%',
                padding: '0.5rem 0.75rem 0.5rem 2.5rem',
                border: '1px solid #d1d5db',
                borderRadius: '0.375rem',
                fontSize: '0.875rem'
              }
            })
          )
        ),
        React.createElement('div', null,
          React.createElement('label', {
            style: {
              display: 'block',
              fontSize: '0.875rem',
              fontWeight: '500',
              color: '#374151',
              marginBottom: '0.5rem'
            }
          }, 'Role'),
          React.createElement('select', {
            value: filterRole,
            onChange: (e) => setFilterRole(e.target.value),
            style: {
              width: '100%',
              padding: '0.5rem 0.75rem',
              border: '1px solid #d1d5db',
              borderRadius: '0.375rem',
              fontSize: '0.875rem',
              backgroundColor: 'white'
            }
          },
            React.createElement('option', { value: 'all' }, 'All Roles'),
            React.createElement('option', { value: 'admin' }, 'Admin'),
            React.createElement('option', { value: 'supervisor' }, 'Supervisor'),
            React.createElement('option', { value: 'student' }, 'Student')
          )
        ),
        React.createElement('div', null,
          React.createElement('label', {
            style: {
              display: 'block',
              fontSize: '0.875rem',
              fontWeight: '500',
              color: '#374151',
              marginBottom: '0.5rem'
            }
          }, 'Status'),
          React.createElement('select', {
            value: filterStatus,
            onChange: (e) => setFilterStatus(e.target.value),
            style: {
              width: '100%',
              padding: '0.5rem 0.75rem',
              border: '1px solid #d1d5db',
              borderRadius: '0.375rem',
              fontSize: '0.875rem',
              backgroundColor: 'white'
            }
          },
            React.createElement('option', { value: 'all' }, 'All Status'),
            React.createElement('option', { value: 'active' }, 'Active'),
            React.createElement('option', { value: 'inactive' }, 'Inactive'),
            React.createElement('option', { value: 'suspended' }, 'Suspended')
          )
        ),
        React.createElement('div', null,
          React.createElement('label', {
            style: {
              display: 'block',
              fontSize: '0.875rem',
              fontWeight: '500',
              color: '#374151',
              marginBottom: '0.5rem'
            }
          }, 'Department'),
          React.createElement('select', {
            value: filterDepartment,
            onChange: (e) => setFilterDepartment(e.target.value),
            style: {
              width: '100%',
              padding: '0.5rem 0.75rem',
              border: '1px solid #d1d5db',
              borderRadius: '0.375rem',
              fontSize: '0.875rem',
              backgroundColor: 'white'
            }
          },
            React.createElement('option', { value: 'all' }, 'All Departments'),
            ...Array.from(new Set(users.map(u => u.department))).map(dept => 
              React.createElement('option', { key: dept, value: dept }, dept)
            )
          )
        ),
        React.createElement('div', null,
          React.createElement('label', {
            style: {
              display: 'block',
              fontSize: '0.875rem',
              fontWeight: '500',
              color: '#374151',
              marginBottom: '0.5rem'
            }
          }, 'Sort By'),
          React.createElement('select', {
            value: sortBy,
            onChange: (e) => setSortBy(e.target.value),
            style: {
              width: '100%',
              padding: '0.5rem 0.75rem',
              border: '1px solid #d1d5db',
              borderRadius: '0.375rem',
              fontSize: '0.875rem',
              backgroundColor: 'white'
            }
          },
            React.createElement('option', { value: 'name' }, 'Name'),
            React.createElement('option', { value: 'role' }, 'Role'),
            React.createElement('option', { value: 'rating' }, 'Rating'),
            React.createElement('option', { value: 'joined' }, 'Joined Date'),
            React.createElement('option', { value: 'lastActive' }, 'Last Active'),
            React.createElement('option', { value: 'activity' }, 'Activity')
          )
        )
      )
    ),

    // Bulk Actions Bar
    selectedUsers.length > 0 && React.createElement('div', {
      style: {
        display: 'flex',
        justifyContent: 'space-between',
        alignItems: 'center',
        padding: '1rem',
        backgroundColor: '#eff6ff',
        border: '1px solid #bfdbfe',
        borderRadius: '0.5rem',
        marginBottom: '1.5rem'
      }
    },
      React.createElement('div', {
        style: {
          display: 'flex',
          alignItems: 'center',
          gap: '1rem'
        }
      },
        React.createElement('span', {
          style: {
            fontSize: '0.875rem',
            fontWeight: '500',
            color: '#1e40af'
          }
        }, `${selectedUsers.length} users selected`),
        React.createElement('button', {
          onClick: () => setSelectedUsers([]),
          style: {
            fontSize: '0.75rem',
            color: '#6b7280',
            background: 'none',
            border: 'none',
            cursor: 'pointer',
            textDecoration: 'underline'
          }
        }, 'Clear selection')
      ),
      React.createElement('div', {
        style: {
          display: 'flex',
          gap: '0.5rem'
        }
      },
        React.createElement('button', {
          onClick: () => console.log('Export selected users'),
          style: {
            display: 'flex',
            alignItems: 'center',
            gap: '0.25rem',
            padding: '0.375rem 0.75rem',
            backgroundColor: '#2563eb',
            color: 'white',
            border: 'none',
            borderRadius: '0.25rem',
            fontSize: '0.75rem',
            fontWeight: '500',
            cursor: 'pointer'
          }
        },
          React.createElement(Download, { size: 14 }),
          'Export'
        ),
        React.createElement('button', {
          onClick: () => console.log('Send email to selected users'),
          style: {
            display: 'flex',
            alignItems: 'center',
            gap: '0.25rem',
            padding: '0.375rem 0.75rem',
            backgroundColor: '#10b981',
            color: 'white',
            border: 'none',
            borderRadius: '0.25rem',
            fontSize: '0.75rem',
            fontWeight: '500',
            cursor: 'pointer'
          }
        },
          React.createElement(Mail, { size: 14 }),
          'Send Email'
        ),
        React.createElement('button', {
          onClick: () => console.log('Delete selected users'),
          style: {
            display: 'flex',
            alignItems: 'center',
            gap: '0.25rem',
            padding: '0.375rem 0.75rem',
            backgroundColor: '#ef4444',
            color: 'white',
            border: 'none',
            borderRadius: '0.25rem',
            fontSize: '0.75rem',
            fontWeight: '500',
            cursor: 'pointer'
          }
        },
          React.createElement(Trash2, { size: 14 }),
          'Delete'
        )
      )
    ),

    // Users Display
    React.createElement('div', {
      style: {
        display: viewMode === 'grid' ? 'grid' : 'block',
        gridTemplateColumns: viewMode === 'grid' ? 'repeat(auto-fill, minmax(400px, 1fr))' : 'none',
        gap: viewMode === 'grid' ? '1.5rem' : '0'
      }
    },
      sortedUsers.map(user => renderUserCard(user))
    )
  );
};

export default Users;
