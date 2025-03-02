
<?php
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        // Filtra y limpia los datos del formulario
        $username = htmlspecialchars(trim(strip_tags($_POST["username"])));
        $password = htmlspecialchars(trim(strip_tags($_POST["password"])));
    
        // Comprobación de las credenciales
        if ($username === "user" && $password === "userpass") {
            unset($_SESSION["error"]);
            $_SESSION["login"] = true;
            $_SESSION["nombre"] = "Usuario";
            header("Location: login.php");
            exit();
        } elseif ($username === "admin" && $password === "adminpass") {
            unset($_SESSION["error"]);
            $_SESSION["login"] = true;
            $_SESSION["nombre"] = "Administrador";
            $_SESSION["esAdmin"] = true;
            header("Location: login.php");
            exit();
        } 
        else {
        $_SESSION["error"] = true;
        header("Location: login.php");
        exit();
     }
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
                header("Refresh: 0.2; url=login.php");  
            } 
            else{
                header("Refresh: 0.2; url=login.php");  
            }
            ?>
        </main> 

    </header>
    <?php include 'footer.php'; ?>
</body>
</html>
