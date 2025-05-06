<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="header"> 
    <img src="<?php echo RUTA_IMGS; ?>/LOGOTIPO.png" alt="LOGOTIPO" class="foto-index">   
    <nav>
        <ul class="navegacion"> 
            <li><a href="<?php echo RUTA_APP; ?>/index.php">Inicio</a> </li> 
            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                <li><a href="<?php echo RUTA_APP; ?>/index.php?action=valoraciones_admin">Valoraciones</a></li>

            <?php elseif (isset($_SESSION['rol']) && $_SESSION['rol'] === 'usuario'): ?>
                <li><a href="<?php echo RUTA_APP; ?>/index.php?action=valoraciones">Valoraciones</a></li>

            <?php else: ?>
                <li><a href="<?php echo RUTA_APP; ?>/index.php?action=login">Valoraciones</a></li>
            <?php endif; ?>
            <li><a href="<?php echo RUTA_APP; ?>/index.php?action=contacto">Contacto</a></li>

            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                <li><a href="<?php echo RUTA_APP; ?>/index.php?action=admin">Admin</a></li>

            <?php elseif (isset($_SESSION['rol']) && $_SESSION['rol'] === 'usuario'): ?>
                <li><a href="<?php echo RUTA_APP; ?>/index.php?action=reservas">Reservas</a></li>
            <?php else: ?>
                <li><a href="<?php echo RUTA_APP; ?>/index.php?action=login">Portal</a></li>
            <?php endif; ?>

            <li><a href="<?php echo RUTA_APP; ?>/index.php?action=faq">FAQ</a></li>      
        </ul>
       <div class="auth-buttons">
            <?php if (isset($_SESSION["usuario_id"])): ?>
                <span class="user-email"><?php echo htmlspecialchars($_SESSION['correo']); ?></span>
                <div class="auth-buttons-container">
                    <a href="index.php?action=editarPerfil" class="btn btn-editar">Editar Perfil</a>
                    <a href="index.php?action=logout" class="btn btn-logout">Cerrar sesión</a>
                </div>
            <?php else: ?>
                <a href="index.php?action=login" class="btn btn-login">Iniciar sesión</a>
            <?php endif; ?>
        </div>
    </nav>    
</header>
