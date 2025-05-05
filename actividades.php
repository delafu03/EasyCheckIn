<h2>Actividades no contratadas</h2>
<?php if (!empty($servicios_disponibles)) { ?>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio (€)</th>
            <th>Contratar</th>
        </tr>
        <?php foreach ($servicios_disponibles as $actividad) { ?>
            <tr>
                <td><?= htmlspecialchars($actividad->nombre) ?></td>
                <td><?= htmlspecialchars($actividad->descripcion) ?></td>
                <td><?= number_format($actividad->precio, 2) ?></td>
                <td>
                    <a href="index.php?action=contratar_actividad&id_reserva=<?= $id_reserva ?>&id_servicio=<?= $actividad->id_servicio ?>" class="btn">Contratar</a>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php } else { ?>
    <p>No hay actividades nuevas disponibles.</p>
<?php } ?>

<h2>Actividades ya contratadas</h2>
<?php if (!empty($servicios_contratados)) { ?>
    <table>
        <tr>
            <th>Nombre</th><th>Descripción</th><th>Precio (€)</th><th>Borrar</th>
        </tr>
        <?php foreach ($servicios_contratados as $actividad) { ?>
            <tr>
                <td><?= htmlspecialchars($actividad->nombre) ?></td>
                <td><?= htmlspecialchars($actividad->descripcion) ?></td>
                <td><?= number_format($actividad->precio, 2) ?></td>
                <td>
                    <a href="index.php?action=eliminar_actividad&id_reserva=<?= $id_reserva ?>&id_servicio=<?= $actividad->id_servicio ?>" class="btn" onclick="return confirm('¿Estás seguro de que deseas eliminar esta actividad?');">Eliminar</a>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php } else { ?>
    <p>No has contratado ninguna actividad todavía.</p>
<?php } ?>
