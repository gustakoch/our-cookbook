<?php

namespace App;

define('HOST', 'mysqldb');
define('DB_NAME', 'cookbook');
define('USER', 'dev');
define('PASSWORD', 'dev');

class Connection {
    public static function getDatabase() {
        try {
            $conn = new \PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME . ";", USER, PASSWORD);
            return $conn;
        } catch (\PDOException $error) {
            echo "Erro: " . $error->getCode() . " Mensagem: " . $error->getMessage();
            die();
        }
    }
}
