<?php
class ReservaController {
    public function index() {
        $reservaModel = new Reserva();
        $reservas = $reservaModel->obtenerReservas();
        include __DIR__ . '/../views/reservas.php';
    }
}
?>