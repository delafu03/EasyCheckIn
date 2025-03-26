<?php
require_once __DIR__ . '/../models/CheckIn.php';

class CheckInController {
    private $checkInModel; 

    public function __construct() {
        $this->checkInModel = new CheckIn(); 
    }

    public function mostrarFormulario($id_reserva) {
        $usuarios = $this->checkInModel->obtenerUsuariosPorReserva($id_reserva);
        $tituloPagina = "Check-In de la Reserva $id_reserva";
        $vista = __DIR__ . '/../../checkin.php';
        include __DIR__ . '/../views/plantillas/plantilla.php';
    }
    
    public function procesarFormulario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado = $this->checkInModel->procesarCheckIn($_POST);
            
            if ($resultado) {
                echo "<script>window.location.href='index.php?action=checkin&id_reserva={$_POST['id_reserva']}';</script>";
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

            $usuarioEncontrado = $this->checkInModel->buscarUsuarioPorDNI($dni);

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
                require_once __DIR__ . '/../../checkin.php';
            }
        }
    }
}
?>
