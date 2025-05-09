<?php

class FormularioFiltroReserva extends Formulario
{
    public function __construct() {
        parent::__construct('formFiltro', [
            'urlRedireccion' => 'index.php?action=reservas_admin',
            'atributos' => ['style' => 'display: none;']
        ]);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $id = $datos['id'] ?? '';
        $estado = $datos['estado'] ?? '';
        $fechaEntrada = $datos['fecha_entrada'] ?? '';
        $fechaSalida = $datos['fecha_salida'] ?? '';

        $selectedTodos = $estado === '' ? 'selected' : '';
        $selectedPendiente = $estado === 'pendiente' ? 'selected' : '';
        $selectedConfirmada = $estado === 'confirmada' ? 'selected' : '';
        $selectedCancelada = $estado === 'cancelada' ? 'selected' : '';

        $html = <<<EOF
            <div class="form-filtro">
                <div class="grupo-filtro">
                    <label for="id">ID:</label>
                    <input type="text" name="id" id="id" value="$id">
                </div>

                <div class="grupo-filtro">
                    <label for="estado">Estado:</label>
                    <select name="estado" id="estado">
                        <option value="" $selectedTodos>-- Todos --</option>
                        <option value="pendiente" $selectedPendiente>Pendiente</option>
                        <option value="confirmada" $selectedConfirmada>Confirmada</option>
                        <option value="cancelada" $selectedCancelada>Cancelada</option>
                    </select>
                </div>

                <div class="grupo-filtro">
                    <label for="fecha_entrada">Desde:</label>
                    <input type="date" name="fecha_entrada" id="fecha_entrada" value="$fechaEntrada">
                </div>

                <div class="grupo-filtro">
                    <label for="fecha_salida">Hasta:</label>
                    <input type="date" name="fecha_salida" id="fecha_salida" value="$fechaSalida">
                </div>

                <button type="submit" class="btn btn-primary">Aplicar</button>
            </div>
        EOF;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        // No se procesa aquí porque lo haces vía JS + AJAX
    }
}
