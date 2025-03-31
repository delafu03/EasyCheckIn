<div class="container">
    <h1>Gestión de Reservas</h1>
    <?php if (!empty($reservas)): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Fecha Entrada</th>
                    <th>Fecha Salida</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservas as $reserva): ?>
                    <tr>
                        <td><?= htmlspecialchars($reserva['id'] ?? '') ?></td>
                        <td><?= htmlspecialchars($reserva['usuario'] ?? 'Desconocido') ?></td>
                        <td><?= htmlspecialchars($reserva['fecha_entrada'] ?? '') ?></td>
                        <td><?= htmlspecialchars($reserva['fecha_salida'] ?? '') ?></td>
                        <td><?= htmlspecialchars($reserva['estado'] ?? '') ?></td>
                        <td>
                            <form action="index.php?action=reservas_admin" method="post" style="display:inline;">
                                <input type="hidden" name="action" value="eliminar_reserva">
                                <input type="hidden" name="id_reserva" value="<?= htmlspecialchars($reserva['id'] ?? '') ?>">
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay reservas registradas en este momento.</p>
    <?php endif; ?>
</div>