<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'includes/config.php';
require_once 'includes/clases/usuarios/formularioEditar.php';

if (!isset($_SESSION['correo'])) {
    die("Error: No se ha iniciado sesión o no se ha configurado el correo.");
}
$formulario = new FormularioEditarPerfil($_SESSION['correo']);
$htmlFormulario = $formulario->gestiona();
echo $htmlFormulario;
