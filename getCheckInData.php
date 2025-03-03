<?php
include 'conexion.php';

$id_reserva = $_GET['id_reserva'];

$sql = "SELECT u.* FROM usuarios u 
        INNER JOIN reservas r ON u.id_usuario = r.id_usuario 
        WHERE r.id_reserva = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_reserva);
$stmt->execute();
$result = $stmt->get_result();

$usuarios = [];
while ($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}

header('Content-Type: application/json');
echo json_encode($usuarios);

$stmt->close();
$conn->close();
?>
