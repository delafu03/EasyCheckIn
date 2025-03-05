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
        $stmt = $this->db->prepare("UPDATE usuarios SET tipo_documento = ?, numero_documento = ?, fecha_expedicion = ?, num_soporte = ?, relacion_parentesco = ?, sexo = ?, nombre = ?, apellidos = ?, fecha_nacimiento = ?, nacionalidad = ?, pais = ?, direccion = ?, correo = ? WHERE id_usuario = ?");
        return $stmt->execute([
            $datos['tipo_documento'], $datos['numero_documento'], $datos['fecha_expedicion'], $datos['num_soporte'], $datos['relacion_parentesco'], $datos['sexo'], $datos['nombre'], $datos['apellidos'], $datos['fecha_nacimiento'], $datos['nacionalidad'], $datos['pais'], $datos['direccion'], $datos['correo'], $datos['id_usuario']
        ]);
    }
}
?>