<?php
require_once "../modelo/modelo.php";
$mdl = new modelo();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = file_get_contents("php://input");
    $datos = json_decode($data);


    if ($datos !== null) {
        require("./tanslator.php");
        $OP = $roter[$datos->formid];

        switch($OP){
            case 'register_user':
                $response = $mdl->register_user($datos->user, $datos->email, $datos->password, $datos->nombre, $datos->apellido, $datos->edad, $datos->sexo, $datos->pais,'');
                
                header('Content-Type: application/json');
                if($response['status'] == 'success'){
                    echo json_encode(array("status" => "success", "message" => "Usuario registrado exitosamente."));
                } else {
                    echo json_encode(array("status" => "error", "message" => $response['message'], "redirect" => "v2g3x4h5j6k7"));
                }
            break;

            case 'login_user':
                $response = $mdl->login_user($datos->username, $datos->password);

                header('Content-Type: application/json');
                echo json_encode($response);

            break;
        }    
    }
}
else {
    header('Content-Type: application/json');
 echo json_encode(array("status" => "error", "message" => 'Metodo invalido', "redirect" => "v2g3x4h5j6k7"));
 exit();
}

?>