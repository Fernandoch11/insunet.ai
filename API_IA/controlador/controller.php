<?php

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['formid']) && $_POST['formid'] != ''){

        require_once("./tanslator.php");
        require_once '../modelo/modelo.php';
        require_once "../conexion/config.php";
        $mdl = new modelo();

        $OP = $roter[$_POST['formid']];
        switch ($OP) {
            case 'register_user':
                $response = $mdl->register_user($_POST['username'], $_POST['email'], $_POST['password'], $_POST['nombre'], $_POST['apellido'], $_POST['edad'], $_POST['sexo'], $_POST['pais'],'');
                
                header('Content-Type: application/json');
                if($response['status'] == 'success'){
                    echo 'script>alert("'.$response['message'].'");</script>';
                    header('Location: ../login');
                } else {
                    echo '<script>alert("'.$response['message'].'");history.back();</script>';
                }
            break;

            case 'login_user':
                $response = $mdl->login_user($_POST['username'], $_POST['password']);

                if($response['status'] == 'success'){
                    header('Location: ../inicio');
                }else{
                    if($response['message'] == 'Usuario o contraseña incorrectos.'){
                        header('Location: ../login_error');
                    }
                }
            break;

            case 'send_api_request':
                $data = ["vals" => [$_POST['edad'], $_POST['genero'], $_POST['etnia'], $_POST['imc'], $_POST['fumar'], $_POST['consumo_alcohol'], $_POST['actividad_fisica'], $_POST['calidad_dieta'], $_POST['calidad_sueno'], $_POST['historial_familiar_diabetes'], $_POST['hipertension'], $_POST['presion_sistolica'], $_POST['presion_diastolica'], $_POST['azucar_ayuno'], $_POST['hba1c'], $_POST['colesterol_total'], $_POST['colesterol_ldl'], $_POST['colesterol_hdl'], $_POST['colesterol_trigliceridos'], $_POST['orina_frecuente'], $_POST['niveles_fatiga'], $_POST['vision_borrosa'], $_POST['heridas_lentas'], $_POST['hormigueo_manos_pies'], $_POST['calidad_agua']]];

                $json_data = json_encode($data);

                $response = $mdl->save_stimate_data($json_data, $data);

                switch ($_POST['tipomodelo']) {
                    case 'rf':
                        $param = 'stimate';
                    break;
                    
                    case 'svm':
                        $param = 'stimateSVM';
                    break;

                    case 'rl':
                        $param = 'stimateRL';
                    break;
                }

                if($response['status'] == 'success'){
                    $id = $response['estimacion_no'];
                    $curl = curl_init($_ENV['VPS_HOST'].$param);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);
                    $response = curl_exec($curl);
                    curl_close($curl);
                
                    $response_data = json_decode($response, true);

                    try {
                        $respuesta = $mdl->update_stimate_data($response_data['status'], $response_data['probabilities']['Con_Diabetes'], $id);
                        if($respuesta['status'] == 'success'){
                            echo $response_data['status']."||".$response_data['probabilities']['Con_Diabetes'];
                            exit();
                        }else{
                            echo $respuesta['message'];
                            exit();
                        }
                }catch(Exception $e){
                    echo "Except error";
                    exit();
                }
                }else{
                    echo $response['message'];
                    exit();
                }
            break;

            case 'recovery':
                $response = $mdl->recovery_password($_POST['email']);
                if($response['status'] == 'success'){

                    require_once './sys_mailer.php';
                    $mailer = new sysmailer();

                    if($mailer->send_mail($response['email'], $response['subject'], $response['message'], "<br>Token: ".$response['token'])){
                        header('Location: ../token_sent');
                        exit();
                    }else{
                        header('Location: ../token_error');
                        exit();
                    }
                }

                if($response['status'] == 'error'){
                    if($response['message'] == 'NO_EXISTE_EMAIL'){
                        header('Location: ../check_email');
                        exit();
                    }
                }
            break;

            case 'verify_token':
                $response = $mdl->verify_token($_POST['token']);
                if($response['status'] == 'success'){
                    header('Location: ../verified_token');
                    exit();
                }

                if($response['status'] == 'error'){
                    if($response['message'] == 'EXPIRED_TOKEN'){
                        header('Location: ../invalid_token');
                        exit();
                    }else if($response['message'] == 'NO_EXISTE_TOKEN'){
                        header('Location: ../token_error_verify');
                        exit();
                    }
                }
            break;

            case 'change_password':
                $response = $mdl->change_password($_POST['new_password']);
                if($response['status'] == 'success'){
                    header('Location: ../password_changed');
                    exit();
                }

                if($response['status'] == 'errordb'){
                    header('Location: ../error_db');
                    exit();
                }

                if($response['status'] == 'errorex'){
                    header('Location: ../error_ex');
                    exit();
                }

                if($response['status'] == 'error_empty'){
                    header('Location: ../password_error_empty');
                    exit();
                }
                
                if($response['status'] == 'error'){
                    header('Location: ../password_error');
                    exit();
                }
            break;

            case 'stimate_diabetes':
                echo 'registrar';
            break;

            case 'go_home':
                echo 'inicio';
            break;
            
            case 'search_data':
                $response = $mdl->search_data($_POST['search'], $_POST['desde'], $_POST['hasta'], $_POST['tipo']);
             
                header('Content-Type: application/json');
                echo json_encode($response);
                exit();
                
            break;

            case 'expireToken':
                $response = $mdl->expireToken();
                if($response['status'] == 'success'){
                    echo "Ok";
                }else{
                    echo "error";
                }

            break;

            case 'get_stimated_data':
                $response = $mdl->get_stimated_data();
                if($response['status'] == 'success'){
                    echo $response['truediabetes'].'||'.$response['falsediabetes'];
                }else{
                    echo 'error';
                }
            break;

            case 'masive_import':
                require '../phpspreadsheet/vendor/autoload.php';
                
                if(isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] == 0){
                    $file = $_FILES['excelFile']['tmp_name'];

                    $spread = IOFactory::load($file);
                    $sheet = $spread->getActiveSheet();
                    $rows = $sheet->toArray();

                    $headers = array_shift($rows);

                    $response = $mdl->masive_import($rows);

                    if($response['status'] == 'success'){
                        echo 'OK';
                    }else{
                        echo 'error';
                    }
                }

                $response = $mdl->masive_import();
        }
    }else{
        echo '<script>alert("Request error");history.back();</script>';
    }
}else{
    echo '<script>alert("Request Method error");history.back();</script>';
}


?>