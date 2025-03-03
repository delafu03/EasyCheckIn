<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(["error" => "Acceso denegado. Debes iniciar sesión."]);
    exit;
}

$id_usuario = $_SESSION['id_usuario']; // ID del usuario autenticado

// Consulta SQL para obtener el historial de reservas
$sql = "SELECT 
            r.id_reserva, 
            r.fecha_entrada, 
            r.fecha_salida, 
            r.estado, 
            GROUP_CONCAT(s.nombre SEPARATOR ', ') AS servicios_contratados
        FROM reservas r
        LEFT JOIN contrataciones c ON r.id_reserva = c.id_reserva
        LEFT JOIN servicios s ON c.id_servicio = s.id_servicio
        WHERE r.id_usuario = ?
        GROUP BY r.id_reserva
        ORDER BY r.fecha_entrada DESC";

$conn = conectar(); // Función que conecta a MySQL
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

// Convertir los resultados en un array
$reservas = [];
while ($row = $result->fetch_assoc()) {
    $reservas[] = $row;
}

echo json_encode($reservas); // Enviar datos en formato JSON

$stmt->close();
$conn->close();
?>
