<?php

namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Resources\Classes\Bcrypt;
use Resources\Controller\Action;
use Resources\Model\Container;

class IndexController extends Action {
    public function index() {
        $this->render('index', 'Layout');
    }

    public function pageCriarConta() {
        error_reporting(~E_NOTICE);

        $this->render('criarconta', 'Layout');
    }

    public function recuperacao() {
        $this->render('recuperacao_senha', 'Layout');
    }

    public function alteracaoSenha() {
        if (isset($_GET['chave']) && $_GET['chave'] != '') {
            $this->dados->chave = preg_replace('/[^[:alnum:]]/', '', $_GET['chave']);
        } else {
            header('Location: /');
        }

        $this->render('alteracao_senha', 'Layout');
    }

    public function recuperarSenha() {
        // error_reporting(~E_WARNING && ~E_NOTICE);

        $usuario = Container::getModel('Usuario');
        $usuario->__set('email', $_POST['email']);

        $dados = $usuario->gerarChaveDeAcesso();

        if (strlen($_POST['email']) <= 0) {
            $this->dados->email = array(
                'email' => $_POST['email'],
                'msg' => 'Por favor, informe o seu e-mail de recuperação.'
            );

            $this->render('recuperacao_senha', 'Layout');
        } else if ($dados == null) {
            $this->dados->email = array(
                'email' => $_POST['email'],
                'msg' => 'O e-mail informado não existe! Verifique os dados e tente novamente.'
            );

            $this->render('recuperacao_senha', 'Layout');
        } else {
            $this->enviarEmailRecuperacaoSenha($dados['chave'], $_POST['email'], $dados['nome_usuario']);
            $this->dados->msg = "Verifique seu e-mail!";

            $this->render('recuperacao_senha', 'Layout');
        }
    }

    public function enviarEmailRecuperacaoSenha($chave, $email_envio, $nome) {
        $html = "
            <h3>Prezado(a) {$nome},</h3>
            <p>
                Parece que você solicitou a recuperação da sua senha de acesso ao sistema do Cookbook.<br>
                Clique no link abaixo para recadastrar a sua senha:<br>
                <a href='http://localhost:3334/alteracaosenha?chave=" . $chave . "'>Cadastrar uma nova senha</a>
            </p>
            <p>
                Caso seu cliente de e-mail não permita clicar no link acima, copie e cole o endereço abaixo no seu navegador de Internet.<br>
                http://localhost:3334/alteracaosenha?chave=" . $chave . "
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

        $mail = new PHPMailer(true);

        try {
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host       = 'smtp.sendgrid.net';       
            $mail->SMTPAuth   = true;
            $mail->Username   = 'apikey';
            $mail->Password   = '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';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet = 'UTF-8';

            $mail->setFrom('site@gtech.epizy.com', 'Our Cookbook');
            $mail->addAddress($email_envio);

            $mail->isHTML(true);
            $mail->Subject = 'Alteração de senha';
            $mail->Body    = $html;
            $mail->AltBody = 'Prezado(a)...';

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        
    }

    public function cadastrarNovaSenha() {
        if (!$_POST['chave']) {
            header('Location: /');
        }

        $usuario = Container::getModel('Usuario');

        $usuario->__set('email', $_POST['email']);
        $usuario->__set('senha', Bcrypt::hash($_POST['senha']));
        $usuario->__set('chave', preg_replace('/[^[:alnum:]]/', '', $_POST['chave']));

        $validacao = $usuario->validarCadastroNovaSenha();

        if ($validacao['ok']) {
            $id_usuario = $usuario->checarChaveDeAcesso($usuario->__get('chave'));

            if ($id_usuario) {
                $usuario->alterarSenhaNoBD($id_usuario);
                $this->dados->msg_ok = "Senha alterada com sucesso!";

                $this->render('alteracao_senha', 'Layout');

            } else {
                $this->dados->chave = preg_replace('/[^[:alnum:]]/', '', $_POST['chave']);
                $this->dados->validacao = array(
                    'msg' => "Usuário não encontrado! Verifique os dados e tente novamente."
                );

                $this->render('alteracao_senha', 'Layout');
            }

        } else {
            $this->dados->chave = preg_replace('/[^[:alnum:]]/', '', $_POST['chave']);
            $this->dados->validacao = array(
                'email' => $_POST['email'],
                'senha' => $_POST['senha'],
                'msg' => $validacao['msg']
            );
            $this->render('alteracao_senha', 'Layout');
        }
    }

    public function criarNovaConta() {
        session_start();
        $usuario = Container::getModel('Usuario');

        $usuario->__set('nome', $_POST['nome']);
        $usuario->__set('email', $_POST['email']);
        $usuario->__set('senha', Bcrypt::hash($_POST['senha']));

        $validacao = $usuario->validarCadastroDeUsuario();

        if ($validacao['ok']) {
            $usuario_existente = $usuario->procuraUsuarioPorEmail();

            if (!$usuario_existente['ok']) {
                $usuario->criarUsuario();
                header('Location: /criarconta?ok');
            } else {
                $this->dados->erro_validacao = array(
                    'msg' => $usuario_existente['msg'],
                    'nome' => $usuario->__get('nome'),
                    'email' => $usuario->__get('email')
                );
                $this->render('criarconta', 'Layout');
            }
        } else {
            $this->dados->erro_validacao = array(
                'msg' => $validacao['msg'],
                'nome' => $usuario->__get('nome'),
                'email' => $usuario->__get('email'),
                'senha' => $_POST['senha']
            );
            $this->render('criarconta', 'Layout');
        }
    }
}
