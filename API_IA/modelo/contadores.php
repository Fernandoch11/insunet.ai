<?php
class contadores {

    public function auto_incrementar($page){
        require_once '../conexion/conexion.php';
        $db = new Conexion();
        $db->connect();
        $dbl = $db->conn;

        $query = "SELECT count, clave FROM custom_increment WHERE page = '$page'";
        $stmt = $dbl->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $result['count'] + 1;
        $clave = $result['clave'];


        $query = "UPDATE custom_increment SET count = $count WHERE page = '$page'";
        $stmt = $dbl->prepare($query);
        $stmt->execute();
        $stmt->closeCursor();

        return $clave.$count;
    }
}

?>