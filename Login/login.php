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
<?php include './header.php'; ?>
    <form action="./Login/procesarLogin.php" method="post" class="login-form">
      <label for="email">Email:</label>
      <input type="text" id="email" name="email" required>
      <label for="password">Contraseña:</label>
      <input type="password" id="password" name="password" required>
      
      <div class="btn-container">
        <button type="submit" class="btn">Iniciar sesión</button>
        <button><a href="registro.php"  type="submit" class="btn" >Registrarse</a></button>

      </div>
        <?php if (isset($_SESSION["login"]) && !isset($_SESSION["error"])) {
         echo"
            <p>Bienvenido {$_SESSION['nombre']}!, usa la cabecera para navegar por nuestra web.</p>
            ";
        } 
        else if (isset($_SESSION["error"]) && $_SESSION["error"]=== true){
            echo"<p style='color:red'>El usuario o contraseña no son válidos.";
        }
        ?>
    
    </form>
    
</body>
<?php include './footer.php'; ?>
    </html>
