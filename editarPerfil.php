<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$formulario = new FormularioEditarPerfil($usuario);
$htmlFormulario = $formulario->gestiona();
echo $htmlFormulario;
