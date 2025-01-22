<?php

require FCPATH. "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {

    public $mail;
    public function sendmail($email='', $subject='', $message='', $filepath='', $filename='') {
        $this->mail = new PHPMailer(true);
        try {
            $this->mail->isSMTP();
            $this->mail->SMTPAuth = true;
            
            $this->mail->Host = "smtp.gmail.com";
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port = 587;
            
            $this->mail->Username = "vashistaditya77@gmail.com";
            $this->mail->Password = "oauinlfztjzrgloi";
            
            $this->mail->setFrom("vashistaditya77@gmail.com", "Aditya Vashist");
            $this->mail->addAddress($email);
            
            $this->mail->Subject = $subject;
            $this->mail->Body = $message;
            $this->mail->addAttachment($filepath, $filename);
            
            $this->mail->send();
            return ("Email sent");
        } catch(Exception $e) {
            return ("Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}");
        }
    }
}