<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
    require_once __DIR__ . '/../../config.php';
} ?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo RUTA_CSS; ?>estilo.css" rel="stylesheet" type="text/css">
        <title>EasyCheckIn</title>
    </head>
    <body>
        <?php include RAIZ_APP  . '/app/views/common/header.php'; ?>
            <!-- usuario iniciado -->
            <?php if (isset($_SESSION["usuario_id"])): ?>
                <!-- user administrador     -->
                <?php if ($_SESSION['rol'] == 'admin'): ?>
                    <div class="contenido">
                        <p>Bienvenido a tu portal de administrador de EasyCheckIn</p>
                        <p> Accede ya a la ventana de <a href="admin.php"> administrador</a> </p>
                        <img src="<?php echo RUTA_IMGS; ?>portal-admin.png" alt="usuario" class="imagen-usuario">
                    </div>

                <!-- user normal -->
                <?php else: ?>
                    <div class="contenido">
                        <p>Bienvenido a tu portal de usuario de EasyCheckIn</p>
                        <p> Podrás encontrar toda la información sobre tus reservas y realizar cambios en ellas. Además de añadir actividades
                            extras que desees realizar o valorar tu estancia en los hoteles que has visitado </p>
                        <img src="<?php echo RUTA_IMGS; ?>portal-user.png" alt="usuario" class="imagen-usuario">   
                    </div>
                    <div class="contenido">
                        <p>Accede a tus <a href="index.php?action=reservas"> reservas</a> </p>
                        <p>O añade ya una <a href="index.php?action=actividades"> actividad</a> para realizar en tu viaje</p>
                    </div>
                <?php endif; ?>

            <!-- no hay ususario iniciado -->
            <?php else: ?>
                <div class="contenido">
                    <img src="<?php echo RUTA_IMGS; ?>usuario.png" alt="usuario" class="imagen-usuario">   
                    <p>Inicia sesión para acceder a tu portal de usuario</p>
                </div>
            <?php endif; ?>
    </body>
    <?php include RAIZ_APP . '/app/views/common/footer.php'; ?> 

</html>