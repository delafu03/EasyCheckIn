<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger y sanitizar los datos del formulario
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($_POST['phone']);
    $reason = htmlspecialchars($_POST['reason']);
    $message = htmlspecialchars($_POST['message']);
    
    // Validar correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Correo electrónico no válido");
    }

    // Formato del log
    $logEntry = "Nombre: $name\nCorreo: $email\nTeléfono: $phone\nMotivo: $reason\nMensaje:\n$message\n\n";
    
    // Archivo de log
    $logFile = "contact_messages.log"; // El archivo donde se guardarán los logs
    
    // Abrir el archivo en modo append (añadir al final)
    if (file_put_contents($logFile, $logEntry, FILE_APPEND)) {
        echo "Mensaje guardado correctamente. Muchas gracias!";
    } else {
        echo "Error al guardar el mensaje en el log.";
    }
} else {
    echo "Acceso denegado.";
}
?>
