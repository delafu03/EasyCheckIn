<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
} ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alojamientos</title>
    <style>
        body {
            background-image: url('<?php echo RUTA_IMGS; ?>/soon.jpg'); /* Ruta de la imagen */
            background-size: cover;  /* La imagen se ajusta al tamaño de la pantalla */
            background-position: center; /* Centra la imagen */
            background-repeat: no-repeat; /* Evita que la imagen se repita */
            height: 100vh; /* Asegura que el body ocupe el 100% de la pantalla */
            margin: 0; /* Elimina márgenes por defecto */
        }
    </style>
</head>
<body>
    <?php include RAIZ_APP  . '/app/views/common/header.php'; ?>
</body>

</html>