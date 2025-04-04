<div class="container">
    <h1>Gestión de Reservas</h1>

    <a href="index.php?action=reserva_vacia" class="btn btn-primary mb-3">Crear Reserva Vacía</a>

    <?php if (!empty($reservas)): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Id Usuarios</th>
                    <th>Fecha Entrada</th>
                    <th>Fecha Salida</th>
                    <th>Estado</th>
                    <th>Guardar</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservas as $reserva): ?>
                    <tr>
                        <?php
                            $form = new FormularioReserva($reserva);
                            echo $form->gestiona(); 
                        ?>
                        <td>
                            <!-- Botón de eliminar -->
                            <form method="post" action="index.php?action=reservas_admin" style="display:inline;">
                                <input type="hidden" name="action" value="eliminar_reserva">
                                <input type="hidden" name="id_reserva" value="<?= htmlspecialchars($reserva['id_reserva']) ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>

                            <!-- Botón de check-in -->
                            <form method="post" action="index.php?action=checkin" style="display:inline;">
                                <input type="hidden" name="id_reserva" value="<?= htmlspecialchars($reserva['id_reserva']) ?>">
                                <button type="submit" class="btn btn-success btn-sm">Check-In</button>
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
