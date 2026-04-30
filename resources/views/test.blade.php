<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPTFMS Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .login-card {
            width: 100%;
            max-width: 448px;
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        .title {
            text-align: center;
            font-size: 1.875rem;
            font-weight: 800;
            color: #111827;
            margin-bottom: 0.5rem;
        }
        .subtitle {
            text-align: center;
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 2rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.25rem;
        }
        .form-input {
            display: block;
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            color: #111827;
            background-color: #ffffff;
        }
        .btn {
            display: flex;
            justify-content: center;
            width: 100%;
            padding: 0.5rem 1rem;
            border: 1px solid transparent;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 0.375rem;
            color: #ffffff;
            background-color: #2563eb;
            cursor: pointer;
            margin-top: 1rem;
        }
        .divider {
            position: relative;
            text-align: center;
            margin: 1.5rem 0;
        }
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background-color: #e5e7eb;
        }
        .divider span {
            position: relative;
            background-color: #ffffff;
            padding: 0 0.5rem;
            font-size: 0.875rem;
            color: #6b7280;
        }
        .link {
            text-align: center;
            font-size: 0.875rem;
            font-weight: 500;
            color: #2563eb;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h2 class="title">Sign in to GPTFMS</h2>
        <p class="subtitle">Group Project Team Formation and Management System</p>
        
        <form>
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-input" placeholder="Email Address" />
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" class="form-input" placeholder="Password" />
            </div>

            <button type="submit" class="btn">Sign in</button>
        </form>

        <div class="divider">
            <span>New to our platform?</span>
        </div>
        <div style="text-align: center;">
            <a href="/register" class="link">Create an account</a>
        </div>
    </div>
</body>
</html>
