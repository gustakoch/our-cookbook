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
    private $quantidade_unidade;
    private $modo_de_fazer;
    private $busca;
    private $qtde_porcoes;
    private $tempo_preparo;

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

        if (strlen($_POST['nome_receita']) <= 0) {
            $results['ok'] = false;
            $results['msg'] = "Informe o nome da receita";
        } else if (strlen($_POST['descricao']) <= 0) {
            $results['ok'] = false;
            $results['msg'] = "Informe uma breve descrição da receita";
        } else if (!$_POST['ingredientes']) {
            $results['ok'] = false;
            $results['msg'] = "Selecione ao menos um ingrediente para a receita";
        } else if (strlen($_POST['modo_de_fazer']) <= 0) {
            $results['ok'] = false;
            $results['msg'] = "Descreva o modo de fazer";
        } else if (strlen($_POST['qtde_porcoes']) <= 0) {
            $results['ok'] = false;
            $results['msg'] = "Informe a quantidade de porções";
        } else if (strlen($_POST['tempo_preparo']) <= 0) {
            $results['ok'] = false;
            $results['msg'] = "Informe a quantidade de tempo para o preparo";
        }

        $postQuantidades = isset($_POST['quantidade']) ? $_POST['quantidade'] : [];

        foreach ($postQuantidades as $qtde) {
            if (!$qtde) {
                $results['ok'] = false;
                $results['msg'] = "Informe a quantidade e unidade de medida do ingrediente selecionado";
            }
        }

        return $results;
    }

    public function validarAtualizacaoReceita() {
        $results = array();
        $results['ok'] = true;
        $results['msg'] = "";

        if (strlen($_POST['nome_receita']) <= 0) {
            $results['ok'] = false;
            $results['msg'] = "Informe o nome da receita.";
        } else if (strlen($_POST['descricao']) <= 0) {
            $results['ok'] = false;
            $results['msg'] = "Informe uma breve descrição da receita.";
        } else if (count($_POST['ingredientes']) == 0) {
            $results['ok'] = false;
            $results['msg'] = "Selecione ao menos um ingrediente para a receita.";
        } else if (strlen($_POST['modo_de_fazer']) <= 0) {
            $results['ok'] = false;
            $results['msg'] = "Descreva o modo de fazer.";
        } else if (strlen($_POST['qtde_porcoes']) <= 0) {
            $results['ok'] = false;
            $results['msg'] = "Informe a quantidade de porções.";
        } else if (strlen($_POST['tempo_preparo']) <= 0) {
            $results['ok'] = false;
            $results['msg'] = "Informe a quantidade de tempo para o preparo.";
        }

        return $results;
    }

    public function salvarReceita() {
        $sql = "INSERT INTO receitas
            (id_usuario, nome_receita, descricao, nome_imagem, ingredientes, quantidade_unidade, modo_de_fazer, qtde_porcoes, tempo_preparo)
            VALUES
            (:id_usuario, :nome_receita, :descricao, :nome_imagem, :ingredientes, :quantidade_unidade, :modo_de_fazer, :qtde_porcoes, :tempo_preparo)";

        $stmt = $this->database->prepare($sql);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':nome_receita', $this->__get('nome_receita'));
        $stmt->bindValue(':descricao', $this->__get('descricao'));
        $stmt->bindValue(':nome_imagem', $this->__get('nome_imagem'));
        $stmt->bindValue(':ingredientes', $this->__get('ingredientes'));
        $stmt->bindValue(':quantidade_unidade', $this->__get('quantidade_unidade'));
        $stmt->bindValue(':modo_de_fazer', $this->__get('modo_de_fazer'));
        $stmt->bindValue(':qtde_porcoes', $this->__get('qtde_porcoes'));
        $stmt->bindValue(':tempo_preparo', $this->__get('tempo_preparo'));
        $stmt->execute();
    }

    public function atualizarReceita() {
        $sql = "UPDATE receitas
            SET
                nome_receita = :nome_receita,
                descricao = :descricao,
                nome_imagem = :nome_imagem,
                ingredientes = :ingredientes,
                quantidade_unidade = :quantidade_unidade,
                modo_de_fazer = :modo_de_fazer,
                qtde_porcoes = :qtde_porcoes,
                tempo_preparo = :tempo_preparo
            WHERE id = :id_receita";

        $stmt = $this->database->prepare($sql);
        $stmt->bindValue(':id_receita', $this->__get('id'));
        $stmt->bindValue(':nome_receita', $this->__get('nome_receita'));
        $stmt->bindValue(':descricao', $this->__get('descricao'));
        $stmt->bindValue(':nome_imagem', $this->__get('nome_imagem'));
        $stmt->bindValue(':ingredientes', $this->__get('ingredientes'));
        $stmt->bindValue(':quantidade_unidade', $this->__get('quantidade_unidade'));
        $stmt->bindValue(':modo_de_fazer', $this->__get('modo_de_fazer'));
        $stmt->bindValue(':qtde_porcoes', $this->__get('qtde_porcoes'));
        $stmt->bindValue(':tempo_preparo', $this->__get('tempo_preparo'));
        $stmt->execute();
    }

    public function todasAsReceitas(): array {
        $sql = "SELECT r.id, r.id_usuario, r.descricao, r.ingredientes, r.modo_de_fazer, r.nome_imagem, r.nome_receita, u.nome,
            DATE_FORMAT(r.cadastrado_em, '%d/%m/%Y \à\s %H:%i') as data_cadastrado, f.id as id_favorito
            FROM receitas r
            INNER JOIN usuarios u
                ON (u.id = r.id_usuario)
            LEFT JOIN favoritos f
                ON (r.id = f.id_receita and f.id_usuario = :id_usuario)
            WHERE r.removido_em IS NULL
            ORDER BY r.cadastrado_em DESC";

        $stmt = $this->database->prepare($sql);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function favoritosPorUsuario() {
        $sql = "SELECT
                DATE_FORMAT(r.cadastrado_em, '%d/%m/%Y \à\s %H:%i') as data_cadastrado,
                r.id, r.descricao,
                r.ingredientes,
                r.modo_de_fazer,
                r.nome_imagem,
                r.nome_receita,
                r.removido_em,
                u.nome,
                u.id as id_usuario,
                f.id as id_favorito
            FROM receitas r
            INNER JOIN usuarios u
                ON (u.id = r.id_usuario)
            LEFT JOIN favoritos f
                ON (r.id = f.id_receita and f.id_usuario = :id_usuario)
            WHERE f.id IS NOT NULL
            AND r.removido_em IS NULL
            ORDER BY r.cadastrado_em DESC";

        $stmt = $this->database->prepare($sql);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function cincoUltimasReceitasCadastradas() {
        $sql = "SELECT r.id as id_receita, r.nome_receita, r.descricao, r.nome_imagem, r.ingredientes, r.modo_de_fazer, u.nome,
            DATE_FORMAT(r.cadastrado_em, '%d/%m/%Y \à\s %H:%i') as data_cadastro
            FROM receitas as r
            INNER JOIN usuarios as u ON (u.id = r.id_usuario)
            WHERE r.removido_em IS NULL
            ORDER BY r.cadastrado_em DESC
            LIMIT 5";

        $stmt = $this->database->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // REMOVER ESSE MÉTODO E UTILIZAR SOMENTE O ABAIXO, COM fetch. Ajustar arquivo app.js pois utiliza esse método.
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

    public function procurarReceitaPorId() {
        $sql = "SELECT r.*, u.nome
            FROM receitas r
            INNER JOIN usuarios u ON (u.id = r.id_usuario)
            WHERE r.id = :id";

        $stmt = $this->database->prepare($sql);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function buscaReceitas() {
        $sql = "SELECT
                r.id, u.id AS id_usuario,
                r.descricao,
                r.ingredientes,
                r.modo_de_fazer,
                r.nome_imagem,
                r.nome_receita,
                u.nome,
                DATE_FORMAT(r.cadastrado_em, '%d/%m/%Y \à\s %H:%i') AS data_cadastrado,
                f.id AS id_favorito
            FROM receitas r
            INNER JOIN usuarios u
                ON (u.id = r.id_usuario)
            LEFT JOIN favoritos f
                ON (r.id = f.id_receita AND f.id_usuario = :id_usuario)
            WHERE (r.nome_receita LIKE :busca OR r.descricao LIKE :busca)
            AND r.removido_em IS NULL
            ORDER BY r.cadastrado_em DESC";

        $busca = $this->__get('busca');
        $busca = "%{$busca}%";

        $stmt = $this->database->prepare($sql);
        $stmt->bindParam(':busca', $busca);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
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
            $stmt->bindParam(':id_usuario', $this->__get('id_usuario'));
            $stmt->bindParam(':id_receita', $this->__get('id'));
            $stmt->execute();

            return false;
        } else {
            $sql = "INSERT INTO favoritos
                (id_usuario, id_receita)
                VALUES
                (:id_usuario, :id_receita)";
            $stmt = $this->database->prepare($sql);
            $stmt->bindParam(':id_usuario', $this->__get('id_usuario'));
            $stmt->bindParam(':id_receita', $this->__get('id'));
            $stmt->execute();
            return true;
        }
    }

    public function removerFavorito() {
        $sql = "DELETE FROM favoritos
                WHERE id_usuario = :id_usuario
                AND id_receita = :id_receita";

        $stmt = $this->database->prepare($sql);
        $stmt->bindParam(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindParam(':id_receita', $this->__get('id'));
        $stmt->execute();
    }

    public function removerReceita() {
        $sql = "UPDATE receitas
            SET removido_em = now()
            WHERE id = :id
            AND id_usuario = :id_usuario";

        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('id', $this->__get('id'));
        $stmt->bindValue('id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function usuarioCadastrouReceita() {
        $sql = "SELECT *
            FROM receitas
            WHERE id = :id
            AND id_usuario = :id_usuario";

        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('id', $this->__get('id'));
        $stmt->bindValue('id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getStringImagem() {
        $sql = "SELECT nome_imagem
            FROM receitas
            WHERE id = :id_receita";
        $stmt = $this->database->prepare($sql);
        $stmt->bindValue(':id_receita', $this->__get('id'));
        $stmt->execute();

        $dado = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $dado['nome_imagem'];
    }
}
