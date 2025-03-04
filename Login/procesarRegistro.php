<?php
    require '../conexion.php'; // Incluir la conexión

    // Verificar que se recibieron datos
    if (!isset($_POST['email'], $_POST['password'], $_POST['tipo_documento'], $_POST['numero_documento'])) {
        die("Error: Faltan datos.");
    }

    // Limpiar datos recibidos
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $tipo_documento = filter_var($_POST['tipo_documento'], FILTER_SANITIZE_STRING);
    $numero_documento = filter_var($_POST['numero_documento'], FILTER_SANITIZE_STRING);

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
    $sql = "INSERT INTO usuarios (tipo_documento, numero_documento, correo, password_hash) VALUES (:tipo_documento, :numero_documento, :correo, :password_hash)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':tipo_documento' => $tipo_documento,
        ':numero_documento' => $numero_documento,
        ':correo' => $email,
        ':password_hash' => $passwordHash
    ]);

    header("Location: ../index.php");
?>
