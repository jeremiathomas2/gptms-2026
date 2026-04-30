import React, { useState, useEffect } from 'react';
import { Plus, Search, Filter, Calendar, Users, Target, Star, Edit, Trash2, Download, MoreVertical, Eye, Clock, AlertCircle, CheckCircle, XCircle, BarChart3, Settings, GitBranch, TrendingUp, Award, MessageSquare, UserPlus, Archive, Play, Pause, RotateCcw } from 'lucide-react';

const Projects = () => {
  const [projects, setProjects] = useState([]);
  const [searchTerm, setSearchTerm] = useState('');
  const [filterStatus, setFilterStatus] = useState('all');
  const [filterPriority, setFilterPriority] = useState('all');
  const [filterTeam, setFilterTeam] = useState('all');
  const [sortBy, setSortBy] = useState('name');
  const [viewMode, setViewMode] = useState('kanban'); // kanban, list, gantt, calendar
  const [selectedProjects, setSelectedProjects] = useState([]);
  const [showCreateModal, setShowCreateModal] = useState(false);
  const [showAdvancedFilters, setShowAdvancedFilters] = useState(false);
  const [dropdownOpen, setDropdownOpen] = useState(null);

  useEffect(() => {
    // Enhanced mock data with comprehensive project details
    setProjects([
      {
        id: 1,
        name: 'E-commerce Platform',
        description: 'Full-stack e-commerce solution with payment integration and real-time inventory management',
        status: 'active',
        progress: 75,
        team: 'Web Development Squad',
        teamId: 1,
        startDate: '2024-01-15',
        endDate: '2024-06-30',
        priority: 'high',
        budget: 50000,
        spent: 37500,
        currency: 'USD',
        milestones: [
          { id: 1, name: 'Design Phase', completed: true, dueDate: '2024-02-01' },
          { id: 2, name: 'Backend Development', completed: true, dueDate: '2024-03-15' },
          { id: 3, name: 'Frontend Development', completed: true, dueDate: '2024-04-30' },
          { id: 4, name: 'Payment Integration', completed: false, dueDate: '2024-05-15' },
          { id: 5, name: 'Testing & Deployment', completed: false, dueDate: '2024-06-30' }
        ],
        tasks: [
          { id: 1, title: 'Database Design', status: 'completed', assignee: 'John Doe', priority: 'high' },
          { id: 2, title: 'API Development', status: 'completed', assignee: 'Jane Smith', priority: 'high' },
          { id: 3, title: 'Payment Gateway', status: 'in-progress', assignee: 'Mike Johnson', priority: 'high' },
          { id: 4, title: 'User Interface', status: 'in-progress', assignee: 'Sarah Wilson', priority: 'medium' },
          { id: 5, title: 'Testing Suite', status: 'todo', assignee: 'Tom Brown', priority: 'medium' }
        ],
        risks: [
          { id: 1, title: 'Payment API Integration', severity: 'medium', mitigation: 'Use fallback payment providers' },
          { id: 2, title: 'Performance Optimization', severity: 'low', mitigation: 'Implement caching strategies' }
        ],
        documents: [
          { id: 1, name: 'Project Charter', type: 'pdf', size: '2.3 MB', uploaded: '2024-01-15' },
          { id: 2, name: 'Technical Specifications', type: 'docx', size: '1.8 MB', uploaded: '2024-01-20' }
        ],
        tags: ['E-commerce', 'React', 'Node.js', 'MongoDB', 'Stripe'],
        health: 'good', // good, at-risk, critical
        lastUpdated: '2024-01-23',
        nextMilestone: 'Payment Integration',
        daysUntilDeadline: 128,
        completionRate: 75,
        velocity: 85,
        qualityScore: 4.2
      },
      {
        id: 2,
        name: 'Predictive Analytics',
        description: 'Machine learning model for business predictions with real-time data processing',
        status: 'active',
        progress: 60,
        team: 'Data Science Research',
        teamId: 2,
        startDate: '2024-02-01',
        endDate: '2024-08-15',
        priority: 'medium',
        budget: 35000,
        spent: 21000,
        currency: 'USD',
        milestones: [
          { id: 1, name: 'Data Collection', completed: true, dueDate: '2024-03-01' },
          { id: 2, name: 'Model Development', completed: true, dueDate: '2024-04-15' },
          { id: 3, name: 'Training & Testing', completed: false, dueDate: '2024-06-01' },
          { id: 4, name: 'Deployment', completed: false, dueDate: '2024-08-15' }
        ],
        tasks: [
          { id: 1, title: 'Data Pipeline', status: 'completed', assignee: 'Alice Chen', priority: 'high' },
          { id: 2, title: 'Feature Engineering', status: 'completed', assignee: 'Bob Zhang', priority: 'high' },
          { id: 3, title: 'Model Training', status: 'in-progress', assignee: 'Carol Davis', priority: 'high' },
          { id: 4, title: 'Validation', status: 'todo', assignee: 'David Lee', priority: 'medium' }
        ],
        risks: [
          { id: 1, title: 'Data Quality Issues', severity: 'high', mitigation: 'Implement data validation checks' },
          { id: 2, title: 'Model Accuracy', severity: 'medium', mitigation: 'Cross-validation with multiple datasets' }
        ],
        documents: [
          { id: 1, name: 'Research Paper', type: 'pdf', size: '4.1 MB', uploaded: '2024-02-01' },
          { id: 2, name: 'Dataset Schema', type: 'xlsx', size: '856 KB', uploaded: '2024-02-10' }
        ],
        tags: ['Machine Learning', 'Python', 'TensorFlow', 'Data Science'],
        health: 'at-risk',
        lastUpdated: '2024-01-22',
        nextMilestone: 'Training & Testing',
        daysUntilDeadline: 175,
        completionRate: 60,
        velocity: 72,
        qualityScore: 3.8
      },
      {
        id: 3,
        name: 'Fitness Tracker',
        description: 'Mobile app for health and fitness tracking with social features and gamification',
        status: 'planning',
        progress: 25,
        team: 'Mobile App Team',
        teamId: 3,
        startDate: '2024-03-01',
        endDate: '2024-09-30',
        priority: 'low',
        budget: 25000,
        spent: 6250,
        currency: 'USD',
        milestones: [
          { id: 1, name: 'Requirements Gathering', completed: true, dueDate: '2024-03-15' },
          { id: 2, name: 'UI/UX Design', completed: false, dueDate: '2024-04-30' },
          { id: 3, name: 'Development Sprint 1', completed: false, dueDate: '2024-06-15' },
          { id: 4, name: 'Development Sprint 2', completed: false, dueDate: '2024-08-15' },
          { id: 5, name: 'Launch & Marketing', completed: false, dueDate: '2024-09-30' }
        ],
        tasks: [
          { id: 1, title: 'Market Research', status: 'completed', assignee: 'Emma Wilson', priority: 'high' },
          { id: 2, title: 'Wireframing', status: 'in-progress', assignee: 'Frank Miller', priority: 'high' },
          { id: 3, title: 'Prototype Development', status: 'todo', assignee: 'Grace Lee', priority: 'medium' }
        ],
        risks: [
          { id: 1, title: 'App Store Approval', severity: 'medium', mitigation: 'Early submission and testing' }
        ],
        documents: [
          { id: 1, name: 'Market Analysis', type: 'pdf', size: '3.2 MB', uploaded: '2024-03-01' }
        ],
        tags: ['Mobile', 'React Native', 'Health', 'Fitness', 'iOS', 'Android'],
        health: 'good',
        lastUpdated: '2024-01-21',
        nextMilestone: 'UI/UX Design',
        daysUntilDeadline: 221,
        completionRate: 25,
        velocity: 68,
        qualityScore: 4.0
      },
      {
        id: 4,
        name: 'AI Research Lab',
        description: 'Advanced artificial intelligence research for natural language processing and computer vision',
        status: 'active',
        progress: 85,
        team: 'AI Research Lab',
        teamId: 4,
        startDate: '2024-01-10',
        endDate: '2024-12-31',
        priority: 'high',
        budget: 120000,
        spent: 102000,
        currency: 'USD',
        milestones: [
          { id: 1, name: 'Literature Review', completed: true, dueDate: '2024-02-28' },
          { id: 2, name: 'Dataset Preparation', completed: true, dueDate: '2024-04-30' },
          { id: 3, name: 'Model Architecture', completed: true, dueDate: '2024-07-31' },
          { id: 4, name: 'Implementation', completed: false, dueDate: '2024-10-31' },
          { id: 5, name: 'Publication', completed: false, dueDate: '2024-12-31' }
        ],
        tasks: [
          { id: 1, title: 'NLP Model Development', status: 'completed', assignee: 'Dr. Sarah Chen', priority: 'high' },
          { id: 2, title: 'Computer Vision Pipeline', status: 'completed', assignee: 'Dr. Michael Zhang', priority: 'high' },
          { id: 3, title: 'Integration Testing', status: 'in-progress', assignee: 'Dr. Lisa Wang', priority: 'high' },
          { id: 4, title: 'Performance Optimization', status: 'in-progress', assignee: 'Dr. James Liu', priority: 'medium' }
        ],
        risks: [
          { id: 1, title: 'Computational Resources', severity: 'medium', mitigation: 'Cloud scaling and optimization' },
          { id: 2, title: 'Research Timeline', severity: 'low', mitigation: 'Parallel research tracks' }
        ],
        documents: [
          { id: 1, name: 'Research Proposal', type: 'pdf', size: '5.7 MB', uploaded: '2024-01-10' },
          { id: 2, name: 'Technical Architecture', type: 'docx', size: '2.1 MB', uploaded: '2024-01-15' }
        ],
        tags: ['AI', 'Machine Learning', 'NLP', 'Computer Vision', 'Research'],
        health: 'critical',
        lastUpdated: '2024-01-24',
        nextMilestone: 'Implementation',
        daysUntilDeadline: 341,
        completionRate: 85,
        velocity: 92,
        qualityScore: 4.7
      },
      {
        id: 5,
        name: 'Data Analytics Dashboard',
        description: 'Real-time business intelligence dashboard with advanced data visualization',
        status: 'on-hold',
        progress: 45,
        team: 'Data Science Research',
        teamId: 2,
        startDate: '2024-01-20',
        endDate: '2024-07-20',
        priority: 'medium',
        budget: 40000,
        spent: 18000,
        currency: 'USD',
        milestones: [
          { id: 1, name: 'Requirements Analysis', completed: true, dueDate: '2024-02-20' },
          { id: 2, name: 'Dashboard Design', completed: true, dueDate: '2024-03-20' },
          { id: 3, name: 'Data Integration', completed: false, dueDate: '2024-05-20' },
          { id: 4, name: 'Visualization Implementation', completed: false, dueDate: '2024-06-20' },
          { id: 5, name: 'User Testing', completed: false, dueDate: '2024-07-20' }
        ],
        tasks: [
          { id: 1, title: 'Data Source Integration', status: 'completed', assignee: 'Tom Anderson', priority: 'high' },
          { id: 2, title: 'Chart Development', status: 'in-progress', assignee: 'Lisa Brown', priority: 'high' },
          { id: 3, title: 'User Interface', status: 'todo', assignee: 'John Smith', priority: 'medium' }
        ],
        risks: [
          { id: 1, title: 'Data Source Availability', severity: 'high', mitigation: 'Multiple data source integration' }
        ],
        documents: [
          { id: 1, name: 'Dashboard Mockups', type: 'figma', size: '12.3 MB', uploaded: '2024-01-20' }
        ],
        tags: ['Analytics', 'Dashboard', 'Data Visualization', 'Business Intelligence'],
        health: 'at-risk',
        lastUpdated: '2024-01-18',
        nextMilestone: 'Data Integration',
        daysUntilDeadline: 179,
        completionRate: 45,
        velocity: 55,
        qualityScore: 3.5
      }
    ]);
  }, []);

  const filteredProjects = projects.filter(project => {
    const matchesSearch = project.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                         project.description.toLowerCase().includes(searchTerm.toLowerCase()) ||
                         project.team.toLowerCase().includes(searchTerm.toLowerCase()) ||
                         project.tags.some(tag => tag.toLowerCase().includes(searchTerm.toLowerCase()));
    const matchesStatus = filterStatus === 'all' || project.status === filterStatus;
    const matchesPriority = filterPriority === 'all' || project.priority === filterPriority;
    const matchesTeam = filterTeam === 'all' || project.team === filterTeam;
    return matchesSearch && matchesStatus && matchesPriority && matchesTeam;
  });

  const sortedProjects = [...filteredProjects].sort((a, b) => {
    switch (sortBy) {
      case 'name':
        return a.name.localeCompare(b.name);
      case 'progress':
        return b.progress - a.progress;
      case 'priority':
        const priorityOrder = { high: 3, medium: 2, low: 1 };
        return priorityOrder[b.priority] - priorityOrder[a.priority];
      case 'deadline':
        return new Date(a.endDate) - new Date(b.endDate);
      case 'budget':
        return b.budget - a.budget;
      case 'health':
        const healthOrder = { critical: 3, 'at-risk': 2, good: 1 };
        return healthOrder[b.health] - healthOrder[a.health];
      default:
        return 0;
    }
  });

  const getStatusColor = (status) => {
    switch (status) {
      case 'active':
        return { bg: '#dcfce7', color: '#166534', icon: CheckCircle };
      case 'completed':
        return { bg: '#dbeafe', color: '#1d4ed8', icon: CheckCircle };
      case 'planning':
        return { bg: '#fef3c7', color: '#92400e', icon: Clock };
      case 'on-hold':
        return { bg: '#f3f4f6', color: '#374151', icon: Pause };
      default:
        return { bg: '#f3f4f6', color: '#374151', icon: AlertCircle };
    }
  };

  const getPriorityColor = (priority) => {
    switch (priority) {
      case 'high':
        return { bg: '#fecaca', color: '#991b1b' };
      case 'medium':
        return { bg: '#fef3c7', color: '#92400e' };
      case 'low':
        return { bg: '#dcfce7', color: '#166534' };
      default:
        return { bg: '#f3f4f6', color: '#374151' };
    }
  };

  const getHealthColor = (health) => {
    switch (health) {
      case 'good':
        return { bg: '#dcfce7', color: '#166534' };
      case 'at-risk':
        return { bg: '#fef3c7', color: '#92400e' };
      case 'critical':
        return { bg: '#fecaca', color: '#991b1b' };
      default:
        return { bg: '#f3f4f6', color: '#374151' };
    }
  };

  const handleProjectAction = (action, projectId) => {
    const project = projects.find(p => p.id === projectId);
    switch (action) {
      case 'view':
        console.log(`Viewing project: ${project.name}`);
        break;
      case 'edit':
        console.log(`Editing project: ${project.name}`);
        break;
      case 'delete':
        if (window.confirm(`Are you sure you want to delete "${project.name}"?`)) {
          setProjects(projects.filter(p => p.id !== projectId));
        }
        break;
      case 'duplicate':
        console.log(`Duplicating project: ${project.name}`);
        break;
      case 'archive':
        console.log(`Archiving project: ${project.name}`);
        break;
      case 'pause':
        console.log(`Pausing project: ${project.name}`);
        break;
      case 'resume':
        console.log(`Resuming project: ${project.name}`);
        break;
      default:
        console.log(`${action} project ${projectId}`);
    }
  };

  const toggleProjectSelection = (projectId) => {
    setSelectedProjects(prev => 
      prev.includes(projectId) 
        ? prev.filter(id => id !== projectId)
        : [...prev, projectId]
    );
  };

  const toggleAllProjects = () => {
    if (selectedProjects.length === sortedProjects.length) {
      setSelectedProjects([]);
    } else {
      setSelectedProjects(sortedProjects.map(p => p.id));
    }
  };

  const renderKanbanBoard = () => {
    const columns = [
      { id: 'planning', title: 'Planning', status: 'planning' },
      { id: 'active', title: 'Active', status: 'active' },
      { id: 'on-hold', title: 'On Hold', status: 'on-hold' },
      { id: 'completed', title: 'Completed', status: 'completed' }
    ];

    return React.createElement('div', {
      style: {
        display: 'grid',
        gridTemplateColumns: `repeat(${columns.length}, 1fr)`,
        gap: '1rem',
        minHeight: '600px'
      }
    },
      columns.map(column => 
        React.createElement('div', {
          key: column.id,
          style: {
            backgroundColor: '#f9fafb',
            borderRadius: '0.5rem',
            padding: '1rem'
          }
        },
          React.createElement('div', {
            style: {
              display: 'flex',
              justifyContent: 'space-between',
              alignItems: 'center',
              marginBottom: '1rem'
            }
          },
            React.createElement('h3', {
              style: {
                fontSize: '1rem',
                fontWeight: '600',
                color: '#374151',
                margin: 0
              }
            }, column.title),
            React.createElement('span', {
              style: {
                backgroundColor: '#e5e7eb',
                color: '#374151',
                padding: '0.25rem 0.5rem',
                borderRadius: '0.25rem',
                fontSize: '0.75rem',
                fontWeight: '500'
              }
            }, projects.filter(p => p.status === column.status).length)
          ),
          React.createElement('div', {
            style: {
              display: 'flex',
              flexDirection: 'column',
              gap: '0.75rem'
            }
          },
            sortedProjects.filter(p => p.status === column.status).map(project => {
              const statusColors = getStatusColor(project.status);
              const priorityColors = getPriorityColor(project.priority);
              const healthColors = getHealthColor(project.health);
              
              return React.createElement('div', {
                key: project.id,
                style: {
                  backgroundColor: 'white',
                  border: '1px solid #e5e7eb',
                  borderRadius: '0.5rem',
                  padding: '1rem',
                  cursor: 'pointer',
                  transition: 'transform 0.2s ease, box-shadow 0.2s ease'
                },
                onMouseEnter: (e) => {
                  e.currentTarget.style.transform = 'translateY(-2px)';
                  e.currentTarget.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.1)';
                },
                onMouseLeave: (e) => {
                  e.currentTarget.style.transform = 'translateY(0)';
                  e.currentTarget.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
                }
              },
                React.createElement('div', {
                  style: {
                    display: 'flex',
                    justifyContent: 'space-between',
                    alignItems: 'flex-start',
                    marginBottom: '0.75rem'
                  }
                },
                  React.createElement('div', null,
                    React.createElement('h4', {
                      style: {
                        fontSize: '0.875rem',
                        fontWeight: '600',
                        color: '#1f2937',
                        marginBottom: '0.25rem',
                        lineHeight: '1.3'
                      }
                    }, project.name),
                    React.createElement('p', {
                      style: {
                        fontSize: '0.75rem',
                        color: '#6b7280',
                        marginBottom: '0.5rem',
                        lineHeight: '1.4'
                      }
                    }, project.description.length > 60 ? project.description.substring(0, 60) + '...' : project.description)
                  ),
                  React.createElement('div', {
                    style: {
                      display: 'flex',
                      flexDirection: 'column',
                      gap: '0.25rem',
                      alignItems: 'flex-end'
                    }
                  },
                    React.createElement('span', {
                      style: {
                        display: 'inline-flex',
                        alignItems: 'center',
                        gap: '0.25rem',
                        padding: '0.125rem 0.375rem',
                        borderRadius: '0.25rem',
                        fontSize: '0.625rem',
                        fontWeight: '500',
                        backgroundColor: priorityColors.bg,
                        color: priorityColors.color
                      }
                    }, project.priority.toUpperCase()),
                    React.createElement('span', {
                      style: {
                        display: 'inline-flex',
                        alignItems: 'center',
                        gap: '0.25rem',
                        padding: '0.125rem 0.375rem',
                        borderRadius: '0.25rem',
                        fontSize: '0.625rem',
                        fontWeight: '500',
                        backgroundColor: healthColors.bg,
                        color: healthColors.color
                      }
                    }, project.health.replace('-', ' ').toUpperCase())
                  )
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
                      fontSize: '0.75rem',
                      color: '#6b7280'
                    }
                  }, project.team),
                  React.createElement('span', {
                    style: {
                      fontSize: '0.75rem',
                      fontWeight: '500',
                      color: '#1f2937'
                    }
                  }, `${project.progress}%`)
                ),
                React.createElement('div', {
                  style: {
                    width: '100%',
                    height: '4px',
                    backgroundColor: '#e5e7eb',
                    borderRadius: '2px',
                    overflow: 'hidden',
                    marginBottom: '0.5rem'
                  }
                },
                  React.createElement('div', {
                    style: {
                      width: `${project.progress}%`,
                      height: '100%',
                      backgroundColor: project.progress >= 80 ? '#10b981' : project.progress >= 60 ? '#f59e0b' : '#ef4444'
                    }
                  })
                ),
                React.createElement('div', {
                  style: {
                    display: 'flex',
                    justifyContent: 'space-between',
                    alignItems: 'center'
                  }
                },
                  React.createElement('div', {
                    style: {
                      display: 'flex',
                      gap: '0.25rem'
                    }
                  },
                    project.tags.slice(0, 2).map(tag => 
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
                    )
                  ),
                  React.createElement('button', {
                    onClick: (e) => {
                      e.stopPropagation();
                      setDropdownOpen(dropdownOpen === project.id ? null : project.id);
                    },
                    style: {
                      padding: '0.25rem',
                      backgroundColor: 'transparent',
                      border: 'none',
                      borderRadius: '0.25rem',
                      cursor: 'pointer'
                    }
                  },
                    React.createElement(MoreVertical, { size: 14, color: '#6b7280' })
                  )
                )
              );
            })
          )
        )
      )
    );
  };

  const renderListView = () => {
    return React.createElement('div', {
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
                checked: selectedProjects.length === sortedProjects.length,
                onChange: toggleAllProjects,
                style: {
                  marginRight: '0.5rem'
                }
              }),
              'Project'
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
            }, 'Team'),
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
            }, 'Budget'),
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
            }, 'Health'),
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
          sortedProjects.map(project => {
            const statusColors = getStatusColor(project.status);
            const healthColors = getHealthColor(project.health);
            
            return React.createElement('tr', {
              key: project.id,
              style: {
                borderBottom: '1px solid #e5e7eb',
                backgroundColor: selectedProjects.includes(project.id) ? '#f0f9ff' : 'white'
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
                    checked: selectedProjects.includes(project.id),
                    onChange: () => toggleProjectSelection(project.id),
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
                        fontSize: '0.875rem',
                        fontWeight: '600',
                        color: '#1f2937',
                        marginBottom: '0.25rem'
                      }
                    }, project.name),
                    React.createElement('div', {
                      style: {
                        fontSize: '0.75rem',
                        color: '#6b7280',
                        marginBottom: '0.25rem'
                      }
                    }, project.description.length > 80 ? project.description.substring(0, 80) + '...' : project.description),
                    React.createElement('div', {
                      style: {
                        display: 'flex',
                        gap: '0.25rem'
                      }
                    },
                      project.tags.slice(0, 3).map(tag => 
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
                      )
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
              }, project.team),
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
                        width: `${project.progress}%`,
                        height: '100%',
                        backgroundColor: project.progress >= 80 ? '#10b981' : project.progress >= 60 ? '#f59e0b' : '#ef4444'
                      }
                    })
                  ),
                  React.createElement('span', {
                    style: {
                      fontSize: '0.875rem',
                      fontWeight: '500',
                      color: '#1f2937'
                    }
                  }, `${project.progress}%`)
                )
              ),
              React.createElement('td', {
                style: {
                  padding: '1rem',
                  fontSize: '0.875rem',
                  color: '#374151',
                  borderRight: '1px solid #e5e7eb'
                }
              }, `$${project.budget.toLocaleString()}`),
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
                    backgroundColor: statusColors.bg,
                    color: statusColors.color
                  }
                },
                  React.createElement(statusColors.icon, { size: 12 }),
                  project.status.charAt(0).toUpperCase() + project.status.slice(1)
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
                    backgroundColor: healthColors.bg,
                    color: healthColors.color
                  }
                }, project.health.replace('-', ' ').toUpperCase())
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
                    onClick: () => handleProjectAction('view', project.id),
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
                    onClick: () => handleProjectAction('edit', project.id),
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
                    onClick: () => handleProjectAction('delete', project.id),
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
            );
          })
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
        }, 'Projects Management'),
        React.createElement('div', {
          style: {
            display: 'flex',
            alignItems: 'center',
            gap: '1rem',
            color: '#6b7280',
            fontSize: '0.875rem'
          }
        },
          React.createElement('span', null, `Showing ${sortedProjects.length} of ${projects.length} projects`),
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
            React.createElement(Target, { size: 14 }),
            `${projects.filter(p => p.status === 'active').length} Active`
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
            `$${projects.reduce((sum, p) => sum + p.budget, 0).toLocaleString()} Total Budget`
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
            onClick: () => setViewMode('kanban'),
            style: {
              padding: '0.375rem 0.75rem',
              backgroundColor: viewMode === 'kanban' ? '#2563eb' : 'transparent',
              color: viewMode === 'kanban' ? 'white' : '#374151',
              border: 'none',
              borderRadius: '0.25rem',
              fontSize: '0.75rem',
              fontWeight: '500',
              cursor: 'pointer'
            }
          }, 'Kanban'),
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
          'New Project'
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
              placeholder: 'Search projects, teams, tags...',
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
            React.createElement('option', { value: 'planning' }, 'Planning'),
            React.createElement('option', { value: 'on-hold' }, 'On Hold'),
            React.createElement('option', { value: 'completed' }, 'Completed')
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
          }, 'Priority'),
          React.createElement('select', {
            value: filterPriority,
            onChange: (e) => setFilterPriority(e.target.value),
            style: {
              width: '100%',
              padding: '0.5rem 0.75rem',
              border: '1px solid #d1d5db',
              borderRadius: '0.375rem',
              fontSize: '0.875rem',
              backgroundColor: 'white'
            }
          },
            React.createElement('option', { value: 'all' }, 'All Priority'),
            React.createElement('option', { value: 'high' }, 'High'),
            React.createElement('option', { value: 'medium' }, 'Medium'),
            React.createElement('option', { value: 'low' }, 'Low')
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
          }, 'Team'),
          React.createElement('select', {
            value: filterTeam,
            onChange: (e) => setFilterTeam(e.target.value),
            style: {
              width: '100%',
              padding: '0.5rem 0.75rem',
              border: '1px solid #d1d5db',
              borderRadius: '0.375rem',
              fontSize: '0.875rem',
              backgroundColor: 'white'
            }
          },
            React.createElement('option', { value: 'all' }, 'All Teams'),
            ...Array.from(new Set(projects.map(p => p.team))).map(team => 
              React.createElement('option', { key: team, value: team }, team)
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
            React.createElement('option', { value: 'progress' }, 'Progress'),
            React.createElement('option', { value: 'priority' }, 'Priority'),
            React.createElement('option', { value: 'deadline' }, 'Deadline'),
            React.createElement('option', { value: 'budget' }, 'Budget'),
            React.createElement('option', { value: 'health' }, 'Health')
          )
        )
      )
    ),

    // Bulk Actions Bar
    selectedProjects.length > 0 && React.createElement('div', {
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
        }, `${selectedProjects.length} projects selected`),
        React.createElement('button', {
          onClick: () => setSelectedProjects([]),
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
          onClick: () => console.log('Export selected projects'),
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
          onClick: () => console.log('Archive selected projects'),
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
          onClick: () => console.log('Delete selected projects'),
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

    // Projects Display based on view mode
    viewMode === 'kanban' ? renderKanbanBoard() : renderListView()
  );
};

export default Projects;
