<?php

namespace App\Helpers;

use App\Models\User;

class ProfileExportHelper
{
    public static function generateProfilePDF($user, $profileData = null, $skillsData = null)
    {
        // Generate HTML content for PDF
        $html = self::generateProfileHTML($user, $profileData, $skillsData);
        
        // Debug: Log the HTML content
        \Log::info('PDF HTML Content:', ['html_length' => strlen($html)]);
        
        // Create a simple but working PDF
        $pdf = self::createSimplePDF($html);
        
        // Debug: Log the PDF content
        \Log::info('PDF Generated:', ['pdf_length' => strlen($pdf), 'pdf_start' => substr($pdf, 0, 100)]);
        
        return $pdf;
    }
    
    private static function generateProfileHTML($user, $profileData = null, $skillsData = null)
    {
        $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Profile Export - ' . $user->name . '</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 30px; }
        .section { margin-bottom: 25px; }
        .section h2 { color: #333; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 15px; }
        .info-row { margin-bottom: 8px; display: flex; }
        .info-label { font-weight: bold; width: 150px; color: #555; }
        .info-value { flex: 1; }
        .skills-list { background: #f5f5f5; padding: 10px; border-radius: 3px; margin-top: 5px; }
        .footer { margin-top: 40px; text-align: center; color: #666; font-size: 12px; border-top: 1px solid #ccc; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>User Profile Export</h1>
        <p>Generated on: ' . now()->format('F d, Y H:i:s') . '</p>
    </div>

    <div class="section">
        <h2>Personal Information</h2>
        <div class="info-row">
            <span class="info-label">Name:</span>
            <span class="info-value">' . htmlspecialchars($user->name) . '</span>
        </div>
        <div class="info-row">
            <span class="info-label">First Name:</span>
            <span class="info-value">' . htmlspecialchars($user->first_name) . '</span>
        </div>
        <div class="info-row">
            <span class="info-label">Last Name:</span>
            <span class="info-value">' . htmlspecialchars($user->last_name) . '</span>
        </div>
        <div class="info-row">
            <span class="info-label">Email:</span>
            <span class="info-value">' . htmlspecialchars($user->email) . '</span>
        </div>
        <div class="info-row">
            <span class="info-label">Phone:</span>
            <span class="info-value">' . htmlspecialchars($user->phone ?? 'Not provided') . '</span>
        </div>
        <div class="info-row">
            <span class="info-label">Gender:</span>
            <span class="info-value">' . htmlspecialchars($user->gender ?? 'Not provided') . '</span>
        </div>
        <div class="info-row">
            <span class="info-label">Registration No:</span>
            <span class="info-value">' . htmlspecialchars($user->registration_number ?? 'Not provided') . '</span>
        </div>
        <div class="info-row">
            <span class="info-label">Status:</span>
            <span class="info-value">' . ucfirst($user->status) . '</span>
        </div>
        <div class="info-row">
            <span class="info-label">Role:</span>
            <span class="info-value">' . ($user->roles->first()->name ?? 'User') . '</span>
        </div>
        <div class="info-row">
            <span class="info-label">Member Since:</span>
            <span class="info-value">' . $user->created_at->format('F d, Y') . '</span>
        </div>
    </div>';

        // Add Skills & Preferences for students
        if ($skillsData) {
            $html .= '
    <div class="section">
        <h2>Skills & Preferences</h2>
        <div class="info-row">
            <span class="info-label">Experience Level:</span>
            <span class="info-value">' . ucfirst($skillsData->experience_level) . '</span>
        </div>';
            
            // Handle skills
            $skills = is_string($skillsData->skills) ? json_decode($skillsData->skills, true) : $skillsData->skills;
            if ($skills && is_array($skills)) {
                $skillsList = implode(', ', array_map('ucfirst', $skills));
                $html .= '
        <div class="info-row">
            <span class="info-label">Technical Skills:</span>
            <div class="skills-list">' . htmlspecialchars($skillsList) . '</div>
        </div>';
            }
            
            // Handle interests
            $interests = is_string($skillsData->interests) ? json_decode($skillsData->interests, true) : $skillsData->interests;
            if ($interests && is_array($interests)) {
                $formattedInterests = array_map(function($interest) {
                    return ucfirst(str_replace('_', ' ', $interest));
                }, $interests);
                $interestsList = implode(', ', $formattedInterests);
                $html .= '
        <div class="info-row">
            <span class="info-label">Areas of Interest:</span>
            <div class="skills-list">' . htmlspecialchars($interestsList) . '</div>
        </div>';
            }
            
            if ($skillsData->project_type) {
                $html .= '
        <div class="info-row">
            <span class="info-label">Project Type:</span>
            <span class="info-value">' . ucfirst($skillsData->project_type) . '</span>
        </div>';
            }
            
            if ($skillsData->project_duration) {
                $html .= '
        <div class="info-row">
            <span class="info-label">Project Duration:</span>
            <span class="info-value">' . ucfirst($skillsData->project_duration) . '</span>
        </div>';
            }
            
            if ($skillsData->goals) {
                $html .= '
        <div class="info-row">
            <span class="info-label">Goals:</span>
            <span class="info-value">' . htmlspecialchars($skillsData->goals) . '</span>
        </div>';
            }
            
            $html .= '
    </div>';
        }

        // Add Professional Profile for supervisors
        if ($profileData) {
            $html .= '
    <div class="section">
        <h2>Professional Profile</h2>
        <div class="info-row">
            <span class="info-label">Department:</span>
            <span class="info-value">' . htmlspecialchars($profileData->department) . '</span>
        </div>
        <div class="info-row">
            <span class="info-label">Position:</span>
            <span class="info-value">' . htmlspecialchars($profileData->position) . '</span>
        </div>';
            
            if ($profileData->specializations) {
                $html .= '
        <div class="info-row">
            <span class="info-label">Specializations:</span>
            <span class="info-value">' . htmlspecialchars($profileData->specializations) . '</span>
        </div>';
            }
            
            if ($profileData->experience) {
                $html .= '
        <div class="info-row">
            <span class="info-label">Experience:</span>
            <span class="info-value">' . $profileData->experience . ' years</span>
        </div>';
            }
            
            $html .= '
    </div>';
        }

        $html .= '
    <div class="footer">
        <p>This profile export was generated from the GPTFMS system.</p>
        <p>For questions or concerns, please contact the system administrator.</p>
    </div>
</body>
</html>';

        return $html;
    }
    
    private static function createSimplePDF($html)
    {
        // Create a working PDF using a much simpler approach
        // Generate text content first
        $text = self::extractTextFromHTML($html);
        
        // Create a basic but working PDF
        return self::generateWorkingPDF($text);
    }
    
    private static function extractTextFromHTML($html)
    {
        // Extract clean text content from HTML
        $text = strip_tags($html);
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        
        // Debug: Log the stripped text
        \Log::info('Text after strip_tags:', ['text_length' => strlen($text), 'text_preview' => substr($text, 0, 200)]);
        
        // Remove extra whitespace and normalize
        $text = preg_replace('/\s+/', ' ', $text);
        $text = str_replace(['  ', '   ', '    '], ' ', $text);
        $text = trim($text);
        
        // Add line breaks for better formatting
        $text = str_replace(['Personal Information', 'Skills & Preferences', 'Professional Profile'], "\n\n$0", $text);
        $text = str_replace(['Name:', 'First Name:', 'Last Name:', 'Email:', 'Phone:', 'Gender:', 'Registration No:', 'Status:', 'Role:', 'Member Since:'], "\n$0", $text);
        
        // Debug: Log the final text
        \Log::info('Final text for PDF:', ['text_length' => strlen($text), 'text_preview' => substr($text, 0, 300)]);
        
        return $text;
    }
    
    private static function generateWorkingPDF($text)
    {
        // Create a simple but working PDF document
        $pdf = "%PDF-1.4\n";
        
        // Calculate content length first
        $content = self::createPDFContent($text);
        $contentLength = strlen($content);
        
        // Object 1: Catalog
        $catalogObj = "1 0 obj\n<<\n/Type /Catalog\n/Pages 2 0 R\n>>\nendobj\n";
        
        // Object 2: Pages
        $pagesObj = "2 0 obj\n<<\n/Type /Pages\n/Kids [3 0 R]\n/Count 1\n>>\nendobj\n";
        
        // Object 3: Page
        $pageObj = "3 0 obj\n<<\n/Type /Page\n/Parent 2 0 R\n/MediaBox [0 0 612 792]\n/Contents 4 0 R\n/Resources <<\n/Font <<\n/F1 5 0 R\n>>\n>>\n>>\nendobj\n";
        
        // Object 4: Content stream
        $contentObj = "4 0 obj\n<<\n/Length $contentLength\n>>\nstream\n" . $content . "\nendstream\nendobj\n";
        
        // Object 5: Font
        $fontObj = "5 0 obj\n<<\n/Type /Font\n/Subtype /Type1\n/BaseFont /Helvetica\n>>\nendobj\n";
        
        // Build PDF
        $pdf .= $catalogObj . $pagesObj . $pageObj . $contentObj . $fontObj;
        
        // Calculate offsets for xref table
        $offset1 = strlen("%PDF-1.4\n") + strlen($catalogObj);
        $offset2 = $offset1 + strlen($pagesObj);
        $offset3 = $offset2 + strlen($pageObj);
        $offset4 = $offset3 + strlen($contentObj);
        $offset5 = $offset4 + strlen($fontObj);
        
        // Cross-reference table
        $xref = "xref\n0 6\n0000000000 65535 f \n";
        $xref .= sprintf("%010d 00000 n \n", $offset1);
        $xref .= sprintf("%010d 00000 n \n", $offset2);
        $xref .= sprintf("%010d 00000 n \n", $offset3);
        $xref .= sprintf("%010d 00000 n \n", $offset4);
        $xref .= sprintf("%010d 00000 n \n", $offset5);
        
        $pdf .= $xref;
        
        // Trailer
        $xrefOffset = strlen($pdf) + strlen($xref) + strlen("trailer\n<<\n/Size 6\n/Root 1 0 R\n>>\nstartxref\n");
        $pdf .= "trailer\n<<\n/Size 6\n/Root 1 0 R\n>>\nstartxref\n$xrefOffset\n%%EOF";
        
        return $pdf;
    }
    
    private static function createPDFContent($text)
    {
        // Create PDF content stream with proper text positioning
        $content = "BT\n/F1 12 Tf\n";
        
        // Split text into lines that fit on the page
        $lines = explode("\n", wordwrap($text, 70)); // 70 chars per line
        $y = 750; // Start from top of page
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (!empty($line) && $y > 50) { // Don't go below 50
                $escapedLine = self::escapePDFString($line);
                $content .= "50 $y Td\n($escapedLine) Tj\n";
                $y -= 15; // Move down 15 points
            }
        }
        
        $content .= "ET\n";
        
        return $content;
    }
    
    private static function escapePDFString($string)
    {
        // Escape special characters for PDF strings
        $replacements = [
            '\\' => '\\\\',
            '(' => '\\(',
            ')' => '\\)',
            "\r" => '',
            "\n" => '',
            "\t" => ' '
        ];
        
        return strtr($string, $replacements);
    }
}
