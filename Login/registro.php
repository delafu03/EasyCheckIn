<?php session_start(); ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="\AW\EasyCheckIn\CSS\estilo.css" rel="stylesheet" type="text/css">
    <link href="../CSS/headerFooter.css" rel="stylesheet" type="text/css">
    <title>Registro de Usuario</title>
    </head>
    <body>
    <?php include '../header.php'; ?>

    <h2 class="header">Registro de Usuario</h2>
        <form action="procesarRegistro.php" method="post" class="register-form">
        
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="tipo_documento">Tipo de documento:</label>
            <input type="tipo_documento" id="tipo_documento" name="tipo_documento" required>

            <label for="numero_documento">Número de documento:</label>
            <input type="numero_documento" id="numero_documento" name="numero_documento" required>

            <button type="submit">Registrarse</button>
        </form>


    <?php include '../footer.php'; ?>
    </body>
</html>
