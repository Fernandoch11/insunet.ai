<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: #fff;
            padding: 2rem 2.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            width: 320px;
        }
        .login-container h2 {
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 0.7rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding-right: 0px;
        }
        .login-container button {
            width: 104%;
            padding: 0.7rem;
            background: #059516;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
        }
        .login-container .register-link {
            display: block;
            margin-top: 1rem;
            text-align: center;
        }
        .login-container .register-link a {
            color: #007bff;
            text-decoration: none;
        }
        .login-container .register-link a:hover {
            text-decoration: underline;
        }

        .login-container .recovery {
            display: block;
            margin-top: 1rem;
            text-align: center;
        }
        .login-container .recovery a {
            color: #007bff;
            text-decoration: none;
        }
        .login-container .recovery a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form action="./controlador/controller.php" method="POST">
            <input type="text" id="username" name="username" placeholder="Usuario" required>
            <input type="password" id="password" name="password" placeholder="Contraseña" required>
            <input type="hidden" name="formid" value="b7wiCPbg3h6f">
            <button type="submit" id="login">Entrar</button>
        </form>
        <div class="register-link">
            ¿No tienes cuenta? <a id="newregister" href="#">Regístrate aquí</a>
        </div>
        <?php if($recovery == 'Y'){ ?>
        <div class="recovery">
            ¿Olvidaste tu contraseña? <a id="recovery" href="#">Recuperar</a>
        </div>
        <?php } ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./functions/functions.js"></script>
</body>
</html>