<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}
?>

<div class="container login-container">
    <h2>Registro</h2>

    <?php if (isset($_GET['error'])): ?>
        <p style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?action=register">

        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>

        <div class="form-group">
            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" required>
        </div>

        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit" class="btn">Registrarse</button>
    </form>

    <p>¿Ya tienes cuenta? <a href="index.php?action=login">Inicia sesión aquí</a></p>
</div>
