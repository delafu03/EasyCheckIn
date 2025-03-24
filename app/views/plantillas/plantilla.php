<?php
require_once RAIZ_APP . '/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title><?= $tituloPagina ?></title>
    <link href="<?php echo RUTA_CSS; ?>estilo.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php include RAIZ_APP  . '/app/views/common/header.php'; ?>
    <?php include $vista; ?>
    <?php include RAIZ_APP . '/app/views/common/footer.php'; ?> 
</body>
</html>
