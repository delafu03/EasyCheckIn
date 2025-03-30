<?php
class Auth {
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

    public function login($correo, $password) {
        try {
            // Buscar usuario en la base de datos
            $stmt = $this->db->prepare("SELECT id_usuario, nombre, rol, password_hash FROM usuarios WHERE correo = :correo");
            $stmt->execute([":correo" => $correo]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($usuario && password_verify($password, $usuario['password_hash'])) {
                session_start();
                $_SESSION['login'] = true;
                $_SESSION['usuario_id'] = $usuario['id_usuario'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['correo'] = $correo;
                $_SESSION['rol'] = $usuario['rol']; // Almacenar el rol del usuario

                return ["success" => "Inicio de sesión exitoso."];
            } else {
                $_SESSION['error'] = true;
                unset($_SESSION["correo"]);
                return ["error" => "Correo o contraseña incorrectos."];
            }
        } catch (PDOException $e) {
            return ["error" => "Error en el login: " . $e->getMessage()];
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        return ["success" => "Sesión cerrada correctamente."];
    }
}
