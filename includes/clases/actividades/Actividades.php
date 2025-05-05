<?php
class Actividades {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function mostrarActividades() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["login"]) || !isset($_SESSION["usuario_id"])) {
            header("Location: index.php?action=login");
            exit();
        }

        $id_usuario = $_SESSION["usuario_id"];
        $id_reserva = $_GET['id_reserva'] ?? null;
        $servicios_disponibles = $this->obtenerServiciosDisponibles($id_reserva);
        $servicios_contratados = $this->obtenerServiciosContratados($id_reserva);

        $tituloPagina = 'Mis Actividades';
        $vista = __DIR__ . '/../../../actividades.php';
        include __DIR__ . '/../../views/plantillas/plantilla.php';
    }

    public function contratarActividad($id_reserva, $id_servicio, $cantidad = 1) {
        try {
            $sql = "INSERT INTO checkin_hotel.contrataciones (id_reserva, id_servicio, cantidad)
                    VALUES (:id_reserva, :id_servicio, :cantidad)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_reserva', $id_reserva, PDO::PARAM_INT);
            $stmt->bindParam(':id_servicio', $id_servicio, PDO::PARAM_INT);
            $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } catch (PDOException $e) {
            error_log("Error al contratar actividad: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerServiciosDisponibles($id_reserva) {
        try {
            $sql = "SELECT id_servicio, nombre, descripcion, precio
                    FROM servicios
                    WHERE id_servicio NOT IN (
                        SELECT id_servicio FROM contrataciones WHERE id_reserva = :id_reserva
                    )";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_reserva', $id_reserva, PDO::PARAM_INT);
            $stmt->execute();
            $servicios = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $servicios[] = new Servicio(
                    $row['id_servicio'],
                    $row['nombre'],
                    $row['descripcion'],
                    $row['precio']
                );
            }

            $stmt->closeCursor();
            return $servicios;
        } catch (PDOException $e) {
            error_log("Error al obtener servicios disponibles: " . $e->getMessage());
            return [];
        }
    }
    
    public function obtenerServiciosContratados($id_reserva) {
        try {
            $sql = "SELECT s.id_servicio, s.nombre, s.descripcion, s.precio
                    FROM contrataciones c
                    JOIN servicios s ON c.id_servicio = s.id_servicio
                    WHERE c.id_reserva = :id_reserva";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_reserva', $id_reserva, PDO::PARAM_INT);
            $stmt->execute();
    
            $servicios = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $servicios[] = new Servicio(
                    $row['id_servicio'],
                    $row['nombre'],
                    $row['descripcion'],
                    $row['precio']
                );
            }
    
            $stmt->closeCursor();
            return $servicios;
        } catch (PDOException $e) {
            error_log("Error al obtener servicios contratados: " . $e->getMessage());
            return [];
        }
    }

    public function eliminarActividad($id_reserva, $id_servicio) {
        try {
            $sql = "DELETE FROM contrataciones
                    WHERE id_reserva = :id_reserva AND id_servicio = :id_servicio";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_reserva', $id_reserva, PDO::PARAM_INT);
            $stmt->bindParam(':id_servicio', $id_servicio, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } catch (PDOException $e) {
            error_log("Error al eliminar actividad contratada: " . $e->getMessage());
            return false;
        }
    }
    
}