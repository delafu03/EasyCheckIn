<?php
include 'conexion.php';

if (isset($_GET['numero_documento'])) {
    $numero_documento = $_GET['numero_documento'];

    $sql = "SELECT * FROM usuarios WHERE numero_documento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $numero_documento);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        echo json_encode($usuario);
    } else {
        echo json_encode(["error" => "No se encontró un usuario con ese número de documento."]);
    }

    $stmt->close();
    $conn->close();
}
?>
