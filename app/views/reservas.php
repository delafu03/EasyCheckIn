<?php
if (!isset($reservas)) {
    $reservas = [];
}
?>

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
