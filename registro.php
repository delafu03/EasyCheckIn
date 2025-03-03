<?php
require 'conexion.php'; // Incluir la conexión

// Verificar que se recibieron datos
if (!isset($_POST['email'], $_POST['password'])) {
    die("Error: Faltan datos.");
}

// Limpiar datos recibidos
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$password = $_POST['password'];

// Verificar si el correo ya está registrado
$sql = "SELECT id_usuario FROM usuarios WHERE correo = :correo";
$stmt = $conn->prepare($sql);
$stmt->execute([':correo' => $email]);

if ($stmt->rowCount() > 0) {
    die("Error: El correo ya está registrado.");
}

// Hashear la contraseña
$passwordHash = password_hash($password, PASSWORD_BCRYPT);

// Insertar usuario con ID automático y rol 'usuario' por defecto
$sql = "INSERT INTO usuarios (correo, password_hash) VALUES (:correo, :password_hash)";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':correo' => $email,
    ':password_hash' => $passwordHash
]);

echo "Registro exitoso.";
?>
