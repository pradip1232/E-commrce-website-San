<?php
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include './invoice_biiling.php';
function sendConfirmationEmail($name, $email, $phoneNumber)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Remove or comment out this line
        $mail->Host       = 'mail.squibfactory.com'; // SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'noreply@squibfactory.com'; // SMTP username
        $mail->Password   = '}f#BCv6&3}w9'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable TLS encryption
        $mail->Port       = 465; // TCP port to connect to

        //Recipients
        $mail->setFrom('noreply@squibfactory.com', 'Squib Factory');
        $mail->addAddress($email); // Add a recipient
        
        $mail->addAttachment('invoice.pdf'); // Attach PDF
        // $mail->addBCC('squibfactory@gmail.com'); // BCC email address

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = "New User Request";

        $mail->Body = "
                <html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            line-height: 1.6;
                        }
                        .container {
                            padding: 10px;
                            background-color: #f9f9f9;
                            border: 1px solid #ddd;
                            border-radius: 5px;
                        }
                        .header {
                            font-size: 18px;
                            font-weight: bold;
                            margin-bottom: 10px;
                        }
                        .content {
                            margin-top: 10px;
                        }
                        .content p {
                            margin: 5px 0;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>New User Request</div>
                        <div class='content'>
                            <p><strong>Name:</strong> $name</p>
                            <p><strong>Email:</strong> $email</p>
                            <p><strong>Phone Number:</strong> $phoneNumber</p>
                           
                        </div>
                    </div>
                    <p>Regards,<br>Squib Factory</p>
                </body>
                </html>
            ";

        $mail->isHTML(true); // Ensure the email is sent as HTML


        $mail->send();
        echo 'Email sent successfully';
    } catch (Exception $e) {
        echo "Error sending confirmation email: {$mail->ErrorInfo}";
    }
}


$name = "Pradip";
$email = "755201pradip@gmail.com";
$phoneNumber = "321654987";
// Call the function for debugging purposes
// sendConfirmationEmail($name, $email, $phoneNumber);
