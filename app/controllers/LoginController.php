<?php
require_once __DIR__ . '/../models/Login.php';

class LoginController{

    private $loginModel; 
    public function __construct(){
        $this->loginModel = new LoginModel();
    }
    
    public function login() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $correo = $_POST['correo'] ?? '';
                $password = $_POST['password'] ?? '';
    
                $resultado = $this->loginModel->login($correo, $password);
                
                if (isset($resultado['success'])) {
                    header('Location: index.php');
                    exit;
                } else {
                    echo json_encode($resultado);
                }
            } else {
                $tituloPagina = 'Iniciar Sesión';
                $vista = __DIR__ . '/../views/login.php';
                include __DIR__ . '/../views/plantillas/plantilla.php';
            }
        }
    
        public function logout() {
            $this->loginModel->logout();
            header('Location: index.php');
            exit;
        }
}


?>