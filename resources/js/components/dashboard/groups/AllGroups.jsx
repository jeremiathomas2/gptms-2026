import React, { useState, useEffect } from 'react';
import { Search, Filter, Edit, Trash2, CheckCircle, Plus, Download, ChevronDown, Star, Users, Calendar, TrendingUp, MoreVertical, Eye, Mail, UserPlus, AlertCircle, Clock, Target, Award, BarChart3, Settings, RefreshCw, Archive } from 'lucide-react';

const AllGroups = () => {
  const [groups, setGroups] = useState([]);
  const [searchTerm, setSearchTerm] = useState('');
  const [filterStatus, setFilterStatus] = useState('all');
  const [filterProject, setFilterProject] = useState('all');
  const [sortBy, setSortBy] = useState('name');
  const [selectedGroups, setSelectedGroups] = useState([]);
  const [showCreateModal, setShowCreateModal] = useState(false);
  const [viewMode, setViewMode] = useState('grid'); // grid or list
  const [showAdvancedFilters, setShowAdvancedFilters] = useState(false);
  const [dropdownOpen, setDropdownOpen] = useState(null);

  useEffect(() => {
    // Enhanced mock data with more details
    setGroups([
      { 
        id: 1, 
        name: 'Web Development Squad', 
        description: 'Building modern web applications with cutting-edge technologies', 
        leader: 'John Doe', 
        leaderEmail: 'john.doe@university.edu',
        members: 4, 
        maxMembers: 5, 
        status: 'active', 
        project: 'E-commerce Platform', 
        rating: 4.8, 
        tags: ['React', 'Node.js', 'TypeScript', 'MongoDB'], 
        createdAt: '2024-01-15',
        lastActivity: '2024-01-20',
        progress: 85,
        milestones: 4,
        completedMilestones: 3,
        budget: 5000,
        spent: 3200,
        priority: 'high',
        skills: ['JavaScript', 'React', 'Node.js', 'CSS'],
        nextMeeting: '2024-01-25',
        availability: 'open'
      },
      { 
        id: 2, 
        name: 'Data Science Research', 
        description: 'Machine learning and data analysis for predictive modeling', 
        leader: 'Jane Smith',
        leaderEmail: 'jane.smith@university.edu', 
        members: 3, 
        maxMembers: 4, 
        status: 'active', 
        project: 'Predictive Analytics', 
        rating: 4.6, 
        tags: ['Python', 'ML', 'TensorFlow', 'Pandas'], 
        createdAt: '2024-01-20',
        lastActivity: '2024-01-22',
        progress: 72,
        milestones: 5,
        completedMilestones: 3,
        budget: 7500,
        spent: 4800,
        priority: 'medium',
        skills: ['Python', 'Machine Learning', 'Statistics', 'Data Visualization'],
        nextMeeting: '2024-01-26',
        availability: 'limited'
      },
      { 
        id: 3, 
        name: 'Mobile App Team', 
        description: 'iOS and Android development for fitness tracking', 
        leader: 'Mike Johnson',
        leaderEmail: 'mike.johnson@university.edu', 
        members: 2, 
        maxMembers: 3, 
        status: 'recruiting', 
        project: 'Fitness Tracker', 
        rating: 4.2, 
        tags: ['React Native', 'Flutter', 'Firebase'], 
        createdAt: '2024-02-01',
        lastActivity: '2024-01-21',
        progress: 45,
        milestones: 6,
        completedMilestones: 2,
        budget: 6000,
        spent: 2100,
        priority: 'medium',
        skills: ['React Native', 'Mobile Development', 'UI Design'],
        nextMeeting: '2024-01-27',
        availability: 'open'
      },
      { 
        id: 4, 
        name: 'AI Research Lab', 
        description: 'Artificial intelligence research for natural language processing', 
        leader: 'Sarah Wilson',
        leaderEmail: 'sarah.wilson@university.edu', 
        members: 5, 
        maxMembers: 6, 
        status: 'active', 
        project: 'NLP System', 
        rating: 4.9, 
        tags: ['AI', 'Python', 'NLP', 'Deep Learning'], 
        createdAt: '2024-01-10',
        lastActivity: '2024-01-23',
        progress: 91,
        milestones: 8,
        completedMilestones: 7,
        budget: 12000,
        spent: 10800,
        priority: 'high',
        skills: ['Python', 'Machine Learning', 'NLP', 'Research'],
        nextMeeting: '2024-01-24',
        availability: 'full'
      },
      { 
        id: 5, 
        name: 'UI/UX Design Studio', 
        description: 'User interface and experience design for modern applications', 
        leader: 'Emily Brown',
        leaderEmail: 'emily.brown@university.edu', 
        members: 3, 
        maxMembers: 4, 
        status: 'pending', 
        project: 'Design System', 
        rating: 4.5, 
        tags: ['Design', 'Figma', 'Adobe XD', 'Prototyping'], 
        createdAt: '2024-02-05',
        lastActivity: '2024-01-19',
        progress: 38,
        milestones: 4,
        completedMilestones: 1,
        budget: 4000,
        spent: 1200,
        priority: 'low',
        skills: ['UI Design', 'UX Research', 'Figma', 'Prototyping'],
        nextMeeting: '2024-01-28',
        availability: 'open'
      }
    ]);
  }, []);

  const filteredGroups = groups.filter(group => {
    const matchesSearch = group.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                         group.description.toLowerCase().includes(searchTerm.toLowerCase()) ||
                         group.leader.toLowerCase().includes(searchTerm.toLowerCase()) ||
                         group.tags.some(tag => tag.toLowerCase().includes(searchTerm.toLowerCase()));
    const matchesStatus = filterStatus === 'all' || group.status === filterStatus;
    const matchesProject = filterProject === 'all' || group.project === filterProject;
    return matchesSearch && matchesStatus && matchesProject;
  });

  const sortedGroups = [...filteredGroups].sort((a, b) => {
    switch (sortBy) {
      case 'name':
        return a.name.localeCompare(b.name);
      case 'members':
        return b.members - a.members;
      case 'rating':
        return b.rating - a.rating;
      case 'created':
        return new Date(b.createdAt) - new Date(a.createdAt);
      case 'progress':
        return b.progress - a.progress;
      case 'activity':
        return new Date(b.lastActivity) - new Date(a.lastActivity);
      default:
        return 0;
    }
  });

  const handleGroupAction = (action, groupId) => {
    const group = groups.find(g => g.id === groupId);
    switch (action) {
      case 'view':
        console.log(`Viewing details for group: ${group.name}`);
        break;
      case 'edit':
        console.log(`Editing group: ${group.name}`);
        break;
      case 'delete':
        if (window.confirm(`Are you sure you want to delete "${group.name}"?`)) {
          setGroups(groups.filter(g => g.id !== groupId));
        }
        break;
      case 'duplicate':
        console.log(`Duplicating group: ${group.name}`);
        break;
      case 'archive':
        console.log(`Archiving group: ${group.name}`);
        break;
      case 'export':
        console.log(`Exporting data for group: ${group.name}`);
        break;
      case 'contact':
        console.log(`Contacting leader of group: ${group.name}`);
        break;
      default:
        console.log(`${action} group ${groupId}`);
    }
  };

  const handleBulkAction = (action) => {
    console.log(`${action} groups:`, selectedGroups);
  };

  const toggleGroupSelection = (groupId) => {
    setSelectedGroups(prev => 
      prev.includes(groupId) 
        ? prev.filter(id => id !== groupId)
        : [...prev, groupId]
    );
  };

  const toggleAllGroups = () => {
    if (selectedGroups.length === sortedGroups.length) {
      setSelectedGroups([]);
    } else {
      setSelectedGroups(sortedGroups.map(g => g.id));
    }
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
        }, 'Groups Management'),
        React.createElement('div', {
          style: {
            display: 'flex',
            alignItems: 'center',
            gap: '1rem',
            color: '#6b7280',
            fontSize: '0.875rem'
          }
        },
          React.createElement('span', null, `Showing ${sortedGroups.length} of ${groups.length} groups`),
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
            React.createElement(Users, { size: 14 }),
            `${groups.reduce((sum, g) => sum + g.members, 0)} Total Members`
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
          React.createElement(Plus, { size: 16 }),
          'Create Group'
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
              placeholder: 'Search groups, leaders, tags...',
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
            React.createElement('option', { value: 'recruiting' }, 'Recruiting'),
            React.createElement('option', { value: 'pending' }, 'Pending')
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
          }, 'Project'),
          React.createElement('select', {
            value: filterProject,
            onChange: (e) => setFilterProject(e.target.value),
            style: {
              width: '100%',
              padding: '0.5rem 0.75rem',
              border: '1px solid #d1d5db',
              borderRadius: '0.375rem',
              fontSize: '0.875rem',
              backgroundColor: 'white'
            }
          },
            React.createElement('option', { value: 'all' }, 'All Projects'),
            ...Array.from(new Set(groups.map(g => g.project))).map(project => 
              React.createElement('option', { key: project, value: project }, project)
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
            React.createElement('option', { value: 'members' }, 'Members'),
            React.createElement('option', { value: 'rating' }, 'Rating'),
            React.createElement('option', { value: 'progress' }, 'Progress'),
            React.createElement('option', { value: 'activity' }, 'Last Activity'),
            React.createElement('option', { value: 'created' }, 'Created Date')
          )
        )
      )
    ),

    // Bulk Actions Bar
    selectedGroups.length > 0 && React.createElement('div', {
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
        }, `${selectedGroups.length} groups selected`),
        React.createElement('button', {
          onClick: () => setSelectedGroups([]),
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
          onClick: () => handleBulkAction('export'),
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
          onClick: () => handleBulkAction('archive'),
          style: {
            display: 'flex',
            alignItems: 'center',
            gap: '0.25rem',
            padding: '0.375rem 0.75rem',
            backgroundColor: '#f59e0b',
            color: 'white',
            border: 'none',
            borderRadius: '0.25rem',
            fontSize: '0.75rem',
            fontWeight: '500',
            cursor: 'pointer'
          }
        },
          React.createElement(Archive, { size: 14 }),
          'Archive'
        ),
        React.createElement('button', {
          onClick: () => handleBulkAction('delete'),
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

    // Groups Display (Grid or List View)
    viewMode === 'grid' ? 
      // Grid View
      React.createElement('div', {
        style: {
          display: 'grid',
          gridTemplateColumns: 'repeat(auto-fill, minmax(350px, 1fr))',
          gap: '1.5rem'
        }
      },
        sortedGroups.map(group => 
          React.createElement('div', {
            key: group.id,
            style: {
              backgroundColor: 'white',
              border: '1px solid #e5e7eb',
              borderRadius: '0.75rem',
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
                checked: selectedGroups.includes(group.id),
                onChange: (e) => {
                  e.stopPropagation();
                  toggleGroupSelection(group.id);
                },
                style: {
                  width: '16px',
                  height: '16px'
                }
              })
            ),
            // Priority Badge
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
                  backgroundColor: 
                    group.priority === 'high' ? '#fef2f2' :
                    group.priority === 'medium' ? '#fefce8' :
                    '#f0fdf4',
                  color: 
                    group.priority === 'high' ? '#991b1b' :
                    group.priority === 'medium' ? '#854d0e' :
                    '#166534'
                }
              },
                group.priority.toUpperCase()
              )
            ),
            // Group Header
            React.createElement('div', {
              style: {
                marginBottom: '1rem',
                paddingLeft: '2rem'
              }
            },
              React.createElement('h3', {
                style: {
                  fontSize: '1.125rem',
                  fontWeight: '600',
                  color: '#1f2937',
                  marginBottom: '0.5rem'
                }
              }, group.name),
              React.createElement('p', {
                style: {
                  fontSize: '0.875rem',
                  color: '#6b7280',
                  lineHeight: '1.5',
                  marginBottom: '0.75rem'
                }
              }, group.description),
              React.createElement('div', {
                style: {
                  display: 'flex',
                  flexWrap: 'wrap',
                  gap: '0.25rem'
                }
              },
                group.tags.slice(0, 3).map(tag => 
                  React.createElement('span', {
                    key: tag,
                    style: {
                      padding: '0.125rem 0.375rem',
                      backgroundColor: '#f3f4f6',
                      borderRadius: '0.25rem',
                      fontSize: '0.625rem',
                      color: '#374151'
                    }
                  }, tag)
                ),
                group.tags.length > 3 && React.createElement('span', {
                  style: {
                    fontSize: '0.625rem',
                    color: '#6b7280'
                  }
                }, `+${group.tags.length - 3} more`)
              )
            ),
            // Group Stats
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
                React.createElement(Users, { size: 16, color: '#6b7280' }),
                React.createElement('div', null,
                  React.createElement('div', {
                    style: {
                      fontSize: '0.875rem',
                      fontWeight: '500',
                      color: '#1f2937'
                    }
                  }, `${group.members}/${group.maxMembers}`),
                  React.createElement('div', {
                    style: {
                      fontSize: '0.75rem',
                      color: '#6b7280'
                    }
                  }, 'Members')
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
                  }, group.rating.toFixed(1)),
                  React.createElement('div', {
                    style: {
                      fontSize: '0.75rem',
                      color: '#6b7280'
                    }
                  }, 'Rating')
                )
              )
            ),
            // Progress Bar
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
                    fontSize: '0.75rem',
                    fontWeight: '500',
                    color: '#374151'
                  }
                }, 'Progress'),
                React.createElement('span', {
                  style: {
                    fontSize: '0.75rem',
                    color: '#6b7280'
                  }
                }, `${group.progress}%`)
              ),
              React.createElement('div', {
                style: {
                  width: '100%',
                  height: '6px',
                  backgroundColor: '#e5e7eb',
                  borderRadius: '3px',
                  overflow: 'hidden'
                }
              },
                React.createElement('div', {
                  style: {
                    width: `${group.progress}%`,
                    height: '100%',
                    backgroundColor: 
                      group.progress >= 80 ? '#10b981' :
                      group.progress >= 60 ? '#f59e0b' :
                      '#ef4444',
                    borderRadius: '3px',
                    transition: 'width 0.3s ease'
                  }
                })
              )
            ),
            // Leader Info
            React.createElement('div', {
              style: {
                display: 'flex',
                justifyContent: 'space-between',
                alignItems: 'center',
                paddingTop: '1rem',
                borderTop: '1px solid #f3f4f6'
              }
            },
              React.createElement('div', {
                style: {
                  display: 'flex',
                  alignItems: 'center',
                  gap: '0.5rem'
                }
              },
                React.createElement('div', {
                  style: {
                    width: '32px',
                    height: '32px',
                    borderRadius: '50%',
                    backgroundColor: '#e5e7eb',
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center'
                  }
                },
                  React.createElement(User, { size: 16, color: '#6b7280' })
                ),
                React.createElement('div', null,
                  React.createElement('div', {
                    style: {
                      fontSize: '0.875rem',
                      fontWeight: '500',
                      color: '#1f2937'
                    }
                  }, group.leader),
                  React.createElement('div', {
                    style: {
                      fontSize: '0.75rem',
                      color: '#6b7280'
                    }
                  }, group.project)
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
                    setDropdownOpen(dropdownOpen === group.id ? null : group.id);
                  },
                  style: {
                    padding: '0.5rem',
                    backgroundColor: 'transparent',
                    border: 'none',
                    borderRadius: '0.25rem',
                    cursor: 'pointer',
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center'
                  }
                },
                  React.createElement(MoreVertical, { size: 16, color: '#6b7280' })
                ),
                dropdownOpen === group.id && React.createElement('div', {
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
                      handleGroupAction('view', group.id);
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
                      handleGroupAction('edit', group.id);
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
                      handleGroupAction('contact', group.id);
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
                    'Contact'
                  ),
                  React.createElement('button', {
                    onClick: (e) => {
                      e.stopPropagation();
                      handleGroupAction('delete', group.id);
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
            )
          )
        )
      ) :
      // List View (Enhanced Table)
      React.createElement('div', {
        style: {
          overflowX: 'auto',
          border: '1px solid #e5e7eb',
          borderRadius: '0.5rem'
        }
      },
        React.createElement('table', {
          style: {
            width: '100%',
            borderCollapse: 'collapse'
          }
        },
          React.createElement('thead', {
            style: {
              backgroundColor: '#f9fafb',
              borderBottom: '1px solid #e5e7eb'
            }
          },
            React.createElement('tr', null,
              React.createElement('th', {
                style: {
                  padding: '1rem',
                  textAlign: 'left',
                  fontSize: '0.875rem',
                  fontWeight: '600',
                  color: '#374151',
                  borderRight: '1px solid #e5e7eb'
                }
              },
                React.createElement('input', {
                  type: 'checkbox',
                  checked: selectedGroups.length === sortedGroups.length,
                  onChange: toggleAllGroups,
                  style: {
                    marginRight: '0.5rem'
                  }
                }),
                'Group'
              ),
              React.createElement('th', {
                style: {
                  padding: '1rem',
                  textAlign: 'left',
                  fontSize: '0.875rem',
                  fontWeight: '600',
                  color: '#374151',
                  borderRight: '1px solid #e5e7eb'
                }
              }, 'Leader'),
              React.createElement('th', {
                style: {
                  padding: '1rem',
                  textAlign: 'left',
                  fontSize: '0.875rem',
                  fontWeight: '600',
                  color: '#374151',
                  borderRight: '1px solid #e5e7eb'
                }
              }, 'Members'),
              React.createElement('th', {
                style: {
                  padding: '1rem',
                  textAlign: 'left',
                  fontSize: '0.875rem',
                  fontWeight: '600',
                  color: '#374151',
                  borderRight: '1px solid #e5e7eb'
                }
              }, 'Progress'),
              React.createElement('th', {
                style: {
                  padding: '1rem',
                  textAlign: 'left',
                  fontSize: '0.875rem',
                  fontWeight: '600',
                  color: '#374151',
                  borderRight: '1px solid #e5e7eb'
                }
              }, 'Status'),
              React.createElement('th', {
                style: {
                  padding: '1rem',
                  textAlign: 'left',
                  fontSize: '0.875rem',
                  fontWeight: '600',
                  color: '#374151',
                  borderRight: '1px solid #e5e7eb'
                }
              }, 'Rating'),
              React.createElement('th', {
                style: {
                  padding: '1rem',
                  textAlign: 'center',
                  fontSize: '0.875rem',
                  fontWeight: '600',
                  color: '#374151'
                }
              }, 'Actions')
            )
          ),
          React.createElement('tbody', null,
            sortedGroups.map(group => 
              React.createElement('tr', {
                key: group.id,
                style: {
                  borderBottom: '1px solid #e5e7eb',
                  backgroundColor: selectedGroups.includes(group.id) ? '#f0f9ff' : 'white',
                  transition: 'background-color 0.2s ease'
                },
                onMouseEnter: (e) => {
                  if (!selectedGroups.includes(group.id)) {
                    e.currentTarget.style.backgroundColor = '#f9fafb';
                  }
                },
                onMouseLeave: (e) => {
                  if (!selectedGroups.includes(group.id)) {
                    e.currentTarget.style.backgroundColor = 'white';
                  }
                }
              },
                React.createElement('td', {
                  style: {
                    padding: '1rem',
                    borderRight: '1px solid #e5e7eb'
                  }
                },
                  React.createElement('div', {
                    style: {
                      display: 'flex',
                      alignItems: 'flex-start',
                      gap: '0.75rem'
                    }
                  },
                    React.createElement('input', {
                      type: 'checkbox',
                      checked: selectedGroups.includes(group.id),
                      onChange: () => toggleGroupSelection(group.id),
                      style: {
                        marginTop: '0.25rem'
                      }
                    }),
                    React.createElement('div', {
                      style: {
                        flex: 1
                      }
                    },
                      React.createElement('div', {
                        style: {
                          display: 'flex',
                          alignItems: 'center',
                          gap: '0.5rem',
                          marginBottom: '0.25rem'
                        }
                      },
                        React.createElement('div', {
                          style: {
                            fontSize: '0.875rem',
                            fontWeight: '600',
                            color: '#1f2937'
                          }
                        }, group.name),
                        React.createElement('span', {
                          style: {
                            display: 'inline-flex',
                            alignItems: 'center',
                            gap: '0.25rem',
                            padding: '0.125rem 0.375rem',
                            borderRadius: '0.25rem',
                            fontSize: '0.625rem',
                            fontWeight: '500',
                            backgroundColor: 
                              group.priority === 'high' ? '#fef2f2' :
                              group.priority === 'medium' ? '#fefce8' :
                              '#f0fdf4',
                            color: 
                              group.priority === 'high' ? '#991b1b' :
                              group.priority === 'medium' ? '#854d0e' :
                              '#166534'
                          }
                        }, group.priority.toUpperCase())
                      ),
                      React.createElement('div', {
                        style: {
                          fontSize: '0.75rem',
                          color: '#6b7280',
                          marginBottom: '0.5rem'
                        }
                      }, group.description),
                      React.createElement('div', {
                        style: {
                          display: 'flex',
                          gap: '0.25rem'
                        }
                      },
                        group.tags.slice(0, 2).map(tag => 
                          React.createElement('span', {
                            key: tag,
                            style: {
                              padding: '0.125rem 0.25rem',
                              backgroundColor: '#f3f4f6',
                              borderRadius: '0.25rem',
                              fontSize: '0.625rem',
                              color: '#374151'
                            }
                          }, tag)
                        ),
                        group.tags.length > 2 && React.createElement('span', {
                          style: {
                            fontSize: '0.625rem',
                            color: '#6b7280'
                          }
                        }, `+${group.tags.length - 2}`)
                      )
                    )
                  )
                ),
                React.createElement('td', {
                  style: {
                    padding: '1rem',
                    fontSize: '0.875rem',
                    color: '#374151',
                    borderRight: '1px solid #e5e7eb'
                  }
                },
                  React.createElement('div', null,
                    React.createElement('div', {
                      style: {
                        fontWeight: '500',
                        marginBottom: '0.25rem'
                      }
                    }, group.leader),
                    React.createElement('div', {
                      style: {
                        fontSize: '0.75rem',
                        color: '#6b7280'
                      }
                    }, group.project)
                  )
                ),
                React.createElement('td', {
                  style: {
                    padding: '1rem',
                    borderRight: '1px solid #e5e7eb'
                  }
                },
                  React.createElement('div', {
                    style: {
                      display: 'flex',
                      alignItems: 'center',
                      gap: '0.5rem'
                    }
                  },
                    React.createElement(Users, { size: 16, color: '#6b7280' }),
                    React.createElement('span', {
                      style: {
                        fontSize: '0.875rem',
                        fontWeight: '500',
                        color: '#1f2937'
                      }
                    }, `${group.members}/${group.maxMembers}`),
                    React.createElement('div', {
                      style: {
                        width: '40px',
                        height: '6px',
                        backgroundColor: '#e5e7eb',
                        borderRadius: '3px',
                        overflow: 'hidden'
                      }
                    },
                      React.createElement('div', {
                        style: {
                          width: `${(group.members / group.maxMembers) * 100}%`,
                          height: '100%',
                          backgroundColor: group.members / group.maxMembers > 0.8 ? '#ef4444' : '#10b981'
                        }
                      })
                    )
                  )
                ),
                React.createElement('td', {
                  style: {
                    padding: '1rem',
                    borderRight: '1px solid #e5e7eb'
                  }
                },
                  React.createElement('div', {
                    style: {
                      display: 'flex',
                      alignItems: 'center',
                      gap: '0.5rem'
                    }
                  },
                    React.createElement('div', {
                      style: {
                        width: '60px',
                        height: '6px',
                        backgroundColor: '#e5e7eb',
                        borderRadius: '3px',
                        overflow: 'hidden'
                      }
                    },
                      React.createElement('div', {
                        style: {
                          width: `${group.progress}%`,
                          height: '100%',
                          backgroundColor: 
                            group.progress >= 80 ? '#10b981' :
                            group.progress >= 60 ? '#f59e0b' :
                            '#ef4444'
                        }
                      })
                    ),
                    React.createElement('span', {
                      style: {
                        fontSize: '0.875rem',
                        fontWeight: '500',
                        color: '#1f2937'
                      }
                    }, `${group.progress}%`)
                  )
                ),
                React.createElement('td', {
                  style: {
                    padding: '1rem',
                    borderRight: '1px solid #e5e7eb'
                  }
                },
                  React.createElement('span', {
                    style: {
                      display: 'inline-flex',
                      alignItems: 'center',
                      gap: '0.25rem',
                      padding: '0.25rem 0.5rem',
                      borderRadius: '0.25rem',
                      fontSize: '0.75rem',
                      fontWeight: '500',
                      backgroundColor: group.status === 'active' ? '#dcfce7' : 
                                     group.status === 'recruiting' ? '#dbeafe' : '#fef3c7',
                      color: group.status === 'active' ? '#166534' : 
                            group.status === 'recruiting' ? '#1d4ed8' : '#92400e'
                    }
                  },
                    group.status === 'active' && React.createElement(CheckCircle, { size: 12 }),
                    group.status.charAt(0).toUpperCase() + group.status.slice(1)
                  )
                ),
                React.createElement('td', {
                  style: {
                    padding: '1rem',
                    borderRight: '1px solid #e5e7eb'
                  }
                },
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
                ),
                React.createElement('td', {
                  style: {
                    padding: '1rem',
                    textAlign: 'center'
                  }
                },
                  React.createElement('div', {
                    style: {
                      display: 'flex',
                      justifyContent: 'center',
                      gap: '0.5rem'
                    }
                  },
                    React.createElement('button', {
                      onClick: () => handleGroupAction('view', group.id),
                      style: {
                        padding: '0.375rem 0.5rem',
                        backgroundColor: '#2563eb',
                        color: 'white',
                        border: 'none',
                        borderRadius: '0.25rem',
                        fontSize: '0.75rem',
                        fontWeight: '500',
                        cursor: 'pointer'
                      }
                    }, 'View'),
                    React.createElement('button', {
                      onClick: () => handleGroupAction('edit', group.id),
                      style: {
                        padding: '0.375rem 0.5rem',
                        backgroundColor: '#f59e0b',
                        color: 'white',
                        border: 'none',
                        borderRadius: '0.25rem',
                        fontSize: '0.75rem',
                        fontWeight: '500',
                        cursor: 'pointer'
                      }
                    }, React.createElement(Edit, { size: 12 })),
                    React.createElement('button', {
                      onClick: () => handleGroupAction('delete', group.id),
                      style: {
                        padding: '0.375rem 0.5rem',
                        backgroundColor: '#ef4444',
                        color: 'white',
                        border: 'none',
                        borderRadius: '0.25rem',
                        fontSize: '0.75rem',
                        fontWeight: '500',
                        cursor: 'pointer'
                      }
                    }, React.createElement(Trash2, { size: 12 }))
                  )
                )
              )
            )
          )
        )
      )
  );
};

export default AllGroups;
