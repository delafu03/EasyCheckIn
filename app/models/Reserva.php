<?php
class Reserva {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

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
}
