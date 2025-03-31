<?php
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioRegistro extends Formulario
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
        <fieldset>
            <legend>Datos de Registro</legend>
            <div>
                <label for="nombre">Nombre:</label>
                <input id="nombre" type="text" name="nombre" value="$nombre" />
                {$erroresCampos['nombre']}
            </div>
            <div>
                <label for="correo">Correo Electrónico:</label>
                <input id="correo" type="email" name="correo" value="$correo" />
                {$erroresCampos['correo']}
            </div>
            <div>
                <label for="password">Contraseña:</label>
                <input id="password" type="password" name="password" />
                {$erroresCampos['password']}
            </div>
            <div>
                <button type="submit" name="registro">Registrar</button>
            </div>
        </fieldset>
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
            $usuario = Usuario::buscaUsuarioPorCorreo($correo);

            if ($usuario) {
                $this->errores[] = "El correo electrónico ya está registrado.";
            } else {
                $usuario = Usuario::crea($correo, $password, $nombre, Usuario::USER_ROLE);
                $app = Aplicacion::getInstance();
                $app->login($usuario);
            }
        }
    }
}
?>
