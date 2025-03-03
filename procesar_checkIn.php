<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = $_POST['id_usuario'];

    // Lista de campos a actualizar
    $campos = ['tipo_documento', 'numero_documento', 'fecha_expedicion', 'nombre', 'apellidos', 'fecha_nacimiento', 'sexo', 'nacionalidad', 'direccion', 'pais', 'correo', 'num_soporte', 'relacion_parentesco'];

    $set = [];
    $params = [];
    $types = '';

    foreach ($campos as $campo) {
        if (!empty($_POST[$campo])) {
            $set[] = "$campo = ?";
            $params[] = $_POST[$campo];
            $types .= 's';
        }
    }

    if (!empty($set)) {
        $sql = "UPDATE usuarios SET " . implode(', ', $set) . " WHERE id_usuario = ?";
        $params[] = $id_usuario;
        $types .= 'i';

        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        if ($stmt->execute()) {
            echo "Información actualizada correctamente.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "No se realizaron cambios.";
    }

    $conn->close();
}
?>
