<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = file_get_contents("php://input");
    $datos = json_decode($data);


    $data = ["vals" => [$datos->Embarazos, $datos->Glucosa, $datos->Presionsangre, 0, 0,$datos->BMI, 0, $datos->Edad]];
    $json_data = json_encode($data);


    $curl = curl_init("http://localhost:5000/predict");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);
    $response = curl_exec($curl);
    curl_close($curl);

    $response_data = json_decode($response, true);

    echo $response_data['status'];
    exit();
} else {
    echo "Error";
    exit();
}
?>