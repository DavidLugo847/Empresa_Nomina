<!DOCTYPE html>

<html lang="es">
<div class="topbar"></div>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="author" content="DavidLugo">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ejemplo de HTML5">
    <meta name="keywords" content="HTML,CSS3,JavaScript">
    <title><?php $data['page_tag'] = "Login - Proyecto"; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<body>

    <section class="form-login">
        <h1> Inicio de Sesion </h1>
        <input class="controls" type="text" name="usuario" value="" placeholder="Usuario">
        <input class="controls" type="password" name="contrasena" value="" placeholder="Contraseña">
        <input class="btn-ingresar" type="submit" name="" value="Ingresar">
        <p><a href="#">¿Olvidaste tu contraseña?</a></p>


    </section>

</body>

</html>