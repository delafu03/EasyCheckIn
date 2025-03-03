<?php
$servidor = "localhost"; 
$usuario = "root"; 
$clave = "1234"; 
$base_datos = "checkin_hotel"; 

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$base_datos;charset=utf8", $usuario, $clave);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
