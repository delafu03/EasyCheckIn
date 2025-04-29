// Definimos toggleValoracion en global
function toggleValoracion(id) {
    const contenedor = document.getElementById(id);
    contenedor.classList.toggle('activa');
}


// Cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
    // Botones Buscar
    document.querySelectorAll('.buscarBtn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id_usuario = this.dataset.idUsuario;
            const id_reserva = this.dataset.idReserva;
            const numero_documento_original = this.dataset.documentoOriginal;

            const dniInput = this.closest('fieldset').querySelector('.dniInput');
            const numero_documento = dniInput.value.trim();

            const formData = new FormData();
            formData.append('buscar_dni', '1');
            formData.append('numero_documento', numero_documento);
            formData.append('numero_documento_original', numero_documento_original);
            formData.append('id_usuario', id_usuario);
            formData.append('id_reserva', id_reserva);

            fetch('index.php?action=buscar_actualizar_usuario', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(html => {
                location.reload();
            })
            .catch(err => {
                console.error('Error al enviar los datos:', err);
            });
        });
    });

    // Transformar a mayúsculas en tiempo real
    document.querySelectorAll('.mayuscula').forEach(campo => {
        campo.addEventListener('input', () => {
            campo.value = campo.value.toUpperCase();
        });
    });

    // FAQs desplegables
    document.querySelectorAll(".faq-question").forEach(question => {
        question.addEventListener("click", function() {
            const answer = this.nextElementSibling;
            answer.style.display = (answer.style.display === "block") ? "none" : "block";
        });
    });

    // Script para manejar estrellas en cualquier formulario
    document.querySelectorAll('.estrellas .estrella').forEach(function(star) {
        star.addEventListener('click', function() {
            var valor = this.getAttribute('data-valor');
            var container = this.parentElement;
            var inputHidden = container.parentElement.querySelector('input[name="puntuacion"]');
            
            // Actualizar estrellas
            container.querySelectorAll('.estrella').forEach(function(s) {
                s.innerHTML = (s.getAttribute('data-valor') <= valor) ? '★' : '☆';
            });

            // Guardar puntuación
            inputHidden.value = valor;
        });
    });

});
