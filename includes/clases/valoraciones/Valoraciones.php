<?php
class Valoraciones {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function guardarValoracion($id_usuario, $id_reserva, $comentario, $puntuacion) {
        try {
            $sql = "INSERT INTO valoraciones (id_usuario, id_reserva, comentario, puntuacion)
                    VALUES (:id_usuario, :id_reserva, :comentario, :puntuacion)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->bindValue(':id_reserva', $id_reserva, PDO::PARAM_INT);
            $stmt->bindValue(':comentario', $comentario, PDO::PARAM_STR);
            $stmt->bindValue(':puntuacion', $puntuacion, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } catch (PDOException $e) {
            error_log("Error al guardar la valoración: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerValoracion($id_usuario, $id_reserva) {
        try {
            $sql = "SELECT comentario, puntuacion FROM valoraciones 
                    WHERE id_usuario = :id_usuario AND id_reserva = :id_reserva";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->bindValue(':id_reserva', $id_reserva, PDO::PARAM_INT);
            $stmt->execute();
    
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
    
            return $fila ? new Valoracion($fila['comentario'], $fila['puntuacion']) : null;
    
        } catch (PDOException $e) {
            error_log("Error al obtener la valoración: " . $e->getMessage());
            return null;
        }
    }

    public function obtenerTodasLasValoraciones() {
        try {
            $sql = "SELECT v.id_valoracion, v.id_reserva, v.comentario, v.puntuacion, u.nombre AS nombre_usuario
                    FROM valoraciones v
                    JOIN usuarios u ON v.id_usuario = u.id_usuario
                    ORDER BY v.id_valoracion DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
    
            $valoraciones = [];
            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $valoraciones[] = new Valoracion(
                    $fila['comentario'],
                    $fila['puntuacion'],
                    $fila['id_valoracion'],
                    $fila['id_reserva'],
                    $fila['nombre_usuario']
                );
            }
            $stmt->closeCursor();
            return $valoraciones;
        } catch (PDOException $e) {
            error_log("Error al obtener todas las valoraciones: " . $e->getMessage());
            return [];
        }
    }
    
    public function mostrarValoraciones() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["login"]) || !isset($_SESSION["usuario_id"])) {
            header("Location: index.php?action=login");
            exit();
        }

        $id_usuario = $_SESSION["usuario_id"];
        $valoraciones = $this->obtenerTodasLasValoraciones();

        $tituloPagina = 'Gestión de Valoraciones';
        $vista = __DIR__ . '/../../../valoraciones_admin.php';
        include __DIR__ . '/../../views/plantillas/plantilla.php';
    }
}
