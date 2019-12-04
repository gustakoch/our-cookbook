<?php

namespace App\Models;

use Resources\Classes\Bcrypt;
use Resources\Model\Model;

class Usuario extends Model {
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $permissao;
    private $status;
    private $chave;

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    public function hashSenha() {
        $sql = "SELECT senha
            FROM usuarios
            WHERE email = :email";

        $stmt = $this->database->prepare($sql);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->execute();

        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $usuario['senha'];
    }

    public function checkUsuario() {
        $hash = $this->hashSenha();
        $senha = $this->senha;

        if (Bcrypt::check($senha, $hash)) {
            return $this->dadosUsuario();
        } else {
            return null;
        }
    }

    public function dadosUsuario() {
        $hash = $this->hashSenha();

        $sql = "SELECT id, nome, email, permissao
            FROM usuarios
            WHERE email = :email
            AND senha = :senha
            AND status_ativado = '1'";

        $stmt = $this->database->prepare($sql);
        $stmt->bindParam(':email', $this->__get('email'));
        $stmt->bindParam(':senha', $hash);
        $stmt->execute();

        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        $this->__set('id', $usuario['id']);
        $this->__set('nome', $usuario['nome']);
        $this->__set('permissao', $usuario['permissao']);

        return $usuario;
    }

    public function criarUsuario() {
        $sql = "INSERT INTO usuarios
            (nome, email, senha, permissao, status_ativado)
            VALUES
            (:nome, :email, :senha, 'user', 0)";

        $stmt = $this->database->prepare($sql);
        $stmt->bindParam(':nome', $this->__get('nome'));
        $stmt->bindParam(':email', $this->__get('email'));
        $stmt->bindParam(':senha', $this->__get('senha'));
        $stmt->execute();

        return $this;
    }

    public function validarCadastroDeUsuario() {
        $results = array();
        $results['ok'] = true;
        $results['msg'] = "";

        if (strlen(trim($this->__get('nome'))) <= 0) {
            $results['ok'] = false;
            $results['msg'] = "Por favor, informe seu nome completo.";
        } else if ((trim(!preg_match("/^([a-zA-Zà-úÀ-Ú]|\s+)+$/", $this->__get('nome'))))) {
            $results['ok'] = false;
            $results['msg'] = "O nome informado é inválido! Por favor, tente novamente.";
        } else if (strlen(trim($this->__get('email'))) <= 0) {
            $results['ok'] = false;
            $results['msg'] = "Por favor, informe seu melhor e-mail.";
        } else if (!filter_var(trim($this->__get('email')), FILTER_VALIDATE_EMAIL)) {
            $results['ok'] = false;
            $results['msg'] = "O e-mail informado é inválido! Por favor, tente novamente.";
        } else if (strlen(trim($_POST['senha'])) <= 5) {
            $results['ok'] = false;
            $results['msg'] = "Sua senha secreta deve ter ao menos 6 dígitos.";
        } else if (strlen(trim($_POST['confirmar_senha'])) <= 0) {
            $results['ok'] = false;
            $results['msg'] = "Você deve confirmar a sua senha secreta.";
        } else if ($_POST['senha'] != $_POST['confirmar_senha']) {
            $results['ok'] = false;
            $results['msg'] = "As senhas não conferem! Por favor, verifique os dados e tente novamente.";
        }

        return $results;
    }

    public function validarCadastroNovaSenha() {
        $results = array();
        $results['ok'] = true;
        $results['msg'] = "";

        if (strlen(trim($this->__get('email'))) <= 0) {
            $results['ok'] = false;
            $results['msg'] = "Por favor, informe seu e-mail de cadastro.";
        } else if (!filter_var(trim($this->__get('email')), FILTER_VALIDATE_EMAIL)) {
            $results['ok'] = false;
            $results['msg'] = "O e-mail informado é inválido! Por favor, tente novamente.";
        } else if (strlen(trim($_POST['senha'])) <= 5) {
            $results['ok'] = false;
            $results['msg'] = "Sua nova senha secreta deve ter ao menos 6 dígitos.";
        } else if (strlen(trim($_POST['confirmar_senha'])) <= 0) {
            $results['ok'] = false;
            $results['msg'] = "Você deve confirmar a sua nova senha secreta.";
        } else if ($_POST['senha'] != $_POST['confirmar_senha']) {
            $results['ok'] = false;
            $results['msg'] = "As senhas não conferem! Por favor, verifique os dados e tente novamente.";
        }

        return $results;
    }

    public function gerarChaveDeAcesso() {
        $sql = "SELECT id, nome, email, senha
            FROM usuarios
            WHERE email = :email";

        $stmt = $this->database->prepare($sql);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->execute();

        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($usuario) {
            $dados = array();
            $dados['chave'] = sha1($usuario['id'] . $usuario['senha']);
            $dados['nome_usuario'] = $usuario['nome'];

            return $dados;
        }
    }

    public function checarChaveDeAcesso($chave) {
        $sql = "SELECT id, email, senha
            FROM usuarios
            WHERE email = :email";

        $stmt = $this->database->prepare($sql);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->execute();

        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (count($usuario) > 0) {
            $chave_usuario = sha1($usuario['id'] . $usuario['senha']);

            if ($chave_usuario == $chave) {
                return $usuario['id'];
            }
        }
    }

    public function alterarSenhaNoBD($id_usuario) {
        $sql = "UPDATE usuarios
            SET senha = :senha
            WHERE id = :id_usuario";

        $stmt = $this->database->prepare($sql);
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
    }

    public function procuraUsuarioPorEmail() {
        $results = array();

        $sql = "SELECT email
            FROM usuarios
            WHERE email = :email";

        $stmt = $this->database->prepare($sql);
        $stmt->bindParam(':email', $this->__get('email'));
        $stmt->execute();

        $usuario = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (count($usuario) > 0) {
            $results['ok'] = true;
            $results['msg'] = "O e-mail informado já existe! Por favor, informe outro.";
        } else {
            $results['ok'] = false;
            $results['msg'] = "Conta criada com sucesso!";
        }

        return $results;
    }

    public function procuraUsuarioPorId() {
        $sql = "SELECT nome, email
            FROM usuarios
            WHERE id = :id";

        $stmt = $this->database->prepare($sql);
        $stmt->bindParam(':id', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function todosOsUsuarios() {
        $sql = "SELECT id, nome, email, status_ativado,
            CASE
                WHEN permissao = 'admin' THEN 'Administrador'
                WHEN permissao = 'user' THEN 'Usuário comum'
            END as permissao
            FROM usuarios
            ORDER BY id";

        $stmt = $this->database->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function updateStatesAtivado() {
        $status = $this->__get('status');

        if ($status == '0') {
            $valor = 1;
        } else if ($status == '1') {
            $valor = 0;
        }

        $sql = "UPDATE usuarios
            SET status_ativado = $valor
            WHERE id = :id";

        $stmt = $this->database->prepare($sql);
        $stmt->bindParam(':id', $this->__get('id'));
        $stmt->execute();

        return true;
    }

    public function validarTrocaDeSenhaAdmin() {
        $validacao = array();
        $validacao['ok'] = true;
        $validacao['msg'] = "";

        if ($this->__get('id') == 0) {
            $validacao['ok'] = false;
            $validacao['msg'] = "Por favor, selecione um usuário.";
        } else if (strlen($_POST['nova_senha']) <= 0) {
            $validacao['ok'] = false;
            $validacao['msg'] = "Por favor, informe a nova senha.";
        } else if (strlen($_POST['confirmar_senha']) <= 0) {
            $validacao['ok'] = false;
            $validacao['msg'] = "Por favor, confirme a nova senha.";
        } else if ($_POST['nova_senha'] != $this->__get('confirmar_senha')) {
            $validacao['ok'] = false;
            $validacao['msg'] = "As senhas não conferem! Por favor, verifique os dados e tente novamente.";
        }

        return $validacao;
    }

    public function alterarSenhaUsuario() {
        $sql = "UPDATE usuarios
            SET senha = :senha
            WHERE id = :id";

        $stmt = $this->database->prepare($sql);
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();
    }
}
