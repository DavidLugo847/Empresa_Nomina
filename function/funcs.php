<?php

function isNull($nombres, $apellidos, $usuario, $pass, $pass_con, $email){
if(strlen(trim($nombres)) < 1 || strlen(trim($apellidos)) < 1 || 
strlen(trim($usuario)) < 1 || strlen(trim($pass)) < 1 || strlen(trim($pass_con)) < 1 || 
strlen(trim($email)) < 1){

    return true;

    } else {
    return false;
    }
}

function isEmail($email){

    if (filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    } else {
        return false;
    }
}

function validaPassword($var1, $var2){
    if(strcmp($var1, $var2) !== 0){
        return false;
    } else {
        return true;
    }
}

function minMax($min, $max, $valor){
    if(strlen(trim($valor)) < $min){
        return true;
    }
    else if(strlen(trim($valor)) < $max){
        return true;
    }
    else{
        return false;
    }
}


function usuarioExiste ($usuario){


    global $mysqli;

    $stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE usuario = ? LIMIT 1");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();
    $num = $stmt->num_rows;
    $stmt->close();

    if ($num > 0){
        return true;
    } else {
        return false;
    }
}


    function emailExiste ($email){


        global $mysqli;
    
        $stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE correo = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $num = $stmt->num_rows;
        $stmt->close();
    
        if ($num > 0){
            return true;
        } else {
            return false;
        }
    }




 function generateToken(){

     $gen = md5(uniqid(mt_rand(), false));

     return $gen;
 }
 

 function hashPassword($password){
     $hash = password_hash($password, PASSWORD_DEFAULT);
 }

 function resultBlock ($errors){
     if(count($errors) > 0){
         echo "<div id='error' class='alert alert-danger' role='alert'>
                <a href='#' onclick=\"showHide('error');\">[X]</a><ul>";
                foreach ($errors as $error){
                    echo "<li>" .$error."</li>";
                }
                echo "</ul>";
                echo "</div>";
     }
}


function registraUsuario($usuario, $pass_hash, $nombres, $email, $activo, $token, $tipo_usuario){
    global $mysqli;

    $stmt = $mysqli->prepare("INSERT INTO usuarios(usuario, password, nombre, apellido, correo, activacion, token, id_tipo)
                            VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sssssisi', $usuario, $pass_hash, $nombres, $apellidos, $email, $activo, $token, $tipo_usuario);

    if ($stmt->execute()){
        return $mysqli->insert_id;
    } else {
        return 0;
    }
}

function enviarEmail($email, $nombres, $asunto, $cuerpo){
    require_once 'PHPMailer/PHPMailerAutoload.php';

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = '587';

    $mail->Username = 'krt847@gmail.com';
    $mail->Password = 'edinson#847';

    $mail->setFrom('krt847@gmail.com', 'Empresa');
    $mail->addAddress($email, $nombres);

    $mail->Subject = $asunto;
    $mail->Body = $cuerpo;
    $mail->IsHTML(true);


    if($mail->send())
    return true;
    else
    return false;
}

function validaToken($id, $token){
    global $mysqli;

    $stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE id = ? AND token = ? LIMIT 1");

    $stmt->bind_param("is", $id, $token);
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;

    if($rows > 0){
        $stmt->bind_result($activacion);
        $stmt->fetch();



    if($activacion == 1){
            $msg = "La cuenta ya ha sido registrada";
        } else {
            if(activarUsuario($id)){
                $msg = 'Cuenta activada';
            } else {
                $msg = 'Error al activar cuenta';
            }
        }
    } else {
        $msg = 'No existe el registro para activar';
}

return $msg;
}



function activarUsuario($id){

global $mysqli;

$stmt = $mysqli->prepare("UPDATE usuarios SET activacion=1 WHERE id = ?");
$stmt->bind_param('s', $id);
$result = $stmt->execute();
$stmt->close();
return $result;
}




?>