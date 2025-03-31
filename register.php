<?php
$formRegister = new FormularioRegister();
$htmlFormRegister = $formRegister->gestiona();
?>

<div class="register-container">
    <h2>Registro</h2>
    <?php echo $htmlFormRegister; ?>
    <p>¿Ya tienes cuenta? <a href="index.php?action=login">Inicia sesión aquí</a></p>
</div>
