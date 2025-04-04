<h2>Check-In de Usuarios</h2>
<h2><strong>ID de Reserva:</strong> <?php echo htmlspecialchars($id_reserva); ?></h2>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("POST recibido");
    error_log(print_r($_POST, true));
}
?>
<?php if (empty($usuarios)): ?>
    <p>No hay usuarios registrados para esta reserva.</p>
<?php else: ?>
    <?php foreach ($usuarios as $usuario): ?>
        <?php
        $fechaNacimiento = !empty($usuario['fecha_nacimiento']) ? $usuario['fecha_nacimiento'] : date('Y-m-d', strtotime('-14 years'));
        $fechaExpedicion = !empty($usuario['fecha_expedicion']) ? $usuario['fecha_expedicion'] : date('Y-m-d', strtotime('-14 years'));
        $form = new FormularioCheckIn($usuario, $id_reserva);
        echo $form->gestiona();
        ?>
    <?php endforeach; ?>
<?php endif; ?>

<script src="<?php echo RUTA_JS; ?>/validaciones.js"></script>
<script src="<?php echo RUTA_JS; ?>/funciones_aux.js"></script>
