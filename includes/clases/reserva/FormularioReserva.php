<?php

class FormularioReserva extends Formulario
{
    public function __construct($reserva = []) {
        $idUnico = 'formReserva_' . ($reserva->id_reserva ?? uniqid());
        parent::__construct($idUnico, ['urlRedireccion' => 'index.php?action=reservas_admin']);
        $this->reserva = $reserva;
    }

    protected function generaCamposFormulario(&$datos)
    {
        $id = $datos['id_reserva'] ?? $this->reserva->id_reserva ?? '';
        $usuariosSeleccionados = $datos['usuarios_ids'] ?? (isset($this->reserva->usuarios_ids) ? json_decode($this->reserva->usuarios_ids, true) : []);
        $fechaEntrada = $datos['fecha_entrada'] ?? $this->reserva->fecha_entrada ?? '';
        $fechaSalida = $datos['fecha_salida'] ?? $this->reserva->fecha_salida ?? '';
        $estado = $datos['estado'] ?? $this->reserva->estado ?? 'pendiente';
    
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['usuarios_ids', 'fecha_entrada', 'fecha_salida', 'estado'], $this->errores, 'span', ['class' => 'error']);
    
        $opciones = ['pendiente', 'confirmada', 'cancelada'];
        $htmlSelectEstado = '<select name="estado" class="form-control">';
        foreach ($opciones as $op) {
            $selected = ($estado === $op) ? 'selected' : '';
            $htmlSelectEstado .= "<option value=\"$op\" $selected>" . ucfirst($op) . "</option>";
        }
        $htmlSelectEstado .= '</select>';
    
        // Obtener todos los usuarios
        $usuarioModel = new Usuario();
        $todosUsuarios = $usuarioModel->obtenerUsuarios();
    
        // Generar checkboxes
        $checkboxesUsuarios = '<div class="checkbox-usuarios">';
        foreach ($todosUsuarios as $u) {
            $checked = in_array($u->id_usuario, $usuariosSeleccionados) ? 'checked' : '';
            $nombreCompleto = htmlspecialchars("{$u->id_usuario} - {$u->nombre} ({$u->correo})");
            $checkboxesUsuarios .= <<<HTML
                <label>
                    <input type="checkbox" name="usuarios_ids[]" value="{$u->id_usuario}" $checked>
                    $nombreCompleto
                </label><br>
            HTML;
        }
        $checkboxesUsuarios .= '</div>';
    
        $html = <<<EOF
        <div class="form-reserva-linea">
            $htmlErroresGlobales
    
            <input type="hidden" name="id_reserva" value="$id">
    
            <span><strong>ID:</strong> $id</span>
    
            $htmlSelectEstado
            {$erroresCampos['estado']}
    
            <input type="date" name="fecha_entrada" value="$fechaEntrada" class="form-control">
            {$erroresCampos['fecha_entrada']}
    
            <input type="date" name="fecha_salida" value="$fechaSalida" class="form-control">
            {$erroresCampos['fecha_salida']}
        </div>
    
        <div>
            <strong>Usuarios:</strong>
            $checkboxesUsuarios
            {$erroresCampos['usuarios_ids']}
        </div>
    
        <div class="acciones">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
        EOF;
    
        return $html;
    }
    

    

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $id = trim($datos['id_reserva'] ?? '');
        $usuariosSeleccionados = $datos['usuarios_ids'] ?? [];
        $fechaEntrada = trim($datos['fecha_entrada'] ?? '');
        $fechaSalida = trim($datos['fecha_salida'] ?? '');
        $estado = trim($datos['estado'] ?? '');

        if (empty($usuariosSeleccionados)) {
            $this->errores['usuarios_ids'] = 'Debes seleccionar al menos un usuario.';
        }

        if (!$fechaEntrada) {
            $this->errores['fecha_entrada'] = 'La fecha de entrada es obligatoria.';
        }

        if (!$fechaSalida) {
            $this->errores['fecha_salida'] = 'La fecha de salida es obligatoria.';
        }

        if (!in_array($estado, ['pendiente', 'confirmada', 'cancelada'])) {
            $this->errores['estado'] = 'Estado inválido.';
        }

        if (count($this->errores) === 0) {
            $usuarios = array_map('intval', $usuariosSeleccionados);

            $reservaModel = new Reserva();

            if ($id) {
                $reservaModel->actualizarReserva([
                    'id_reserva' => $id,
                    'usuarios_ids' => $usuarios,
                    'fecha_entrada' => $fechaEntrada,
                    'fecha_salida' => $fechaSalida,
                    'estado' => $estado
                ]);
            }
        }
    }
}
