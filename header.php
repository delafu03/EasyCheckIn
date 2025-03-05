<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
} ?>
<head>
    <link href="/EasyCheckIn/CSS/headerFooter.css" rel="stylesheet" type="text/css">
</head>
<header class="header"> 
    <img src="/EasyCheckIn/img/LOGOTIPO.png" alt="LOGOTIPO" class="foto-index" >   
    <nav>
        <ul class="navegacion"> 
            <a href="/EasyCheckIn/index.php">Inicio</a> <li></li> 
            <a href="/EasyCheckIn/alojamientos.html">Alojamientos</a> <li></li>
            <a href="/EasyCheckIn/contacto.php">Contacto</a> <li></li>
            <a href="/EasyCheckIn/portal.php">Mi Portal</a> <li></li>
            
        </ul>
        <div class="auth-buttons"> 
            <?php if (isset($_SESSION["email"])): ?>
                <a href="/EasyCheckIn/Login/logout.php" class="btn-logout">Cerrar sesión</a>
            <?php else: ?>
                <a href="/EasyCheckIn/Login/login.php" class="btn-login">Iniciar sesión</a>
            <?php endif; ?>
        </div>
    </nav>    
</header>
