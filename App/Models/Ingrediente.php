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

    public function todosOsIngredientes() {
        $sql = "SELECT * FROM ingredientes ORDER BY cadastrado_em DESC";

        $stmt = $this->database->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function validacaoDeCampos() {
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
    
}
