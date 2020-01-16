<?php
namespace App;

class Connection {
    public static function getDatabase() {
        $dsn = "mysql:host=". $_ENV['HOST'] .";dbname=". $_ENV['DB_NAME'] ."";
	    $user = $_ENV['USER'];
        $passwd = $_ENV['PASSWORD_DB'];

        try {
            $conn = new \PDO($dsn, $user, $passwd);
            return $conn;
        } catch (\PDOException $error) {
            echo "Erro: " . $error->getCode() . " Mensagem: " . $error->getMessage();
            die();
        }
    }
}
