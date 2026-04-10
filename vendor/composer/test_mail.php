<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->SMTPDebug  = SMTP::DEBUG_SERVER; // Remove this after testing
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'dukedaniel.tolentino@gmail.com';
    $mail->Password   = 'nmcf pfan pggr kphe'; // App password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // ✅ Fixed
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom('dukedaniel.tolentino@gmail.com', 'SKonnect');
    $mail->addAddress('tolentino.dukedaniel.diatre@gmail.com', 'Recipient');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Test Email';
    $mail->Body    = 'Hello! Gumagana na PHPMailer mo 🎉';
    $mail->AltBody = 'Hello! Gumagana na PHPMailer mo'; // ✅ Fallback for non-HTML

    $mail->send();
    echo 'Message sent!';
} catch (Exception $e) {
    echo "Error: {$mail->ErrorInfo}";
}