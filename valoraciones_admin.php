<div class="admin-valoraciones">
    <h2>Todas las valoraciones</h2>

    <?php if (!empty($valoraciones)) { ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Reserva</th>
                    <th>Usuario</th>
                    <th>Puntuación</th>
                    <th>Comentario</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($valoraciones as $valoracion) { ?>
                    <tr>
                        <td><?= htmlspecialchars($valoracion->id_valoracion) ?></td>
                        <td><?= htmlspecialchars($valoracion->id_reserva) ?></td>
                        <td><?= htmlspecialchars($valoracion->nombre_usuario) ?></td>
                        <td>
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo '<span class="estrella_admin">' . ($i <= $valoracion->puntuacion ? '★' : '☆') . '</span>';
                        }
                        ?>
                        </td>
                        <td><?= nl2br(htmlspecialchars($valoracion->comentario)) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No hay valoraciones registradas.</p>
    <?php } ?>
</div>
