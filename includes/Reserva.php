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
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error en la consulta: " . $e->getMessage());
        }
    }

    public function obtenerTodasLasReservas() {
        try {
            $sql = "SELECT 
                        id_reserva, 
                        fecha_entrada, 
                        fecha_salida,
                        estado,
                        usuarios_ids
                    FROM reservas";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $reservas;
        } catch (PDOException $e) {
            return ["error" => "Error en la consulta: " . $e->getMessage()];
        }
    }    

    public function eliminarReserva($id_reserva) {
        try {
            $sql = "DELETE FROM reservas WHERE id_reserva = :id_reserva";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id_reserva', $id_reserva, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Error en la consulta: " . $e->getMessage());
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
        $vista = __DIR__ . '/../reservas.php';
        include __DIR__ . '/views/plantillas/plantilla.php';
    }

    public function mostrarTodasReservas() {
        $reservas = $this->obtenerTodasLasReservas();
        error_log(print_r($reservas, true)); // Log para depuración
        $tituloPagina = 'Reservas EasyCheckIn';
        $vista = __DIR__ . '/../reservas_admin.php';
        include __DIR__ . '/views/plantillas/plantilla.php';
    }

    public function procesarEliminarReserva($id_reserva) {
        $this->eliminarReserva($id_reserva);
        header('Location: index.php?action=reservas_admin');
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
    
        $sql = "UPDATE reservas SET " . implode(', ', $campos) . " WHERE id_reserva = :id_reserva";
        $stmt = $this->db->prepare($sql);
    
        foreach ($valores as $param => $valor) {
            $stmt->bindValue($param, $valor === '' ? null : $valor, is_int($valor) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
    
        return $stmt->execute();
    }

    public function crearReservaVacia() {
        try {
            $sql = "INSERT INTO reservas (usuarios_ids, fecha_entrada, fecha_salida, estado)
                    VALUES (:usuarios_ids, :fecha_entrada, :fecha_salida, :estado)";
            
            $stmt = $this->db->prepare($sql);
    
            $hoy = date('Y-m-d');
            $manana = date('Y-m-d', strtotime('+1 day'));
            $pasado = date('Y-m-d', strtotime('+2 days'));
    
            $stmt->bindValue(':usuarios_ids', json_encode([]), PDO::PARAM_STR);
            $stmt->bindValue(':fecha_entrada', $manana, PDO::PARAM_STR);
            $stmt->bindValue(':fecha_salida', $pasado, PDO::PARAM_STR);
            $stmt->bindValue(':estado', 'pendiente', PDO::PARAM_STR);
    
            $stmt->execute();
    
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error al crear reserva vacía: " . $e->getMessage());
            return false;
        }
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
