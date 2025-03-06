<?php
require_once __DIR__ . '/../models/CheckIn.php';
class CheckInController {
    public function mostrarFormulario($id_reserva) {
        $checkInModel = new CheckIn();
        $usuarios = $checkInModel->obtenerUsuariosPorReserva($id_reserva);
        include __DIR__ . '/../views/checkin.php';
    }
    
    public function procesarFormulario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $checkInModel = new CheckIn();
            $resultado = $checkInModel->procesarCheckIn($_POST);
            
            if ($resultado) {
                echo "<script>alert('Check-In actualizado con éxito'); window.location.href='index.php?action=checkin&id_reserva={$_POST['id_reserva']}';</script>";
            } else {
                echo "<script>alert('Error al actualizar el Check-In');</script>";
            }
        }
    }
}
?>