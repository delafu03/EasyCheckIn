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
            $stmt->closeCursor();
            
            $user_list = $result['user_list'] ?? '';

            if (empty($user_list)) {
                return [];
            }
    
            $userIds = array_map('trim', explode(',', $user_list));
            $userIds = array_filter($userIds, 'is_numeric');
            $userIds = array_map('intval', $userIds);
            if (empty($userIds)) return [];
    
            // Generar nombres de parámetros individuales
            $placeholders = [];
            $params = [];
            foreach ($userIds as $index => $userId) {
                $paramName = ":id_" . $index;
                $placeholders[] = $paramName;
                $params[$paramName] = $userId;
            }

            /*
            userIds = [3, 7, 9]
            $placeholders = [':id_0', ':id_1', ':id_2'];
            $params = [
                ':id_0' => 3,
                ':id_1' => 7,
                ':id_2' => 9
            ];
            */
    
            $sql = "SELECT * FROM usuarios WHERE id_usuario IN (" . implode(',', $placeholders) . ")";
            $stmt = $this->db->prepare($sql);
    
            foreach ($params as $param => $value) {
                $stmt->bindValue($param, $value, PDO::PARAM_INT);
            }
    
            $stmt->execute();
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $usuarios;
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
            $stmt->closeCursor();
    
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

            foreach ($valores as $campo => $valor) {
                $tipo = is_int($valor) ? PDO::PARAM_INT : ($valor === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
                $stmt->bindValue(":$campo", $valor, $tipo);
            }

            // También bind para id_usuario en WHERE
            $stmt->bindValue(":id_usuario", $datos['id_usuario'], PDO::PARAM_INT);
            $stmt->execute($valores);
            $stmt->closeCursor();
    
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
            $sql = "SELECT * FROM usuarios WHERE numero_documento = :dni";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(":dni", $dni, PDO::PARAM_STR);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $usuario;
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
            $id_usuario_actual = (int)$_POST["id_usuario"];
            $id_reserva = (int)$_POST["id_reserva"];
    
            $usuarioEncontrado = $this->buscarUsuarioPorDNI($dni);
    
            if ($usuarioEncontrado) {
                $id_usuario_encontrado = (int)$usuarioEncontrado["id_usuario"];
                
                if ($id_usuario_encontrado === $id_usuario_actual) {
                    $this->procesarCheckIn([
                        "id_usuario" => $id_usuario_actual,
                        "numero_documento" => $usuarioEncontrado["numero_documento"],
                        "sexo" => $usuarioEncontrado["sexo"],
                        "nombre" => $usuarioEncontrado["nombre"],
                        "apellidos" => $usuarioEncontrado["apellidos"],
                        "fecha_nacimiento" => $usuarioEncontrado["fecha_nacimiento"],
                        "nacionalidad" => $usuarioEncontrado["nacionalidad"],
                        "pais" => $usuarioEncontrado["pais"],
                        "direccion" => $usuarioEncontrado["direccion"],
                    ]);
                } else {
                    $this->actualizarUsuarioEnReserva($id_reserva, $id_usuario_actual, $id_usuario_encontrado);
                }
    
                header("Location: index.php?action=checkin&id_reserva=$id_reserva");
                exit();
            } else {
                $mensaje = "No se encontró un usuario con ese número de documento.";
                include __DIR__ . '/views/checkin.php';
            }
        }
    }
    
    public function actualizarUsuarioEnReserva($id_reserva, $id_usuario_antiguo, $id_usuario_nuevo) {
        try {
            $sql = "SELECT usuarios_ids FROM reservas WHERE id_reserva = :id_reserva";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(":id_reserva", $id_reserva, PDO::PARAM_INT);
            $stmt->execute();
            $reserva = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
    
            if (!$reserva) return;
    
            error_log("Reserva encontrada: " . json_encode($reserva));
            $usuarios_ids = json_decode($reserva["usuarios_ids"], true);
            error_log("Usuarios IDs: " . json_encode($usuarios_ids));
            if (!is_array($usuarios_ids)) return;
    
            $index = array_search((int)$id_usuario_antiguo, $usuarios_ids);
            if ($index !== false) {
                $usuarios_ids[$index] = (int)$id_usuario_nuevo;
    
                $sqlUpdate = "UPDATE reservas SET usuarios_ids = :usuarios_ids WHERE id_reserva = :id_reserva";
                $stmt = $this->db->prepare($sqlUpdate);
                $stmt->bindValue(":usuarios_ids", json_encode($usuarios_ids), PDO::PARAM_STR);
                $stmt->bindValue(":id_reserva", $id_reserva, PDO::PARAM_INT);
                $stmt->execute();
                $stmt->closeCursor();
            }
        } catch (PDOException $e) {
            return [];
        }
    }
    
}
?>