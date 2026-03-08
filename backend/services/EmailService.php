<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailService {
    
    private $mail;
    
    public function __construct() {
        $this->mail = new PHPMailer(true);
    }

    /* ── OTP VERIFICATION EMAIL ────────────────────────────────── */

    public function sendOTP($email, $otp, $name) {
        try {
            $this->mail->SMTPDebug = 0;
            $this->mail->isSMTP();
            $this->mail->Host       = 'smtp.gmail.com';
            $this->mail->SMTPAuth   = true;
            $this->mail->Username   = 'skonnect.system@gmail.com';
            $this->mail->Password   = 'dktl mpvg fwfu hqnt';
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port       = 587;

            $this->mail->setFrom('skonnect.system@gmail.com', 'SKonnect');
            $this->mail->addAddress($email, $name);

            $this->mail->isHTML(true);
            $this->mail->Subject = 'SKonnect - Email Verification OTP';
            $this->mail->Body    = "Your SKonnect verification OTP is: <strong>" . $otp . "</strong><br><br>This code will expire in 10 minutes.";
            $this->mail->AltBody = "Your SKonnect verification OTP is: " . $otp . "\n\nThis code will expire in 10 minutes.";

            $this->mail->send();
            return true;

        } catch (Exception $e) {
            error_log("PHPMailer Error: " . $this->mail->ErrorInfo);
            return false;
        }
    }

    /* ── ANNOUNCEMENT NOTIFICATION EMAIL ──────────────────────── */

    public function sendAnnouncementNotification(string $email, string $name, array $announcement): bool {
        try {
            $this->mail = new PHPMailer(true);
            $this->mail->SMTPDebug = 0;
            $this->mail->isSMTP();
            $this->mail->Host       = 'smtp.gmail.com';
            $this->mail->SMTPAuth   = true;
            $this->mail->Username   = 'skonnect.system@gmail.com';
            $this->mail->Password   = 'dktl mpvg fwfu hqnt';
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port       = 587;

            $this->mail->setFrom('skonnect.system@gmail.com', 'SKonnect - Barangay Sauyo');
            $this->mail->addAddress($email, $name);

            $title    = htmlspecialchars($announcement['title']);
            $category = ucfirst(htmlspecialchars($announcement['category']));
            $excerpt  = htmlspecialchars(mb_substr(strip_tags($announcement['content']), 0, 200));
            $date     = date('F j, Y', strtotime($announcement['published_at']));

            $this->mail->isHTML(true);
            $this->mail->Subject = "New Announcement: {$title}";
            $this->mail->Body    = "
                <div style='font-family:Segoe UI,sans-serif;max-width:600px;margin:auto;background:#f4f6f9;padding:24px;border-radius:12px;'>
                    <div style='background:linear-gradient(135deg,#0f2545,#1e5fa8);border-radius:10px;padding:28px 32px;border-left:5px solid #facc15;'>
                        <p style='color:#facc15;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin:0 0 8px;'>New Announcement - {$category}</p>
                        <h2 style='color:#ffffff;font-size:20px;font-weight:800;margin:0 0 12px;line-height:1.3;'>{$title}</h2>
                        <p style='color:rgba(255,255,255,0.75);font-size:13.5px;line-height:1.7;margin:0 0 16px;'>{$excerpt}...</p>
                        <p style='color:rgba(255,255,255,0.5);font-size:11.5px;margin:0 0 20px;'>Posted on {$date}</p>
                        <a href='http://localhost/SKonnect/views/public/announcement_view.php'
                           style='display:inline-block;background:#facc15;color:#0f2545;font-weight:700;font-size:13px;padding:11px 22px;border-radius:8px;text-decoration:none;'>
                            View Announcement
                        </a>
                    </div>
                    <p style='color:#94a3b8;font-size:11px;text-align:center;margin-top:20px;'>
                        You received this because you are a registered resident of Barangay Sauyo.<br>
                        SKonnect - Sangguniang Kabataan Portal
                    </p>
                </div>
            ";
            $this->mail->AltBody = "New Announcement: {$title}\n\nCategory: {$category}\n\n{$excerpt}...\n\nPosted on {$date}\n\nVisit: http://localhost/SKonnect/views/public/announcements.php";

            $this->mail->send();
            return true;

        } catch (Exception $e) {
            error_log("Announcement email error for {$email}: " . $this->mail->ErrorInfo);
            return false;
        }
    }
}
?>