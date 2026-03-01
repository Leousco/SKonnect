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
    
    public function sendOTP($email, $otp, $name) {
        try {
            // Server settings
            $this->mail->SMTPDebug = 0;                                 
            $this->mail->isSMTP();                                      
            $this->mail->Host       = 'smtp.gmail.com';                 
            $this->mail->SMTPAuth   = true;                            
            $this->mail->Username   = 'skonnect.system@gmail.com';           
            $this->mail->Password   = 'dktl mpvg fwfu hqnt';              
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   
            $this->mail->Port       = 587;                              
            
            // Recipients
            $this->mail->setFrom('skonnect.system@gmail.com', 'SKonnect');
            $this->mail->addAddress($email, $name);
            
            // Content
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
}
?>