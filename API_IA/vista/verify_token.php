<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        if($token_success == 'N'){ 
            $title = 'Verificar Token';
        }else{
            $title = 'Actualizar Contraseña';
        } 
     ?>    
    <title><?php echo $title; ?></title>
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
        .container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        .form-group input {
            width: 94%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #059516;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .links {
            text-align: center;
            margin-top: 15px;
        }
        .links a {
            color: #007bff;
            text-decoration: none;
            margin: 0 5px;
        }
        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<script>
    function verify_credentials() {
            var new_password = document.getElementById("new_password").value;
            var confirm_password = document.getElementById("confirm_password").value;

            if (new_password !== confirm_password) {
                alert("Las contraseñas no coinciden.");
                return false;
            }

            if(new_password.length == 0 || confirm_password.length == 0){
                alert("Las contraseñas no pueden estar vacías.");{
                return false;
            }

            document.getElementById("form1").submit();
        }
    }
</script>

<body>
    <?php if($token_success == 'N'){ ?>
    <div class="container">
        <div class="form-container">
            <h2>Verificar Token</h2>
            <form action="./controlador/controller.php" method="POST">
                <div class="form-group">
                    <input type="text" id="token" name="token" placeholder="Ingresa tu token" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn">Verificar</button>
                </div>
                <input type="hidden" name="formid" value="m0n1o2p3q4r5">
            </form>
            <div class="links">
                <a id="backtorecovery" href="#">Regresar a recuperar</a>
            </div>
        </div>
    </div>
    <?php } ?>

    <?php 
    if($token_success == 'Y'){ 
    ?>
        <div class="container">
            <div class="form-container">
                <h2>Cambiar Contraseña</h2>
                <form id="form1" action="./controlador/controller.php" method="POST">
                    <div class="form-group">
                        <input type="password" id="new_password" name="new_password" placeholder="Ingresa tu nueva contraseña" required>
                    </div>
                    <div class="form-group">
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirma tu nueva contraseña" required>
                    </div>
                    <div class="form-group">
                        <button onclick="verify_credentials();" class="btn">Actualizar Contraseña</button>
                    </div>
                    <input type="hidden" name="formid" value="s6t7u8v9w0x1">
                </form>
            </div>
        </div>
    <?php } ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./functions/functions.js"></script>
</body>
</html>