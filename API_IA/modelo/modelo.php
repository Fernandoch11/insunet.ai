<?php
session_start();
class modelo {

    public function register_user($user, $email, $password, $nombre, $apellido, $edad, $sexo, $pais, $tipo_usuario) {
        if (empty($user) || empty($email) || empty($password)) {
            return array("status" => "error", "message" => "Todos los campos son obligatorios.");
        }

        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return array("status" => "error", "message" => "El formato del correo electrónico es inválido.");
        }

        require_once "../conexion/conexion.php";
        $db = new Conexion();
        $db->connect();
        $dbl = $db->conn;
        $enc = "e2f81a3d46c94b1ab87b61ea305cedff25c6d1b7462a4e7a58d4cf81d8fbb3ad";

        if (!$dbl) {
            return array("status" => "error", "message" => "Error de conexión a la base de datos.");
        }

        if($tipo_usuario == "" || $tipo_usuario == null){
            $tipo_usuario = 'user';
        }

        $sql = "INSERT INTO users(username, email, password, nombre, apellido, edad, sexo, pais, fecha_registro, tipo_usuario) VALUES ('".$user."', '".$email."', AES_ENCRYPT('$password', UNHEX('$enc')) , '$nombre', '$apellido', '$edad', '$sexo', '$pais', NOW(), '$tipo_usuario')";
        $stmt = $dbl->prepare($sql);
        try {
            if($stmt->execute()){
                $stmt->closeCursor();
                return array("status" => "success", "message" => "Usuario registrado exitosamente.");
            }
        } catch (PDOException $e) {
            return array("status" => "error", "message" => "Error al registrar el usuario: " . $e->getMessage());
        }
        
    }

    public function login_user($user, $password) {
        if (empty($user) || empty($password)) {
            return array("status" => "error", "message" => "Todos los campos son obligatorios.");
        }

        require_once "../conexion/conexion.php";
        $db = new Conexion();
        $db->connect();
        $dbl = $db->conn;
        $enc = "e2f81a3d46c94b1ab87b61ea305cedff25c6d1b7462a4e7a58d4cf81d8fbb3ad";

        if (!$dbl) {
            return array("status" => "error", "message" => "Error de conexión a la base de datos.");
        }

        
        $sql = "SELECT * FROM users WHERE username = :user AND password = AES_ENCRYPT(:password, UNHEX(:enc))";
        $stmt = $dbl->prepare($sql);
        $stmt->bindParam(':user', $user);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':enc', $enc);
        
        try {
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $_SESSION['user'] = $user;
                return array("status" => "success", "message" => "Usuario logueado exitosamente.", "redirect" => "a8b9c0d1e2f3");
            } else {
                return array("status" => "error", "message" => "Usuario o contraseña incorrectos.");
            }
        } catch (PDOException $e) {
            return array("status" => "error", "message" => "Error al iniciar sesión: " . $e->getMessage());
        }

    }

    public function recovery_password($email) {
        if (empty($email)) {
            return array("status" => "error", "message" => "El correo electrónico es obligatorio.");
        }

        require_once "../conexion/config.php";
        require_once "../conexion/conexion.php";
        $db = new Conexion();
        $db->connect();
        $dbl = $db->conn;

        if (!$dbl) {
            return array("status" => "error", "message" => "Error de conexión a la base de datos.");
        }

        $sql = "SELECT count(*) FROM users WHERE email = :email";
        $stmt = $dbl->prepare($sql);
        $stmt->bindParam(':email', $email);
        if($stmt->execute()){
            $count = $stmt->fetchColumn();
            if($count == 0){
                return array("status" => "error", "message" => "NO_EXISTE_EMAIL");
            } 
            $stmt->closeCursor();
        }

        $token = bin2hex(random_bytes(10));

        $sql = "INSERT INTO recuperar_credenciales(email, token, date) VALUES (:email, :token, SYSDATE())";
        $stmt = $dbl->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':token', $token);

        try {
            if ($stmt->execute()) {
                $stmt->closeCursor();
                $subject = "Recuperación de contraseña";
                $message = "http://".$_ENV['SYS_HOST1']."/".$_ENV['SYS_PATH']."/verify_token";
                
                return array("status" => "success", "message" => $message, "token" => $token, "email" => $email, "subject" => $subject);
            } else {
                return array("status" => "error", "message" => "Error al enviar el correo electrónico.");
            }
        } catch (PDOException $e) {
            return array("status" => "error", "message" => "Error al registrar la solicitud de recuperación: " . $e->getMessage());
        }


    }

    public function verify_token($token){
        if (empty($token)) {
            return array("status" => "error", "message" => "El token es obligatorio.");
        }

        require_once "../conexion/conexion.php";
        $db = new Conexion();
        $db->connect();
        $dbl = $db->conn;

        if (!$dbl) {
            return array("status" => "error", "message" => "Error de conexión a la base de datos.");
        }

        $sql = "SELECT count(*) FROM recuperar_credenciales WHERE token = :token";
        $stmt = $dbl->prepare($sql);
        $stmt->bindParam(':token', $token);

        if($stmt->execute()){
            $count = $stmt->fetchColumn();
            if($count == 0){
                return array("status" => "no_existe", "message" => "NO_EXISTE_TOKEN");
            }else if($count > 0){
                $sql = "SELECT status FROM recuperar_credenciales WHERE token = :token";
                $stmt = $dbl->prepare($sql);
                $stmt->bindParam(':token', $token);
                $stmt->execute();

                $status = $stmt->fetchColumn();
                //si status es igual a EXPIRADO retorna error
                if($status == 'EXPIRADO'){
                    return array("status" => "error", "message" => "EXPIRED_TOKEN");
                }else if($status == 'ACTIVO'){
                    $sql = "UPDATE recuperar_credenciales SET status = 'USADO' WHERE token = :token";
                    $stmt = $dbl->prepare($sql);
                    $stmt->bindParam(':token', $token);
                    $stmt->execute();
                    $stmt->closeCursor();
                    $_SESSION['token'] = $token;
                    return array("status" => "success", "message" => "Token verificado exitosamente.");
                }
            } 
        }
    }

    public function change_password($password){
        if (empty($password)) {
            return array("status" => "error_empty", "message" => "La contraseña es obligatoria.");
        }

        require_once "../conexion/conexion.php";
        $db = new Conexion();
        $db->connect();
        $dbl = $db->conn;
        $enc = "e2f81a3d46c94b1ab87b61ea305cedff25c6d1b7462a4e7a58d4cf81d8fbb3ad";

        if (!$dbl) {
            return array("status" => "errordb", "message" => "Error de conexión a la base de datos.");
        }

       

        $sql ="SELECT email FROM recuperar_credenciales WHERE token = :token AND status = 'USADO'";
        $stmt = $dbl->prepare($sql);
        $stmt->bindParam(':token', $_SESSION['token']);
        $stmt->execute();
        $email = $stmt->fetchColumn();

        $sql = "UPDATE users SET password = AES_ENCRYPT(:password, UNHEX(:enc)) WHERE email = :email";
        $stmt = $dbl->prepare($sql);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':enc', $enc);
        $stmt->bindParam(':email', $email);

        try {
            if ($stmt->execute()) {
                $stmt->closeCursor();
                unset($_SESSION['token']);
                return array("status" => "success", "message" => "Contraseña cambiada exitosamente.");
            } else {
                return array("status" => "error", "message" => "Error al cambiar la contraseña.");
            }
        } catch (PDOException $e) {
            return array("status" => "errorex", "message" => "Error al cambiar la contraseña: " . $e->getMessage());
        }
    }

    public function save_stimate_data($json, $data){
        if( empty($json) || empty($data)) {
            return array("status" => "error", "message" => "Todos los campos son obligatorios0.");
        }

        require_once "contadores.php";
        $cont = new contadores();
        $estimacion_no = $cont->auto_incrementar('send_api_request');
        require_once "../conexion/conexion.php";
        $db = new Conexion();
        $db->connect();
        $dbl = $db->conn;

        if (!$dbl) {
            return array("status" => "error", "message" => "Error de conexión a la base de datos.");
        }

        $sql = "INSERT INTO data_estimada_api (usuario,edad,genero,etnia,imc,fuma,consumo_alcohol,actividad_fisica,calidad_dieta,calidad_sueno,historial_familiar,hipertension,psistolica,pdiastolica,zucar_ayuno,hba1c,colesterol_total,col_ldl,col_hdl,col_trigliseridos,orina_frecuente,nivel_fatiga,vision_borrosa,heridas_lentas,hormigueo,calidad_agua, json_send, estimacion_no) VALUES (:usuario,:edad,:genero,:etnia,:imc,:fuma,:consumo_alcohol,:actividad_fisica,:calidad_dieta,:calidad_sueno,:historial_familiar,:hipertension,:psistolica,:pdiastolica,:zucar_ayuno,:hba1c,:colesterol_total,:col_ldl,:col_hdl,:col_trigliseridos,:orina_frecuente,:nivel_fatiga,:vision_borrosa,:heridas_lentas, :hormigueo, :calidad_agua, :json_send, :estimacion_no)";
        $stmt = $dbl->prepare($sql);
        $stmt->bindParam(':usuario', $_SESSION['user']);
        $stmt->bindParam(':edad', $data['vals'][0]);
        $stmt->bindParam(':genero', $data['vals'][1]);
        $stmt->bindParam(':etnia', $data['vals'][2]);
        $stmt->bindParam(':imc', $data['vals'][3]);
        $stmt->bindParam(':fuma', $data['vals'][4]);
        $stmt->bindParam(':consumo_alcohol', $data['vals'][5]);
        $stmt->bindParam(':actividad_fisica', $data['vals'][6]);
        $stmt->bindParam(':calidad_dieta', $data['vals'][7]);
        $stmt->bindParam(':calidad_sueno', $data['vals'][8]);
        $stmt->bindParam(':historial_familiar', $data['vals'][9]);
        $stmt->bindParam(':hipertension', $data['vals'][10]);
        $stmt->bindParam(':psistolica', $data['vals'][11]);
        $stmt->bindParam(':pdiastolica', $data['vals'][12]);
        $stmt->bindParam(':zucar_ayuno', $data['vals'][13]);
        $stmt->bindParam(':hba1c', $data['vals'][14]);
        $stmt->bindParam(':colesterol_total', $data['vals'][15]);
        $stmt->bindParam(':col_ldl', $data['vals'][16]);
        $stmt->bindParam(':col_hdl', $data['vals'][17]);
        $stmt->bindParam(':col_trigliseridos', $data['vals'][18]);
        $stmt->bindParam(':orina_frecuente', $data['vals'][19]);
        $stmt->bindParam(':nivel_fatiga', $data['vals'][20]);
        $stmt->bindParam(':vision_borrosa', $data['vals'][21]);
        $stmt->bindParam(':heridas_lentas', $data['vals'][22]);
        $stmt->bindParam(':hormigueo', $data['vals'][23]);
        $stmt->bindParam(':calidad_agua', $data['vals'][24]);
        $stmt->bindParam(':json_send', $json);
        $stmt->bindParam(':json_send', $json, PDO::PARAM_STR, 0, $json);
        $stmt->bindParam(':estimacion_no', $estimacion_no); 

        try {
            if ($stmt->execute()) {
                $stmt->closeCursor();
                return array("status" => "success", "message" => "Datos guardados exitosamente.", "estimacion_no" => $estimacion_no);
            } else {
                return array("status" => "error", "message" => "Error al guardar los datos.");
            }
        } catch (PDOException $e) {
            return array("status" => "errorex", "message" => "Error al guardar los datos: " . $e->getMessage());
        }

    }

    public function update_stimate_data($status, $probabilidad, $estimacion_no){
        if (empty($status) || empty($probabilidad) || empty($estimacion_no)) {
            return array("status" => "error", "message" => "Todos los campos son obligatorios1.");
        }

        require_once "../conexion/conexion.php";
        $db = new Conexion();
        $db->connect();
        $dbl = $db->conn;

        if (!$dbl) {
            return array("status" => "error", "message" => "Error de conexión a la base de datos.");
        }

        $sql = "INSERT INTO resultado_estimacion (estimacion_no, status, probabilidad, fecha) VALUES(:estimacion_no, :status, :probabilidad, SYSDATE())";
        $stmt = $dbl->prepare($sql);
        $stmt->bindParam(':estimacion_no', $estimacion_no);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':probabilidad', $probabilidad);

        try {
            if ($stmt->execute()) {
                $stmt->closeCursor();
                return array("status" => "success", "message" => "Datos actualizados exitosamente.");
            } else {
                return array("status" => "error", "message" => "Error al actualizar los datos.");
            }
        } catch (PDOException $e) {
            return array("status" => "errorex", "message" => "Error al actualizar los datos: " . $e->getMessage());
        }

    }

    public function search_data($search, $desde, $hasta, $type){
        
        require_once "../conexion/conexion.php";
        $db = new Conexion();
        $db->connect();
        $dbl = $db->conn;

        if (!$dbl) {
            return array("status" => "error", "message" => "Error de conexión a la base de datos.");
        }

        $filtro = "";
        if($type == 'estimacion_no'){
            $filtro .= "AND t1.".$type." = '".$search."'";
        }else if($type == 'usuario'){
            $filtro .= "AND t2.".$type." = '".$search."'";
        }

        $filtro_d = "";
        if($hasta != '' && $desde != ''){
            $filtro_d = " AND DATE(t1.fecha) BETWEEN '".$desde."' AND '".$hasta."'";
        }

        try{
        $sql = "SELECT t1.estimacion_no, t2.usuario, t1.status, t1.probabilidad, t1.fecha FROM resultado_estimacion t1 join data_estimada_api t2 on t1.estimacion_no = t2.estimacion_no WHERE 1=1 $filtro $filtro_d";
        $stmt = $dbl->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_NUM);
        return $result;
        
        }catch(PDOException $e){
            return array("status" => "errorex", "message" => "Error al ejecutar la consulta");
        }
    }

    public function expireToken(){
        require_once '../conexion/conexion.php';
        $db = new Conexion();
        $db->connect();
        $dbl = $db->conn;

        if (!$dbl) {
            return array("status" => "error", "message" => "Error de conexión a la base de datos.");
        }

        try{
            $sql = "call expire_tokens()";
            $stmt = $dbl->prepare($sql);
            if($stmt->execute()){
                return array("status" => "success", "message" => "OK");
            }

        }catch(PDOException $e){
            return array("status" => "errorex", "message" => "error en ejecucon de consulta");
        }

    }

    public function get_stimated_data(){
        require_once '../conexion/conexion.php';
        $db = new Conexion();
        $db->connect();
        $dbl = $db->conn;

        if(!$dbl){
            return array("status" => "error", "message" => "Error de conexión a la base de datos.");
        }

        try{
            $sql = "SELECT 
                    (SELECT count(*) FROM resultado_estimacion WHERE probabilidad < 0.50) AS falsediabetes, 
                    (SELECT count(*) FROM resultado_estimacion WHERE probabilidad > 0.50) AS truediabetes";

            $stmt = $dbl->prepare($sql);
            if($stmt->execute()){
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($resultado) {
                    return array("status" => "success", "truediabetes" => $resultado['truediabetes'], "falsediabetes" => $resultado['falsediabetes']);
                }else{
                    return array("status" => "error", "message" => "No se encontraron resultados.");
                }
            } else {
                return array("status" => "error", "message" => "Error al ejecutar la consulta.");
            }    
        }catch(PDOException $e){
            return array("status" => "errorex", "message" => "error en ejecucon de consulta");
        }
    }

    public function masive_import($rows){
/*
        require_once "contadores.php";
        $cont = new contadores();
        $estimacion_no = $cont->auto_incrementar('send_api_request');

        require_once '../conexion/conexion.php';
        $db = new Conexion();
        $db->connect();
        $dbl = $db->conn;

        if(!$dbl){
            return array("status" => "error", "message" => "Error de conexión a la base de datos.");
        }

        $sql = "INSERT INTO data_estimada_api (usuario,edad,genero,etnia,imc,fuma,consumo_alcohol,actividad_fisica,calidad_dieta,calidad_sueno,historial_familiar,hipertension,psistolica,pdiastolica,zucar_ayuno,hba1c,colesterol_total,col_ldl,col_hdl,col_trigliseridos,orina_frecuente,nivel_fatiga,vision_borrosa,heridas_lentas,hormigueo,calidad_agua, json_send, estimacion_no) VALUES (:usuario,:edad,:genero,:etnia,:imc,:fuma,:consumo_alcohol,:actividad_fisica,:calidad_dieta,:calidad_sueno,:historial_familiar,:hipertension,:psistolica,:pdiastolica,:zucar_ayuno,:hba1c,:colesterol_total,:col_ldl,:col_hdl,:col_trigliseridos,:orina_frecuente,:nivel_fatiga,:vision_borrosa,:heridas_lentas, :hormigueo, :calidad_agua, :json_send, :estimacion_no)";

        $stmt = $dbl->prepare($sql);

        foreach($rows as $row){
            $stmt->execute([
                ':usuario' => $row[0],
                ''
            ]);
        }
            */
    }

}

?>