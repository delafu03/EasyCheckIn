<?php
session_start();
require '../conexion.php'; // Incluir la conexión

if (isset($_POST['correo']) && isset($_POST['password'])) {
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Buscar usuario en la base de datos
    $sql = "SELECT id_usuario, nombre, rol, password_hash FROM usuarios WHERE correo = :correo";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':correo' => $correo]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
   
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>

    <main id="contenido">
        <?php
            if ($user && password_verify($password, $user['password_hash'])) {
                // Iniciar sesión
                $_SESSION['login'] = true;
                $_SESSION['user_id'] = $user['id_usuario'];
                $_SESSION['nombre'] = $user['nombre'];
                $_SESSION['rol'] = $user['rol'];
                $_SESSION['correo'] = $correo;//para comprobar si se ha iniciado sesion luego en el header y cambiar el boton inciar sesion a cerrar sesion 
                header("Location: login.php");
                exit();
            } else {
                $_SESSION['error'] = true;
                unset($_SESSION["correo"]);
                header("Location: login.php");
                exit();
            }
        ?>
    </main> 

</body>
</html>
