<?php

namespace App\Models;

use Resources\Model\Model;

class Receita extends Model {
    private $id;
    private $id_usuario;
    private $nome_receita;
    private $descricao;
    private $nome_imagem;
    private $ingredientes;
    private $modo_de_fazer;
    private $busca;

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    public function validarCadastroDeReceitas() {
        $results = array();
        $results['ok'] = true;
        $results['msg'] = "";

        if ($_FILES['imagem']['name'] == "") {
            $results['ok'] = false;
            $results['msg'] = "Você precisa selecionar uma imagem";
        } else if (strlen($_POST['nome_receita']) <= 0) {
            $results['ok'] = false;
            $results['msg'] = "Informe o nome da receita";
        } else if (strlen($_POST['descricao']) <= 0) {
            $results['ok'] = false;
            $results['msg'] = "Informe uma breve descrição da receita";
        } else if (count($_POST['ingredientes']) == 0) {
            $results['ok'] = false;
            $results['msg'] = "Selecione ao menos um ingrediente para a receita";
        } else if (strlen($_POST['modo_de_fazer']) <= 0) {
            $results['ok'] = false;
            $results['msg'] = "Descreva o modo de fazer";
        }

        return $results;
    }

    public function salvarReceita() {
        $sql = "INSERT INTO receitas
            (id_usuario, nome_receita, descricao, nome_imagem, ingredientes, modo_de_fazer)
            VALUES
            (:id_usuario, :nome_receita, :descricao, :nome_imagem, :ingredientes, :modo_de_fazer)";

        $stmt = $this->database->prepare($sql);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':nome_receita', $this->__get('nome_receita'));
        $stmt->bindValue(':descricao', $this->__get('descricao'));
        $stmt->bindValue(':nome_imagem', $this->__get('nome_imagem'));
        $stmt->bindValue(':ingredientes', $this->__get('ingredientes'));
        $stmt->bindValue(':modo_de_fazer', $this->__get('modo_de_fazer'));
        $stmt->execute();

        return true;
    }

    public function todasAsReceitas() {
        $sql = "SELECT r.id, r.descricao, r.ingredientes, r.modo_de_fazer, r.nome_imagem, r.nome_receita, u.nome,
            DATE_FORMAT(r.cadastrado_em, '%d/%m/%Y \à\s %H:%i') as data_cadastrado, f.id as id_favorito
            FROM receitas r
            INNER JOIN usuarios u
                ON (u.id = r.id_usuario)
            LEFT JOIN favoritos f
                ON (r.id = f.id_receita and f.id_usuario = :id_usuario)
            ORDER BY r.cadastrado_em DESC";

        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function favoritosPorUsuario() {
        $sql = "SELECT r.id, r.descricao, r.ingredientes, r.modo_de_fazer, r.nome_imagem, r.nome_receita, u.nome,
            DATE_FORMAT(r.cadastrado_em, '%d/%m/%Y \à\s %H:%i') as data_cadastrado, f.id as id_favorito
            FROM receitas r
            INNER JOIN usuarios u
                ON (u.id = r.id_usuario)
            LEFT JOIN favoritos f
                ON (r.id = f.id_receita and f.id_usuario = :id_usuario)
            WHERE f.id IS NOT NULL
            ORDER BY r.cadastrado_em DESC";

        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function cincoUltimasReceitasCadastradas() {
        $sql = "SELECT r.id as id_receita, r.nome_receita, r.descricao, r.nome_imagem, r.ingredientes, r.modo_de_fazer, u.nome,
            DATE_FORMAT(r.cadastrado_em, '%d/%m/%Y \à\s %H:%i') as data_cadastro
            FROM receitas as r
            INNER JOIN usuarios as u ON (u.id = r.id_usuario)
            ORDER BY r.cadastrado_em DESC
            LIMIT 5";

        $stmt = $this->database->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getReceitaPorId() {
        $sql = "SELECT r.*, u.nome
            FROM receitas r
            INNER JOIN usuarios u ON (u.id = r.id_usuario)
            WHERE r.id = :id";

        $stmt = $this->database->prepare($sql);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function buscaReceitas() {
        $sql = "SELECT r.id, r.descricao, r.ingredientes, r.modo_de_fazer, r.nome_imagem, r.nome_receita, u.nome,
            DATE_FORMAT(r.cadastrado_em, '%d/%m/%Y \à\s %H:%i') as data_cadastrado, f.id as id_favorito
            FROM receitas r
            INNER JOIN usuarios u
                ON (u.id = r.id_usuario)
            LEFT JOIN favoritos f
                ON (r.id = f.id_receita and f.id_usuario = :id_usuario)
            WHERE nome_receita LIKE :busca
            OR descricao LIKE :busca
            ORDER BY r.cadastrado_em DESC";

        $busca = $this->__get('busca');
        $busca = "%{$busca}%";

        $stmt = $this->database->prepare($sql);
        $stmt->bindParam('busca', $busca);
        $stmt->bindValue('id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function buscarByIdReceitaAndIdUsuario() {
        $sql = "SELECT *
            FROM favoritos
            WHERE id_usuario = :id_usuario
            AND id_receita = :id";

        $stmt = $this->database->prepare($sql);
        $stmt->bindParam(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindParam(':id', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function atualizarFavorito() {
        if (count($this->buscarByIdReceitaAndIdUsuario()) > 0) {
            $sql = "DELETE FROM favoritos
                WHERE id_usuario = :id_usuario
                AND id_receita = :id_receita";

            $stmt = $this->database->prepare($sql);
            $stmt->bindParam('id_usuario', $this->__get('id_usuario'));
            $stmt->bindParam('id_receita', $this->__get('id'));
            $stmt->execute();

            return false;
        } else {
            $sql = "INSERT INTO favoritos
                (id_usuario, id_receita)
                VALUES
                (:id_usuario, :id_receita)";
            $stmt = $this->database->prepare($sql);
            $stmt->bindParam('id_usuario', $this->__get('id_usuario'));
            $stmt->bindParam('id_receita', $this->__get('id'));
            $stmt->execute();
            return true;
        }
    }
}
