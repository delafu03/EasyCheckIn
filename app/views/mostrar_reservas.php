<div class="container">
    <h1>Gestión de Reservas</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservas as $reserva): ?>
                <tr>
                    <td><?= htmlspecialchars($reserva['id']) ?></td>
                    <td><?= htmlspecialchars($reserva['usuario']) ?></td>
                    <td><?= htmlspecialchars($reserva['fecha']) ?></td>
                    <td><?= htmlspecialchars($reserva['estado']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>