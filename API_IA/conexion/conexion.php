<?php

class Conexion {
    private $host = 'localhost';
    private $db_name = 'insunet_ai';
    private $username = 'root';
    private $password = '';

    public $conn;
    public $encrypt = 'e2f81a3d46c94b1ab87b61ea305cedff25c6d1b7462a4e7a58d4cf81d8fbb3ad';

    public function connect() {
        require_once "config.php";

        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host={$_ENV['SYS_HOST']};dbname={$_ENV['DB_NAME']}", $_ENV['DB_USER'], $_ENV['DB_PASS']);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
    }

}

?>