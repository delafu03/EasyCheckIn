<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
} ?>

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
            <p><strong>EasyCheckIn</strong> es una plataforma digital que agiliza el check-in y mejora la experiencia en alojamientos, 
            ofreciendo comodidad a huéspedes y eficiencia a administradores. 
            Nuestra solución integral ha sido diseñada para transformar el proceso de llegada en una experiencia rápida y sin complicaciones, 
            eliminando largas esperas y simplificando la gestión administrativa.</p>
        </div>
        <img src="./img/hotel.png" alt="HOTEL" class="foto-index">
            <!-- usuario iniciado -->
            <?php if (isset($_SESSION["email"])): ?>
                <div class="contenido">
                    <p><strong>¡BIENVENIDO!</strong> a EasyCheckIn</p>
                </div>
            <!-- no hay usuario iniciado -->
            <?php else: ?>
                <div class="contenido">
                    <p>Inicia sesión para acceder a un contenido exclusivo con información sobre alojamientos, reservas y actividades o eventos.</p>
                </div>
                <?php endif; ?>
        
    </body>

    <?php include 'footer.php'; ?>

</html>
