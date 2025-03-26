<?php
class RegistroModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function register($nombre, $correo, $password) {
        try {
            // Verificar si el usuario ya existe
            $stmt = $this->db->prepare("SELECT id_usuario FROM usuarios WHERE correo = :correo");
            $stmt->execute([":correo" => $correo]);
            if ($stmt->rowCount() > 0) {
                return ["error" => "El correo ya está registrado."];
            }

            // Hash de la contraseña y asignar rol por defecto ("usuario")
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, correo, password_hash, rol) VALUES (:nombre, :correo, :password_hash, 'usuario')");
            $stmt->execute([
                ":nombre" => $nombre,
                ":correo" => $correo,
                ":password_hash" => $hashedPassword
            ]);

            return ["success" => "Registro exitoso, ahora puedes iniciar sesión."];
        } catch (PDOException $e) {
            return ["error" => "Error en el registro: " . $e->getMessage()];
        }
    }
}
