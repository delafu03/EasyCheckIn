<?php
require_once __DIR__ . '/../models/Reserva.php';

class ReservaController {
    private $reservaModel;

    public function __construct() {
        $this->reservaModel = new Reserva();
    }

    public function mostrarReservas() {
        session_start();

        if (!isset($_SESSION["login"]) || !isset($_SESSION["usuario_id"])) {
            header("Location: index.php?action=login");
            exit();
        }

        $id_usuario = $_SESSION["usuario_id"];
        echo "<script>
                console.log('Mostrando reservas del usuario con ID: $id_usuario');
              </script>";
        $reservas = $this->reservaModel->obtenerReservasPorUsuario($id_usuario);

        require_once __DIR__ . '/../views/reservas.php';
    }
}
