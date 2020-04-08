<?php

namespace App\Models;

use Resources\Model\Model;

class Ingrediente extends Model {
    private $id;
    private $id_usuario;
    private $ingrediente;
    private $cadastrado_em;

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    public function todosOsIngredientes(): array {
        $sql = "SELECT
                *
            FROM ingredientes
            ORDER BY ingrediente ASC";

        $stmt = $this->database->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function ingredientesPorPagina($inicio, $qtdePagina): array {
        $sql = "SELECT
                *
            FROM ingredientes
            ORDER BY ingrediente ASC
            LIMIT $inicio, $qtdePagina";

        $stmt = $this->database->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function getIngredientesAtivos(): array {
        $sql = "SELECT
                *
            FROM ingredientes
            WHERE ativo = 1
            ORDER BY ingrediente ASC";

        $stmt = $this->database->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function validacaoDeCampos(): bool {
        $valido = true;

        if (strlen(trim($this->__get('ingrediente'))) <= 0) {
            $valido = false;
        }

        return $valido;
    }

    public function cadastrarIngrediente() {
        $sql = "INSERT INTO ingredientes
            (id_usuario, ingrediente, cadastrado_em)
            VALUES
            (:id_usuario, :ingrediente, now())";

        $stmt = $this->database->prepare($sql);
        $stmt->bindParam(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindParam(':ingrediente', $this->__get('ingrediente'));
        $stmt->execute();

        return $this;
    }

    public function unidadesMedidaIngredientes() {
        $sql = "SELECT *
            FROM unidades_medida_ingredientes";

        $stmt = $this->database->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllUnidadesMedida() {
        $sql = "SELECT
                *
            FROM unidades_medida_ingredientes";

        $stmt = $this->database->prepare($sql);
        $stmt->execute();

        $unidades = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $unidades;
    }

    public function excluirIngredienteById() {
        $sql = "DELETE FROM
                ingredientes
            WHERE id = :id";

        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('id', $this->__get('id'));
        $stmt->execute();

        $rowCount = $stmt->rowCount();

        return $rowCount;
    }

    public function inativarIngredienteById() {
        $sql = "UPDATE
                ingredientes
            SET
                ativo = 0
            WHERE id = :id";

        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('id', $this->__get('id'));
        $stmt->execute();

        $rowCount = $stmt->rowCount();

        return $rowCount;
    }

    public function editarReceiteById() {
        $sql = "UPDATE
                ingredientes
            SET
                ingrediente = :ingrediente
            WHERE id = :id";

        $ingrediente = $this->__get('ingrediente');

        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('id', $this->__get('id'));
        $stmt->bindValue('ingrediente', $this->__get('ingrediente'));
        $stmt->execute();

        $rowCount = $stmt->rowCount();

        return $rowCount;
    }

    public function verificaNomeIngrediente() {
        $sql = "SELECT
                ingrediente
            FROM ingredientes
            WHERE ingrediente = :ingrediente";

        $stmt = $this->database->prepare($sql);
        $stmt->bindValue('ingrediente', $this->__get('ingrediente'));
        $stmt->execute();

        $existe = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($existe)
            return true;

        return false;
    }

}
