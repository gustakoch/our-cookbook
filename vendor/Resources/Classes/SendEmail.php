<?php
namespace Resources\Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class SendMail extends PHPMailer {
    private $from = 'site@gtech.epizy.com';

    public function newUserRegister($nome, $email) {
        $body = "
            <h3>Novo usuário se registrou no sistema</h3>
            <p>
                Dados informados no registro:<br>
                <strong>{$nome}</strong> <span>({$email})</span>
            </p>
            <p>
                Para liberar o acesso do novo usuário, você pode utilizar o link abaixo.<br>
                http://localhost:3334/usuarios
            </p>
            <p>
                --<br>
                Essa é uma mensagem automática, favor não respondê-la.<br>
                --<br><br>

                Atenciosamente,<br>
                Our Cookbook | Todos os direitos reservados.<br>
                gtech.epizy.com
            </p>
        ";

        $this->isSMTP();
        // $this->SMTPDebug  = SMTP::DEBUG_SERVER;
        $this->Host       = 'smtp.sendgrid.net';
        $this->SMTPAuth   = true;
        $this->Username   = $_ENV['USERNAME_SENDGRID'];
        $this->Password   = $_ENV['PASSWORD_SENDGRID'];
        $this->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->Port       = 587;
        $this->CharSet    = 'UTF-8';

        $this->setFrom($this->from, 'Our Cookbook');
        $this->addAddress('srt.gugah@gmail.com');

        $this->isHTML(true);
        $this->Subject = 'Novo usuário registrado';
        $this->Body    = $body;
        $this->AltBody = 'Novo usuário se registrou no sistema';

        $this->send();
    }
}
