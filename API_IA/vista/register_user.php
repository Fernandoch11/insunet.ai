<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .register-container {
            background: #fff;
            padding: 2rem 2.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            width: 340px;
        }
        .register-container h2 {
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .register-container input[type="text"],
        .register-container input[type="password"],
        .register-container input[type="email"] {
            width: 100%;
            padding: 0.7rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding-right: 0px;
        }
        .register-container button {
            width: 104%;
            padding: 0.7rem;
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
        }
        .register-container .login-link {
            display: block;
            margin-top: 1rem;
            text-align: center;
        }
        .register-container .login-link a {
            color: #007bff;
            text-decoration: none;
        }
        .register-container .login-link a:hover {
            text-decoration: underline;
        }
				
				.custom-select-container {
					margin-bottom: 1rem;
				}
				
				.custom-select {
						width: 104%;
						padding: 0.7rem;
						border: 1px solid #007bff;
						border-radius: 4px;
						background: #f8f9fa;
						font-size: 1rem;
						color: #333;
						appearance: none;
						-webkit-appearance: none;
						-moz-appearance: none;
						background-image: url("data:image/svg+xml;charset=UTF-8,<svg width='16' height='16' fill='gray' xmlns='http://www.w3.org/2000/svg'><path d='M4 6l4 4 4-4'/></svg>");
						background-repeat: no-repeat;
						background-position: right 0.7rem center;
						background-size: 1rem;
				}
				
				.custom-select:focus {
						border-color: #0056b3;
						outline: none;
				}

    </style>
		<script>
		function validate_pass(pass_c){
			var first_pass = document.getElementById("password").value;
			
			if(first_pass != pass_c){
				alert("la contraseña no coincide");
			}
		}
		</script>
</head>
<body>
<div class="register-container">
        <h2>Registro de Usuario</h2>
        <form action="./controlador/controller.php" method="POST">
            <input type="hidden" name="formid" value="TZLGtxBfvytd">
            <input type="text" id="username" name="username" placeholder="Usuario" required>
						
						<input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
						<input type="text" id="apellido" name="apellido" placeholder="Apellido" required>
						<input type="text" id="edad" name="edad" placeholder="Edad" required>
						
						<div class="custom-select-container">
						<select id="sexo" name="sexo" class="custom-select">
							<option id="sex" value=""></option>
							<optgroup label="Sexo">
							<option value="1">Hombre</option>
							<option value="2">Mujer</option>
							</optgroup>
						</select>
						</div>
						
						<input type="text" id="pais" name="pais" placeholder="Pais" required>
						
            <input type="email" id="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" id="password" name="password" placeholder="Contraseña" required>
            <input type="password" id="confirm_password" Onchange="validate_pass(this.value);" name="confirm_password" placeholder="Confirmar contraseña" required>
            <button id="submit">Registrarse</button>
        </form>
        <div class="login-link">
            ¿Ya tienes cuenta? <a id="login" href="#">Inicia sesión aquí</a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./functions/functions.js"></script>
</body>
</html>