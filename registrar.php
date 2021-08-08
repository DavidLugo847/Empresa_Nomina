<?php

require 'function/conexion.php';
require 'function/funcs.php';

$errors = array();

if (!empty($_POST)){

$nombres = $mysqli->real_escape_string($_POST['nombres']);
$apellidos = $mysqli->real_escape_string($_POST['apellidos']);
$usuario = $mysqli->real_escape_string($_POST['usuario']);
$password = $mysqli->real_escape_string($_POST['password']);
$con_password = $mysqli->real_escape_string($_POST['con_password']);
$email = $mysqli->real_escape_string($_POST['email']);
$captcha = $mysqli->real_escape_string($_POST['g-recaptcha-response']);


$activo = 0;
$tipo_usuario = 2;
$secret = '6LfmRucbAAAAAL0g1lP71UxluFtrAGD4xfHp2VeI';

if(!$captcha){

    $errors[] = "Por favor verifica el captcha";
}

if(isNull($nombres, $apellidos, $usuario, $password, $con_password, $email)){

    $errors[] = "Debe llenar todos los campos";
}

if (!isEmail($email)){

    $errors[] = "Direccion de correo invalida";
}


if (!validaPassword($password, $con_password)){

    $errors[] = "Las contraseñas no coinciden";
}


if (usuarioExiste($usuario)){

    $errors[] = "El nombre de usuario $usuario ya existe";
}


if (emailExiste($email)){

    $errors[] = "El correo electronico $email ya existe";
}
if(count($errors) == 0){

    $response = file_get_contents(
        "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");
        $arr = json_decode($response, TRUE);

        if($arr['success']){

            $pass_hash = hashPassword($password);
            $token = generateToken();

            $registro = registraUsuario($usuario, $pass_hash, $nombres, $apellidos, $email, $activo, $token, $tipo_usuario);

            if($registro > 0){

            $url = 'http://'.$_SERVER["SERVER_NAME"].'/login/activar.php?id='.$registro.'&val='.$token;

            $asunto = 'Activar Cuenta - Sistema de Usuario';
            $cuerpo = "Estimado $nombre: <br/><br/>Para continuar con el proceso de registro, es indispensable
            de click en la siguiente liga <a href='$url'>Activar Cuenta<a/>";

            if(enviarEmail($email, $nombres, $asunto, $cuerpo)){
            
            echo "Para terminar el proceso de registro siga las instrucciones que le hemos
            enviado a la direccion de correo electronico: $email";

            echo "<br><a href='index.php' >Iniciar Sesion</a>";
            exit;
            
            } else {
                $errors[]= 'Error al enviar correo';
            }

            } else {
                $errors[]= 'Error al registar';
            }
            
        } else {
            $errors[]= 'Error al comprobar Captcha';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Empresa</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous">
    </script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Crear Cuenta</h3>
                                </div>
                                <div class="card-body">
                                    <form id="signupform" role="form" action="<?php $_SERVER['PHP_SELF'] ?>"
                                        method="POST" autocomplete="off">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="input" id="inputFirstName" name="usuario"
                                                value="<?php if (isset($usuario)) echo $usuario; ?>" required
                                                type="text" placeholder="Escriba su nombre de usuario" />
                                            <label for="inputEmail">Usuario</label>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3 mb-md-0">

                                                <label for="inputFirstName">Usuario</label>
                                            </div>
                                        </div>

                                        <div class="row mb-3">

                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputFirstName" name="nombres"
                                                        value="<?php if (isset($nombres)) echo $nombres; ?>" required
                                                        type="text" placeholder="Escriba sus nombres" />
                                                    <label for="inputFirstName">Nombres</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="inputLastName" name="apellidos"
                                                        value="<?php if (isset($apellidos)) echo $apellidos; ?>"
                                                        required type="text" placeholder="Escribas sus apellidos" />
                                                    <label for="inputLastName">Apellidos</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" name="email"
                                                value="<?php if (isset($email)) echo $email; ?>" required type="email"
                                                placeholder="name@example.com" />
                                            <label for="inputEmail">Correo Electronico</label>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPassword" name="password"
                                                        value="<?php if (isset($password)) echo $password; ?>" required
                                                        type="password" placeholder="Create a password" />
                                                    <label for="inputPassword">Contraseña</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPasswordConfirm"
                                                        name="con_password"
                                                        value="<?php if (isset($con_password)) echo $con_password; ?>"
                                                        required type="password" placeholder="Confirm password" />
                                                    <label for="inputPasswordConfirm">Confirmar Contraseña</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <div class="g-recaptcha"
                                                    data-sitekey="6LfmRucbAAAAAPG-2Mi5kfItefqE8yOVoT2dBZFJ"></div>
                                            </div>
                                        </div>
                                </div>
                                <div class="mt-4 mb-0">
                                    <div class="d-grid"><button type="submit" class="btn btn-primary btn-block">Create
                                            Account</button></div>
                                </div>
                                </form>

                                <?php echo resultBlock($errors); ?>



                            </div>
                            <div class="card-footer text-center py-3">
                                <div class="small"><a href="login.html">¿Ya tienes una cuenta? Iniciar sesion</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </main>
    </div>
    <div id="layoutAuthentication_footer">
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Your Website 2021</div>
                    <div>
                        <a href="#">Privacy Policy</a> &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>
</body>

</html>