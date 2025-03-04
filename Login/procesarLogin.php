<?php
session_start();
require 'conexion.php'; // Incluir la conexión

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Buscar usuario en la base de datos
    $sql = "SELECT id_usuario, nombre, es_admin, password_hash FROM usuarios WHERE correo = :correo";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':correo' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

   
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./CSS/estilo.css" rel="stylesheet" type="text/css">
    <title>ProcesarLogin</title>
</head>
<body>
    <header> 
        <h1>EasyCheckIn</h1>
        <?php include 'header.php'; ?>
    </header>
    
    <main id="contenido">
        <?php
            if ($user && password_verify($password, $user['password_hash'])) {
                // Iniciar sesión
                $_SESSION['login'] = true;
                $_SESSION['user_id'] = $user['id_usuario'];
                $_SESSION['nombre'] = $user['nombre'];
                $_SESSION['esAdmin'] = $user['es_admin'];
                header("Location: login.php");
                exit();
            } else {
                $_SESSION['error'] = true;
                header("Location: login.php");
                exit();
            }
        ?>
    </main> 

    <?php include 'footer.php'; ?>
</body>
</html>
