<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Profile Export - {{ $user->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section h2 {
            color: #333;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .info-row {
            margin-bottom: 8px;
            display: flex;
        }
        .info-label {
            font-weight: bold;
            width: 150px;
            color: #555;
        }
        .info-value {
            flex: 1;
        }
        .skills-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 10px;
        }
        .skill-item {
            background: #f5f5f5;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 14px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>User Profile Export</h1>
        <p>Generated on: {{ now()->format('F d, Y H:i:s') }}</p>
    </div>

    <div class="section">
        <h2>Personal Information</h2>
        <div class="info-row">
            <span class="info-label">Name:</span>
            <span class="info-value">{{ $user->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">First Name:</span>
            <span class="info-value">{{ $user->first_name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Last Name:</span>
            <span class="info-value">{{ $user->last_name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Email:</span>
            <span class="info-value">{{ $user->email }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Phone:</span>
            <span class="info-value">{{ $user->phone ?? 'Not provided' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Gender:</span>
            <span class="info-value">{{ $user->gender ?? 'Not provided' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Registration No:</span>
            <span class="info-value">{{ $user->registration_number ?? 'Not provided' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Status:</span>
            <span class="info-value">{{ ucfirst($user->status) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Role:</span>
            <span class="info-value">{{ $user->roles->first()->name ?? 'User' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Member Since:</span>
            <span class="info-value">{{ $user->created_at->format('F d, Y') }}</span>
        </div>
    </div>

    @if($skillsData)
    <div class="section">
        <h2>Skills & Preferences</h2>
        <div class="info-row">
            <span class="info-label">Experience Level:</span>
            <span class="info-value">{{ ucfirst($skillsData->experience_level) }}</span>
        </div>
        
        @php
            $skills = is_string($skillsData->skills) ? json_decode($skillsData->skills, true) : $skillsData->skills;
            $interests = is_string($skillsData->interests) ? json_decode($skillsData->interests, true) : $skillsData->interests;
        @endphp
        
        @if($skills && is_array($skills))
        <div class="info-row">
            <span class="info-label">Technical Skills:</span>
            <div class="skills-grid">
                @foreach($skills as $skill)
                    <div class="skill-item">{{ ucfirst($skill) }}</div>
                @endforeach
            </div>
        </div>
        @endif
        
        @if($interests && is_array($interests))
        <div class="info-row">
            <span class="info-label">Areas of Interest:</span>
            <div class="skills-grid">
                @foreach($interests as $interest)
                    <div class="skill-item">{{ ucfirst(str_replace('_', ' ', $interest)) }}</div>
                @endforeach
            </div>
        </div>
        @endif
        
        @if($skillsData->project_type)
        <div class="info-row">
            <span class="info-label">Project Type:</span>
            <span class="info-value">{{ ucfirst($skillsData->project_type) }}</span>
        </div>
        @endif
        
        @if($skillsData->project_duration)
        <div class="info-row">
            <span class="info-label">Project Duration:</span>
            <span class="info-value">{{ ucfirst($skillsData->project_duration) }}</span>
        </div>
        @endif
        
        @if($skillsData->goals)
        <div class="info-row">
            <span class="info-label">Goals:</span>
            <span class="info-value">{{ $skillsData->goals }}</span>
        </div>
        @endif
    </div>
    @endif

    @if($profileData)
    <div class="section">
        <h2>Professional Profile</h2>
        <div class="info-row">
            <span class="info-label">Department:</span>
            <span class="info-value">{{ $profileData->department }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Position:</span>
            <span class="info-value">{{ $profileData->position }}</span>
        </div>
        @if($profileData->specializations)
        <div class="info-row">
            <span class="info-label">Specializations:</span>
            <span class="info-value">{{ $profileData->specializations }}</span>
        </div>
        @endif
        @if($profileData->experience)
        <div class="info-row">
            <span class="info-label">Experience:</span>
            <span class="info-value">{{ $profileData->experience }} years</span>
        </div>
        @endif
    </div>
    @endif

    <div class="footer">
        <p>This profile export was generated from the GPTFMS system.</p>
        <p>For questions or concerns, please contact the system administrator.</p>
    </div>
</body>
</html>
