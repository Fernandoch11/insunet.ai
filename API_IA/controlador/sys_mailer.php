<?php
use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

class sysmailer{

    
    public function send_mail($email, $subject, $message, $token){
        require './vendor/autoload.php';
        require '../conexion/config.php';
        require '../src/templates.php';

        $template = new templates();
   
        $plantilla = $template->get_template('recovery_account');
        $plantilla = str_replace('@enlace', utf8_decode($message), $plantilla);
        $plantilla = str_replace('@token', $token, $plantilla);
        $plantilla = str_replace('@Compy', $_ENV['SYS_NAME'], $plantilla);

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = $_ENV['SYS_MAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SYS_MAIL_USER'];
            $mail->Password = $_ENV['API_KEY'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $_ENV['SYS_MAIL_PORT'];

            $mail->setFrom($_ENV['SYS_MAIL'], $_ENV['SYS_NAME']);
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = utf8_decode($subject);
            $mail->Body = $plantilla;

            if($mail->send()){
                return true;
            }else{
                return false;
            }
    }catch (Exception $e) {
            return false;
        }
    }
}


?>