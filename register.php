<?php
if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

require_once __DIR__ . '/includes/FormularioRegister.php';

$formRegister = new FormularioRegister();
$htmlFormRegister = $formRegister->gestiona();
?>

<div class="register-container">
    <h2>Registro</h2>
    <?php echo $htmlFormRegister; ?>
    <p>¿Ya tienes cuenta? <a href="index.php?action=login">Inicia sesión aquí</a></p>
</div>
