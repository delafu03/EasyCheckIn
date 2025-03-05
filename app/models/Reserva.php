<?php
class Reserva {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function obtenerReservas() {
        $stmt = $this->db->query("SELECT * FROM reservas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>