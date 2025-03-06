<?php
include 'conexion.php';

$sql = "SELECT * FROM servicios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./CSS/estilo.css" rel="stylesheet" type="text/css">
    <link href="../CSS/headerFooter.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php include 'header.php'; ?>
    <h1>Lista de Alojamientos</h1>
    <div class="contenedor">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="alojamiento">
                //<img src="img/<?php echo $row['imagen']; ?>" alt="<?php echo $row['nombre']; ?>">
                <h2><?php echo $row['nombre']; ?></h2>
                <p><?php echo $row['descripcion']; ?></p>
                <p><strong>Precio:</strong> $<?php echo $row['precio']; ?></p>
            </div>
        <?php endwhile; ?>
     <?php else: ?>
        <p class="mensaje-error">No hay alojamientos disponibles en este momento.</p>
     <?php endif; ?>
    </div>
</body>

<?php
$conn->close();
?>

<?php include 'footer.php'; ?>
    </html>
