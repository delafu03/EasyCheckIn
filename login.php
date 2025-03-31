<?php
if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}
require_once __DIR__ . '/includes/FormularioLogin.php';

$formLogin = new FormularioLogin();
$htmlFormLogin = $formLogin->gestiona();
?>

<div class="login-container">
    <h2>Iniciar Sesión</h2>
    <?php echo $htmlFormLogin; ?>
    <p>¿No tienes cuenta? <a href="index.php?action=register">Regístrate aquí</a></p>
</div>

