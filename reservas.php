<?php
session_start();
include 'conexion.php'; // Conectar a la base de datos

// Si no hay sesión activa, redirigir a login
if (!isset($_SESSION["login"]) || !isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION["id_usuario"];

// Obtener las reservas del usuario logueado
$sql = "SELECT id_reserva, fecha_entrada, fecha_salida FROM reservas WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Reservas</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<h2>Mis Reservas</h2>

<?php if ($result->num_rows > 0) { ?>
    <table>
        <tr>
            <th>ID Reserva</th>
            <th>Fecha Entrada</th>
            <th>Fecha Salida</th>
            <th>Acción</th>
        </tr>
        <?php while ($reserva = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= htmlspecialchars($reserva["id_reserva"]) ?></td>
                <td><?= htmlspecialchars($reserva["fecha_entrada"]) ?></td>
                <td><?= htmlspecialchars($reserva["fecha_salida"]) ?></td>
                <td><a href="checkIn.html?id_reserva=<?= $reserva['id_reserva'] ?>" class="btn">Ir al Check-in</a></td>
            </tr>
        <?php } ?>
    </table>
<?php } else { ?>
    <p>No tienes reservas registradas.</p>
<?php } ?>

<a href="logout.php" class="btn">Cerrar sesión</a>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
