<?php
// Include PHPMailer and Google API Client libraries
require 'autoload.php';  // Make sure the path is correct to 'vendor' folder

// Import necessary classes from PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to send the notification email
function sendNotificationEmail($to, $subject, $body) {
    try {
        $mail = new PHPMailer(true);

        // Server settings
        $mail->isSMTP();
        $mail->Host = 'localhost';  // SMTP server (use correct SMTP server)
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@example.com';  //  SMTP username
        $mail->Password = 'your-password';  //  SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Encryption method
        $mail->Port = 587;  // Port for STARTTLS (or 465 for SSL)

        // Recipients
        $mail->setFrom('your-email@example.com', 'E-Wallet System');
        $mail->addAddress($to);  // Add recipient's email address

        // Email content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        // Send email
        $mail->send();
        echo 'Notification email sent successfully!';
    } catch (Exception $e) {
        echo "Failed to send email. Error: {$mail->ErrorInfo}";
    }
}
?>
