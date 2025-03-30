<?php
// Asegurar que las reservas estén definidas antes de usarlas
if (!isset($reservas)) {
    $reservas = [];
}
require_once __DIR__ . '/../../config.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Reservas</title>
    <link href="<?php echo RUTA_CSS; ?>estilo.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php include RAIZ_APP  . '/app/views/common/header.php'; ?>
<h2>Mis Reservas</h2>

<?php if (!empty($reservas)) { ?>
    <table>
        <tr>
            <th>ID Reserva</th>
            <th>Fecha Entrada</th>
            <th>Fecha Salida</th>
            <th>Acción</th>
        </tr>
        <?php foreach ($reservas as $reserva) { ?>
            <tr>
                <td><?= htmlspecialchars($reserva["id_reserva"]) ?></td>
                <td><?= htmlspecialchars($reserva["fecha_entrada"]) ?></td>
                <td><?= htmlspecialchars($reserva["fecha_salida"]) ?></td>
                <td><a href="index.php?action=checkin&id_reserva=<?= $reserva['id_reserva'] ?>" class="btn">Ir al Check-in</a></td>
            </tr>
        <?php } ?>
    </table>
<?php } else { ?>
    <p>No tienes reservas registradas.</p>
<?php } ?>
<?php include RAIZ_APP . '/app/views/common/footer.php'; ?> 
</body>
</html>
