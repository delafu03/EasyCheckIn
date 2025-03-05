<?php
require 'config/database.php';
require 'app/models/Reserva.php';
require 'app/models/CheckIn.php';
require 'app/controllers/ReservaController.php';
require 'app/controllers/CheckInController.php';

$action = $_GET['action'] ?? 'reservas';
$id_reserva = $_GET['id_reserva'] ?? null;

    if ($action == 'reservas') {
        (new ReservaController())->index();
    } elseif ($action == 'checkin' && $id_reserva) {
        (new CheckInController())->mostrarFormulario($id_reserva);
    } elseif ($action == 'procesar_checkin') {
        (new CheckInController())->procesarFormulario();
    } else {
        echo "Ruta no válida.";
}
?>