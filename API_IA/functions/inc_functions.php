<?php

function load_code($strid){
    require_once('../conexion/conexion.php');
    $db = new Conexion();
    $db->connect();
    $dbl = $db->conn;

    if (!$dbl) {
        return '';
    }

    $sql =  "SELECT screencode, screen_title, css, nav_bar_inc FROM _load_code WHERE code = '".$strid."'";
    $statement = $dbl->prepare($sql);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if ($result && !empty($result['screencode'])) {
        return $result;
    } else {
        return '';
    }
}

?>