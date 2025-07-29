<?php
$url = isset($_GET['url']) ? $_GET['url'] : 'login';

$ruta = 'vista/'.$url.'.php';

require('./src/router.php');
$recovery = 'N';
$token_success = 'N';
if(isset($errors[$url]) && $errors[$url]['message'] != '') {
    echo '<script>alert("'.$errors[$url]['message'].'");</script>';
    $ruta = 'vista/'.$errors[$url]['redirect'].'.php';
    $recovery = $errors[$url]['show_recovery'];
    $token_success = $errors[$url]['token_success'];
}

if (file_exists($ruta)) {
    include_once $ruta;
} else {
    include_once 'vista/error.php';
}

