<!-- usuario iniciado -->
<?php if (isset($_SESSION["usuario_id"])): ?>
    <!-- user administrador -->
    <?php if ($_SESSION['rol'] == 'admin'): ?>
        <div class="contenido">
            <p>Bienvenido a tu portal de administrador de EasyCheckIn</p>
            <p>Accede ya a la ventana de <a href="index.php?action=admin">administrador</a>.</p>
        </div>
    <!-- user normal -->
    <?php else: ?>
        <div class="contenido">
            <p>Bienvenido a tu portal de usuario de EasyCheckIn</p>
            <p>
                Podrás encontrar toda la información sobre tus reservas y realizar cambios en ellas. 
                Además, podrás añadir actividades extras que desees realizar o valorar tu estancia en los hoteles que has visitado.
            </p>
        </div>
        <div class="contenido">
            <p>Accede a tus <a href="index.php?action=reservas">reservas</a>.</p>
        </div>
    <?php endif; ?>

<?php endif; ?>