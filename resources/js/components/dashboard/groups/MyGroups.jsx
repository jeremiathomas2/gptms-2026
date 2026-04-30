import React, { useState, useEffect } from 'react';
import { Plus, UsersIcon, UserCheck, AlertCircle, Star, MessageSquare, UserPlus, CheckCircle } from 'lucide-react';

const MyGroups = () => {
  const [groups, setGroups] = useState([]);
  const [showCreateModal, setShowCreateModal] = useState(false);

  useEffect(() => {
    // Mock data for user's groups
    setGroups([
      { id: 1, name: 'Web Development Squad', description: 'Building modern web applications', leader: 'John Doe', members: 4, maxMembers: 5, status: 'active', project: 'E-commerce Platform', rating: 4.8 },
      { id: 2, name: 'Data Science Research', description: 'Machine learning and data analysis', leader: 'Jane Smith', members: 3, maxMembers: 4, status: 'active', project: 'Predictive Analytics', rating: 4.6 },
      { id: 3, name: 'Mobile App Team', description: 'iOS and Android development', leader: 'Mike Johnson', members: 2, maxMembers: 3, status: 'recruiting', project: 'Fitness Tracker', rating: 4.2 }
    ]);
  }, []);

  const handleGroupAction = (action, groupId) => {
    console.log(`${action} group ${groupId}`);
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
        }, 'My Groups'),
        React.createElement('p', {
          style: {
            color: '#6b7280',
            fontSize: '0.875rem'
          }
        }, 'Groups you are a member of')
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
        React.createElement(Plus, { size: 16 }),
        'Join Group'
      )
    ),
    // Stats cards
    React.createElement('div', {
      style: {
        display: 'grid',
        gridTemplateColumns: 'repeat(auto-fit, minmax(200px, 1fr))',
        gap: '1rem',
        marginBottom: '2rem'
      }
    },
      React.createElement('div', {
        style: {
          padding: '1.5rem',
          backgroundColor: '#f0f9ff',
          border: '1px solid #bae6fd',
          borderRadius: '0.5rem'
        }
      },
        React.createElement('div', {
          style: {
            display: 'flex',
            alignItems: 'center',
            gap: '0.75rem',
            marginBottom: '0.5rem'
          }
        },
          React.createElement(UsersIcon, { size: 24, color: '#0284c7' }),
          React.createElement('span', {
            style: {
              fontSize: '2rem',
              fontWeight: 'bold',
              color: '#0c4a6e'
            }
          }, '3')
        ),
        React.createElement('div', {
          style: {
            fontSize: '0.875rem',
            color: '#0c4a6e'
          }
        }, 'Total Groups')
      ),
      React.createElement('div', {
        style: {
          padding: '1.5rem',
          backgroundColor: '#f0fdf4',
          border: '1px solid #bbf7d0',
          borderRadius: '0.5rem'
        }
      },
        React.createElement('div', {
          style: {
            display: 'flex',
            alignItems: 'center',
            gap: '0.75rem',
            marginBottom: '0.5rem'
          }
        },
          React.createElement(UserCheck, { size: 24, color: '#16a34a' }),
          React.createElement('span', {
            style: {
              fontSize: '2rem',
              fontWeight: 'bold',
              color: '#15803d'
            }
          }, '1')
        ),
        React.createElement('div', {
          style: {
            fontSize: '0.875rem',
            color: '#15803d'
          }
        }, 'Groups Leading')
      ),
      React.createElement('div', {
        style: {
          padding: '1.5rem',
          backgroundColor: '#fefce8',
          border: '1px solid #fde68a',
          borderRadius: '0.5rem'
        }
      },
        React.createElement('div', {
          style: {
            display: 'flex',
            alignItems: 'center',
            gap: '0.75rem',
            marginBottom: '0.5rem'
          }
        },
          React.createElement(AlertCircle, { size: 24, color: '#ca8a04' }),
          React.createElement('span', {
            style: {
              fontSize: '2rem',
              fontWeight: 'bold',
              color: '#a16207'
            }
          }, '2')
        ),
        React.createElement('div', {
          style: {
            fontSize: '0.875rem',
            color: '#a16207'
          }
        }, 'Pending Invites')
      )
    ),
    // My groups list
    React.createElement('div', {
      style: {
        display: 'grid',
        gridTemplateColumns: 'repeat(auto-fit, minmax(300px, 1fr))',
        gap: '1.5rem'
      }
    },
      ...groups.map(group => 
        React.createElement('div', {
          key: group.id,
          style: {
            padding: '1.5rem',
            border: '1px solid #e5e7eb',
            borderRadius: '0.5rem',
            backgroundColor: 'white',
            boxShadow: '0 1px 3px 0 rgba(0, 0, 0, 0.1)'
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
            React.createElement('div', null,
              React.createElement('h3', {
                style: {
                  fontSize: '1.125rem',
                  fontWeight: '600',
                  color: '#1f2937',
                  marginBottom: '0.25rem'
                }
              }, group.name),
              React.createElement('p', {
                style: {
                  fontSize: '0.875rem',
                  color: '#6b7280',
                  marginBottom: '0.5rem'
                }
              }, group.description)
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
                backgroundColor: group.status === 'active' ? '#dcfce7' : '#dbeafe',
                color: group.status === 'active' ? '#166534' : '#1d4ed8'
              }
            },
              group.status === 'active' && React.createElement(CheckCircle, { size: 12 }),
              group.status === 'active' ? 'Active' : 'Pending'
            )
          ),
          React.createElement('div', {
            style: {
              marginBottom: '1rem'
            }
          },
            React.createElement('div', {
              style: {
                display: 'flex',
                justifyContent: 'space-between',
                alignItems: 'center',
                marginBottom: '0.5rem'
              }
            },
              React.createElement('span', {
                style: {
                  fontSize: '0.875rem',
                  color: '#6b7280'
                }
              }, 'Leader'),
              React.createElement('span', {
                style: {
                  fontSize: '0.875rem',
                  fontWeight: '500',
                  color: '#1f2937'
                }
              }, group.leader)
            ),
            React.createElement('div', {
              style: {
                display: 'flex',
                justifyContent: 'space-between',
                alignItems: 'center',
                marginBottom: '0.5rem'
              }
            },
              React.createElement('span', {
                style: {
                  fontSize: '0.875rem',
                  color: '#6b7280'
                }
              }, 'Members'),
              React.createElement('span', {
                style: {
                  fontSize: '0.875rem',
                  fontWeight: '500',
                  color: '#1f2937'
                }
              }, `${group.members}/${group.maxMembers}`)
            ),
            React.createElement('div', {
              style: {
                display: 'flex',
                justifyContent: 'space-between',
                alignItems: 'center'
              }
            },
              React.createElement('span', {
                style: {
                  fontSize: '0.875rem',
                  color: '#6b7280'
                }
              }, 'Rating'),
              React.createElement('div', {
                style: {
                  display: 'flex',
                  alignItems: 'center',
                  gap: '0.25rem'
                }
              },
                React.createElement(Star, {
                  size: 14,
                  color: '#fbbf24',
                  fill: '#fbbf24'
                }),
                React.createElement('span', {
                  style: {
                    fontSize: '0.875rem',
                    fontWeight: '500',
                    color: '#1f2937'
                  }
                }, group.rating.toFixed(1))
              )
            )
          ),
          React.createElement('div', {
            style: {
              display: 'flex',
              gap: '0.5rem'
            }
          },
            React.createElement('button', {
              onClick: () => handleGroupAction('view', group.id),
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
            }, 'View Details'),
            React.createElement('button', {
              onClick: () => console.log('Open chat'),
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
            }, 'Chat')
          )
        )
      )
    ),
    // Recent activity
    React.createElement('div', {
      style: {
        marginTop: '2rem'
      }
    },
      React.createElement('h3', {
        style: {
          fontSize: '1.125rem',
          fontWeight: '600',
          color: '#1f2937',
          marginBottom: '1rem'
        }
      }, 'Recent Activity'),
      React.createElement('div', {
        style: {
          display: 'grid',
          gap: '0.75rem'
        }
      },
        React.createElement('div', {
          style: {
            display: 'flex',
            alignItems: 'center',
            gap: '0.75rem',
            padding: '0.75rem',
            backgroundColor: '#f9fafb',
            borderRadius: '0.375rem'
          }
        },
          React.createElement(MessageSquare, { size: 16, color: '#6b7280' }),
          React.createElement('div', {
            style: {
              flex: 1
            }
          },
            React.createElement('div', {
              style: {
                fontSize: '0.875rem',
                fontWeight: '500',
                color: '#1f2937'
              }
            }, 'New message in Web Development Squad'),
            React.createElement('div', {
              style: {
                fontSize: '0.75rem',
                color: '#6b7280'
              }
            }, '2 hours ago')
          )
        ),
        React.createElement('div', {
          style: {
            display: 'flex',
            alignItems: 'center',
            gap: '0.75rem',
            padding: '0.75rem',
            backgroundColor: '#f9fafb',
            borderRadius: '0.375rem'
          }
        },
          React.createElement(UserPlus, { size: 16, color: '#6b7280' }),
          React.createElement('div', {
            style: {
              flex: 1
            }
          },
            React.createElement('div', {
              style: {
                fontSize: '0.875rem',
                fontWeight: '500',
                color: '#1f2937'
              }
            }, 'New member joined AI Research Lab'),
            React.createElement('div', {
              style: {
                fontSize: '0.75rem',
                color: '#6b7280'
              }
            }, '5 hours ago')
          )
        )
      )
    )
  );
};

export default MyGroups;
