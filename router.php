<?php
require 'config/database.php';
require 'app/models/Reserva.php';
require 'app/models/CheckIn.php';
require 'app/controllers/ReservaController.php';
require 'app/controllers/CheckInController.php';
require 'app/controllers/AuthController.php';

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
} 
} elseif ($action == 'mostrar_usuarios') {
    require 'app/controllers/AdminController.php';
    (new AdminController())->mostrarUsuarios();
    exit;
} elseif ($action == 'mostrar_reservas') {
    require 'app/controllers/AdminController.php';
    (new AdminController())->mostrarReservas();
    exit;
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
    (new AuthController())->register();
    exit;
} elseif ($action === 'login') {
    (new AuthController())->login();
    exit;
} elseif ($action === 'logout') {
    (new AuthController())->logout();
    exit;
} else {
    $tituloPagina = 'Error';
    $vista = 'app/views/error404.php';
}

if ($vista !== null) {
    include 'app/views/plantillas/plantilla.php';
}
?>
