<?php

namespace App;

define('HOST', 'localhost');
define('DB_NAME', 'cookbook');
define('USER', 'root');
define('PASSWORD', '');

class ConnectionDatabase {
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
