<h2>Registro</h2>

<?php if (isset($_GET['error'])): ?>
    <p style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
<?php endif; ?>

<form method="POST" action="index.php?action=register">
    <label>Nombre:</label>
    <input type="text" name="nombre" required>

    <label>Correo:</label>
    <input type="email" name="correo" required>

    <label>Contraseña:</label>
    <input type="password" name="password" required>

    <button type="submit">Registrarse</button>
</form>

<p>¿Ya tienes cuenta? <a href="index.php?action=login">Inicia sesión aquí</a></p>
