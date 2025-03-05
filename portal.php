<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="./CSS/estilo.css" rel="stylesheet" type="text/css">
        <title>EasyCheckIn</title>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="contenido">
            <?php if ($usuario): ?>
                <p>Bienvenido a tu portal de usuario de EasyCheckIn</p>
            <?php else: ?>
                <img src="./img/usuario.png" alt="usuario" class="imagen-usuario">   
                <p>Inicia sesión para acceder a tu portal de usuario</p>
            <?php endif; ?>
        </div>
    </body>

    <?php include 'footer.php'; ?>

</html>
