<?php
require_once __DIR__ . '/../config.php';

class Database {
    private static $instance = null;
    private $conn;
    
    private $host = BD_HOST;
    private $user = BD_USER;
    private $pass = BD_PASS;
    private $dbname = BD_NAME;
    
    private function __construct() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->conn;
    }
}
?>