<?php
    require_once "../conexion/conexion.php";

    $db = new Conexion();
    $db->connect();
    $dbl = $db->conn;

    $sql = "update recuperar_credenciales t1 set t1.status = 'EXPIRADO' where TIMESTAMPDIFF(MINUTE,t1.date,SYSDATE()) >= 10 AND t1.status = 'ACTIVO'";
    $stmt = $dbl->prepare($sql);
    if($stmt->execute()){
        $stmt->closeCursor();
    }
?>