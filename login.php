<?php
    session_start();
    ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="./CSS/estilo.css" rel="stylesheet" type="text/css">
        <title>Login</title>
    </head>
    <body>
        <?php include 'header.php'; ?>

        <main class="login-container">
            <h2>Iniciar sesión</h2>
            <form action="procesarLogin.php" method="post" class="login-form">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit" class="btn">Inciar sesión</button>

            <?php if (isset($_SESSION["error"]) && $_SESSION["error"] === true) {
                echo "<p style='color:red;'>El usuario o contraseña no son válidos.</p>";
                unset($_SESSION["error"]); // Elimina el error después de mostrarlo
            } 
            else if (isset($_SESSION["nombre"])) {
                echo "<p>Bienvenido {$_SESSION['nombre']}! Usa la cabecera para navegar por nuestra web.</p>";
            }
            ?>
            
        </form>
        <?php include 'footer.php'; ?>
    </body>
</html>