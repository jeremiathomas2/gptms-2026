import React, { useState } from 'react';

const CreateGroup = () => {
  const [formData, setFormData] = useState({
    groupName: '',
    project: '',
    description: '',
    maxMembers: 5,
    groupType: 'project',
    privacy: 'public',
    skills: [],
    additionalRequirements: '',
    startDate: '',
    endDate: ''
  });

  const handleInputChange = (e) => {
    const { name, value, type, checked } = e.target;
    if (type === 'checkbox') {
      setFormData(prev => ({
        ...prev,
        skills: checked 
          ? [...prev.skills, value]
          : prev.skills.filter(skill => skill !== value)
      }));
    } else {
      setFormData(prev => ({
        ...prev,
        [name]: value
      }));
    }
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    console.log('Creating group:', formData);
    // Handle group creation logic here
  };

  const skills = ['JavaScript', 'Python', 'React', 'Node.js', 'Machine Learning', 'Data Analysis', 'UI/UX Design', 'Project Management'];

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
        marginBottom: '2rem'
      }
    },
      React.createElement('h2', {
        style: {
          fontSize: '1.5rem',
          fontWeight: 'bold',
          color: '#1f2937',
          marginBottom: '0.5rem'
        }
      }, 'Create New Group'),
      React.createElement('p', {
        style: {
          color: '#6b7280',
          fontSize: '0.875rem'
        }
      }, 'Fill in the details below to create a new group')
    ),
    // Create group form
    React.createElement('form', {
      onSubmit: handleSubmit,
      style: {
        display: 'grid',
        gap: '1.5rem'
      }
    },
      // Basic Information
      React.createElement('div', {
        style: {
          padding: '1.5rem',
          border: '1px solid #e5e7eb',
          borderRadius: '0.5rem',
          backgroundColor: '#f9fafb'
        }
      },
        React.createElement('h3', {
          style: {
            fontSize: '1.125rem',
            fontWeight: '600',
            color: '#1f2937',
            marginBottom: '1rem'
          }
        }, 'Basic Information'),
        React.createElement('div', {
          style: {
            display: 'grid',
            gridTemplateColumns: 'repeat(auto-fit, minmax(250px, 1fr))',
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
            }, 'Group Name *'),
            React.createElement('input', {
              type: 'text',
              name: 'groupName',
              value: formData.groupName,
              onChange: handleInputChange,
              required: true,
              placeholder: 'Enter group name',
              style: {
                width: '100%',
                padding: '0.5rem 0.75rem',
                border: '1px solid #d1d5db',
                borderRadius: '0.375rem',
                fontSize: '0.875rem'
              }
            })
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
            }, 'Project *'),
            React.createElement('input', {
              type: 'text',
              name: 'project',
              value: formData.project,
              onChange: handleInputChange,
              required: true,
              placeholder: 'Enter project name',
              style: {
                width: '100%',
                padding: '0.5rem 0.75rem',
                border: '1px solid #d1d5db',
                borderRadius: '0.375rem',
                fontSize: '0.875rem'
              }
            })
          )
        ),
        React.createElement('div', {
          style: {
            marginTop: '1rem'
          }
        },
          React.createElement('label', {
            style: {
              display: 'block',
              fontSize: '0.875rem',
              fontWeight: '500',
              color: '#374151',
              marginBottom: '0.5rem'
            }
          }, 'Description *'),
          React.createElement('textarea', {
            name: 'description',
            value: formData.description,
            onChange: handleInputChange,
            required: true,
            rows: 3,
            placeholder: 'Describe the group purpose and objectives',
            style: {
              width: '100%',
              padding: '0.5rem 0.75rem',
              border: '1px solid #d1d5db',
              borderRadius: '0.375rem',
              fontSize: '0.875rem',
              resize: 'vertical'
            }
          })
        )
      ),
      // Group Settings
      React.createElement('div', {
        style: {
          padding: '1.5rem',
          border: '1px solid #e5e7eb',
          borderRadius: '0.5rem',
          backgroundColor: '#f9fafb'
        }
      },
        React.createElement('h3', {
          style: {
            fontSize: '1.125rem',
            fontWeight: '600',
            color: '#1f2937',
            marginBottom: '1rem'
          }
        }, 'Group Settings'),
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
            }, 'Maximum Members *'),
            React.createElement('input', {
              type: 'number',
              name: 'maxMembers',
              value: formData.maxMembers,
              onChange: handleInputChange,
              required: true,
              min: 2,
              max: 10,
              style: {
                width: '100%',
                padding: '0.5rem 0.75rem',
                border: '1px solid #d1d5db',
                borderRadius: '0.375rem',
                fontSize: '0.875rem'
              }
            })
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
            }, 'Group Type'),
            React.createElement('select', {
              name: 'groupType',
              value: formData.groupType,
              onChange: handleInputChange,
              style: {
                width: '100%',
                padding: '0.5rem 0.75rem',
                border: '1px solid #d1d5db',
                borderRadius: '0.375rem',
                fontSize: '0.875rem',
                backgroundColor: 'white'
              }
            },
              React.createElement('option', { value: 'project' }, 'Project Team'),
              React.createElement('option', { value: 'research' }, 'Research Group'),
              React.createElement('option', { value: 'study' }, 'Study Group'),
              React.createElement('option', { value: 'competition' }, 'Competition Team')
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
            }, 'Privacy'),
            React.createElement('select', {
              name: 'privacy',
              value: formData.privacy,
              onChange: handleInputChange,
              style: {
                width: '100%',
                padding: '0.5rem 0.75rem',
                border: '1px solid #d1d5db',
                borderRadius: '0.375rem',
                fontSize: '0.875rem',
                backgroundColor: 'white'
              }
            },
              React.createElement('option', { value: 'public' }, 'Public'),
              React.createElement('option', { value: 'private' }, 'Private'),
              React.createElement('option', { value: 'invite-only' }, 'Invite Only')
            )
          )
        )
      ),
      // Skills & Requirements
      React.createElement('div', {
        style: {
          padding: '1.5rem',
          border: '1px solid #e5e7eb',
          borderRadius: '0.5rem',
          backgroundColor: '#f9fafb'
        }
      },
        React.createElement('h3', {
          style: {
            fontSize: '1.125rem',
            fontWeight: '600',
            color: '#1f2937',
            marginBottom: '1rem'
          }
        }, 'Skills & Requirements'),
        React.createElement('div', null,
          React.createElement('label', {
            style: {
              display: 'block',
              fontSize: '0.875rem',
              fontWeight: '500',
              color: '#374151',
              marginBottom: '0.5rem'
            }
          }, 'Required Skills'),
          React.createElement('div', {
            style: {
              display: 'flex',
              flexWrap: 'wrap',
              gap: '0.5rem',
              marginBottom: '1rem'
            }
          },
            skills.map(skill => 
              React.createElement('label', {
                key: skill,
                style: {
                  display: 'flex',
                  alignItems: 'center',
                  gap: '0.25rem',
                  padding: '0.25rem 0.5rem',
                  border: '1px solid #d1d5db',
                  borderRadius: '0.25rem',
                  fontSize: '0.75rem',
                  cursor: 'pointer'
                }
              },
                React.createElement('input', {
                  type: 'checkbox',
                  value: skill,
                  checked: formData.skills.includes(skill),
                  onChange: handleInputChange,
                  style: {
                    marginRight: '0.25rem'
                  }
                }),
                skill
              )
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
          }, 'Additional Requirements'),
          React.createElement('textarea', {
            name: 'additionalRequirements',
            value: formData.additionalRequirements,
            onChange: handleInputChange,
            rows: 2,
            placeholder: 'Any additional requirements or qualifications...',
            style: {
              width: '100%',
              padding: '0.5rem 0.75rem',
              border: '1px solid #d1d5db',
              borderRadius: '0.375rem',
              fontSize: '0.875rem',
              resize: 'vertical'
            }
          })
        )
      ),
      // Timeline
      React.createElement('div', {
        style: {
          padding: '1.5rem',
          border: '1px solid #e5e7eb',
          borderRadius: '0.5rem',
          backgroundColor: '#f9fafb'
        }
      },
        React.createElement('h3', {
          style: {
            fontSize: '1.125rem',
            fontWeight: '600',
            color: '#1f2937',
            marginBottom: '1rem'
          }
        }, 'Timeline'),
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
            }, 'Start Date'),
            React.createElement('input', {
              type: 'date',
              name: 'startDate',
              value: formData.startDate,
              onChange: handleInputChange,
              style: {
                width: '100%',
                padding: '0.5rem 0.75rem',
                border: '1px solid #d1d5db',
                borderRadius: '0.375rem',
                fontSize: '0.875rem'
              }
            })
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
            }, 'Expected End Date'),
            React.createElement('input', {
              type: 'date',
              name: 'endDate',
              value: formData.endDate,
              onChange: handleInputChange,
              style: {
                width: '100%',
                padding: '0.5rem 0.75rem',
                border: '1px solid #d1d5db',
                borderRadius: '0.375rem',
                fontSize: '0.875rem'
              }
            })
          )
        )
      ),
      // Form Actions
      React.createElement('div', {
        style: {
          display: 'flex',
          justifyContent: 'flex-end',
          gap: '1rem',
          paddingTop: '1rem',
          borderTop: '1px solid #e5e7eb'
        }
      },
        React.createElement('button', {
          type: 'button',
          onClick: () => console.log('Cancel'),
          style: {
            padding: '0.5rem 1rem',
            backgroundColor: '#f3f4f6',
            color: '#374151',
            border: '1px solid #d1d5db',
            borderRadius: '0.375rem',
            fontSize: '0.875rem',
            fontWeight: '500',
            cursor: 'pointer'
          }
        }, 'Cancel'),
        React.createElement('button', {
          type: 'submit',
          style: {
            padding: '0.5rem 1rem',
            backgroundColor: '#2563eb',
            color: 'white',
            border: 'none',
            borderRadius: '0.375rem',
            fontSize: '0.875rem',
            fontWeight: '500',
            cursor: 'pointer'
          }
        }, 'Create Group')
      )
    )
  );
};

export default CreateGroup;
