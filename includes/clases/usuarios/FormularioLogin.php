<?php
class FormularioLogin extends Formulario
{
    public function __construct() {
        parent::__construct('formLogin', ['urlRedireccion' => 'index.php']);
    }

    protected function generaCamposFormulario(&$datos)
	{
		// Se reutiliza el correo electrónico introducido previamente o se deja en blanco
		$email = $datos['correo'] ?? '';

		// Se generan los mensajes de error si existen
		$htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
		$erroresCampos = self::generaErroresCampos(['correo', 'password'], $this->errores, 'span', array('class' => 'error'));

		$mensajeError = '';

		if (isset($_SESSION['error'])) {
			$mensajeError = '<p style="color: red;">Correo o contraseña incorrectos.</p>';
			unset($_SESSION['error']);
		}

		// Generar el HTML del formulario SIN el encabezado
		$html = <<<EOF
        $htmlErroresGlobales
        $mensajeError

        <div class="form-group">
            <label for="correo">Correo Electrónico</label>
            <input id="correo" type="email" name="correo" value="$email" required>
            {$erroresCampos['correo']}
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" required>
            {$erroresCampos['password']}
        </div>

        <button type="submit" class="btn">Ingresar</button>
        EOF;

		return $html;
	}


    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $correo = trim($datos['correo'] ?? '');
        $correo = filter_var($correo, FILTER_SANITIZE_EMAIL);
        if ( ! $correo || empty($correo) ) {
            $this->errores['correo'] = 'El correo electrónico no puede estar vacío';
        }
        
        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $password || empty($password) ) {
            $this->errores['password'] = 'La contraseña no puede estar vacía.';
        }
        
        if (count($this->errores) === 0) {
            // Llamada al método login del modelo Usuario
            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->login($correo, $password);
        
            if (!$usuario) {
                $_SESSION['error'] = true;
                $this->errores[] = "El correo o la contraseña no coinciden";
            }
        }
    }
}

?>