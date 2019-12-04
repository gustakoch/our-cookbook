<?php

namespace App\Models;

use Resources\Model\Model;

class Mensagem extends Model {
    private $id;
    private $nome;
    private $email;
    private $telefone;
    private $assunto;
    private $mensagem;
    private $usuario;
    private $enviado_em;

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    public function todasAsMensagens() {
        $sql = "SELECT id, nome, email, telefone, assunto, mensagem, lido,
            DATE_FORMAT(enviado_em, '%d/%m/%Y \à\s %H:%i') as data_enviado
            FROM mensagens
            ORDER BY enviado_em DESC";

        $stmt = $this->database->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function mensagensNaoLidas() {
        $sql = "SELECT count(*) as nao_lidas
            FROM mensagens
            WHERE lido = 0";

        $stmt = $this->database->prepare($sql);
        $stmt->execute();

        $dado = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $dado['nao_lidas'];
    }

    public function mensagensLidas() {
        $sql = "SELECT count(*) as lidas
            FROM mensagens
            WHERE lido = 1";

        $stmt = $this->database->prepare($sql);
        $stmt->execute();

        $dado = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $dado['lidas'];
    }

    public function validacaoDeCampos() {
        $validacao = array();
        $validacao['ok'] = true;
        $validacao['msg'] = "";

        if (strlen(trim($this->__get('nome'))) <= 0) {
            $validacao['ok'] = false;
            $validacao['msg'] = "Por favor, informe seu nome.";
        } else if (strlen(trim($this->__get('email'))) <= 0) {
            $validacao['ok'] = false;
            $validacao['msg'] = "Por favor, informe seu e-mail.";
        } else if (!filter_var(trim($this->__get('email')), FILTER_VALIDATE_EMAIL)) {
            $validacao['ok'] = false;
            $validacao['msg'] = "O e-mail informado é inválido! Por favor, tente novamente.";
        } else if (strlen(trim($this->__get('assunto'))) <= 0) {
            $validacao['ok'] = false;
            $validacao['msg'] = "Por favor, informe o assunto da mensagem.";
        } else if (strlen(trim($this->__get('mensagem'))) <= 0) {
            $validacao['ok'] = false;
            $validacao['msg'] = "Por favor, informe a sua mensagem.";
        }

        return $validacao;
    }

    public function salvarMensagem() {
        date_default_timezone_set("America/Recife");

        $sql = "INSERT INTO mensagens
            (nome, email, telefone, assunto, mensagem, usuario)
            VALUES
            (:nome, :email, :telefone, :assunto, :mensagem, :usuario)";

        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('nome', $this->__get('nome'));
        $stmt->bindValue('email', $this->__get('email'));
        $stmt->bindValue('telefone', $this->__get('telefone'));
        $stmt->bindValue('assunto', $this->__get('assunto'));
        $stmt->bindValue('mensagem', $this->__get('mensagem'));
        $stmt->bindValue('usuario', $this->__get('usuario'));
        $stmt->execute();
    }


}