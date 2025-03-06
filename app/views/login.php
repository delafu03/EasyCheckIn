<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}
?>

<h2>Iniciar Sesión</h2>
<?php if (isset($_SESSION['error'])): ?>
    <p style="color: red;">Correo o contraseña incorrectos.</p>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (isset($_GET['registro_exitoso'])): ?>
    <p style="color: green;">Registro exitoso, ahora puedes iniciar sesión.</p>
<?php endif; ?>

<form method="POST" action="index.php?action=login">
    <label>Correo:</label>
    <input type="email" name="correo" required>

    <label>Contraseña:</label>
    <input type="password" name="password" required>

    <button type="submit">Ingresar</button>
</form>

<p>¿No tienes cuenta? <a href="index.php?action=register">Regístrate aquí</a></p>
