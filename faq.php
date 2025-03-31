<?php
$faqs = [
    [
        'pregunta' => '¿Cómo puedo hacer una reserva?',
        'respuesta' => 'Para hacer una reserva, inicia sesión en tu cuenta, selecciona el hotel y las fechas que deseas, luego completa el formulario de reserva con tu información.'
    ],
    [
        'pregunta' => '¿Puedo cancelar mi reserva?',
        'respuesta' => 'La política de cancelación depende del tipo de reserva y el hotel. Para saber más, consulta las condiciones de cancelación en tu reserva.'
    ],
    [
        'pregunta' => '¿Cómo puedo modificar una reserva?',
        'respuesta' => 'Para modificar una reserva, accede a tu cuenta, busca la reserva que deseas cambiar y sigue los pasos para actualizar la información.'
    ],
    [
        'pregunta' => '¿Qué hago si no encuentro la habitación que quiero?',
        'respuesta' => 'Si no encuentras la habitación que deseas, puedes buscar en otros hoteles o fechas, o contactar con nuestro soporte para más opciones.'
    ],
    [
        'pregunta' => '¿Es seguro realizar mi pago a través de EasyCheckIn?',
        'respuesta' => 'Sí, EasyCheckIn utiliza encriptación de alta seguridad para proteger tus datos personales y de pago durante el proceso de reserva.'
    ],
    [
        'pregunta' => '¿Puedo pagar al hotel directamente?',
        'respuesta' => 'Algunos hoteles permiten pagar directamente en el hotel, pero otros requieren el pago anticipado a través de la plataforma. Verifica los detalles al momento de la reserva.'
    ],
    [
        'pregunta' => '¿Cómo puedo ver mis reservas anteriores?',
        'respuesta' => 'Puedes ver tus reservas anteriores en el apartado "Mis Reservas" de tu portal de usuario.'
    ],
    [
        'pregunta' => '¿Cómo añado una actividad extra a mi reserva?',
        'respuesta' => 'Accede a tu portal de usuario, selecciona la reserva y podrás agregar actividades extras disponibles durante tu estancia.'
    ]
];
?>

<div class="faq-container">
    <h1>Preguntas Frecuentes</h1>
    <?php foreach ($faqs as $faq): ?>
        <div class="faq-item">
            <button class="faq-question"><?php echo htmlspecialchars($faq['pregunta']); ?></button>
            <div class="faq-answer" style="display: none;">
                <p>
                    <?php echo htmlspecialchars($faq['respuesta']); ?>

                    <?php
                    $respuesta = $faq['respuesta'];
                    if (strpos($respuesta, 'reservas') !== false) {
                        echo ' <a href="index.php?action=reservas">Ver mis reservas</a>';
                    } elseif (strpos($respuesta, 'actividad') !== false) {
                        echo ' <a href="index.php?action=actividades">Añadir una actividad</a>';
                    } elseif (strpos($respuesta, 'historial') !== false) {
                        echo ' <a href="index.php?action=historial">Ver mi historial de reservas</a>';
                    } elseif (strpos($respuesta, 'inicia sesión') !== false) {
                        echo ' <a href="index.php?action=login">Inicia sesión Aquí</a>';
                    }
                    ?>
                </p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script src="<?php echo RUTA_JS; ?>funciones_aux.js"></script>