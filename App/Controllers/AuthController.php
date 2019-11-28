<?php

namespace App\Controllers;

use Resources\Classes\Logs;
use Resources\Controller\Action;
use Resources\Model\Container;

class AuthController extends Action {
    public function login() {
        $usuario = Container::getModel('Usuario');

        $usuario->__set('email', $_POST['email']);
        $usuario->__set('senha', $_POST['senha']);

        $usuario->checkUsuario();

        if ($usuario->__get('id') != '' && $usuario->__get('nome') != '') {
            session_start();

            $_SESSION['id'] = $usuario->__get('id');
            $_SESSION['nome'] = $usuario->__get('nome');
            $_SESSION['permissao'] = $usuario->__get('permissao');

            $this->lembrarSenha();

            Logs::register($_POST['email'], 'success', 'Usuário conectou na aplicação!');
            sleep(1);
            header('Location: /admin');
        } else {
            Logs::register($_POST['email'], 'error', 'Usuário e ou senha inválidos no login!');
            header('Location: /?email=' . $usuario->__get('email') . '&error');
        }
    }

    public function lembrarSenha() {
        if (isset($_POST['lembrar_senha'])) {
            $expira = time() + (60 * 60 * 24 * 30);
            setcookie('senha', $_POST['senha'], $expira);
            setcookie('email', $_POST['email'], $expira);
        } else {
            setcookie('senha', '', time() -1);
            setcookie('email', '', time() -1);
        }
    }

    public function sair() {
        session_start();
        session_destroy();

        header('Location: /');
    }
}
