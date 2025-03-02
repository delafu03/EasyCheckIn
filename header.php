<?php session_start(); ?>
<header> 
    <h1>EasyCheckIn</h1>
    <nav>
        <ul class="navegacion"> 
            <li><a href="detalles.html">Detalles</a></li>
            <li>|</li>
            <li><a href="bocetos.html">Bocetos</a></li>
            <li>|</li>
            <li><a href="miembros.html">Miembros</a></li>
            <li>|</li>
            <li><a href="planificacion.html">Planificación</a></li>
            <li>|</li>
            <li><a href="contacto.html">Contacto</a></li>
        </ul>
    </nav>

    <?php if (isset($_SESSION["login"]) ): ?>
        <a href="logout.php" class="btn-logout">Logout</a>
    <?php else: ?>
        <a href="login.php" class="btn-login">Login</a>
    <?php endif; ?>
</header>
