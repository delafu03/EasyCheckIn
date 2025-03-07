<?php
require 'config/database.php';
require 'app/models/Reserva.php';
require 'app/models/CheckIn.php';
require 'app/controllers/ReservaController.php';
require 'app/controllers/CheckInController.php';
require 'app/controllers/AuthController.php';

$action = $_GET['action'] ?? 'home';
$id_reserva = $_GET['id_reserva'] ?? null;

if ($action == 'home') {
    include 'app/views/index.php';
} elseif ($action == 'contacto') {
    include 'app/views/contacto.php';
} elseif ($action == 'alojamiento') {
    include 'app/views/alojamiento.php';
} elseif ($action == 'portal') {
    include 'app/views/portal.php';
} elseif ($action == 'actividades') {
    include 'app/views/actividades.php';
} elseif ($action == 'reservas') {
    (new ReservaController())->mostrarReservas();
} elseif ($action == 'checkin' && $id_reserva) {
    (new CheckInController())->mostrarFormulario($id_reserva);
} elseif ($action == 'buscar_actualizar_usuario') {
    (new CheckInController())->buscarYActualizarUsuario();
} elseif ($action == 'procesar_checkin') {
    (new CheckInController())->procesarFormulario();
} elseif ($action === 'register') {
    (new AuthController())->register();
} elseif ($action === 'login') {
    (new AuthController())->login();
} elseif ($action === 'logout') {
    (new AuthController())->logout();
} else {
    echo "Ruta no válida.";
}
?>
