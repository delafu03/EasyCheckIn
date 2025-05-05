<?php
class Reserva {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // === MÉTODO DEL MODELO ===
    public function obtenerReservasPorUsuario($id_usuario) {
        try {
            $sql = "SELECT id_reserva, fecha_entrada, fecha_salida 
                    FROM reservas 
                    WHERE JSON_CONTAINS(usuarios_ids, :id_usuario, '$')";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id_usuario', json_encode((int)$id_usuario), PDO::PARAM_STR);
            $stmt->execute();

            $reservas = [];
            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $reservas[] = new ReservaModelo(
                    $fila['id_reserva'],
                    $fila['fecha_entrada'],
                    $fila['fecha_salida']
                );
            }

            $stmt->closeCursor();
            return $reservas;
        } catch (PDOException $e) {
            error_log("Error en obtenerReservasPorUsuario: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerTodasLasReservas() {
        try {
            $sql = "SELECT id_reserva, fecha_entrada, fecha_salida, estado, usuarios_ids FROM reservas";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            
            $reservas = [];
            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $reservas[] = new ReservaModelo(
                    $fila['id_reserva'],
                    $fila['fecha_entrada'],
                    $fila['fecha_salida'],
                    $fila['estado'],
                    $fila['usuarios_ids']
                );
            }

            $stmt->closeCursor();
            return $reservas;
        } catch (PDOException $e) {
            error_log("Error en obtenerTodasLasReservas: " . $e->getMessage());
            return [];
        }
    } 

    public function eliminarReserva($id_reserva) {
        try {
            $sql = "DELETE FROM reservas WHERE id_reserva = :id_reserva";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id_reserva', $id_reserva, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
        } catch (PDOException $e) {
            error_log("Error al eliminar reserva: " . $e->getMessage());
        }
    }

    public function actualizarReserva($datos) {
        $permitidos = ['usuarios_ids', 'fecha_entrada', 'fecha_salida', 'estado'];
        $campos = [];
        $valores = [];
    
        foreach ($permitidos as $campo) {
            if (isset($datos[$campo])) {
                if ($campo === 'usuarios_ids') {
                    $valor = is_array($datos[$campo])
                        ? json_encode(array_map('intval', $datos[$campo])) // ya es array
                        : json_encode(array_filter(array_map('intval', explode(',', $datos[$campo])))); // por si viene en string            
                } else {
                    $valor = $datos[$campo];
                }
    
                $campos[] = "$campo = :$campo";
                $valores[":$campo"] = $valor;
            }
        }
    
        if (empty($campos)) {
            return false;
        }
    
        $valores[':id_reserva'] = $datos['id_reserva'];
        
        try {
            $sql = "UPDATE reservas SET " . implode(', ', $campos) . " WHERE id_reserva = :id_reserva";
            $stmt = $this->db->prepare($sql);
        
            foreach ($valores as $param => $valor) {
                $stmt->bindValue($param, $valor === '' ? null : $valor, is_int($valor) ? PDO::PARAM_INT : PDO::PARAM_STR);
            }
        
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } catch (PDOException $e) {
            error_log("Error al actualizar reserva: " . $e->getMessage());
            return false;
        }
    }
    
    public function crearReservaVacia() {
        try {
            $sql = "INSERT INTO reservas (usuarios_ids, fecha_entrada, fecha_salida, estado)
                    VALUES (:usuarios_ids, :fecha_entrada, :fecha_salida, :estado)";
            $stmt = $this->db->prepare($sql);

            $manana = date('Y-m-d', strtotime('+1 day'));
            $pasado = date('Y-m-d', strtotime('+2 days'));

            $stmt->bindValue(':usuarios_ids', json_encode([]), PDO::PARAM_STR);
            $stmt->bindValue(':fecha_entrada', $manana, PDO::PARAM_STR);
            $stmt->bindValue(':fecha_salida', $pasado, PDO::PARAM_STR);
            $stmt->bindValue(':estado', 'pendiente', PDO::PARAM_STR);

            $stmt->execute();
            $id = $this->db->lastInsertId();
            $stmt->closeCursor();
            return $id;
        } catch (PDOException $e) {
            error_log("Error al crear reserva vacía: " . $e->getMessage());
            return false;
        }
    }

    // === MÉTODO DEL CONTROLADOR ===
    public function mostrarReservas() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["login"]) || !isset($_SESSION["usuario_id"])) {
            header("Location: index.php?action=login");
            exit();
        }

        $id_usuario = $_SESSION["usuario_id"];
        $reservas = $this->obtenerReservasPorUsuario($id_usuario);

        $tituloPagina = 'Mis Reservas';
        $vista = __DIR__ . '/../../../reservas.php';
        include __DIR__ . '/../../views/plantillas/plantilla.php';
    }

    public function mostrarReservasValoracion() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["login"]) || !isset($_SESSION["usuario_id"])) {
            header("Location: index.php?action=login");
            exit();
        }

        $id_usuario = $_SESSION["usuario_id"];
        $reservas = $this->obtenerReservasPorUsuario($id_usuario);

        $tituloPagina = 'Mis Valoraciones';
        $vista = __DIR__ . '/../../../valoraciones.php';
        include __DIR__ . '/../../views/plantillas/plantilla.php';
    }

    public function mostrarTodasReservas() {
        $reservas = $this->obtenerTodasLasReservas();
        error_log(print_r($reservas, true)); // Log para depuración
        $tituloPagina = 'Reservas EasyCheckIn';
        $vista = __DIR__ . '/../../../reservas_admin.php';
        include __DIR__ . '/../../views/plantillas/plantilla.php';
    }

    public function procesarEliminarReserva($id_reserva) {
        $this->eliminarReserva($id_reserva);
        header('Location: index.php?action=reservas_admin');
    }

    public function procesarCrearReservaVacia() {
        $id_reserva = $this->crearReservaVacia();
        if ($id_reserva) {
            header('Location: index.php?action=reservas_admin');
        } else {
            echo "Error al crear la reserva vacía.";
        }
    }
}
