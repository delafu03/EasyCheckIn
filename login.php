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
    </header>

    <main class="login-container">
        <h2>Iniciar sesión</h2>
        <form action="procesarLogin.php" method="post" class="login-form">
            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" class="btn">Inciar sesión</button>

        <?php if ($_SESSION["error"]) {
         echo"<p style='color:red'>El usuario o contraseña no son válidos.";
        } 
        else{
            echo"
            <p>Bienvenido {$_SESSION['nombre']}!, usa la cabecera para navegar por nuestra web.</p>
            ";
        }
        ?>
        
    </form>
    
    </body>
    </html>
