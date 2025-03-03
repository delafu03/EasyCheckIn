<?php
session_start();
require 'conexion.php'; // Incluir la conexión

// Verificar datos recibidos
if (!isset($_POST['email'], $_POST['password'])) {
    die("Error: Faltan datos.");
}

$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$password = $_POST['password'];

// Buscar usuario
$sql = "SELECT id_usuario, password_hash FROM usuarios WHERE correo = :correo";
$stmt = $conn->prepare($sql);
$stmt->execute([':correo' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password_hash'])) {
    $_SESSION['user_id'] = $user['id_usuario'];
    echo "Inicio de sesión exitoso.";
} else {
    echo "Correo o contraseña incorrectos.";
}
?>

