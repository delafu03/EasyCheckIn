<?php
    session_start();
?>

<?php
    session_start();
    ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="./CSS/estilo.css" rel="stylesheet" type="text/css">
        <title>Login</title>
    </head>
    <body>
        <?php include 'header.php'; ?>

        <div id="contenedor"> <!-- Inicio del contenedor -->
        
            <main>
            <?php
            if(isset($_SESSION["login"])){
                unset($_SESSION["login"]);
                unset($_SESSION["nombre"]);
                if (isset($_SESSION["esAdmin"])) {
                    unset($_SESSION["esAdmin"]);
                    }
                    session_destroy();
                    // Recargar la página después de 0.2 segundos
                    header("Refresh: 0.2; url=logout.php"); 
                    exit();
                }
                echo "<h1>Gracias por visitar nuestra web. ¡Hasta pronto!</h1>";
            ?>
            </main>
        
        </div>
        <?php include 'footer.php'; ?>
    </body>
</html>