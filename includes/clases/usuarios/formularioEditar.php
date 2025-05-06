<?php
require_once 'includes/clases/formularios/Formulario.php';
require_once 'includes/clases/usuarios/UsuarioModelo.php';

class FormularioEditarPerfil extends Formulario {
    private $correo;

    public function __construct($correo) {
        parent::__construct('formEditarPerfil', ['urlRedireccion' => 'perfil.php']);
        $this->correo = $correo;
    }

    protected function generaCamposFormulario(&$datos) {
        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->buscaUsuarioPorCorreo($this->correo);

        $nombre = $usuario->getNombre() ?? '';
        $correo = $usuario->getCorreo() ?? '';
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'correo', 'password'], $this->errores, 'span', ['class' => 'error']);

        return <<<EOF
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
                <label for="password">Nueva Contraseña (opcional):</label>
                <input type="password" id="password" name="password">
                {$erroresCampos['password']}
            </div>
            <button type="submit" class="btn">Guardar Cambios</button>
        EOF;
    }

    protected function procesaFormulario(&$datos) {
        $nombre = trim($datos['nombre'] ?? '');
        $correo = trim($datos['correo'] ?? '');
        $password = trim($datos['password'] ?? '');

        if (!$nombre || mb_strlen($nombre) < 5) {
            $this->errores['nombre'] = 'El nombre debe tener al menos 5 caracteres.';
        }

        if (!$correo || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $this->errores['correo'] = 'El correo electrónico no es válido.';
        }

        if ($password && mb_strlen($password) < 6) {
            $this->errores['password'] = 'La contraseña debe tener al menos 6 caracteres.';
        }

        if (empty($this->errores)) {
            $usuarioModel = new Usuario();
            $actualizado = $usuarioModel->actualizaUsuarioPorCorreo($this->correo, $nombre, $correo, $password);
            if ($actualizado) {
                $_SESSION['correo'] = $correo; // Actualizar el correo en la sesión si se cambia
                return 'perfil.php';
            } else {
                $this->errores['general'] = 'Error al actualizar los datos. Inténtalo de nuevo.';
            }
        }

        return null;
    }
}