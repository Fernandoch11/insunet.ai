<?php
class templates{
    public function get_template($template){
        if($template == 'recovery_account'){
            $html = "
                        <!DOCTYPE html>
                        <html lang='es'>
                        <head>
                            <meta charset='UTF-8'>
                            <title>Recuperar Contraseña</title>
                            <style>
                                body {
                                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                                    background-color: #f4f4f7;
                                    margin: 0;
                                    padding: 0;
                                }
                                .container {
                                    max-width: 600px;
                                    margin: 40px auto;
                                    background-color: #ffffff;
                                    padding: 30px;
                                    border-radius: 10px;
                                    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                                }
                                h1 {
                                    color: #333333;
                                    text-align: center;
                                }
                                p {
                                    color: #555555;
                                    font-size: 16px;
                                    line-height: 1.6;
                                }
                                .button {
                                    display: block;
                                    width: 200px;
                                    margin: 30px auto;
                                    padding: 12px;
                                    background-color: #4CAF50;
                                    color: #ffffff !important;
                                    text-align: center;
                                    text-decoration: none;
                                    font-weight: bold;
                                    border-radius: 5px;
                                }
                                .footer {
                                    text-align: center;
                                    margin-top: 20px;
                                    font-size: 12px;
                                    color: #aaaaaa;
                                }
                            </style>
                        </head>
                        <body>
                            <div class='container'>
                                <h1> ".utf8_decode('¿Olvidaste tu contraseña?')."</h1>
                                <p>Hola,</p>
                                <p>Recibimos una solicitud para restablecer tu ".utf8_decode('contraseña').". Para continuar, haz clic en el ".utf8_decode("botón")." de abajo:</p>
                                
                                <a href='@enlace' class='button'>Recuperar ".utf8_decode('contraseña')."</a>
                                
                                <p>Este es tu token de ".utf8_decode('recuperación').": <strong>@token</strong></p>
                                <p>Si no solicitaste este cambio, puedes ignorar este correo de manera segura.</p>
                                
                                <div class='footer'>
                                    ".utf8_decode('©')." 2025 @Compy, Todos los derechos reservados.
                                </div>
                            </div>
                        </body>
                        </html>

            ";

            return $html;
        }
    }
}


?>