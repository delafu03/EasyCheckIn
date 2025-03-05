<?php session_start(); ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/EasyCheckIn/CSS/estilo.css" rel="stylesheet" type="text/css">
    <link href="../CSS/headerFooter.css" rel="stylesheet" type="text/css">
    <title>Registro de Usuario</title>
    </head>
    <body>
    <?php include '../header.php'; ?>

    <h2 class="header">Registro de Usuario</h2>
        <form action="procesarRegistro.php" method="post" class="register-form">
            <label for="nombre">Nombre:</label>
            <input type="nombre" id="nombre" name="nombre" required>

            <label for="apellidos">Apellidos:</label>
            <input type="apellidos" id="apellidos" name="apellidos" required>
        
            <label for="correo">Correo Electrónico:</label>
            <input type="correo" id="correo" name="correo" required>
            
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            

            <button type="submit" class="btn">Registrarse</button>
        </form>


    <?php include '../footer.php'; ?>
    </body>
</html>
