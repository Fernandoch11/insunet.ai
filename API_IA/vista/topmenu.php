<?php
require_once("./conexion/config.php");
session_start();

if(!isset($_SESSION['user'] ) || $_SESSION['user'] == '') {
    header("Location: ./");
    exit();
}
?>
<nav class="navbar">
    <div class="navbar-brand"><?php echo $_ENV['SYS_NAME'] ?></div>
        <input type="checkbox" id="navbar-toggle" class="navbar-toggle">
        <label for="navbar-toggle" class="navbar-icon">&#9776;</label>
        <div class="navbar-links">
            <hr class="devider"/>
            <a id="home" href="#">Inicio</a>
            <a id="formdata" href="#">Registrar</a>
            <a href="#" onclick="window.location.href='./controlador/logout.php'">Salir</a>
    </div>
</nav>