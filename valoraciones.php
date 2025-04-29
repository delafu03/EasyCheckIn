<?php
if (!isset($reservas)) {
    $reservas = [];
}
?>

<div class="valoraciones-container">
    <h2>Valoración de mis reservas</h2>

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
                    <td>
                        <button class="btn" onclick="toggleValoracion('valoracion-<?= $reserva['id_reserva'] ?>')">Valorar</button>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div id="valoracion-<?= $reserva['id_reserva'] ?>" class="desplegable-contenedor">
                            <?php
                                $form = new FormularioValoraciones($reserva['id_reserva']);
                                echo $form->gestiona();                        
                            ?>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>No tienes reservas pendientes de valoración.</p>
    <?php } ?>
</div>

<script src="<?php echo RUTA_JS; ?>/funciones_aux.js"></script>
