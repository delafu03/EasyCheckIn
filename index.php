<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./CSS/index.css" rel="stylesheet" type="text/css">
    <title>EasyCheckIn</title>
</head>
<body>
    <header> 
        <img src="./img/LOGOTIPO.png" alt="LOGOTIPO" class="foto-index" > 
        <nav>
            <ul class="navegacion"> 
                <a href="alojamientos.html">Alojamientos</a> <li></li>
                <a href="miembros.html">Equipo</a> <li></li>
                <a href="contacto.html">Contacto</a> <li></li>
                <a href="admin.html">Administración</a> <li></li>
                <a href="portal.html">Mi Portal</a> <li></li>

            </ul>
            <?php if ($usuario): ?>
                <a href="logout.php">Cerrar Sesión</a>
            <?php endif; ?>
    </header>
    
    <div class="contenido">
        <p><strong>EasyCheckIn</strong> es una plataforma digital que agiliza el check-in y mejora la experiencia en alojamientos, 
        ofreciendo comodidad a huéspedes y eficiencia a administradores. 
        Nuestra solución integral ha sido diseñada para transformar el proceso de llegada en una experiencia rápida y sin complicaciones, 
        eliminando largas esperas y simplificando la gestión administrativa.</p>

    </div>
    <div class="contenido">
        <?php if ($usuario): ?>
            <p><strong>¡BIENVENIDO!</strong> as EasyCheckIn</p>
        <?php else: ?>
            <p>Inicia sesión para acceder a un contenido exclusivo con información sobre alojamientos, reservas y actividades o eventos.</p>
            <a href="login.php" class="btn-login">Login</a>
        <?php endif; ?>
    </div>
</body>
</html>
