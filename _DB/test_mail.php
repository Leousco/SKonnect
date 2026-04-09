<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'dukedaniel.tolentino@gmail.com'; // palitan mo
    $mail->Password   = '1234';    // app password, hindi normal password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom('dukedaniel.tolentino@gmail.com', 'SKonnect');
    $mail->addAddress('tolentino.dukedaniel.diatre@gmail.com'); // kung kanino mo issend

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Test Email';
    $mail->Body    = 'Hello! Gumagana na PHPMailer mo 🎉';

    $mail->send();
    echo 'Message sent!';
} catch (Exception $e) {
    echo "Error: {$mail->ErrorInfo}";
}