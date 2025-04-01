<?php

class FormularioCheckIn extends Formulario
{
    public function __construct($usuario = [], $id_reserva = '') {
        $tipoFormulario = 'formCheckIn-' . ($usuario['id_usuario'] ?? 'nuevo');
        parent::__construct($tipoFormulario, [
            'class' => 'form-container-checkin',
            'urlRedireccion' => "index.php?action=checkin&id_reserva=$id_reserva"
        ]);
        $this->usuario = $usuario;
        $this->id_reserva = $id_reserva;
    }

    protected function generaCamposFormulario(&$datos)
    {
        $id_usuario = $this->usuario['id_usuario'] ?? '';
        $nombre = $this->usuario['nombre'] ?? '';
        $apellidos = $this->usuario['apellidos'] ?? '';
        $tipo_documento = $this->usuario['tipo_documento'] ?? 'DNI';
        $numero_documento = $this->usuario['numero_documento'] ?? '';
        $fecha_nacimiento = $this->usuario['fecha_nacimiento'] ?? date('Y-m-d', strtotime('-14 years'));
        $fecha_expedicion = $this->usuario['fecha_expedicion'] ?? date('Y-m-d', strtotime('-14 years'));
        $num_soporte = $this->usuario['num_soporte'] ?? '';
        $sexo = $this->usuario['sexo'] ?? '';
        $nacionalidad = $this->usuario['nacionalidad'] ?? '';
        $pais = $this->usuario['pais'] ?? '';
        $direccion = $this->usuario['direccion'] ?? '';
        $correo = $this->usuario['correo'] ?? '';

        $selDNI = ($tipo_documento === 'DNI') ? 'selected' : '';
        $selPasaporte = ($tipo_documento === 'Pasaporte') ? 'selected' : '';
        $selM = ($sexo === 'Masculino') ? 'selected' : '';
        $selF = ($sexo === 'Femenino') ? 'selected' : '';
        $selO = ($sexo === 'Otro') ? 'selected' : '';        

        $tipoFormulario = 'formCheckIn-' . $id_usuario;

        $html = <<<EOF
        <fieldset>
            <legend>Usuario (ID: $id_usuario): $nombre $apellidos</legend>
            <input type="hidden" name="tipoFormulario" value="$tipoFormulario">
            <input type="hidden" name="id_usuario" value="$id_usuario">
            <input type="hidden" name="id_reserva" value="{$this->id_reserva}">

            <div class="form-row">
                <div class="form-group-checkin col-2">
                    <label>Tipo de Documento:</label>
                    <select name="tipo_documento" class="tipoDocumento">
                        <option value="DNI" $selDNI>DNI</option>
                    </select>
                </div>
                <div class="form-group-checkin col-2">
                    <label>Número de Documento:</label>
                    <input type="text" name="numero_documento" class="dniInput mayuscula" value="$numero_documento">
                </div>
                <div class="form-group-checkin col-1">
                    <label>&nbsp;</label>
                    <button type="button"
                        class="buscarBtn"
                        data-id-usuario="$id_usuario"
                        data-id-reserva="{$this->id_reserva}"
                        data-documento-original="{$this->usuario['numero_documento']}">
                        Buscar
                    </button>
                </div>
                <div class="form-group-checkin col-2">
                    <label>Fecha de Expedición:</label>
                    <input type="date" name="fecha_expedicion" class="fechaExpedicion" value="$fecha_expedicion">
                </div>
                <div class="form-group-checkin col-2">
                    <label>Número de Soporte:</label>
                    <input type="text" name="num_soporte" class="numSoporte mayuscula" value="$num_soporte">
                </div>
                <div class="form-group-checkin col-1">
                    <label>Sexo:</label>
                    <select name="sexo">
                        <option value="Masculino" $selM>Masculino</option>
                        <option value="Femenino" $selF>Femenino</option>
                        <option value="Otro" $selO>Otro</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group-checkin col-2">
                    <label>Nombre:</label>
                    <input type="text" name="nombre" class="mayuscula" value="$nombre">
                </div>
                <div class="form-group-checkin col-4">
                    <label>Apellidos:</label>
                    <input type="text" name="apellidos" class="mayuscula" value="$apellidos">
                </div>
                <div class="form-group-checkin col-2">
                    <label>Fecha de Nacimiento:</label>
                    <input type="date" name="fecha_nacimiento" class="fechaNacimiento" value="$fecha_nacimiento">
                </div>
                <div class="form-group-checkin col-2">
                    <label>Nacionalidad:</label>
                    <input type="text" name="nacionalidad" class="mayuscula" value="$nacionalidad">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group-checkin col-2">
                    <label>País:</label>
                    <input type="text" name="pais" class="mayuscula" value="$pais">
                </div>
                <div class="form-group-checkin col-4">
                    <label>Dirección:</label>
                    <input type="text" name="direccion" class="mayuscula" value="$direccion">
                </div>
                <div class="form-group-checkin col-3">
                    <label>Correo:</label>
                    <input type="email" name="correo" class="correoInput" value="$correo">
                </div>
                <div class="form-group-checkin col-1">
                    <label>&nbsp;</label>
                    <button type="submit">Actualizar</button>
                </div>
            </div>
        </fieldset>
        EOF;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        error_log("Procesando FormularioCheckIn para ID: " . ($datos['id_usuario'] ?? 'N/A'));

        $checkIn = new CheckIn();
        $resultado = $checkIn->procesarCheckIn($datos);

        if (isset($resultado['error'])) {
            $this->errores[] = $resultado['error'];
        }
    }
}
