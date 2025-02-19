<?php
    session_start(); // Inicia la sesión para poder usar $_SESSION

    // Filtra y limpia los datos del formulario (username y password)
    $username = htmlspecialchars(trim(strip_tags($_REQUEST["username"])));
    $password = htmlspecialchars(trim(strip_tags($_REQUEST["password"])));

    // Comprobación de las credenciales
    if ($username == "user" && $password == "userpass") {
        // Si las credenciales son correctas, guarda en la sesión
        $_SESSION["login"] = true;
        $_SESSION["nombre"] = "Usuario";  // Guarda el nombre del usuario
        $_SESSION["error"]=false; 
    } else if ($username == "admin" && $password == "adminpass") {
        // Si es un administrador
        $_SESSION["login"] = true;
        $_SESSION["nombre"] = "Administrador";  // Guarda el nombre del admin
        $_SESSION["error"]=false; 
        $_SESSION["esAdmin"] = true;  // Añade la variable para verificar si es admin
    }
    else{
        $_SESSION["error"]=true; 
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./CSS/estilo.css" rel="stylesheet" type="text/css">
    <title>ProcesarLogin</title>
</head>
<body>

    <header> 
        <h1>EasyCheckIn</h1>
        <nav>
            <ul class="navegacion"> 
                <a href="detalles.html">Detalles</a> <li></li>
                <a href="bocetos.html">Bocetos</a> <li></li>
                <a href="miembros.html">Miembros</a> <li></li>
                <a href="planificacion.html">Planificación</a> <li></li>
                <a href="contacto.html">Contacto</a> <li></li>
            </ul>
        </nav>
        <a href="login.php" class="btn-login">Login</a>

        <main id="contenido">
            <?php
            if (isset($_SESSION["login"])){ // Si no hay sesión de login, es un usuario incorrecto
                header("Refresh: 0.2; url=index.html");  
            } 
            else{
                header("Refresh: 0.2; url=login.php");  
            }
            ?>
        </main> 

    </header>