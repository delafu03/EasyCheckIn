<?php
require_once 'includes/config.php';

require_once 'includes/clases/Formulario.php';
require_once 'includes/clases/Database.php';

require_once 'includes/clases/usuarios/Usuario.php';
require_once 'includes/clases/usuarios/UsuarioModelo.php';
require_once 'includes/clases/usuarios/FormularioLogin.php';
require_once 'includes/clases/usuarios/FormularioRegister.php';
require_once 'includes/clases/usuarios/formularioEditar.php';


require_once 'includes/clases/checkin/CheckIn.php';
require_once 'includes/clases/checkin/CheckInModelo.php';
require_once 'includes/clases/checkin/FormularioCheckIn.php';
require_once 'includes/clases/checkin/perfilContenido.php';


require_once 'includes/clases/reserva/Reserva.php';
require_once 'includes/clases/reserva/ReservaModelo.php';
require_once 'includes/clases/reserva/FormularioReserva.php';

require_once 'includes/clases/valoraciones/Valoraciones.php';
require_once 'includes/clases/valoraciones/Valoracion.php';
require_once 'includes/clases/valoraciones/FormularioValoraciones.php';

require_once 'includes/clases/actividades/Actividades.php';
require_once 'includes/clases/actividades/Servicio.php';


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
    case 'admin':
        $tituloPagina = 'Administración';
        $vista = 'admin.php';
        break;
    case 'faq':
        $tituloPagina = 'Preguntas Frecuentes';
        $vista = 'faq.php';
        break;
    case 'actividades':
        $id_reserva = $_POST['id_reserva'] ?? $_GET['id_reserva'] ?? null;
        if ($id_reserva) {
            (new Actividades())->mostrarActividades();
        }
        exit;
    case 'contratar_actividad':
        $id_reserva = $_POST['id_reserva'] ?? $_GET['id_reserva'] ?? null;
        $id_servicio = $_POST['id_servicio'] ?? $_GET['id_servicio'] ?? null;

        if ($id_reserva && $id_servicio) {
            $actividades = new Actividades();
            $exito = $actividades->contratarActividad((int)$id_reserva, (int)$id_servicio);
            header("Location: index.php?action=actividades&id_reserva=$id_reserva");
        } else {
            (new Actividades())->mostrarActividades();
        }
        exit;

    case 'eliminar_actividad':
        $id_reserva = $_GET['id_reserva'] ?? null;
        $id_servicio = $_GET['id_servicio'] ?? null;
    
        if ($id_reserva && $id_servicio) {
            $actividades = new Actividades();
            $exito = $actividades->eliminarActividad((int)$id_reserva, (int)$id_servicio);
            header("Location: index.php?action=actividades&id_reserva=$id_reserva");
        } else {
            header("Location: index.php?action=actividades&error=param");
        }
        exit;
        
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
    case 'valoraciones':
        (new Reserva())->mostrarReservasValoracion();
        exit;
    case 'reserva_vacia':
        (new Reserva())->procesarCrearReservaVacia();
        exit;
    case 'checkin':
        $id_reserva = $_POST['id_reserva'] ?? $_GET['id_reserva'] ?? null;
        if ($id_reserva) {
            (new CheckIn())->mostrarFormulario($id_reserva);
        }
        exit;
    case 'buscar_actualizar_usuario':
        (new CheckIn())->buscarYActualizarUsuario();
        exit;
    case 'register':
        $tituloPagina = 'Registro';
        $vista = 'register.php';
        break;
    case 'login':
        $tituloPagina = 'Iniciar Sesión';
        $vista = 'login.php'; 
        break;
    case 'editarPerfil': 
        $tituloPagina = 'Editar Perfil';
        $vista = 'editarPerfil.php'; 
        break;

    case 'valoraciones_admin':
        (new Valoraciones())->mostrarValoraciones();
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
