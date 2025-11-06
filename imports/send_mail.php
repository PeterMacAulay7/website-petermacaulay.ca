<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first   = htmlspecialchars(trim($_POST['firstname']));
    $last    = htmlspecialchars(trim($_POST['lastname']));
    $email   = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST['subject']));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }

    $mail = new PHPMailer(true);
    $config = include '/home/peteynsf/config.php';
    try {
        // SMTP setup
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $config['smtp_user'];
        $mail->Password = $config['smtp_pass'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom($config['smtp_user'], 'Website Contact Form');
        $mail->addAddress($config['smtp_user']); // where to receive
        $mail->addReplyTo($email, "$first $last");

        // Content
        $mail->isHTML(false);
        $mail->Subject = "New message from $first $last";
        $mail->Body = "Name: $first $last\nEmail: $email\n\nMessage:\n$message";

        $mail->send();
        header("Location: /imports/thank_you.php");
        exit;
    } catch (Exception $e) {
        echo "Sorry, message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
