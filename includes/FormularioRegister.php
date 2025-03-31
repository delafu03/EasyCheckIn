<?php

class FormularioRegister extends Formulario
{
    public function __construct() {
        parent::__construct('formRegistro', ['urlRedireccion' => 'index.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $nombre = $datos['nombre'] ?? '';
        $correo = $datos['correo'] ?? '';
        $password = $datos['password'] ?? '';

        // Generación de los errores si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'correo', 'password'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="$nombre" required>
            {$erroresCampos['nombre']}
        </div>
        
        <div class="form-group">
            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" value="$correo" required>
            {$erroresCampos['correo']}
        </div>
        
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            {$erroresCampos['password']}
        </div>
        
        <button type="submit" class="btn">Registrarse</button>
        EOF;        

        return $html;
    }
    

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombre || mb_strlen($nombre) < 5) {
            $this->errores['nombre'] = 'El nombre debe tener al menos 5 caracteres.';
        }

        $correo = trim($datos['correo'] ?? '');
        $correo = filter_var($correo, FILTER_SANITIZE_EMAIL);
        if ( ! $correo || empty($correo)) {
            $this->errores['correo'] = 'El correo electrónico es obligatorio.';
        }

        $password = trim($datos['password'] ?? '');
        if ( ! $password) {
            $this->errores['password'] = 'La contraseña es obligatoria.';
        }

        // Si no hay errores, procesamos el registro
        if (count($this->errores) === 0) {
            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->buscaUsuarioPorCorreo($correo);
            error_log("Usuario encontrado: " . print_r($usuario, true)); // Para depuración

            if ($usuario) {
                $this->errores[] = "El correo electrónico ya está registrado.";
            } else {
                $usuario = $usuarioModel->register($nombre, $correo, $password);
            }
        }
    }
}
?>
