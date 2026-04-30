import React, { useState, useEffect } from 'react';
import { TrendingUp, Users, Target, Calendar, Download, Filter, BarChart3, PieChart, Activity, Eye, Settings, RefreshCw, AlertCircle, Clock, Award, Zap, Globe, Smartphone, Monitor, Tablet, ChevronDown, ChevronUp, MoreVertical, ArrowUp, ArrowDown, Minus } from 'lucide-react';

const Analytics = () => {
  const [period, setPeriod] = useState('month');
  const [chartType, setChartType] = useState('overview');
  const [timeRange, setTimeRange] = useState('30d');
  const [selectedMetrics, setSelectedMetrics] = useState(['users', 'groups', 'performance']);
  const [showAdvancedFilters, setShowAdvancedFilters] = useState(false);
  const [loading, setLoading] = useState(false);
  const [dropdownOpen, setDropdownOpen] = useState(null);

  useEffect(() => {
    // Simulate loading analytics data
    setLoading(true);
    const timer = setTimeout(() => {
      setLoading(false);
    }, 1000);
    return () => clearTimeout(timer);
  }, [period, timeRange]);

  const metrics = [
    {
      id: 'users',
      title: 'Total Users',
      value: '1,234',
      change: '+12%',
      trend: 'up',
      icon: Users,
      color: '#3b82f6',
      bgColor: '#dbeafe',
      details: {
        current: 1234,
        previous: 1102,
        growth: 12.0,
        newThisPeriod: 89,
        activeThisPeriod: 1156,
        churnRate: 2.3
      }
    },
    {
      id: 'groups',
      title: 'Active Groups',
      value: '45',
      change: '+8%',
      trend: 'up',
      icon: Target,
      color: '#10b981',
      bgColor: '#d1fae5',
      details: {
        current: 45,
        previous: 42,
        growth: 7.1,
        avgMembers: 27.4,
        completionRate: 78.5,
        avgDuration: '45 days'
      }
    },
    {
      id: 'performance',
      title: 'Completion Rate',
      value: '87%',
      change: '+5%',
      trend: 'up',
      icon: TrendingUp,
      color: '#f59e0b',
      bgColor: '#fef3c7',
      details: {
        current: 87.2,
        previous: 83.0,
        growth: 5.1,
        onTimeCompletion: 92.3,
        avgQuality: 4.2,
        satisfaction: 4.6
      }
    },
    {
      id: 'response',
      title: 'Avg. Response Time',
      value: '2.3h',
      change: '-15%',
      trend: 'down',
      icon: Clock,
      color: '#ef4444',
      bgColor: '#fecaca',
      details: {
        current: 2.3,
        previous: 2.7,
        improvement: 14.8,
        slaCompliance: 94.2,
        peakHours: '2-4 PM',
        weekendAvg: 4.1
      }
    },
    {
      id: 'engagement',
      title: 'User Engagement',
      value: '76%',
      change: '+3%',
      trend: 'up',
      icon: Activity,
      color: '#8b5cf6',
      bgColor: '#ede9fe',
      details: {
        current: 76.4,
        previous: 74.1,
        growth: 3.1,
        dailyActive: 892,
        weeklyActive: 1156,
        monthlyActive: 1234
      }
    },
    {
      id: 'revenue',
      title: 'Revenue',
      value: '$45.2K',
      change: '+18%',
      trend: 'up',
      icon: Award,
      color: '#10b981',
      bgColor: '#d1fae5',
      details: {
        current: 45200,
        previous: 38305,
        growth: 18.0,
        perUser: 36.6,
        recurring: 78.5,
        churn: 2.3
      }
    }
  ];

  const chartData = {
    overview: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      datasets: [
        {
          label: 'Users',
          data: [890, 920, 980, 1050, 1120, 1234],
          color: '#3b82f6'
        },
        {
          label: 'Groups',
          data: [32, 35, 38, 40, 42, 45],
          color: '#10b981'
        },
        {
          label: 'Projects',
          data: [120, 135, 148, 162, 178, 195],
          color: '#f59e0b'
        }
      ]
    },
    userActivity: {
      labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      datasets: [
        {
          label: 'Active Users',
          data: [890, 920, 1150, 1180, 1120, 650, 480],
          color: '#3b82f6'
        },
        {
          label: 'New Users',
          data: [12, 15, 18, 22, 19, 8, 5],
          color: '#10b981'
        }
      ]
    },
    deviceUsage: {
      labels: ['Desktop', 'Mobile', 'Tablet'],
      datasets: [
        {
          label: 'Usage %',
          data: [65, 28, 7],
          color: ['#3b82f6', '#10b981', '#f59e0b']
        }
      ]
    },
    performance: {
      labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
      datasets: [
        {
          label: 'Completion Rate',
          data: [82, 85, 87, 89],
          color: '#10b981'
        },
        {
          label: 'Quality Score',
          data: [4.0, 4.1, 4.2, 4.3],
          color: '#f59e0b'
        }
      ]
    }
  };

  const trafficSources = [
    { source: 'Direct', users: 456, percentage: 37, color: '#3b82f6' },
    { source: 'Social Media', users: 298, percentage: 24, color: '#10b981' },
    { source: 'Email', users: 234, percentage: 19, color: '#f59e0b' },
    { source: 'Search', users: 148, percentage: 12, color: '#8b5cf6' },
    { source: 'Referral', users: 98, percentage: 8, color: '#ef4444' }
  ];

  const topPages = [
    { page: '/dashboard', views: 3420, avgTime: '5:23', bounceRate: 23 },
    { page: '/groups', views: 2890, avgTime: '4:15', bounceRate: 31 },
    { page: '/projects', views: 2156, avgTime: '6:45', bounceRate: 19 },
    { page: '/analytics', views: 1876, avgTime: '3:28', bounceRate: 42 },
    { page: '/users', views: 1234, avgTime: '2:56', bounceRate: 38 }
  ];

  const renderMetricCard = (metric) => {
    return React.createElement('div', {
      key: metric.id,
      style: {
        backgroundColor: 'white',
        border: '1px solid #e5e7eb',
        borderRadius: '1rem',
        padding: '1.5rem',
        position: 'relative',
        transition: 'transform 0.2s ease, box-shadow 0.2s ease'
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
      // Header
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
            alignItems: 'center',
            gap: '0.75rem'
          }
        },
          React.createElement('div', {
            style: {
              width: '48px',
              height: '48px',
              borderRadius: '0.75rem',
              backgroundColor: metric.bgColor,
              display: 'flex',
              alignItems: 'center',
              justifyContent: 'center'
            }
          },
            React.createElement(metric.icon, { size: 24, color: metric.color })
          ),
          React.createElement('div', null,
            React.createElement('h3', {
              style: {
                fontSize: '0.875rem',
                fontWeight: '500',
                color: '#6b7280',
                marginBottom: '0.25rem'
              }
            }, metric.title),
            React.createElement('div', {
              style: {
                fontSize: '1.875rem',
                fontWeight: '700',
                color: '#1f2937',
                lineHeight: '1'
              }
            }, metric.value)
          )
        ),
        React.createElement('div', {
          style: {
            display: 'flex',
            alignItems: 'center',
            gap: '0.25rem',
            padding: '0.25rem 0.5rem',
            borderRadius: '0.375rem',
            backgroundColor: metric.trend === 'up' ? '#dcfce7' : '#fecaca',
            color: metric.trend === 'up' ? '#166534' : '#991b1b',
            fontSize: '0.75rem',
            fontWeight: '500'
          }
        },
          metric.trend === 'up' ? React.createElement(ArrowUp, { size: 12 }) : React.createElement(ArrowDown, { size: 12 }),
          metric.change
        )
      ),
      // Details
      React.createElement('div', {
        style: {
          display: 'grid',
          gridTemplateColumns: 'repeat(2, 1fr)',
          gap: '0.75rem'
        }
      },
        React.createElement('div', null,
          React.createElement('div', {
            style: {
              fontSize: '0.75rem',
              color: '#6b7280',
              marginBottom: '0.125rem'
            }
          }, 'Previous Period'),
          React.createElement('div', {
            style: {
              fontSize: '0.875rem',
              fontWeight: '500',
              color: '#1f2937'
            }
          }, metric.details.previous.toLocaleString())
        ),
        React.createElement('div', null,
          React.createElement('div', {
            style: {
              fontSize: '0.75rem',
              color: '#6b7280',
              marginBottom: '0.125rem'
            }
          }, 'Growth'),
          React.createElement('div', {
            style: {
              fontSize: '0.875rem',
              fontWeight: '500',
              color: metric.trend === 'up' ? '#059669' : '#dc2626'
            }
          }, `${metric.details.growth > 0 ? '+' : ''}${metric.details.growth}%`)
        )
      ),
      // Action Button
      React.createElement('button', {
        onClick: () => setDropdownOpen(dropdownOpen === metric.id ? null : metric.id),
        style: {
          width: '100%',
          marginTop: '1rem',
          padding: '0.5rem',
          backgroundColor: '#f9fafb',
          border: '1px solid #e5e7eb',
          borderRadius: '0.5rem',
          fontSize: '0.75rem',
          color: '#6b7280',
          cursor: 'pointer',
          display: 'flex',
          alignItems: 'center',
          justifyContent: 'center',
          gap: '0.5rem'
        }
      },
        React.createElement(MoreVertical, { size: 14 }),
        'View Details'
      )
    );
  };

  const renderChart = (type) => {
    const data = chartData[type];
    
    return React.createElement('div', {
      style: {
        backgroundColor: 'white',
        border: '1px solid #e5e7eb',
        borderRadius: '1rem',
        padding: '1.5rem'
      }
    },
      // Chart Header
      React.createElement('div', {
        style: {
          display: 'flex',
          justifyContent: 'space-between',
          alignItems: 'center',
          marginBottom: '1.5rem'
        }
      },
        React.createElement('h3', {
          style: {
            fontSize: '1.125rem',
            fontWeight: '600',
            color: '#1f2937'
          }
        }, type === 'overview' ? 'Overview' : type === 'userActivity' ? 'User Activity' : type === 'deviceUsage' ? 'Device Usage' : 'Performance Trends'),
        React.createElement('div', {
          style: {
            display: 'flex',
            gap: '0.5rem'
          }
        },
          React.createElement('button', {
            onClick: () => console.log('Export chart'),
            style: {
              padding: '0.5rem',
              backgroundColor: '#f3f4f6',
              border: '1px solid #e5e7eb',
              borderRadius: '0.375rem',
              cursor: 'pointer'
            }
          },
            React.createElement(Download, { size: 16, color: '#6b7280' })
          ),
          React.createElement('button', {
            onClick: () => console.log('Refresh chart'),
            style: {
              padding: '0.5rem',
              backgroundColor: '#f3f4f6',
              border: '1px solid #e5e7eb',
              borderRadius: '0.375rem',
              cursor: 'pointer'
            }
          },
            React.createElement(RefreshCw, { size: 16, color: '#6b7280' })
          )
        )
      ),
      // Chart Visualization (Simplified)
      React.createElement('div', {
        style: {
          height: '300px',
          display: 'flex',
          alignItems: 'flex-end',
          justifyContent: 'space-between',
          gap: '0.5rem',
          padding: '1rem 0'
        }
      },
        data.labels.map((label, index) => 
          React.createElement('div', {
            key: label,
            style: {
              flex: 1,
              display: 'flex',
              flexDirection: 'column',
              alignItems: 'center',
              gap: '0.5rem'
            }
          },
            // Bars for each dataset
            React.createElement('div', {
              style: {
                display: 'flex',
                gap: '0.25rem',
                alignItems: 'flex-end',
                height: '200px'
              }
            },
              data.datasets.map((dataset, datasetIndex) => 
                React.createElement('div', {
                  key: dataset.label,
                  style: {
                    width: '20px',
                    height: `${(dataset.data[index] / Math.max(...dataset.data)) * 180}px`,
                    backgroundColor: dataset.color,
                    borderRadius: '0.25rem 0.25rem 0 0',
                    opacity: datasetIndex === 0 ? 1 : 0.7
                  },
                  title: `${dataset.label}: ${dataset.data[index]}`
                })
              )
            ),
            // Label
            React.createElement('span', {
              style: {
                fontSize: '0.75rem',
                color: '#6b7280',
                textAlign: 'center'
              }
            }, label)
          )
        )
      ),
      // Legend
      React.createElement('div', {
        style: {
          display: 'flex',
          justifyContent: 'center',
          gap: '1.5rem',
          marginTop: '1rem'
        }
      },
        data.datasets.map(dataset => 
          React.createElement('div', {
            key: dataset.label,
            style: {
              display: 'flex',
              alignItems: 'center',
              gap: '0.5rem'
            }
          },
            React.createElement('div', {
              style: {
                width: '12px',
                height: '12px',
                backgroundColor: dataset.color,
                borderRadius: '0.125rem'
              }
            }),
            React.createElement('span', {
              style: {
                fontSize: '0.75rem',
                color: '#6b7280'
              }
            }, dataset.label)
          )
        )
      )
    );
  };

  const renderTrafficSources = () => {
    return React.createElement('div', {
      style: {
        backgroundColor: 'white',
        border: '1px solid #e5e7eb',
        borderRadius: '1rem',
        padding: '1.5rem'
      }
    },
      React.createElement('h3', {
        style: {
          fontSize: '1.125rem',
          fontWeight: '600',
          color: '#1f2937',
          marginBottom: '1.5rem'
        }
      }, 'Traffic Sources'),
      React.createElement('div', {
        style: {
          display: 'flex',
          flexDirection: 'column',
          gap: '1rem'
        }
      },
        trafficSources.map(source => 
          React.createElement('div', {
            key: source.source,
            style: {
              display: 'flex',
              alignItems: 'center',
              gap: '1rem'
            }
          },
            React.createElement('div', {
              style: {
                width: '40px',
                height: '40px',
                borderRadius: '0.5rem',
                backgroundColor: source.color,
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                color: 'white',
                fontSize: '0.875rem',
                fontWeight: '600'
              }
            }, source.source.charAt(0)),
            React.createElement('div', {
              style: {
                flex: 1
              }
            },
              React.createElement('div', {
                style: {
                  fontSize: '0.875rem',
                  fontWeight: '500',
                  color: '#1f2937',
                  marginBottom: '0.25rem'
                }
              }, source.source),
              React.createElement('div', {
                style: {
                  fontSize: '0.75rem',
                  color: '#6b7280'
                }
              }, `${source.users} users`)
            ),
            React.createElement('div', {
              style: {
                fontSize: '1.125rem',
                fontWeight: '600',
                color: '#1f2937'
              }
            }, `${source.percentage}%`),
            React.createElement('div', {
              style: {
                width: '100px',
                height: '8px',
                backgroundColor: '#e5e7eb',
                borderRadius: '4px',
                overflow: 'hidden'
              }
            },
              React.createElement('div', {
                style: {
                  width: `${source.percentage}%`,
                  height: '100%',
                  backgroundColor: source.color
                }
              })
            )
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
        }, 'Analytics Dashboard'),
        React.createElement('div', {
          style: {
            display: 'flex',
            alignItems: 'center',
            gap: '1rem',
            color: '#6b7280',
            fontSize: '0.875rem'
          }
        },
          React.createElement('span', null, 'Comprehensive insights and performance metrics'),
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
            React.createElement(Zap, { size: 14 }),
            'Real-time'
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
        // Time Range Selector
        React.createElement('select', {
          value: timeRange,
          onChange: (e) => setTimeRange(e.target.value),
          style: {
            padding: '0.5rem 0.75rem',
            border: '1px solid #d1d5db',
            borderRadius: '0.375rem',
            fontSize: '0.875rem',
            backgroundColor: 'white'
          }
        },
          React.createElement('option', { value: '7d' }, 'Last 7 Days'),
          React.createElement('option', { value: '30d' }, 'Last 30 Days'),
          React.createElement('option', { value: '90d' }, 'Last 90 Days'),
          React.createElement('option', { value: '1y' }, 'Last Year')
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
          onClick: () => console.log('Export analytics'),
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
          React.createElement(Download, { size: 16 }),
          'Export Report'
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
          }, 'Metrics'),
          React.createElement('div', {
            style: {
              display: 'flex',
              flexWrap: 'wrap',
              gap: '0.5rem'
            }
          },
            ['users', 'groups', 'performance', 'engagement', 'revenue'].map(metric => 
              React.createElement('button', {
                key: metric,
                onClick: () => {
                  setSelectedMetrics(prev => 
                    prev.includes(metric) 
                      ? prev.filter(m => m !== metric)
                      : [...prev, metric]
                  );
                },
                style: {
                  padding: '0.25rem 0.5rem',
                  borderRadius: '0.25rem',
                  fontSize: '0.75rem',
                  fontWeight: '500',
                  border: '1px solid #e5e7eb',
                  backgroundColor: selectedMetrics.includes(metric) ? '#2563eb' : 'white',
                  color: selectedMetrics.includes(metric) ? 'white' : '#374151',
                  cursor: 'pointer'
                }
              }, metric.charAt(0).toUpperCase() + metric.slice(1))
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
          }, 'Comparison'),
          React.createElement('select', {
            style: {
              width: '100%',
              padding: '0.5rem 0.75rem',
              border: '1px solid #d1d5db',
              borderRadius: '0.375rem',
              fontSize: '0.875rem',
              backgroundColor: 'white'
            }
          },
            React.createElement('option', { value: 'previous' }, 'Previous Period'),
            React.createElement('option', { value: 'year' }, 'Same Period Last Year'),
            React.createElement('option', { value: 'target' }, 'Target Goals')
          )
        )
      )
    ),

    // Key Metrics Grid
    React.createElement('div', {
      style: {
        display: 'grid',
        gridTemplateColumns: 'repeat(auto-fit, minmax(300px, 1fr))',
        gap: '1.5rem',
        marginBottom: '2rem'
      }
    },
      ...metrics.filter(metric => selectedMetrics.includes(metric.id)).map(metric => renderMetricCard(metric))
    ),

    // Chart Type Selector
    React.createElement('div', {
      style: {
        display: 'flex',
        gap: '0.5rem',
        marginBottom: '1.5rem',
        flexWrap: 'wrap'
      }
    },
      [
        { id: 'overview', label: 'Overview', icon: BarChart3 },
        { id: 'userActivity', label: 'User Activity', icon: Activity },
        { id: 'deviceUsage', label: 'Device Usage', icon: Monitor },
        { id: 'performance', label: 'Performance', icon: TrendingUp }
      ].map(type => 
        React.createElement('button', {
          key: type.id,
          onClick: () => setChartType(type.id),
          style: {
            display: 'flex',
            alignItems: 'center',
            gap: '0.5rem',
            padding: '0.5rem 1rem',
            backgroundColor: chartType === type.id ? '#2563eb' : '#f3f4f6',
            color: chartType === type.id ? 'white' : '#374151',
            border: chartType === type.id ? '1px solid #2563eb' : '1px solid #d1d5db',
            borderRadius: '0.375rem',
            fontSize: '0.875rem',
            fontWeight: '500',
            cursor: 'pointer'
          }
        },
          React.createElement(type.icon, { size: 16 }),
          type.label
        )
      )
    ),

    // Charts and Analytics Grid
    React.createElement('div', {
      style: {
        display: 'grid',
        gridTemplateColumns: 'repeat(auto-fit, minmax(500px, 1fr))',
        gap: '1.5rem',
        marginBottom: '2rem'
      }
    },
      // Main Chart
      renderChart(chartType),
      
      // Traffic Sources
      renderTrafficSources()
    ),

    // Top Pages Analysis
    React.createElement('div', {
      style: {
        backgroundColor: 'white',
        border: '1px solid #e5e7eb',
        borderRadius: '1rem',
        padding: '1.5rem'
      }
    },
      React.createElement('h3', {
        style: {
          fontSize: '1.125rem',
          fontWeight: '600',
          color: '#1f2937',
          marginBottom: '1.5rem'
        }
      }, 'Top Pages Analysis'),
      React.createElement('div', {
        style: {
          overflowX: 'auto'
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
                  padding: '0.75rem',
                  textAlign: 'left',
                  fontSize: '0.875rem',
                  fontWeight: '500',
                  color: '#374151',
                  borderBottom: '1px solid #e5e7eb'
                }
              }, 'Page'),
              React.createElement('th', {
                style: {
                  padding: '0.75rem',
                  textAlign: 'left',
                  fontSize: '0.875rem',
                  fontWeight: '500',
                  color: '#374151',
                  borderBottom: '1px solid #e5e7eb'
                }
              }, 'Views'),
              React.createElement('th', {
                style: {
                  padding: '0.75rem',
                  textAlign: 'left',
                  fontSize: '0.875rem',
                  fontWeight: '500',
                  color: '#374151',
                  borderBottom: '1px solid #e5e7eb'
                }
              }, 'Avg. Time'),
              React.createElement('th', {
                style: {
                  padding: '0.75rem',
                  textAlign: 'left',
                  fontSize: '0.875rem',
                  fontWeight: '500',
                  color: '#374151',
                  borderBottom: '1px solid #e5e7eb'
                }
              }, 'Bounce Rate')
            )
          ),
          React.createElement('tbody', null,
            topPages.map((page, index) => 
              React.createElement('tr', {
                key: page.page,
                style: {
                  borderBottom: '1px solid #e5e7eb',
                  backgroundColor: index % 2 === 0 ? 'white' : '#f9fafb'
                }
              },
                React.createElement('td', {
                  style: {
                    padding: '0.75rem',
                    fontSize: '0.875rem',
                    color: '#1f2937',
                    fontFamily: 'monospace'
                  }
                }, page.page),
                React.createElement('td', {
                  style: {
                    padding: '0.75rem',
                    fontSize: '0.875rem',
                    color: '#374151',
                    fontWeight: '500'
                  }
                }, page.views.toLocaleString()),
                React.createElement('td', {
                  style: {
                    padding: '0.75rem',
                    fontSize: '0.875rem',
                    color: '#374151'
                  }
                }, page.avgTime),
                React.createElement('td', {
                  style: {
                    padding: '0.75rem',
                    fontSize: '0.875rem',
                    color: '#374151'
                  }
                },
                  React.createElement('span', {
                    style: {
                      display: 'inline-flex',
                      alignItems: 'center',
                      gap: '0.25rem',
                      padding: '0.125rem 0.375rem',
                      borderRadius: '0.25rem',
                      fontSize: '0.75rem',
                      fontWeight: '500',
                      backgroundColor: page.bounceRate < 30 ? '#dcfce7' : page.bounceRate < 50 ? '#fef3c7' : '#fecaca',
                      color: page.bounceRate < 30 ? '#166534' : page.bounceRate < 50 ? '#92400e' : '#991b1b'
                    }
                  }, `${page.bounceRate}%`)
                )
              )
            )
          )
        )
      )
    ),

    // Loading Overlay
    loading && React.createElement('div', {
      style: {
        position: 'fixed',
        top: 0,
        left: 0,
        right: 0,
        bottom: 0,
        backgroundColor: 'rgba(0, 0, 0, 0.5)',
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
        zIndex: 50
      }
    },
      React.createElement('div', {
        style: {
          backgroundColor: 'white',
          padding: '2rem',
          borderRadius: '1rem',
          display: 'flex',
          flexDirection: 'column',
          alignItems: 'center',
          gap: '1rem'
        }
      },
        React.createElement(RefreshCw, { size: 32, color: '#3b82f6', style: { animation: 'spin 1s linear infinite' } }),
        React.createElement('div', {
          style: {
            fontSize: '1rem',
            fontWeight: '500',
            color: '#374151'
          }
        }, 'Loading Analytics Data...')
      )
    )
  );
};

export default Analytics;
