<?php     

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

    function sendotp($email,$username,$otp){

        require 'vendor/autoload.php';
        try {

            $mail = new PHPMailer(true);

            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'nirmaeats@gmail.com';                     //SMTP username
            $mail->Password   = 'Nirmaeats@11';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;       

            $mail->setFrom('nirmaeats@gmail.com', 'NirmaEats');
            $mail->addAddress($email, $username);

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'One Time Password (OTP) to verify Email ID';
            $username = strtoupper($username);
            $html = "
                Hi <strong>$username</strong>, <br>
                Your One Time Password (OTP) is <strong>$otp</strong> <br><br>
                The OTP will expire in ten minutes if not used. <br>
                If you have not made this request, please contact our customer support immediately.<br>
                <br>
                Thank You,<br>
                <strong>NirmaEats Team<strong>
            ";
            $mail->Body = $html;

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
