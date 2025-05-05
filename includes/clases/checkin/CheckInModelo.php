<?php
class CheckInModelo {
    public $id_usuario;
    public $nombre;
    public $correo;
    public $rol;
    public $numero_documento;
    public $sexo;
    public $apellidos;
    public $fecha_nacimiento;
    public $nacionalidad;
    public $pais;
    public $direccion;

    public function __construct($id_usuario, $nombre, $correo, $rol = null, $numero_documento = null, $sexo = null, $apellidos = null, $fecha_nacimiento = null, $nacionalidad = null, $pais = null, $direccion = null) {
        $this->id_usuario = $id_usuario;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->rol = $rol;
        $this->numero_documento = $numero_documento;
        $this->sexo = $sexo;
        $this->apellidos = $apellidos;
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->nacionalidad = $nacionalidad;
        $this->pais = $pais;
        $this->direccion = $direccion;
    }
}
