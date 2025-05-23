<?php
class Usuario {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // === MÉTODOS DEL MODELO ===

    public function register($nombre, $correo, $password) {
        try {

            // Hash de la contraseña y asignar rol por defecto ("usuario")
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, correo, password_hash, rol) VALUES (:nombre, :correo, :password_hash, 'usuario')");
            $stmt->execute([
                ":nombre" => $nombre,
                ":correo" => $correo,
                ":password_hash" => $hashedPassword
            ]);
            $stmt->closeCursor();
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
            $stmt->closeCursor();

            if ($usuario && password_verify($password, $usuario['password_hash'])) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['login'] = true;
                $_SESSION['usuario_id'] = $usuario['id_usuario'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['correo'] = $correo;
                $_SESSION['rol'] = $usuario['rol']; // Almacenar el rol del usuario

                return header('Location: index.php');
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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        return ["success" => "Sesión cerrada correctamente."];
    }

    public function obtenerUsuarios() {
        try {
            $sql = "SELECT id_usuario, nombre, correo FROM usuarios WHERE rol != 'admin'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            $usuarios = [];
            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $usuarios[] = new UsuarioModelo(
                    $fila['id_usuario'],
                    $fila['nombre'],
                    $fila['correo'],
                    null
                );
            }
    
            $stmt->closeCursor();
            return $usuarios;
        } catch (PDOException $e) {
            die("Error en la consulta: " . $e->getMessage());
        }
    }
    public function eliminarUsuario($id_usuario) {
        try {
            $sql = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
        } catch (PDOException $e) {
            die("Error en la consulta: " . $e->getMessage());
        }
    }

   
    public function buscaUsuarioPorCorreo($correo) {
        try {
            $stmt = $this->db->prepare("SELECT id_usuario, nombre, correo FROM usuarios WHERE correo = :correo");
            $stmt->execute([":correo" => $correo]);
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();

            return $fila ? new UsuarioModelo(
                $fila['id_usuario'],
                $fila['nombre'],
                $fila['correo'],
                'usuario'
            ) : null;
        } catch (PDOException $e) {
            die("Error en la consulta: " . $e->getMessage());
        }
    }

    // === MÉTODOS DEL CONSTRUCTOR ===

    public function procesar_register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $correo = $_POST['correo'] ?? '';
            $password = $_POST['password'] ?? '';

            $resultado = $this->register($nombre, $correo, $password);
            
            if (isset($resultado['success'])) {
                header('Location: index.php?action=login');
                exit;
            } else {
                echo json_encode($resultado);
            }
        } else {
            $tituloPagina = 'Registro';
            $vista = __DIR__ . '/../../../register.php';
            include __DIR__ . '/../../views/plantillas/plantilla.php';
        }
    }

    public function procesar_logout() {
        $this->logout();
        header('Location: index.php');
        exit;
    }

    public function mostrarUsuarios() {
        $usuarios = $this->obtenerUsuarios();

        $tituloPagina = 'Usuarios EasyCheckIn';
        $vista = __DIR__ . '/../../../usuarios_admin.php';
        include __DIR__ . '/../../views/plantillas/plantilla.php';
    }
    
    public function actualizaUsuario($idUsuario, $nombre, $correo, $password = null) {
        if ($password) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE usuarios SET nombre = :nombre, correo = :correo, password_hash = :password WHERE id_usuario = :id");
            return $stmt->execute([':nombre' => $nombre, ':correo' => $correo, ':password' => $passwordHash, ':id' => $idUsuario]);
        } else {
            $stmt = $this->db->prepare("UPDATE usuarios SET nombre = :nombre, correo = :correo WHERE id_usuario = :id");
            return $stmt->execute([':nombre' => $nombre, ':correo' => $correo, ':id' => $idUsuario]);
        }
    }

    public function editarPerfil() {
        session_start();
        $usuario = $this->buscaUsuarioPorCorreo($_SESSION['correo']);

        $tituloPagina = 'Usuarios EasyCheckIn';
        $vista = __DIR__ . '/../../../editarPerfil.php';
        include __DIR__ . '/../../views/plantillas/plantilla.php';
    }
}