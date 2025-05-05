<div class="container-reservas-admin">
    <h1>Gestión de Reservas</h1>

    <a href="index.php?action=reserva_vacia" class="btn btn-primary mb-3">Crear Reserva Vacía</a>

    <?php if (!empty($reservas)): ?>
        <div class="reservas-admin-wrapper">
            <?php foreach ($reservas as $reserva): ?>
                <div class="reserva-admin-card">
                    <?php
                        $form = new FormularioReserva($reserva);
                        echo $form->gestiona(); 
                    ?>

                    <div class="acciones-admin">
                        <form method="get" action="index.php?action=checkin&id_reserva=<?= $reserva->id_reserva ?>">
                            <input type="hidden" name="action" value="checkin">
                            <input type="hidden" name="id_reserva" value="<?= htmlspecialchars($reserva->id_reserva) ?>">
                            <button type="submit" class="btn btn-success">Check-In</button>
                        </form>

                        <form method="post" action="index.php?action=reservas_admin">
                            <input type="hidden" name="action" value="eliminar_reserva">
                            <input type="hidden" name="id_reserva" value="<?= htmlspecialchars($reserva->id_reserva) ?>">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No hay reservas registradas en este momento.</p>
    <?php endif; ?>
</div>