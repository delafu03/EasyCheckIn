<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../../config.php';
?>
<head>
    <link href="<?php echo RUTA_CSS; ?>headerFooter.css" rel="stylesheet" type="text/css">
</head>
<header class="header"> 
    <img src="<?php echo RUTA_IMGS; ?>LOGOTIPO.png" alt="LOGOTIPO" class="foto-index">   
    <nav>
        <ul class="navegacion"> 
            <a href="<?php echo RUTA_APP; ?>/index.php">Inicio</a> <li></li> 
            <a href="<?php echo RUTA_APP; ?>/index.php?action=alojamiento">Alojamientos</a> <li></li>
            <a href="<?php echo RUTA_APP; ?>/index.php?action=contacto">Contacto</a> <li></li>
            <a href="<?php echo RUTA_APP; ?>/index.php?action=portal">Mi Portal</a> <li></li>
            <a href="<?php echo RUTA_APP; ?>/index.php?action=faq">FAQ</a> <li></li>      
        </ul>
        <div class="auth-buttons"> 
            <?php if (isset($_SESSION["usuario_id"])): ?>
                <span><?php echo htmlspecialchars($_SESSION['correo']); ?></span>
                <!-- <?php if ($_SESSION['rol'] === 'admin'): ?>
                    <a href="index.php?action=admin" class="btn-admin">Panel Admin</a>
                <?php endif; ?> -->
                <a href="index.php?action=logout" class="btn-logout">Cerrar sesión</a>
            <?php else: ?>
                <a href="index.php?action=login" class="btn-login">Iniciar sesión</a>
            <?php endif; ?>
        </div>
    </nav>    
</header>
