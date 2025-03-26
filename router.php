<?php
require 'config/database.php';
require 'app/models/Reserva.php';
require 'app/models/CheckIn.php';
require 'app/models/Registro.php';
require 'app/models/Login.php';

require 'app/controllers/ReservaController.php';
require 'app/controllers/CheckInController.php';
require 'app/controllers/LoginController.php';
require 'app/controllers/RegistroController.php';

$action = $_GET['action'] ?? 'home';
$id_reserva = $_GET['id_reserva'] ?? null;

// Variables compartidas por la plantilla
$tituloPagina = 'EasyCheckIn';
$vista = null;

if ($action == 'home') {
    $tituloPagina = 'Inicio';
    $vista = 'app/views/index.php';
} elseif ($action == 'contacto') {
    $tituloPagina = 'Contacto';
    $vista = 'app/views/contacto.php';
} elseif ($action == 'alojamiento') {
    $tituloPagina = 'Alojamientos';
    $vista = 'app/views/alojamiento.php';
} elseif ($action == 'portal') {
    $tituloPagina = 'Portal';
    $vista = 'app/views/portal.php';
} elseif ($action == 'actividades') {
    $tituloPagina = 'Actividades';
    $vista = 'app/views/actividades.php';
} elseif ($action == 'admin') {
    $tituloPagina = 'Administración';
    $vista = 'app/views/admin.php';
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
    $vista = 'app/views/error404.php';
}

if ($vista !== null) {
    include 'app/views/plantillas/plantilla.php';
}
?>
