<?php

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
        $nombreJS = json_encode($nombre);
        $correoJS = json_encode($correo);
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'correo', 'password', 'confirmar_password', 'general'], $this->errores, 'span', ['class' => 'error']);

        return <<<EOF
            <div class="editar-perfil-container">
                <h2 class="editar-perfil-titulo">Editar Perfil</h2>
                $htmlErroresGlobales
                <div class="editar-perfil-grupo">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="{$this->escapa($nombre)}">
                    <span class="editar-perfil-error">{$erroresCampos['nombre']}</span>
                </div>
                <div class="editar-perfil-grupo">
                    <label for="correo">Correo Electrónico:</label>
                    <input type="email" id="correo" name="correo" value="{$this->escapa($correo)}">
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
                <button type="submit" id="guardarCambiosBtn" class="boton-centrado-guardar" disabled>Guardar Cambios</button>
                <span class="editar-perfil-error general">{$erroresCampos['general']}</span>
            </div>
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

        error_log("Nombre POST: $nombre, Nombre actual: $nombreActual");
        error_log("Correo POST: $correo, Correo actual: $correoActual");

        if (!empty($password)) {
            if (empty($confirmarPassword) || $password !== $confirmarPassword) {
                $this->errores['confirmar_password'] = 'La contraseña y su confirmación no coinciden.';
            } 
            elseif (mb_strlen($password) < 4) {
                $this->errores['password'] = 'La contraseña debe tener al menos 4 caracteres.';
            }
        }

        if (
            ($nombre === $nombreActual) &&
            ($correo === $correoActual) &&
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

        error_log("Error en la actualización: " . json_encode($this->errores));
        return null;
    }
}