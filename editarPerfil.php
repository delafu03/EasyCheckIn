<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$formulario = new FormularioEditarPerfil($usuario);
$htmlFormulario = $formulario->gestiona();
echo $htmlFormulario;
?>

<script src="<?php echo RUTA_JS; ?>/validaciones.js"></script>