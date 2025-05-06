<?php
require_once 'includes/clases/usuarios/UsuarioModelo.php';
require_once 'includes/clases/usuarios/Usuario.php';

class FormularioEditarPerfil extends Formulario {
    private $correo;

    public function __construct($correo) {
        parent::__construct('formEditarPerfil', ['urlRedireccion' => 'perfil.php']);
        $this->correo = $correo;
    }

    protected function generaCamposFormulario(&$datos) {
        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->buscaUsuarioPorCorreo($this->correo);

        if (!$usuario) {
            throw new Exception("Usuario no encontrado.");
        }

        $nombre = $usuario->getNombre() ?? '';
        $correo = $usuario->getCorreo() ?? '';
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'confirmar_nombre', 'correo', 'confirmar_correo', 'password', 'confirmar_password'], $this->errores, 'span', ['class' => 'error']);

        return <<<EOF
            <div class="form-container">
                <h2>Editar Perfil</h2>
                $htmlErroresGlobales
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="">
                    {$erroresCampos['nombre']}
                </div>
                <div class="form-group">
                    <label for="confirmar_nombre">Confirmar Nombre:</label>
                    <input type="text" id="confirmar_nombre" name="confirmar_nombre">
                    {$erroresCampos['confirmar_nombre']}
                </div>
                <div class="form-group">
                    <label for="correo">Correo Electrónico:</label>
                    <input type="email" id="correo" name="correo" value="">
                    {$erroresCampos['correo']}
                </div>
                <div class="form-group">
                    <label for="confirmar_correo">Confirmar Correo Electrónico:</label>
                    <input type="email" id="confirmar_correo" name="confirmar_correo">
                    {$erroresCampos['confirmar_correo']}
                </div>
                <div class="form-group">
                    <label for="password">Nueva Contraseña:</label>
                    <input type="password" id="password" name="password">
                    {$erroresCampos['password']}
                </div>
                <div class="form-group">
                    <label for="confirmar_password">Confirmar Contraseña:</label>
                    <input type="password" id="confirmar_password" name="confirmar_password">
                    {$erroresCampos['confirmar_password']}
                </div>
                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary" onclick="return confirmarCambios()">Guardar Cambios</button>
                    <a href="perfil.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>
            <script>
                function confirmarCambios() {
                    const nombre = document.getElementById('nombre').value.trim();
                    const confirmarNombre = document.getElementById('confirmar_nombre').value.trim();
                    const correo = document.getElementById('correo').value.trim();
                    const confirmarCorreo = document.getElementById('confirmar_correo').value.trim();
                    const password = document.getElementById('password').value.trim();
                    const confirmarPassword = document.getElementById('confirmar_password').value.trim();

                    if (!nombre && !confirmarNombre && !correo && !confirmarCorreo && !password && !confirmarPassword) {
                        return confirm('No ha realizado ningún cambio. ¿Desea salir sin guardar?');
                    }
                    return true;
                }
            </script>
        EOF;
    }

    protected function procesaFormulario(&$datos) {
        $nombre = trim($datos['nombre'] ?? '');
        $confirmarNombre = trim($datos['confirmar_nombre'] ?? '');
        $correo = trim($datos['correo'] ?? '');
        $confirmarCorreo = trim($datos['confirmar_correo'] ?? '');
        $password = trim($datos['password'] ?? '');
        $confirmarPassword = trim($datos['confirmar_password'] ?? '');

        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->buscaUsuarioPorCorreo($this->correo);

        if (!$usuario) {
            $this->errores['general'] = 'Usuario no encontrado.';
            return null;
        }

        $nombreActual = $usuario->getNombre();
        $correoActual = $usuario->getCorreo();

        if ($nombre !== $nombreActual) {
            if (empty($confirmarNombre) || $nombre !== $confirmarNombre) {
                $this->errores['confirmar_nombre'] = 'El nombre y su confirmación no coinciden.';
            }
        }

        if ($correo !== $correoActual) {
            if (empty($confirmarCorreo) || $correo !== $confirmarCorreo) {
                $this->errores['confirmar_correo'] = 'El correo y su confirmación no coinciden.';
            }
        }

        if (!empty($password)) {
            if (empty($confirmarPassword) || $password !== $confirmarPassword) {
                $this->errores['confirmar_password'] = 'La contraseña y su confirmación no coinciden.';
            } 
        }

        if (
            ($nombre === $nombreActual || empty($nombre))  &&
            ($correo === $correoActual || empty($correo))  &&
            empty($password)
        ) {
            $this->errores['general'] = 'No se realizaron cambios.';
            return null;
        }

        if (empty($this->errores)) {
            $actualizado = $usuarioModel->actualizaUsuario(
                $usuario->getId(),
                $nombre !== $nombreActual ? $nombre : $nombreActual,
                $correo !== $correoActual ? $correo : $correoActual,
                !empty($password) ? $password : null
            );

            if ($actualizado) {
                $_SESSION['correo'] = $correo; 
                return 'perfil.php';
            } else {
                $this->errores['general'] = 'Error al actualizar los datos. Inténtalo de nuevo.';
            }
        }

        return null;
    }
}