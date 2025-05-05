<?php
class Servicio {
    public $id_servicio;
    public $nombre;
    public $descripcion;
    public $precio;

    public function __construct($id_servicio, $nombre, $descripcion, $precio) {
        $this->id_servicio = $id_servicio;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
    }
}
