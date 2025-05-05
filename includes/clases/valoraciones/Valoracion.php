<?php
class Valoracion {
    public $id_valoracion;
    public $id_reserva;
    public $comentario;
    public $puntuacion;
    public $nombre_usuario;

    public function __construct($comentario, $puntuacion, $id_valoracion = null, $id_reserva = null, $nombre_usuario = null) {
        $this->comentario = $comentario;
        $this->puntuacion = $puntuacion;
        $this->id_valoracion = $id_valoracion;
        $this->id_reserva = $id_reserva;
        $this->nombre_usuario = $nombre_usuario;
    }
}
