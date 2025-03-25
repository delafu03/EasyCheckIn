<?php
require_once __DIR__ . '/../models/Admin.php';

class AdminController {
    public function mostrarUsuarios() {
        $db = Database::getConnection();
        $query = "SELECT id, nombre, email FROM usuarios WHERE rol != 'admin'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once '../views/usuarios.php';
    }

    public function mostrarReservas() {
        $db = Database::getConnection();
        $query = "SELECT r.id, u.nombre AS usuario, r.fecha, r.estado 
                  FROM reservas r 
                  JOIN usuarios u ON r.usuario_id = u.id";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once '../views/reservas.php';
    }
}