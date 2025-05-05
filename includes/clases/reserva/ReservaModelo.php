<?php
class ReservaModelo {
    public $id_reserva;
    public $fecha_entrada;
    public $fecha_salida;
    public $estado;
    public $usuarios_ids;

    public function __construct($id_reserva, $fecha_entrada, $fecha_salida, $estado = null, $usuarios_ids = null) {
        $this->id_reserva = $id_reserva;
        $this->fecha_entrada = $fecha_entrada;
        $this->fecha_salida = $fecha_salida;
        $this->estado = $estado;
        $this->usuarios_ids = $usuarios_ids;
    }
}
