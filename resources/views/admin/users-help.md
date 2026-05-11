# User Management Shortcuts Guide

## Quick Actions (Header Buttons)

### Export Users
- **Button**: Green export icon
- **Function**: Downloads all users as CSV file
- **Keyboard Shortcut**: `Ctrl/Cmd + E`
- **Data Exported**: Name, Email, Role, Status, Phone, Created Date

### Import Users
- **Button**: Purple import icon
- **Function**: Upload CSV file to bulk import users
- **Keyboard Shortcut**: `Ctrl/Cmd + I`
- **CSV Format**: Name, Email, Role, Status, Phone

### Bulk Actions
- **Button**: Orange bulk actions icon
- **Keyboard Shortcut**: `Ctrl/Cmd + B`
- **Options**:
  - Bulk Activate/Deactivate
  - Bulk Delete
  - Bulk Role Change

### Refresh
- **Button**: Gray refresh icon
- **Function**: Reloads the user list
- **Keyboard Shortcut**: `F5` or `Ctrl/Cmd + R`

### Add User
- **Button**: Blue add user icon
- **Function**: Navigate to user registration page
- **Keyboard Shortcut**: `Ctrl/Cmd + N`

## User Card Actions

### Quick Status Toggle
- **Icon**: Green checkmark (active) or red X (inactive)
- **Function**: Toggle user between active/inactive
- **Confirmation**: Yes/No dialog

### Quick Role Edit
- **Icon**: Purple settings icon
- **Function**: Cycle through roles (Admin → Supervisor → Student → Admin)
- **Confirmation**: Yes/No dialog

### Action Buttons
- **View**: Opens user details page
- **Edit**: Opens user edit page
- **Reset**: Generates new temporary password
- **Delete**: Permanently deletes user (with confirmation)

## Search and Filter

### Search Bar
- **Placeholder**: "Search users by name, email, or role..."
- **Keyboard Shortcut**: `Ctrl/Cmd + F` to focus
- **Real-time**: Filters as you type

### Role Filter
- **Options**: All Roles, Admin, Supervisor, Student
- **Function**: Show only users with selected role

### Status Filter
- **Options**: All Status, Active, Inactive, Suspended
- **Function**: Show only users with selected status

### Clear Filters
- **Function**: Reset all search and filter fields
- **Effect**: Shows all users again

## Keyboard Shortcuts Summary

| Shortcut | Action |
|----------|--------|
| `Ctrl/Cmd + N` | Add New User |
| `Ctrl/Cmd + E` | Export Users |
| `Ctrl/Cmd + I` | Import Users |
| `Ctrl/Cmd + B` | Bulk Actions |
| `Ctrl/Cmd + F` | Focus Search |
| `F5` | Refresh Page |

## User Statistics Cards

### Total Users
- Shows total number of registered users
- Icon: Blue user group

### Active Users
- Shows number of active users
- Displays active rate percentage
- Icon: Green checkmark

### Admin Users
- Shows number of admin users
- Icon: Purple shield

### Students
- Shows number of student accounts
- Icon: Yellow graduation cap

## Responsive Design

### Mobile (< 640px)
- Buttons show icons only (text hidden)
- Cards use smaller text and spacing
- Search bar becomes full width

### Tablet (640px - 1024px)
- Mixed icon/text display
- Optimized spacing and layout

### Desktop (> 1024px)
- Full functionality with all text labels
- Optimal spacing and layout

## API Endpoints

### User Status Toggle
```
POST /admin/users/{id}/toggle
Response: { success: true, message: "User status updated successfully!" }
```

### User Role Update
```
POST /admin/users/{id}/role
Body: { role: "admin|supervisor|student" }
Response: { success: true, message: "User role updated successfully!" }
```

### Password Reset
```
POST /admin/users/{id}/reset-password
Response: { success: true, message: "Password reset successfully. Temp: xxxxxx" }
```

### Export Users
```
GET /admin/users/export
Response: CSV file download
```

### Import Users
```
POST /admin/users/import
Body: multipart/form-data with csv_file
Response: { success: true, message: "Import completed: X imported, Y failed" }
```

## Error Handling

### Network Errors
- Shows notification: "Failed to [action]. Please try again."
- Console logs detailed error information

### Validation Errors
- Shows specific error messages from backend
- Form validation feedback

### Permission Errors
- Redirects to dashboard with error message
- Logs unauthorized access attempts

## Security Features

### CSRF Protection
- All POST requests include CSRF token
- Automatic token refresh

### Confirmation Dialogs
- Destructive actions require confirmation
- Clear action descriptions

### Activity Logging
- All user management actions logged
- Admin action tracking

## Performance Optimizations

### Lazy Loading
- Large user lists load progressively
- Infinite scroll for 1000+ users

### Caching
- User data cached for 5 minutes
- Statistics updated hourly

### Debounced Search
- Search input debounced (300ms)
- Prevents excessive API calls

## Browser Compatibility

### Supported Browsers
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

### Fallbacks
- Basic functionality without JavaScript
- Graceful degradation for older browsers
