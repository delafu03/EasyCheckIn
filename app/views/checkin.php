<h2>Check-In de Usuarios</h2>
<h2>ID de Reserva:</strong> <?php echo htmlspecialchars($id_reserva); ?></h2>
<?php if (empty($usuarios)): ?>
    <p>No hay usuarios registrados para esta reserva.</p>
<?php else: ?>
    <?php foreach ($usuarios as $usuario): ?>
        <?php
        $fechaNacimiento = !empty($usuario['fecha_nacimiento']) ? $usuario['fecha_nacimiento'] : date('Y-m-d', strtotime('-14 years'));
        $fechaExpedicion = !empty($usuario['fecha_expedicion']) ? $usuario['fecha_expedicion'] : date('Y-m-d', strtotime('-14 years'));
        ?>
        
        <form method="POST" action="index.php?action=procesar_checkin">
            <fieldset>
                <legend>Usuario (ID: <?php echo $usuario['id_usuario']; ?>): <?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellidos']); ?></legend>
                <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">
                <input type="hidden" name="id_reserva" value="<?php echo $id_reserva; ?>">
                
                <label>Tipo de Documento:</label>
                <select name="tipo_documento" class="tipoDocumento">
                    <option value="DNI" <?php echo ($usuario['tipo_documento'] == 'DNI') ? 'selected' : ''; ?>>DNI</option>
                    <option value="Pasaporte" <?php echo ($usuario['tipo_documento'] == 'Pasaporte') ? 'selected' : ''; ?>>Pasaporte</option>
                </select>
                
                <label>Número de Documento:</label>
                <!-- Formulario principal donde el usuario ingresa el número de documento -->
                <input type="text" name="numero_documento" class="dniInput mayuscula"
                    value="<?= isset($_POST['numero_documento']) ? htmlspecialchars($_POST['numero_documento']) : htmlspecialchars($usuario['numero_documento']) ?>">

                <button type="button"
                    class="buscarBtn"
                    data-id-usuario="<?= $usuario['id_usuario'] ?>"
                    data-id-reserva="<?= $id_reserva ?>"
                    data-documento-original="<?= $usuario['numero_documento'] ?>">
                    Buscar
                </button>

                <label>Fecha de Expedición:</label>
                <input type="date" name="fecha_expedicion" class="fechaExpedicion" value="<?php echo htmlspecialchars($fechaExpedicion); ?>">
                
                <label>Número de Soporte:</label>
                <input type="text" name="num_soporte" class="numSoporte mayuscula" 
                    value="<?php echo htmlspecialchars($usuario['num_soporte']); ?>">
                
                <label>Sexo:</label>
                <select name="sexo">
                    <option value="Masculino" <?php echo ($usuario['sexo'] == 'M') ? 'selected' : ''; ?>>Masculino</option>
                    <option value="Femenino" <?php echo ($usuario['sexo'] == 'F') ? 'selected' : ''; ?>>Femenino</option>
                    <option value="Otro" <?php echo ($usuario['sexo'] == 'O') ? 'selected' : ''; ?>>Otro</option>
                </select>
                
                <label>Nombre:</label>
                <input type="text" name="nombre" class="mayuscula" value="<?php echo htmlspecialchars($usuario['nombre']); ?>">
                
                <label>Apellidos:</label>
                <input type="text" name="apellidos" class="mayuscula" value="<?php echo htmlspecialchars($usuario['apellidos']); ?>">
                
                <label>Fecha de Nacimiento:</label> 
                <input type="date" name="fecha_nacimiento" class="fechaNacimiento" value="<?php echo htmlspecialchars($fechaNacimiento); ?>">
                
                <label>Nacionalidad:</label>
                <input type="text" name="nacionalidad" class="mayuscula" value="<?php echo htmlspecialchars($usuario['nacionalidad']); ?>">
                
                <label>País:</label>
                <input type="text" name="pais" class="mayuscula" value="<?php echo htmlspecialchars($usuario['pais']); ?>">
                
                <label>Dirección:</label>
                <input type="text" name="direccion" class="mayuscula" value="<?php echo htmlspecialchars($usuario['direccion']); ?>">
                
                <label>Correo:</label>
                <input type="email" name="correo" class="correoInput" value="<?php echo htmlspecialchars($usuario['correo']); ?>">
                
                <button type="submit">Actualizar</button>
            </fieldset>
        </form>
    <?php endforeach; ?>
<?php endif; ?>

<script src="<?php echo RUTA_JS; ?>validaciones.js"></script>
<script src="<?php echo RUTA_JS; ?>funciones_aux.js"></script>
