<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="contenido">
    <p><strong>EasyCheckIn</strong> es una plataforma digital que agiliza el check-in y mejora la experiencia en alojamientos, 
    ofreciendo comodidad a huéspedes y eficiencia a administradores. 
    Nuestra solución integral ha sido diseñada para transformar el proceso de llegada en una experiencia rápida y sin complicaciones, 
    eliminando largas esperas y simplificando la gestión administrativa.</p>
</div>

<img src="<?php echo RUTA_IMGS; ?>hotel.png" alt="HOTEL" class="foto-index">

<?php if (isset($_SESSION["usuario_id"])): ?>
    <div class="contenido">
        <p><strong>¡BIENVENIDO <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</strong> a EasyCheckIn</p>
    </div>
<?php else: ?>
    <div class="contenido">
        <p>Inicia sesión para acceder a contenido exclusivo sobre alojamientos, reservas y actividades.</p>
    </div>
<?php endif; ?>