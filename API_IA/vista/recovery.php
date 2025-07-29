
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.login-container {
    background: #ffffff;
    padding: 20px 30px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    text-align: center;
}

h2 {
    margin-bottom: 20px;
    color: #333333;
}

.form-group {
    margin-bottom: 15px;
    text-align: left;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555555;
}

input[type="email"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #cccccc;
    border-radius: 4px;
    font-size: 14px;
    box-sizing: border-box;
}

button.btn {
    background-color: #059516;
    color: #ffffff;
    border: none;
    padding: 10px 15px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
}

.form-footer {
    margin-top: 15px;
}

.form-footer a {
    color: #007bff;
    text-decoration: none;
}

.form-footer a:hover {
    text-decoration: underline;
}
</style>
</head>
<body>
    <div class="login-container">
        <h2>Recuperar Contraseña</h2>
        <form action="./controlador/controller.php" method="POST">
            <div class="form-group">
                <input type="email" id="email" name="email" placeholder="Ingresa tu correo" required>
            </div>
            <input type="hidden" name="formid" value="g4h5i6j7k8l9">
            <button type="submit" class="btn">Enviar</button>
        </form>
        <div class="form-footer">
            <a id="returntologin" href="#">Volver al inicio de sesión</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./functions/functions.js"></script>
</body>
</html>