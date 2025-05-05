<?php

class FormularioReserva extends Formulario
{
    public function __construct($reserva = []) {
        // Si quieres redirigir al listado de reservas tras guardar
        parent::__construct('formReserva', ['urlRedireccion' => 'index.php?action=reservas_admin']);
        $this->reserva = $reserva;
    }

    protected function generaCamposFormulario(&$datos)
    {
        $id = $datos['id_reserva'] ?? $this->reserva->id_reserva ?? '';
        $usuarios = $datos['usuarios_ids'] ?? (isset($this->reserva->usuarios_ids) ? implode(',', json_decode($this->reserva->usuarios_ids, true)) : '');
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
        $html = <<<EOF
        $htmlErroresGlobales

        <input type="hidden" name="id_reserva" value="$id">

        <td>
            $id
            <input type="hidden" name="id_reserva" value="$id">
        </td>

        <td>
            <input type="text" name="usuarios_ids" value="$usuarios" class="form-control">
            {$erroresCampos['usuarios_ids']}
        </td>
        <td>
            <input type="date" name="fecha_entrada" value="$fechaEntrada" class="form-control">
            {$erroresCampos['fecha_entrada']}
        </td>
        <td>
            <input type="date" name="fecha_salida" value="$fechaSalida" class="form-control">
            {$erroresCampos['fecha_salida']}
        </td>
        <td>
            $htmlSelectEstado
            {$erroresCampos['estado']}
        </td>
        <td>
            <button type="submit" class="btn btn-primary">Guardar</button>
        
        EOF;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $id = trim($datos['id_reserva'] ?? '');
        $usuariosStr = trim($datos['usuarios_ids'] ?? '');
        $fechaEntrada = trim($datos['fecha_entrada'] ?? '');
        $fechaSalida = trim($datos['fecha_salida'] ?? '');
        $estado = trim($datos['estado'] ?? '');

        if (!$usuariosStr) {
            $this->errores['usuarios_ids'] = 'Debes introducir al menos un ID de usuario.';
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
            $usuarios = array_filter(array_map('intval', explode(',', $usuariosStr)));

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
