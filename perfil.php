<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'includes\config.php'; 

$tituloPagina = 'Perfil - EasyCheckIn';
$vista = __DIR__ . '/includes/clases/checkin/perfilContenido.php'; 
include __DIR__ . '/includes/views/plantillas/plantilla.php';

?>
