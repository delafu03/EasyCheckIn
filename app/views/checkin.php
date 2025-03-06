<?php
require_once __DIR__ . '/../../config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Check-In</title>
    <link href="<?php echo RUTA_CSS; ?>estilo.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php include RAIZ_APP  . '/app/views/common/header.php'; ?>
    <h2>Check-In de Usuarios</h2>
    <h2>ID de Reserva:</strong> <?php echo htmlspecialchars($id_reserva); ?></h2>
    <?php if (empty($usuarios)): ?>
        <p>No hay usuarios registrados para esta reserva.</p>
    <?php else: ?>
        <?php foreach ($usuarios as $usuario): ?>
            <?php
            $fechaNacimiento = !empty($usuario['fecha_nacimiento']) ? $usuario['fecha_nacimiento'] : date('Y-m-d', strtotime('-14 years'));
            $edad = calcularEdad($fechaNacimiento);
            echo "<script>console.log('Edad calculada correctamente: $edad');</script>";
            $fechaExpedicion = !empty($usuario['fecha_expedicion']) ? $usuario['fecha_expedicion'] : date('Y-m-d', strtotime('-14 years'));
            ?>
            
            <form method="POST" action="index.php?action=procesar_checkin">
                <fieldset>
                    <legend>Usuario (ID: <?php echo $usuario['id_usuario']; ?>): <?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellidos']); ?></legend>
                    <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">
                    <input type="hidden" name="id_reserva" value="<?php echo $id_reserva; ?>">
                    
                    <label>Tipo de Documento:</label>
                    <select name="tipo_documento" <?php echo ($edad < 14) ? 'disabled' : ''; ?>>
                        <option value="DNI" <?php echo ($usuario['tipo_documento'] == 'DNI') ? 'selected' : ''; ?>>DNI</option>
                        <option value="Pasaporte" <?php echo ($usuario['tipo_documento'] == 'Pasaporte') ? 'selected' : ''; ?>>Pasaporte</option>
                    </select>
                    
                    <label>Número de Documento:</label>
                    <input type="text" name="numero_documento" value="<?php echo htmlspecialchars($usuario['numero_documento']); ?>" <?php echo ($edad < 14) ? 'disabled' : ''; ?>>
                    
                    <label>Fecha de Expedición:</label>
                    <input type="date" name="fecha_expedicion" value="<?php echo htmlspecialchars($fechaExpedicion); ?>" <?php echo ($edad < 14) ? 'disabled' : ''; ?>>
                    
                    <label>Número de Soporte:</label>
                    <input type="text" name="num_soporte" value="<?php echo htmlspecialchars($usuario['num_soporte']); ?>" <?php echo ($edad < 14) ? 'disabled' : ''; ?>>
                    
                    <label>Relación de Parentesco:</label>
                    <input type="text" name="relacion_parentesco" value="<?php echo htmlspecialchars($usuario['relacion_parentesco']); ?>" <?php echo ($edad >= 14) ? 'disabled' : ''; ?>>
                    
                    <label>Sexo:</label>
                    <select name="sexo">
                        <option value="Masculino" <?php echo ($usuario['sexo'] == 'M') ? 'selected' : ''; ?>>Masculino</option>
                        <option value="Femenino" <?php echo ($usuario['sexo'] == 'F') ? 'selected' : ''; ?>>Femenino</option>
                        <option value="Otro" <?php echo ($usuario['sexo'] == 'O') ? 'selected' : ''; ?>>Otro</option>
                    </select>
                    
                    <label>Nombre:</label>
                    <input type="text" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>">
                    
                    <label>Apellidos:</label>
                    <input type="text" name="apellidos" value="<?php echo htmlspecialchars($usuario['apellidos']); ?>">
                    
                    <label>Fecha de Nacimiento:</label>
                    <input type="date" name="fecha_nacimiento" value="<?php echo htmlspecialchars($fechaNacimiento); ?>">
                    
                    <label>Nacionalidad:</label>
                    <input type="text" name="nacionalidad" value="<?php echo htmlspecialchars($usuario['nacionalidad']); ?>">
                    
                    <label>País:</label>
                    <input type="text" name="pais" value="<?php echo htmlspecialchars($usuario['pais']); ?>">
                    
                    <label>Dirección:</label>
                    <input type="text" name="direccion" value="<?php echo htmlspecialchars($usuario['direccion']); ?>">
                    
                    <label>Correo:</label>
                    <input type="email" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>">
                    
                    <button type="submit">Actualizar</button>
                </fieldset>
            </form>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
<?php include RAIZ_APP . '/app/views/common/footer.php'; ?> 
</html>

<?php
// Funciones PHP para validaciones y lógica
function calcularEdad($fechaNacimiento) {
    if (!$fechaNacimiento) return 0;
    $hoy = new DateTime();
    $nacimiento = new DateTime($fechaNacimiento);
    return $hoy->diff($nacimiento)->y;
}

function validarDNI($dni) {
    return preg_match('/^[0-9]{8}[A-Z]$/', $dni);
}
?>
