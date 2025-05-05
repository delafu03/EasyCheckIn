<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
} 
?>
<!-- usuario iniciado -->
<?php if (isset($_SESSION["usuario_id"])): ?>
    <!-- user administrador     -->
    <?php if ($_SESSION['rol'] == 'admin'): ?>
        <div class="contenido">
            <p>Bienvenido a tu portal de administrador de EasyCheckIn</p>
            <p> Accede ya a la ventana de <a href="index.php?action=admin"> administrador</a> </p>
            <img src="<?php echo RUTA_IMGS; ?>/portal-admin.png" alt="usuario" class="imagen-usuario">
        </div>

    <!-- user normal -->
    <?php else: ?>
        <div class="contenido">
            <p>Bienvenido a tu portal de usuario de EasyCheckIn</p>
            <p> Podrás encontrar toda la información sobre tus reservas y realizar cambios en ellas. Además de añadir actividades
                extras que desees realizar o valorar tu estancia en los hoteles que has visitado </p>
            <img src="<?php echo RUTA_IMGS; ?>/portal-user.png" alt="usuario" class="imagen-usuario">   
        </div>
        <div class="contenido">
            <p>Accede a tus <a href="index.php?action=reservas"> reservas</a> </p>
            <!-- <p>O añade ya una <a href="index.php?action=actividades"> actividad</a> para realizar en tu viaje</p> -->
        </div>
    <?php endif; ?>

<!-- no hay ususario iniciado -->
<?php else: ?>
    <div class="contenido">
        <img src="<?php echo RUTA_IMGS; ?>/usuario.png" alt="usuario" class="imagen-usuario">   
        <p>Inicia sesión para acceder a tu portal de usuario</p>
    </div>
<?php endif; ?>