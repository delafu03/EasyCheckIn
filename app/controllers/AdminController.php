<?php
require_once __DIR__ . '/../models/Usuarios.php';
require_once __DIR__ . '/../models/Reserva.php';

class AdminController {
    private $reservaModel, $usuariosModel;

    public function __construct() {
        $this->reservaModel = new Reserva();
        $this->usuariosModel = new Usuarios();
    }

    public function mostrarUsuarios() {
        $usuarios = $this->usuariosModel->obtenerUsuarios();

        $tituloPagina = 'Usuarios EasyCheckIn';
        $vista = __DIR__ . '/../views/mostrar_usuarios.php';
        require_once __DIR__ . '/../views/plantillas/plantilla.php';
    }

    public function mostrarReservas() {
        $reservas = $this->reservaModel->obtenerTodasLasReservas(); 
        $tituloPagina = 'Reservas EasyCheckIn';
        $vista = __DIR__ . '/../views/mostrar_reservas.php';
        require_once __DIR__ . '/../views/plantillas/plantilla.php';
    }
}