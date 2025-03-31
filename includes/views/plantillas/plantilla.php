<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title><?= $tituloPagina ?></title>
    <link href="<?php echo RUTA_CSS; ?>/headerFooter.css" rel="stylesheet" type="text/css">
    <link href="<?php echo RUTA_CSS; ?>estilo.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php include RAIZ_APP  . '/includes/views/common/header.php'; ?>
    <?php include $vista; ?>
    <?php include RAIZ_APP . '/includes/views/common/footer.php'; ?> 
</body>
</html>
