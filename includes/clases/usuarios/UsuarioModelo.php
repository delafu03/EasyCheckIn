<?php
class UsuarioModelo {
    public $id_usuario;
    public $nombre;
    public $correo;
    public $rol;

    public function __construct($id_usuario, $nombre, $correo, $rol) {
        $this->id_usuario = $id_usuario;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->rol = $rol;
    }

    public function getId() {
        return $this->id_usuario;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCorreo() {
        return $this->correo;
    }
    
}
