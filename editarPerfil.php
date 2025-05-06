<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'includes/config.php';
require_once 'includes/clases/usuarios/UsuarioModelo.php';
require_once 'includes/clases/formularios/FormularioEditarPerfil.php';

$tituloPagina = 'Editar Perfil - EasyCheckIn';

// Crear una instancia del formulario
$formulario = new FormularioEditarPerfil($_SESSION['correo']);
$htmlFormulario = $formulario->gestiona();

$vista = __DIR__ . '/includes/views/formulario.php';
include __DIR__ . '/includes/views/plantillas/plantilla.php';