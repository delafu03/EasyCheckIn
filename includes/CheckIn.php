<?php
class CheckIn {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function obtenerUsuariosPorReserva($id_reserva) {
        try {
            $sql = "SELECT REPLACE(REPLACE(JSON_UNQUOTE(JSON_EXTRACT(usuarios_ids, '$[*]')), '[', ''), ']', '') 
                    AS user_list FROM reservas WHERE id_reserva = :id_reserva";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(":id_reserva", $id_reserva, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $user_list = $result['user_list'] ?? '';

            if (empty($user_list)) {
                return [];
            }
            
            // Obtener información de los usuarios relacionados a la reserva
            $sql = "SELECT * FROM usuarios WHERE id_usuario IN ($user_list)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
    
    public function procesarCheckIn($datos) {
        try {
            // Verificar si el número de documento ya existe en otro usuario
            $sql = "SELECT id_usuario FROM usuarios WHERE numero_documento = :numero_documento AND id_usuario != :id_usuario";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(":numero_documento", $datos['numero_documento'], PDO::PARAM_STR);
            $stmt->bindValue(":id_usuario", $datos['id_usuario'], PDO::PARAM_INT);
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                return ["error" => "El número de documento ya está registrado en otro usuario."];
            }
    
            // Filtrar solo los campos enviados
            $campos_actualizar = [];
            $valores = [];
    
            foreach ($datos as $campo => $valor) {
                if ($campo !== "id_usuario" && $campo !== "id_reserva") { // No actualizar claves primarias
                    $campos_actualizar[] = "$campo = :$campo";
                    $valores[":$campo"] = ($valor === "" ? NULL : $valor);
                }
            }
    
            // Si no hay campos a actualizar, devolver un mensaje de error
            if (empty($campos_actualizar)) {
                return ["error" => "No hay datos válidos para actualizar."];
            }
    
            $valores[":id_usuario"] = $datos['id_usuario'];

            $sql = "UPDATE usuarios SET " . implode(", ", $campos_actualizar) . " WHERE id_usuario = :id_usuario";
    
            $stmt = $this->db->prepare($sql);
            $stmt->execute($valores);
    
            // Verificar si la actualización afectó alguna fila
            if ($stmt->rowCount() > 0) {
                return ["success" => "Usuario actualizado correctamente."];
            } else {
                return ["error" => "No se realizaron cambios en la base de datos. ¿Los datos son los mismos?"];
            }
    
        } catch (PDOException $e) {
            return ["error" => "Error al actualizar el usuario: " . $e->getMessage()];
        }
    }

    public function buscarUsuarioPorDNI($dni) {
        try {
            $sql = "SELECT * FROM usuarios WHERE numero_documento = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$dni]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function mostrarFormulario($id_reserva) {
        $usuarios = $this->obtenerUsuariosPorReserva($id_reserva);
        $tituloPagina = "Check-In de la Reserva $id_reserva";
        $vista = __DIR__ . '/../checkin.php';

        include __DIR__ . '/views/plantillas/plantilla.php';
    }
    
    public function procesarFormulario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado = $this->procesarCheckIn($_POST);
            
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

            $usuarioEncontrado = $this->buscarUsuarioPorDNI($dni);

            if ($usuarioEncontrado) {
                $this->procesarCheckIn([
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
                include __DIR__ . '/views/checkin.php';
            }
        }
    }
}
?>