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
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay reservas registradas en este momento.</p>
    <?php endif; ?>
</div>