<?php
require_once __DIR__ . '/../models/CheckIn.php';

class CheckInController {
    private $checkInModel; 

    public function __construct() {
        $this->checkInModel = new CheckIn(); 
    }

    public function mostrarFormulario($id_reserva) {
        $usuarios = $this->checkInModel->obtenerUsuariosPorReserva($id_reserva);
        include __DIR__ . '/../views/checkin.php';
    }
    
    public function procesarFormulario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado = $this->checkInModel->procesarCheckIn($_POST);
            
            if ($resultado) {
                echo "<script>alert('Check-In actualizado con éxito'); window.location.href='index.php?action=checkin&id_reserva={$_POST['id_reserva']}';</script>";
            } else {
                echo "<script>alert('Error al actualizar el Check-In');</script>";
            }
        }
    }

    public function buscarYActualizarUsuario() {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["buscar_dni"])) {
            $dni = trim($_POST["numero_documento"]);
            $id_usuario = $_POST["id_usuario"];
            $id_reserva = $_POST["id_reserva"];
            $numero_documento_original = $_POST["numero_documento_original"];

            //hazme un script para ver que numero documento y id usario llegan
            echo "<script>console.log('DNI: $dni, ID Usuario: $id_usuario');</script>";
            $usuarioEncontrado = $this->checkInModel->buscarUsuarioPorDNI($dni);

            //hazme un script para ver que usuario encontrado llega
            echo "<script>console.log('Usuario encontrado: " . json_encode($usuarioEncontrado) . "');</script>";
            if ($usuarioEncontrado) {
                $this->checkInModel->procesarCheckIn([
                    "id_usuario" => $id_usuario, // Usuario a actualizar
                    "numero_documento" => $numero_documento_original,
                    "sexo" => $usuarioEncontrado["sexo"],
                    "nombre" => $usuarioEncontrado["nombre"],
                    "apellidos" => $usuarioEncontrado["apellidos"],
                    "fecha_nacimiento" => $usuarioEncontrado["fecha_nacimiento"],
                    "nacionalidad" => $usuarioEncontrado["nacionalidad"],
                    "pais" => $usuarioEncontrado["pais"],
                    "direccion" => $usuarioEncontrado["direccion"],
                ]);

                header("Location: index.php?action=checkin&id_reserva=$id_reserva");
                exit();
            } else {
                $mensaje = "No se encontró un usuario con ese número de documento.";
                require_once __DIR__ . '/../views/checkin.php';
            }
        }
    }
}
?>
