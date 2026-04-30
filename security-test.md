# Security Test Plan for GPTFMS Authentication System

## Overview
This document outlines comprehensive security tests for the authentication system to ensure users cannot access the dashboard after logout without proper login.

## Security Features Implemented

### 1. Authentication Middleware
- **File**: `app/Http/Middleware/Authenticate.php`
- **Features**:
  - Session validation
  - IP address consistency checking
  - Session timeout (30 minutes)
  - Periodic session regeneration (5 minutes)
  - Last activity tracking

### 2. Route Protection
- **File**: `routes/web.php`
- **Features**:
  - All dashboard routes protected by `auth` middleware
  - Login/register routes protected by `guest` middleware
  - Fallback route redirects unknown URLs to login

### 3. Session Security
- **File**: `config/session.php`
- **Features**:
  - Session encryption enabled
  - Reduced session lifetime (30 minutes)
  - Expire on browser close enabled

### 4. CSRF Protection
- **File**: `app/Http/Middleware/VerifyCsrfToken.php`
- **Features**:
  - CSRF token validation for all POST requests
  - Automatic token generation in forms

## Test Cases

### Test 1: Basic Login/Logout Flow
1. **Steps**:
   - Navigate to `/`
   - Login with valid credentials
   - Access dashboard
   - Logout
   - Try to access dashboard again

2. **Expected Results**:
   - Should be redirected to login page
   - Should see "Please login to access this page" message

### Test 2: Direct URL Access After Logout
1. **Steps**:
   - Login and logout normally
   - Try to access protected routes directly:
     - `/dashboard`
     - `/groups`
     - `/profile`
     - `/settings`

2. **Expected Results**:
   - All requests should redirect to login page
   - Should not be able to access any protected content

### Test 3: Session Timeout
1. **Steps**:
   - Login successfully
   - Wait 31+ minutes (or modify session timeout for testing)
   - Try to access any protected route

2. **Expected Results**:
   - Should see "Session expired" message
   - Should be forced to login again

### Test 4. IP Address Validation
1. **Steps**:
   - Login from one IP address
   - Change IP address (if possible in test environment)
   - Try to access protected content

2. **Expected Results**:
   - Should see "Security violation: IP address changed" message
   - Should be forced to login again

### Test 5: CSRF Protection
1. **Steps**:
   - Try to submit login form without CSRF token
   - Try to submit logout form without CSRF token

2. **Expected Results**:
   - Forms should be rejected
   - Should see validation error for missing token

### Test 6: Browser Close/Reopen
1. **Steps**:
   - Login successfully
   - Close browser completely
   - Reopen browser and try to access dashboard

2. **Expected Results**:
   - Should be redirected to login page
   - Session should be expired due to `expire_on_close`

### Test 7: Multiple Browser Tabs
1. **Steps**:
   - Login in one tab
   - Open dashboard in multiple tabs
   - Logout in one tab
   - Try to access dashboard in other tabs

2. **Expected Results**:
   - All tabs should redirect to login when accessed
   - Should not be able to access protected content

### Test 8: Back Button Navigation
1. **Steps**:
   - Login and access dashboard
   - Logout
   - Use browser back button

2. **Expected Results**:
   - Should not be able to view cached dashboard content
   - Should be redirected to login page

### Test 9: Direct API Access
1. **Steps**:
   - Login and get session cookie
   - Logout
   - Try to access protected API endpoints with old session

2. **Expected Results**:
   - API calls should return 401 Unauthorized
   - Should not be able to access protected data

### Test 10: Session Fixation Prevention
1. **Steps**:
   - Monitor session ID before and after login
   - Check session ID regeneration

2. **Expected Results**:
   - Session ID should change after login
   - Session ID should regenerate periodically

## Manual Testing Commands

### Clear Application Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Test Routes
```bash
php artisan route:list
```

### Check Session Configuration
```bash
php artisan tinker
>>> config('session.lifetime')
>>> config('session.expire_on_close')
>>> config('session.encrypt')
```

## Security Headers to Verify

Add to `app/Http/Middleware/TrustProxies.php` if needed:
- X-Frame-Options
- X-Content-Type-Options
- X-XSS-Protection
- Strict-Transport-Security

## Additional Security Recommendations

1. **Rate Limiting**: Implement login attempt rate limiting
2. **Password Policy**: Enforce strong password requirements
3. **Two-Factor Authentication**: Add 2FA for sensitive operations
4. **Audit Logging**: Log all authentication events
5. **Session Hijacking Protection**: Implement additional fingerprinting

## Test Results Checklist

- [ ] Basic login/logout works correctly
- [ ] Protected routes redirect to login after logout
- [ ] Session timeout forces re-authentication
- [ ] IP address validation works
- [ ] CSRF tokens are validated
- [ ] Browser close expires session
- [ ] Multiple tabs handle logout correctly
- [ ] Back button doesn't show cached content
- [ ] API endpoints are protected
- [ ] Session fixation is prevented

## Troubleshooting

If tests fail:
1. Check middleware registration in `bootstrap/app.php`
2. Verify session configuration in `.env`
3. Clear application cache
4. Check browser developer tools for session data
5. Verify CSRF tokens are present in forms
