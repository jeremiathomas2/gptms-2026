import React, { useState, useEffect } from 'react';
import { UsersIcon, Target, TrendingUp as TrendingUpIcon, Zap, DownloadCloud, Star, Users2 } from 'lucide-react';

const GroupAnalytics = () => {
  const [groups, setGroups] = useState([]);
  const [filter, setFilter] = useState('all');

  useEffect(() => {
    // Mock data for analytics
    setGroups([
      { id: 1, name: 'Web Development Squad', project: 'E-commerce Platform', members: 4, rating: 4.8 },
      { id: 2, name: 'Data Science Research', project: 'Predictive Analytics', members: 3, rating: 4.6 },
      { id: 3, name: 'Mobile App Team', project: 'Fitness Tracker', members: 2, rating: 4.2 },
      { id: 4, name: 'AI Research Lab', project: 'NLP System', members: 5, rating: 4.9 },
      { id: 5, name: 'UI/UX Design Studio', project: 'Design System', members: 3, rating: 4.5 }
    ]);
  }, []);

  const handleExportAnalytics = () => {
    console.log('Exporting analytics data...');
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
        }, 'Group Analytics'),
        React.createElement('p', {
          style: {
            color: '#6b7280',
            fontSize: '0.875rem'
          }
        }, 'Comprehensive insights and performance metrics')
      ),
      React.createElement('div', {
        style: {
          display: 'flex',
          gap: '0.5rem'
        }
      },
        React.createElement('select', {
          value: filter,
          onChange: (e) => setFilter(e.target.value),
          style: {
            padding: '0.5rem 0.75rem',
            border: '1px solid #d1d5db',
            borderRadius: '0.375rem',
            fontSize: '0.875rem',
            backgroundColor: 'white'
          }
        },
          React.createElement('option', { value: 'all' }, 'All Groups'),
          React.createElement('option', { value: 'active' }, 'Active Groups'),
          React.createElement('option', { value: 'my' }, 'My Groups')
        ),
        React.createElement('button', {
          onClick: handleExportAnalytics,
          style: {
            display: 'flex',
            alignItems: 'center',
            gap: '0.5rem',
            padding: '0.5rem 1rem',
            backgroundColor: '#f3f4f6',
            color: '#374151',
            border: '1px solid #d1d5db',
            borderRadius: '0.375rem',
            fontSize: '0.875rem',
            fontWeight: '500',
            cursor: 'pointer'
          }
        },
          React.createElement(DownloadCloud, { size: 16 }),
          'Export'
        )
      )
    ),
    // Key Metrics
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
          }, '24')
        ),
        React.createElement('div', {
          style: {
            fontSize: '0.875rem',
            color: '#0c4a6e',
            marginBottom: '0.25rem'
          }
        }, 'Total Members'),
        React.createElement('div', {
          style: {
            fontSize: '0.75rem',
            color: '#64748b'
          }
        }, '+12% from last month')
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
          React.createElement(Target, { size: 24, color: '#16a34a' }),
          React.createElement('span', {
            style: {
              fontSize: '2rem',
              fontWeight: 'bold',
              color: '#15803d'
            }
          }, '87%')
        ),
        React.createElement('div', {
          style: {
            fontSize: '0.875rem',
            color: '#15803d',
            marginBottom: '0.25rem'
          }
        }, 'Completion Rate'),
        React.createElement('div', {
          style: {
            fontSize: '0.75rem',
            color: '#64748b'
          }
        }, '+5% from last month')
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
          React.createElement(TrendingUpIcon, { size: 24, color: '#ca8a04' }),
          React.createElement('span', {
            style: {
              fontSize: '2rem',
              fontWeight: 'bold',
              color: '#a16207'
            }
          }, '4.6')
        ),
        React.createElement('div', {
          style: {
            fontSize: '0.875rem',
            color: '#a16207',
            marginBottom: '0.25rem'
          }
        }, 'Avg Rating'),
        React.createElement('div', {
          style: {
            fontSize: '0.75rem',
            color: '#64748b'
          }
        }, '+0.3 from last month')
      ),
      React.createElement('div', {
        style: {
          padding: '1.5rem',
          backgroundColor: '#fef2f2',
          border: '1px solid #fecaca',
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
          React.createElement(Zap, { size: 24, color: '#dc2626' }),
          React.createElement('span', {
            style: {
              fontSize: '2rem',
              fontWeight: 'bold',
              color: '#991b1b'
            }
          }, '15')
        ),
        React.createElement('div', {
          style: {
            fontSize: '0.875rem',
            color: '#991b1b',
            marginBottom: '0.25rem'
          }
        }, 'Active Projects'),
        React.createElement('div', {
          style: {
            fontSize: '0.75rem',
            color: '#64748b'
          }
        }, '+3 from last month')
      )
    ),
    // Charts Section
    React.createElement('div', {
      style: {
        display: 'grid',
        gridTemplateColumns: 'repeat(auto-fit, minmax(400px, 1fr))',
        gap: '1.5rem',
        marginBottom: '2rem'
      }
    },
      // Group Performance Chart
      React.createElement('div', {
        style: {
          padding: '1.5rem',
          border: '1px solid #e5e7eb',
          borderRadius: '0.5rem',
          backgroundColor: 'white'
        }
      },
        React.createElement('h3', {
          style: {
            fontSize: '1.125rem',
            fontWeight: '600',
            color: '#1f2937',
            marginBottom: '1rem'
          }
        }, 'Group Performance Trend'),
        React.createElement('div', {
          style: {
            height: '200px',
            backgroundColor: '#f9fafb',
            borderRadius: '0.375rem',
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center',
            marginBottom: '1rem'
          }
        },
          React.createElement('div', {
            style: {
              textAlign: 'center',
              color: '#6b7280'
            }
          },
            React.createElement(TrendingUpIcon, { size: 48, color: '#9ca3af' }),
            React.createElement('div', {
              style: {
                marginTop: '0.5rem'
              }
            }, 'Performance chart would be displayed here')
          )
        ),
        React.createElement('div', {
          style: {
            display: 'flex',
            justifyContent: 'space-between',
            fontSize: '0.875rem'
          }
        },
          React.createElement('span', { style: { color: '#6b7280' } }, 'Last 6 months'),
          React.createElement('span', { style: { color: '#10b981', fontWeight: '500' } }, '+23% growth')
        )
      ),
      // Group Distribution
      React.createElement('div', {
        style: {
          padding: '1.5rem',
          border: '1px solid #e5e7eb',
          borderRadius: '0.5rem',
          backgroundColor: 'white'
        }
      },
        React.createElement('h3', {
          style: {
            fontSize: '1.125rem',
            fontWeight: '600',
            color: '#1f2937',
            marginBottom: '1rem'
          }
        }, 'Group Distribution'),
        React.createElement('div', {
          style: {
            height: '200px',
            backgroundColor: '#f9fafb',
            borderRadius: '0.375rem',
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center',
            marginBottom: '1rem'
          }
        },
          React.createElement('div', {
            style: {
              textAlign: 'center',
              color: '#6b7280'
            }
          },
            React.createElement(Users2, { size: 48, color: '#9ca3af' }),
            React.createElement('div', {
              style: {
                marginTop: '0.5rem'
              }
            }, 'Distribution chart would be displayed here')
          )
        ),
        React.createElement('div', {
          style: {
            display: 'grid',
            gridTemplateColumns: 'repeat(2, 1fr)',
            gap: '0.5rem',
            fontSize: '0.75rem'
          }
        },
          React.createElement('div', {
            style: {
              display: 'flex',
              alignItems: 'center',
              gap: '0.25rem'
            }
          },
            React.createElement('div', {
              style: {
                width: '12px',
                height: '12px',
                backgroundColor: '#3b82f6',
                borderRadius: '2px'
              }
            }),
            React.createElement('span', { style: { color: '#6b7280' } }, 'Project Teams (40%)')
          ),
          React.createElement('div', {
            style: {
              display: 'flex',
              alignItems: 'center',
              gap: '0.25rem'
            }
          },
            React.createElement('div', {
              style: {
                width: '12px',
                height: '12px',
                backgroundColor: '#10b981',
                borderRadius: '2px'
              }
            }),
            React.createElement('span', { style: { color: '#6b7280' } }, 'Research (30%)')
          ),
          React.createElement('div', {
            style: {
              display: 'flex',
              alignItems: 'center',
              gap: '0.25rem'
            }
          },
            React.createElement('div', {
              style: {
                width: '12px',
                height: '12px',
                backgroundColor: '#f59e0b',
                borderRadius: '2px'
              }
            }),
            React.createElement('span', { style: { color: '#6b7280' } }, 'Study (20%)')
          ),
          React.createElement('div', {
            style: {
              display: 'flex',
              alignItems: 'center',
              gap: '0.25rem'
            }
          },
            React.createElement('div', {
              style: {
                width: '12px',
                height: '12px',
                backgroundColor: '#ef4444',
                borderRadius: '2px'
              }
            }),
            React.createElement('span', { style: { color: '#6b7280' } }, 'Competition (10%)')
          )
        )
      )
    ),
    // Top Performing Groups
    React.createElement('div', {
      style: {
        padding: '1.5rem',
        border: '1px solid #e5e7eb',
        borderRadius: '0.5rem',
        backgroundColor: 'white'
      }
    },
      React.createElement('h3', {
        style: {
          fontSize: '1.125rem',
          fontWeight: '600',
          color: '#1f2937',
          marginBottom: '1rem'
        }
      }, 'Top Performing Groups'),
      React.createElement('div', {
        style: {
          display: 'grid',
          gap: '0.75rem'
        }
      },
        ...groups.slice(0, 3).map((group, index) => 
          React.createElement('div', {
            key: group.id,
            style: {
              display: 'flex',
              alignItems: 'center',
              gap: '1rem',
              padding: '0.75rem',
              backgroundColor: '#f9fafb',
              borderRadius: '0.375rem'
            }
          },
            React.createElement('div', {
              style: {
                width: '32px',
                height: '32px',
                borderRadius: '50%',
                backgroundColor: index === 0 ? '#fbbf24' : index === 1 ? '#d1d5db' : '#f3f4f6',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                fontSize: '0.875rem',
                fontWeight: 'bold',
                color: index === 0 ? '#92400e' : '#374151'
              }
            }, index + 1),
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
              }, group.name),
              React.createElement('div', {
                style: {
                  fontSize: '0.75rem',
                  color: '#6b7280'
                }
              }, `${group.members} members · ${group.project}`)
            ),
            React.createElement('div', {
              style: {
                textAlign: 'right'
              }
            },
              React.createElement('div', {
                style: {
                  display: 'flex',
                  alignItems: 'center',
                  gap: '0.25rem',
                  fontSize: '0.875rem',
                  fontWeight: '500',
                  color: '#1f2937'
                }
              },
                React.createElement(Star, {
                  size: 14,
                  color: '#fbbf24',
                  fill: '#fbbf24'
                }),
                group.rating.toFixed(1)
              ),
              React.createElement('div', {
                style: {
                  fontSize: '0.75rem',
                  color: '#10b981'
                }
              }, `+${index + 2}%`)
            )
          )
        )
      )
    ),
    // Activity Heatmap
    React.createElement('div', {
      style: {
        marginTop: '1.5rem',
        padding: '1.5rem',
        border: '1px solid #e5e7eb',
        borderRadius: '0.5rem',
        backgroundColor: 'white'
      }
    },
      React.createElement('h3', {
        style: {
          fontSize: '1.125rem',
          fontWeight: '600',
          color: '#1f2937',
          marginBottom: '1rem'
        }
      }, 'Group Activity Heatmap'),
      React.createElement('div', {
        style: {
          display: 'grid',
          gridTemplateColumns: 'repeat(7, 1fr)',
          gap: '0.25rem',
          marginBottom: '0.5rem'
        }
      },
        ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'].map(day => 
          React.createElement('div', {
            key: day,
            style: {
              fontSize: '0.75rem',
              color: '#6b7280',
              textAlign: 'center',
              fontWeight: '500'
            }
          }, day)
        )
      ),
      React.createElement('div', {
        style: {
          display: 'grid',
          gridTemplateColumns: 'repeat(7, 1fr)',
          gap: '0.25rem'
        }
      },
        ...Array.from({ length: 28 }, (_, i) => 
          React.createElement('div', {
            key: i,
            style: {
              aspectRatio: '1',
              backgroundColor: Math.random() > 0.7 ? '#10b981' : 
                              Math.random() > 0.4 ? '#34d399' : 
                              Math.random() > 0.2 ? '#6ee7b7' : '#d1fae5',
              borderRadius: '0.25rem'
            }
          })
        )
      ),
      React.createElement('div', {
        style: {
          display: 'flex',
          alignItems: 'center',
          gap: '1rem',
          marginTop: '1rem',
          fontSize: '0.75rem',
          color: '#6b7280'
        }
      },
        React.createElement('span', null, 'Less'),
        React.createElement('div', {
          style: {
            display: 'flex',
            gap: '0.25rem'
          }
        },
          React.createElement('div', {
            style: {
              width: '12px',
              height: '12px',
              backgroundColor: '#d1fae5',
              borderRadius: '2px'
            }
          }),
          React.createElement('div', {
            style: {
              width: '12px',
              height: '12px',
              backgroundColor: '#6ee7b7',
              borderRadius: '2px'
            }
          }),
          React.createElement('div', {
            style: {
              width: '12px',
              height: '12px',
              backgroundColor: '#34d399',
              borderRadius: '2px'
            }
          }),
          React.createElement('div', {
            style: {
              width: '12px',
              height: '12px',
              backgroundColor: '#10b981',
              borderRadius: '2px'
            }
          })
        ),
        React.createElement('span', null, 'More')
      )
    )
  );
};

export default GroupAnalytics;
