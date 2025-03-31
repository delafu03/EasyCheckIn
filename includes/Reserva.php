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
                    id_reserva as id, 
                    fecha_entrada, 
                    fecha_salida,
                    estado,
                    (SELECT nombre FROM usuarios WHERE id_usuario = 
                        JSON_UNQUOTE(JSON_EXTRACT(usuarios_ids, '$[0]'))) as usuario
                    FROM reservas";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error en la consulta: " . $e->getMessage());
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
        session_start();

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
        $tituloPagina = 'Reservas EasyCheckIn';
        $vista = __DIR__ . '/../reservas_admin.php';
        include __DIR__ . '/views/plantillas/plantilla.php';
    }

    public function procesarEliminarReserva($id_reserva) {
        $this->eliminarReserva($id_reserva);
        header('Location: index.php?action=reservas_admin');
    }
}
