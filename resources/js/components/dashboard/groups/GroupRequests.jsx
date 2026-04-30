import React, { useState } from 'react';
import { UserPlus, Clock, CheckCircle, UserIcon } from 'lucide-react';

const GroupRequests = () => {
  const [activeTab, setActiveTab] = useState('incoming');

  const incomingRequests = [
    {
      id: 1,
      userName: 'Sarah Johnson',
      userEmail: 'sarah.johnson@university.edu',
      requestedAt: '2 hours ago',
      groupName: 'Web Development Squad',
      skills: ['React', 'JavaScript', 'Node.js', 'UI/UX Design'],
      status: 'pending'
    },
    {
      id: 2,
      userName: 'Mike Chen',
      userEmail: 'mike.chen@university.edu',
      requestedAt: '5 hours ago',
      groupName: 'Data Science Research Group',
      skills: ['Python', 'Machine Learning', 'Data Analysis'],
      status: 'accepted'
    }
  ];

  const handleRequestAction = (action, requestId) => {
    console.log(`${action} request ${requestId}`);
  };

  const handleSendInvitations = () => {
    console.log('Opening invitation modal');
  };

  return React.createElement('div', {
    style: {
      padding: '2rem',
      backgroundColor: 'white',
      borderRadius: '0.75rem',
      boxShadow: '0 1px 3px 0 rgba(0, 0, 0, 0.1)'
    }
  },
    // Header
    React.createElement('div', {
      style: {
        display: 'flex',
        justifyContent: 'space-between',
        alignItems: 'center',
        marginBottom: '2rem'
      }
    },
      React.createElement('div', null,
        React.createElement('h2', {
          style: {
            fontSize: '1.5rem',
            fontWeight: 'bold',
            color: '#1f2937',
            marginBottom: '0.25rem'
          }
        }, 'Group Requests'),
        React.createElement('p', {
          style: {
            color: '#6b7280',
            fontSize: '0.875rem'
          }
        }, 'Manage join requests and invitations')
      ),
      React.createElement('div', {
        style: {
          display: 'flex',
          gap: '0.5rem'
        }
      },
        React.createElement('button', {
          onClick: handleSendInvitations,
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
          'Invite Members'
        )
      )
    ),
    // Request tabs
    React.createElement('div', {
      style: {
        display: 'flex',
        gap: '0.25rem',
        marginBottom: '1.5rem',
        borderBottom: '1px solid #e5e7eb'
      }
    },
      ['incoming', 'outgoing', 'sent'].map(tab => 
        React.createElement('button', {
          key: tab,
          onClick: () => setActiveTab(tab),
          style: {
            padding: '0.75rem 1rem',
            backgroundColor: tab === activeTab ? '#2563eb' : 'transparent',
            color: tab === activeTab ? 'white' : '#6b7280',
            border: 'none',
            borderBottom: tab === activeTab ? '2px solid #2563eb' : '2px solid transparent',
            fontSize: '0.875rem',
            fontWeight: '500',
            cursor: 'pointer',
            borderRadius: '0.375rem 0.375rem 0 0'
          }
        },
          tab.charAt(0).toUpperCase() + tab.slice(1),
          tab === 'incoming' && React.createElement('span', {
            style: {
              marginLeft: '0.5rem',
              padding: '0.125rem 0.375rem',
              backgroundColor: '#1e40af',
              borderRadius: '0.25rem',
              fontSize: '0.75rem'
            }
          }, incomingRequests.length)
        )
      )
    ),
    // Incoming requests
    React.createElement('div', {
      style: {
        display: 'grid',
        gap: '1rem'
      }
    },
      ...incomingRequests.map(request => 
        React.createElement('div', {
          key: request.id,
          style: {
            padding: '1rem',
            border: '1px solid #e5e7eb',
            borderRadius: '0.5rem',
            backgroundColor: '#f9fafb'
          }
        },
          React.createElement('div', {
            style: {
              display: 'flex',
              justifyContent: 'space-between',
              alignItems: 'flex-start',
              marginBottom: '1rem'
            }
          },
            React.createElement('div', {
              style: {
                display: 'flex',
                gap: '0.75rem'
              }
            },
              React.createElement('div', {
                style: {
                  width: '40px',
                  height: '40px',
                  borderRadius: '50%',
                  backgroundColor: request.status === 'accepted' ? '#dcfce7' : '#dbeafe',
                  display: 'flex',
                  alignItems: 'center',
                  justifyContent: 'center'
                }
              },
                React.createElement(UserIcon, { 
                  size: 20, 
                  color: request.status === 'accepted' ? '#166534' : '#1d4ed8' 
                })
              ),
              React.createElement('div', null,
                React.createElement('div', {
                  style: {
                    fontSize: '1rem',
                    fontWeight: '600',
                    color: '#1f2937',
                    marginBottom: '0.25rem'
                  }
                }, request.userName),
                React.createElement('div', {
                  style: {
                    fontSize: '0.875rem',
                    color: '#6b7280',
                    marginBottom: '0.25rem'
                  }
                }, request.userEmail),
                React.createElement('div', {
                  style: {
                    fontSize: '0.75rem',
                    color: '#9ca3af'
                  }
                }, `Requested ${request.requestedAt}`)
              )
            ),
            React.createElement('span', {
              style: {
                display: 'inline-flex',
                alignItems: 'center',
                gap: '0.25rem',
                padding: '0.25rem 0.5rem',
                borderRadius: '0.25rem',
                fontSize: '0.75rem',
                fontWeight: '500',
                backgroundColor: request.status === 'accepted' ? '#dcfce7' : '#fef3c7',
                color: request.status === 'accepted' ? '#166534' : '#92400e'
              }
            },
              request.status === 'accepted' ? React.createElement(CheckCircle, { size: 12 }) : React.createElement(Clock, { size: 12 }),
              request.status === 'accepted' ? 'Accepted' : 'Pending'
            )
          ),
          React.createElement('div', {
            style: {
              marginBottom: '1rem'
            }
          },
            React.createElement('div', {
              style: {
                fontSize: '0.875rem',
                fontWeight: '500',
                color: '#1f2937',
                marginBottom: '0.25rem'
              }
            }, request.status === 'accepted' ? `Joined: ${request.groupName}` : `Wants to join: ${request.groupName}`),
            React.createElement('div', {
              style: {
                fontSize: '0.875rem',
                color: '#6b7280'
              }
            }, `Skills: ${request.skills.join(', ')}`)
          ),
          React.createElement('div', {
            style: {
              display: 'flex',
              gap: '0.5rem'
            }
          },
            request.status === 'pending' ? [
              React.createElement('button', {
                key: 'accept',
                onClick: () => handleRequestAction('accept', request.id),
                style: {
                  flex: 1,
                  padding: '0.5rem',
                  backgroundColor: '#10b981',
                  color: 'white',
                  border: 'none',
                  borderRadius: '0.375rem',
                  fontSize: '0.875rem',
                  fontWeight: '500',
                  cursor: 'pointer'
                }
              }, 'Accept'),
              React.createElement('button', {
                key: 'view',
                onClick: () => handleRequestAction('view', request.id),
                style: {
                  flex: 1,
                  padding: '0.5rem',
                  backgroundColor: '#f3f4f6',
                  color: '#374151',
                  border: '1px solid #d1d5db',
                  borderRadius: '0.375rem',
                  fontSize: '0.875rem',
                  fontWeight: '500',
                  cursor: 'pointer'
                }
              }, 'View Profile'),
              React.createElement('button', {
                key: 'reject',
                onClick: () => handleRequestAction('reject', request.id),
                style: {
                  padding: '0.5rem',
                  backgroundColor: '#ef4444',
                  color: 'white',
                  border: 'none',
                  borderRadius: '0.375rem',
                  fontSize: '0.875rem',
                  fontWeight: '500',
                  cursor: 'pointer'
                }
              }, 'Reject')
            ] : [
              React.createElement('button', {
                key: 'message',
                onClick: () => handleRequestAction('message', request.id),
                style: {
                  flex: 1,
                  padding: '0.5rem',
                  backgroundColor: '#2563eb',
                  color: 'white',
                  border: 'none',
                  borderRadius: '0.375rem',
                  fontSize: '0.875rem',
                  fontWeight: '500',
                  cursor: 'pointer'
                }
              }, 'Send Message'),
              React.createElement('button', {
                key: 'view',
                onClick: () => handleRequestAction('view', request.id),
                style: {
                  flex: 1,
                  padding: '0.5rem',
                  backgroundColor: '#f3f4f6',
                  color: '#374151',
                  border: '1px solid #d1d5db',
                  borderRadius: '0.375rem',
                  fontSize: '0.875rem',
                  fontWeight: '500',
                  cursor: 'pointer'
                }
              }, 'View Profile')
            ]
          )
        )
      )
    ),
    // Statistics
    React.createElement('div', {
      style: {
        marginTop: '2rem',
        padding: '1rem',
        backgroundColor: '#f8fafc',
        border: '1px solid #e2e8f0',
        borderRadius: '0.5rem'
      }
    },
      React.createElement('h3', {
        style: {
          fontSize: '1rem',
          fontWeight: '600',
          color: '#1f2937',
          marginBottom: '0.75rem'
        }
      }, 'Request Statistics'),
      React.createElement('div', {
        style: {
          display: 'grid',
          gridTemplateColumns: 'repeat(auto-fit, minmax(150px, 1fr))',
          gap: '1rem'
        }
      },
        React.createElement('div', null,
          React.createElement('div', {
            style: {
              fontSize: '1.5rem',
              fontWeight: 'bold',
              color: '#059669'
            }
          }, '8'),
          React.createElement('div', {
            style: {
              fontSize: '0.75rem',
              color: '#6b7280'
            }
          }, 'Total Requests')
        ),
        React.createElement('div', null,
          React.createElement('div', {
            style: {
              fontSize: '1.5rem',
              fontWeight: 'bold',
              color: '#2563eb'
            }
          }, '5'),
          React.createElement('div', {
            style: {
              fontSize: '0.75rem',
              color: '#6b7280'
            }
          }, 'Accepted')
        ),
        React.createElement('div', null,
          React.createElement('div', {
            style: {
              fontSize: '1.5rem',
              fontWeight: 'bold',
              color: '#d97706'
            }
          }, '2'),
          React.createElement('div', {
            style: {
              fontSize: '0.75rem',
              color: '#6b7280'
            }
          }, 'Pending')
        ),
        React.createElement('div', null,
          React.createElement('div', {
            style: {
              fontSize: '1.5rem',
              fontWeight: 'bold',
              color: '#dc2626'
            }
          }, '1'),
          React.createElement('div', {
            style: {
              fontSize: '0.75rem',
              color: '#6b7280'
            }
          }, 'Rejected')
        )
      )
    )
  );
};

export default GroupRequests;
