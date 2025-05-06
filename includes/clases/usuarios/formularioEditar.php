<?php
require_once 'includes/clases/usuarios/UsuarioModelo.php';
require_once 'includes/clases/usuarios/Usuario.php';

class FormularioEditarPerfil extends Formulario {

    public function __construct($usuario) {
        parent::__construct('formEditarPerfil', ['urlRedireccion' => 'index.php?action=editarPerfil']);
        $this->usuario = $usuario;
    }

    protected function generaCamposFormulario(&$datos) {

        if (!$this->usuario) {
            throw new Exception("Usuario no encontrado.");
        }

        $nombre = $this->usuario->nombre ?? '';
        $correo = $this->usuario->correo ?? '';
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'correo', 'password', 'confirmar_password'], $this->errores, 'span', ['class' => 'error']);

        return <<<EOF
            <div class="editar-perfil-container">
                <h2 class="editar-perfil-titulo">Editar Perfil</h2>
                $htmlErroresGlobales
                <div class="editar-perfil-grupo">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="">
                    <span class="editar-perfil-error">{$erroresCampos['nombre']}</span>
                </div>
                <div class="editar-perfil-grupo">
                    <label for="correo">Correo Electrónico:</label>
                    <input type="email" id="correo" name="correo" value="">
                    <span class="editar-perfil-error">{$erroresCampos['correo']}</span>
                </div>
                <div class="editar-perfil-grupo">
                    <label for="password">Nueva Contraseña:</label>
                    <input type="password" id="password" name="password">
                    <span class="editar-perfil-error">{$erroresCampos['password']}</span>
                </div>
                <div class="editar-perfil-grupo">
                    <label for="confirmar_password">Confirmar Contraseña:</label>
                    <input type="password" id="confirmar_password" name="confirmar_password">
                    <span class="editar-perfil-error">{$erroresCampos['confirmar_password']}</span>
                </div>
                <button type="submit" class="boton-centrado-guardar" onclick="return validarCambios()">Guardar Cambios</button>
            </div>

            <script>
                function validarCambios() {
                    const nombre = document.getElementById('nombre').value.trim();
                    const confirmarNombre = document.getElementById('confirmar_nombre').value.trim();
                    const correo = document.getElementById('correo').value.trim();
                    const confirmarCorreo = document.getElementById('confirmar_correo').value.trim();
                    const password = document.getElementById('password').value.trim();
                    const confirmarPassword = document.getElementById('confirmar_password').value.trim();

                    if (
                        (!nombre && !confirmarNombre) &&
                        (!correo && !confirmarCorreo) &&
                        (!password && !confirmarPassword)
                    ) {
                        alert('No se realizaron cambios. Por favor, modifique al menos un campo antes de guardar.');
                        return false; 
                    }

                    return true; // Permite el envío del formulario
                }
            </script>
        EOF;
    }

    protected function procesaFormulario(&$datos) {
        $nombre = trim($datos['nombre'] ?? '');
        $correo = trim($datos['correo'] ?? '');
        $password = trim($datos['password'] ?? '');
        $confirmarPassword = trim($datos['confirmar_password'] ?? '');


        if (!$this->usuario) {
            $this->errores['general'] = 'Usuario no encontrado.';
            return null;
        }

        $nombreActual = $this->usuario->nombre;
        $correoActual = $this->usuario->correo;

        if (!empty($password)) {
            if (empty($confirmarPassword) || $password !== $confirmarPassword) {
                $this->errores['confirmar_password'] = 'La contraseña y su confirmación no coinciden.';
            } 
            elseif (mb_strlen($password) < 6) {
                $this->errores['password'] = 'La contraseña debe tener al menos 6 caracteres.';
            }
        }

        if (
            (empty($nombre) || $nombre === $nombreActual) &&
            (empty($correo) || $correo === $correoActual) &&
            empty($password)
        ) {
            $this->errores['general'] = 'No se realizaron cambios.';
            return null;
        }

        if (empty($this->errores)) {
            $usuarioModel = new Usuario();
            $actualizado = $usuarioModel->actualizaUsuario(
                $this->usuario->id_usuario,
                !empty($nombre) ? $nombre : $nombreActual,
                !empty($correo) ? $correo : $correoActual,
                !empty($password) ? $password : null
            );

            if ($actualizado) {
                $_SESSION['correo'] = $correo; 
                return 'index.php?action=editarPerfil';
            } else {
                $this->errores['general'] = 'Error al actualizar los datos. Inténtalo de nuevo.';
            }
        }

        return null;
    }
}