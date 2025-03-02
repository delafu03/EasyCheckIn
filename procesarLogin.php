<?php
session_start(); // Inicia la sesión

// Verifica si se han enviado los datos del formulario
if (isset($_POST["username"]) && isset($_POST["password"])) {
    // Filtra y limpia los datos
    $username = htmlspecialchars(trim(strip_tags($_POST["username"])));
    $password = htmlspecialchars(trim(strip_tags($_POST["password"])));

    if ($username == "user" && $password == "userpass") {
        $_SESSION["login"] = true;
        $_SESSION["nombre"] = "Usuario";
        unset($_SESSION["error"]); // Elimina el error si existía
        header("Location: index.php"); // Redirige al inicio
        exit();
    } 
    else if ($username == "admin" && $password == "adminpass") {
        $_SESSION["login"] = true;
        $_SESSION["nombre"] = "Administrador";
        $_SESSION["esAdmin"] = true;
        unset($_SESSION["error"]); // Elimina el error si existía
        header("Location: index.php"); // Redirige al inicio
        exit();
    } 
    else {
        $_SESSION["error"] = true; // Indica error de login
        header("Location: login.php"); // Redirige de vuelta al login
        exit();
    }
} else {
    $_SESSION["error"] = true;
    header("Location: login.php");
    exit();
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
                <?php include 'header.php'; ?>
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
                <?php include 'footer.php'; ?>
        </header>
        <?php include 'footer.php'; ?>

    </body>
</html>