<?php
require_once 'includes/Database.php';
require_once 'includes/Usuario.php';
require_once 'includes/Reserva.php';
require_once 'includes/CheckIn.php';
require_once 'includes/Formulario.php';
require_once 'includes/FormularioLogin.php';
require_once 'includes/FormularioRegister.php';
require_once 'config.php';

$action = $_GET['action'] ?? 'home';
$id_reserva = $_GET['id_reserva'] ?? null;

$tituloPagina = 'EasyCheckIn';
$vista = null;

switch ($action) {
    case 'home':
        $tituloPagina = 'Inicio';
        $vista = 'home.php';
        break;
    case 'contacto':
        $tituloPagina = 'Contacto';
        $vista = 'contacto.php';
        break;
    case 'alojamiento':
        $tituloPagina = 'Alojamientos';
        $vista = 'alojamiento.php';
        break;
    case 'portal':
        $tituloPagina = 'Portal';
        $vista = 'portal.php';
        break;
    case 'actividades':
        $tituloPagina = 'Actividades';
        $vista = 'actividades.php';
        break;
    case 'admin':
        $tituloPagina = 'Administración';
        $vista = 'admin.php';
        break;
    case 'faq':
        $tituloPagina = 'Preguntas Frecuentes';
        $vista = 'faq.php';
        break;
    case 'reservas_admin':
        if (isset($_POST['action']) && $_POST['action'] === 'eliminar_reserva') {
            $id_reserva = $_POST['id_reserva'] ?? null;
            if ($id_reserva) {
                (new Reserva())->eliminarReserva($id_reserva);
                header('Location: index.php?action=reservas_admin&status=success');
            }
        }
        else
            (new Reserva())->mostrarTodasReservas();
        exit;
    case 'usuarios_admin':
        if (isset($_POST['action']) && $_POST['action'] === 'eliminar_usuario') {
            $id_usuario = $_POST['id_usuario'] ?? null;
            if ($id_usuario) {
                (new Usuario())->eliminarUsuario($id_usuario);
                header('Location: index.php?action=usuarios_admin&status=success');
            }
        }
        else
            (new Usuario())->mostrarUsuarios();
        exit;
    case 'reservas':
        (new Reserva())->mostrarReservas();
        exit;
    case 'checkin':
        $id_reserva = $_POST['id_reserva'] ?? $_GET['id_reserva'] ?? null; // Verificar en POST y GET
        if ($id_reserva) {
            (new CheckIn())->mostrarFormulario($id_reserva);
        }
        exit;
    case 'buscar_actualizar_usuario':
        (new CheckIn())->buscarYActualizarUsuario();
        exit;
    case 'procesar_checkin':
        (new CheckIn())->procesarFormulario();
        exit;
    case 'register':
        $tituloPagina = 'Registro';
        $vista = 'register.php';
        break;
    case 'login':
        $tituloPagina = 'Iniciar Sesión';
        $vista = 'login.php'; 
        break;
    case 'logout':
        (new Usuario())->procesar_logout();
        exit;
    default:
        $tituloPagina = 'Error';
        $vista = 'error404.php';
        break;
}

if ($vista !== null) {
    include 'includes/views/plantillas/plantilla.php';
}
?>
