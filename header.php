<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
} ?>
<head>
    <link href="./CSS/headerFooter.css" rel="stylesheet" type="text/css">
</head>
<header> 
    <nav>
        <ul class="navegacion"> 
            <a href="/EasyCheckIn/alojamientos.php">Alojamientos</a> <li></li>
            <a href="/EasyCheckIn/miembros.html">Equipo</a> <li></li>
            <a href="/EasyCheckIn/contacto.html">Contacto</a> <li></li>
            <a href="/EasyCheckIn/admin.html">Administración</a> <li></li>
            <a href="/EasyCheckIn/portal.html">Mi Portal</a> <li></li>

            
            <?php if (isset($_SESSION["email"])): ?>
                <a href="/EasyCheckIn/Login/logout.php" class="btn-logout">Cerrar sesión</a>
            <?php else: ?>
                <a href="/EasyCheckIn/Login/login.php" class="btn-login">Iniciar sesión</a>
            <?php endif; ?>

        </ul>
    </nav>    
</header>
