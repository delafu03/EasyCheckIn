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
                    <form action="index.php?action=contratar_actividad" method="post">
                        <input type="hidden" name="id_reserva" value="<?= $id_reserva ?>">
                        <input type="hidden" name="id_servicio" value="<?= $actividad->id_servicio ?>">
                        <button type="submit" class="btn">Contratar</button>
                    </form>
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
                    <form action="index.php?action=eliminar_actividad" method="post" onsubmit="return confirm('¿Eliminar actividad?');">
                        <input type="hidden" name="id_reserva" value="<?= $id_reserva ?>">
                        <input type="hidden" name="id_servicio" value="<?= $actividad->id_servicio ?>">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php } else { ?>
    <p>No has contratado ninguna actividad todavía.</p>
<?php } ?>
