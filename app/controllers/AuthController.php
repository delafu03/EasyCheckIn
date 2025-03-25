<?php
require_once __DIR__ . '/../models/Auth.php';
class AuthController {
    private $authModel;

    public function __construct() {
        $this->authModel = new Auth();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $correo = $_POST['correo'] ?? '';
            $password = $_POST['password'] ?? '';

            $resultado = $this->authModel->register($nombre, $correo, $password);
            
            if (isset($resultado['success'])) {
                header('Location: index.php?action=login');
                exit;
            } else {
                echo json_encode($resultado);
            }
        } else {
            include __DIR__ . '/../views/register.php';
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = $_POST['correo'] ?? '';
            $password = $_POST['password'] ?? '';

            $resultado = $this->authModel->login($correo, $password);
            
            if (isset($resultado['success'])) {
                header('Location: index.php');
                exit;
            } else {
                echo json_encode($resultado);
            }
        } else {
            include __DIR__ . '/../views/login.php';
        }
    }

    public function logout() {
        $this->authModel->logout();
        header('Location: index.php');
        exit;
    }
}
