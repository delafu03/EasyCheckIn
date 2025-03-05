<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
} ?>
<head>
    <link href="./CSS/headerFooter.css" rel="stylesheet" type="text/css">
</head>
<header> 
    <nav>
        <ul class="navegacion"> 
            <a href="alojamientos.html">Alojamientos</a> <li></li>
            <a href="miembros.html">Equipo</a> <li></li>
            <a href="contacto.html">Contacto</a> <li></li>
            <a href="admin.html">Administración</a> <li></li>
            <a href="portal.html">Mi Portal</a> <li></li>

            
            <?php if (isset($_SESSION["correo"])): ?>
                <a href="/AW/EasyCheckIn/Login/logout.php" class="btn-logout">Cerrar sesión</a>
            <?php else: ?>
                <a href="/AW/EasyCheckIn/Login/login.php" class="btn-login">Iniciar sesión</a>
            <?php endif; ?>

        </ul>
    </nav>    
</header>
