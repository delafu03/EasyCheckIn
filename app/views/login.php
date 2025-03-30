<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}
require_once __DIR__ . '/../../config.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="<?php echo RUTA_CSS; ?>estilo.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php include RAIZ_APP  . '/app/views/common/header.php'; ?>
    <div class="container login-container">
        <h2>Iniciar Sesión</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <p style="color: red;">Correo o contraseña incorrectos.</p>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_GET['registro_exitoso'])): ?>
            <p style="color: green;">Registro exitoso, ahora puedes iniciar sesión.</p>
        <?php endif; ?>

        <form method="POST" action="index.php?action=login">
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="correo" required>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn">Ingresar</button>
        </form>

        <p>¿No tienes cuenta? <a href="index.php?action=register">Regístrate aquí</a></p>

</body>

</html>
