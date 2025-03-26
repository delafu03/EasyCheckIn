<?php
require 'includes/Database.php';
// require 'includes/Usuario.php';
// require 'includes/Reserva.php';
// require 'includes/CheckIn.php';
require 'includes/models/Reserva.php';
require 'includes/models/CheckIn.php';
require 'includes/models/Registro.php';
require 'includes/models/Login.php';

require 'includes/controllers/ReservaController.php';
require 'includes/controllers/CheckInController.php';
require 'includes/controllers/LoginController.php';
require 'includes/controllers/RegistroController.php';

$action = $_GET['action'] ?? 'home';
$id_reserva = $_GET['id_reserva'] ?? null;

// Variables compartidas por la plantilla
$tituloPagina = 'EasyCheckIn';
$vista = null;

if ($action == 'home') {
    $tituloPagina = 'Inicio';
    $vista = 'home.php';
} elseif ($action == 'contacto') {
    $tituloPagina = 'Contacto';
    $vista = 'contacto.php';
} elseif ($action == 'alojamiento') {
    $tituloPagina = 'Alojamientos';
    $vista = 'alojamiento.php';
} elseif ($action == 'portal') {
    $tituloPagina = 'Portal';
    $vista = 'portal.php';
} elseif ($action == 'actividades') {
    $tituloPagina = 'Actividades';
    $vista = 'actividades.php';
} elseif ($action == 'admin') {
    $tituloPagina = 'Administración';
    $vista = 'admin.php';
} elseif ($action == 'reservas') {
    (new ReservaController())->mostrarReservas();
    exit;
} elseif ($action == 'checkin' && $id_reserva) {
    (new CheckInController())->mostrarFormulario($id_reserva);
    exit;
} elseif ($action == 'buscar_actualizar_usuario') {
    (new CheckInController())->buscarYActualizarUsuario();
    exit;
} elseif ($action == 'procesar_checkin') {
    (new CheckInController())->procesarFormulario();
    exit;
} elseif ($action === 'register') {
    (new RegistroController())->register();
    exit;
} elseif ($action === 'login') {
    (new LoginController())->login();
    exit;
} elseif ($action === 'logout') {
    (new LoginController())->logout();
    exit;
} else {
    $tituloPagina = 'Error';
    $vista = 'error404.php';
}

if ($vista !== null) {
    include 'includes/views/plantillas/plantilla.php';
}
?>