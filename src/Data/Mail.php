<?php

    namespace imdmedia\Data;

    use imdmedia\Data\Config;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    abstract class Mail {


    public static function sendResetMail($userEmail, $url) {

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPDebug = 2;
    $mail->SMTPOptions = array(
                    'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                 )
                );
    $config = Config::getConfig();
    $user = $config['mailuser'];
    $password = $config['mailpw'];

    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $user; 
    $mail->Password = $password; 
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom('IMDmediaHelpdesk@gmail.com', 'IMDmediaHelpdesk');
    $mail->addAddress($userEmail);
    $mail->isHTML(true);
    $mail->Subject = 'Password reset request for IMDmedia';
            $mail->Body = '<p>Here is your reset link: </br><a href=' . $url . '>' . $url . '</a></p>';
            if (!$mail->send()) {
                throw new Exception("Message could not be sent. Mailer Error: " . $mail->ErrorInfo);
            } else {
                header("Location: reset-password.php?reset=success");
            }

    }
}
