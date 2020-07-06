<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../php-mailer/Exception.php';
require '../php-mailer/PHPMailer.php';
require '../php-mailer/SMTP.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp1.example.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'user@example.com';                     // SMTP username
    $mail->Password   = 'secret';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
    $mail->addReplyTo('info@example.com', 'Information');

    if (!isset($_POST['user_name']) || !isset($_POST['user_number']) || !$_POST['user_message'])
    {
      throw new Exception('Error');
      exit;
    }

    // Get user data
    $user_name = $_POST['user_name'];
    $user_number = $_POST['user_number'];
    $user_message = $_POST['user_message'];

    $body = 'username: '.$user_name.'<br>user number: '.$user_number.'<br>user message: '.$user_message;
    $bodyAlt = 'username: '.$user_name.'\n user number: '.$user_number.'\n user message: '.$user_message;

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'User message';
    $mail->Body    = $body;
    $mail->AltBody = $bodyAlt;

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}