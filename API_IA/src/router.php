<?php
$errors = array(
    'login_error' => ['message' => 'Usuario o contraseña incorrectos.', 'redirect' => 'login', 'show_recovery' => 'Y', 'token_success' => 'N'],
    'token_sent' => ['message' => 'Token enviado exitosamente', 'redirect' => 'verify_token', 'show_recovery' => 'N', 'token_success' => 'N'],
    'token_error' => ['message' => 'Error al enviar el token', 'redirect' => 'recovery', 'show_recovery' => 'N', 'token_success' => 'N'],
    'check_email' => ['message' => 'Verifica tu correo electrónico', 'redirect' => 'recovery', 'show_recovery' => 'N', 'token_success' => 'N'],
    'verified_token' => ['message' => 'Token verificado exitosamente', 'redirect' => 'verify_token', 'show_recovery' => 'N', 'token_success' => 'Y'],
    'invalid_token' => ['message' => 'El token ha expirado', 'redirect' => 'recovery', 'show_recovery' => 'N', 'token_success' => 'N'],
    'token_error_verify' => ['message' => 'Error al verificar el token', 'redirect' => 'verify_token', 'show_recovery' => 'N', 'token_success' => 'N'],
    'password_changed' => ['message' => 'Contraseña cambiada exitosamente', 'redirect' => 'login', 'show_recovery' => 'N', 'token_success' => 'N'],
    'password_error' => ['message' => 'Error al cambiar la contraseña', 'redirect' => 'recovery', 'show_recovery' => 'N', 'token_success' => 'N'],
    'error_db' => ['message' => 'Error de base de datos', 'redirect' => 'error', 'show_recovery' => 'N', 'token_success' => 'N'],
    'error_ex' => ['message' => 'Error inesperado', 'redirect' => 'error', 'show_recovery' => 'N', 'token_success' => 'N'],
    'password_error_empty' => ['message' => 'La contraseña no puede estar vacía', 'redirect' => 'recovery', 'show_recovery' => 'N', 'token_success' => 'N']
);
?>