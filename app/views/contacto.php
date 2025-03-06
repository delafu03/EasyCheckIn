<?php
require_once __DIR__ . '/../../config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Formulario de Contacto</title>
    <link href="<?php echo RUTA_CSS; ?>estilo.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php include RAIZ_APP  . '/app/views/common/header.php'; ?>
    <h2>Si ha tenido algún problema con su reserva, alguna duda o sugerencia, no dude en contactarnos a través de este formulario. Nos pondremos en contacto con usted lo antes posible.</h2>
    <div class="container">
        <form action="mailto:dadela03@ucm.es" method="POST" enctype="text/plain">
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" id="name" name="Nombre" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="Email" required>
            </div>
            
            <div class="form-group">
                <label>Motivo de la consulta:</label>
                <div class="radio-group">
                    <label><input type="radio" name="motivo" value="evaluacion" required> Evaluación</label>
                    <label><input type="radio" name="motivo" value="sugerencias"> Sugerencias</label>
                    <label><input type="radio" name="motivo" value="criticas"> Críticas</label>
                </div>
            </div>

            <div class="form-group">
                <label for="message">Mensaje</label>
                <textarea id="message" name="Mensaje" rows="4" required></textarea>
            </div>
        
            <div class="form-group" id="terms">
                <input id="checkbox" type="checkbox" name="Terminos" value="Aceptado" required>
                <label for="checkbox">Marque esta casilla para verificar que ha leído nuestros términos y condiciones del servicio</label>
            </div>
            
            <button type="submit">Enviar</button>
        </form>
    </div>
    <?php include RAIZ_APP . '/app/views/common/footer.php'; ?> 

</body>
</html>