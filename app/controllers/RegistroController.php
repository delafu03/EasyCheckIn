<?php
require_once __DIR__ . '/../models/Registro.php';

class RegistroController{

    private $registroModel; 
    public function __construct(){
        $this->registroModel = new RegistroModel();
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $correo = $_POST['correo'] ?? '';
            $password = $_POST['password'] ?? '';

            $resultado = $this->registroModel->register($nombre, $correo, $password);
            
            if (isset($resultado['success'])) {
                header('Location: index.php?action=login');
                exit;
            } else {
                echo json_encode($resultado);
            }
        } else {
            $tituloPagina = 'Registro';
            $vista = __DIR__ . '/../views/register.php';
            include __DIR__ . '/../views/plantillas/plantilla.php';
        }
    }
}


?>