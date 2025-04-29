<?php
class FormularioValoraciones extends Formulario
{
    private $idReserva;

    public function __construct($idReserva) {
        $this->idReserva = $idReserva;
        parent::__construct('formValoracion_' . $idReserva, [
            'urlRedireccion' => 'index.php?action=valoraciones'
        ]);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $idUsuario = $_SESSION['usuario_id'];

        $valoracionModel = new Valoraciones();
        $valoracionExistente = $valoracionModel->obtenerValoracion($idUsuario, $this->idReserva);
    
        $comentario = $valoracionExistente['comentario'] ?? '';
        $puntuacion = $valoracionExistente['puntuacion'] ?? '';

        $html = '
            <input type="hidden" name="id_reserva" value="' . htmlspecialchars($this->idReserva) . '">
            <textarea name="comentario" placeholder="Escribe tu comentario..." required>' . htmlspecialchars($comentario) . '</textarea>
            <div class="estrellas" id="estrellas-' . htmlspecialchars($this->idReserva) . '">';

            for ($i = 1; $i <= 5; $i++) {
                $rellena = ($i <= $puntuacion) ? 'rellena' : '';
                $starChar = '★';
                $html .= '<span class="estrella ' . $rellena . '" data-valor="' . $i . '">' . $starChar . '</span>';
            }

        $html .= '
            </div>
            <input type="hidden" name="puntuacion" id="puntuacion-' . htmlspecialchars($this->idReserva) . '" value="' . htmlspecialchars($puntuacion) . '" required>
            <br>
            <button type="submit" class="btn">Enviar Valoración</button>
            <script>
                document.querySelectorAll("#estrellas-' . htmlspecialchars($this->idReserva) . ' .estrella").forEach(function(star) {
                    star.addEventListener("click", function() {
                        var valor = this.getAttribute("data-valor");
                        var container = this.parentElement;
                        var inputHidden = document.getElementById("puntuacion-' . htmlspecialchars($this->idReserva) . '");
                        
                        container.querySelectorAll(".estrella").forEach(function(s) {
                            s.innerHTML = (s.getAttribute("data-valor") <= valor) ? "★" : "☆";
                        });
                        
                        inputHidden.value = valor;
                    });
                });
            </script>
        ';

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $idReserva = trim($datos['id_reserva'] ?? '');
        $comentario = trim($datos['comentario'] ?? '');
        $puntuacion = trim($datos['puntuacion'] ?? '');

        // Validaciones
        if (empty($idReserva)) {
            $this->errores[] = 'No se ha indicado la reserva.';
        }

        if (empty($comentario)) {
            $this->errores[] = 'El comentario no puede estar vacío.';
        }

        if (!is_numeric($puntuacion) || $puntuacion < 1 || $puntuacion > 5) {
            $this->errores[] = 'La puntuación debe ser un número entre 1 y 5.';
        }

        if (count($this->errores) === 0) {
            $valoracion = new Valoraciones();
            $id_usuario = $_SESSION['usuario_id'];

            if ($valoracion->guardarValoracion($id_usuario, $this->idReserva, $comentario, $puntuacion)) {
                return 'Valoración guardada con éxito.';
            } else {
                $this->errores[] = 'Error al guardar la valoración. Por favor, inténtalo de nuevo.';
            }
        } else {
            return $this->errores;
        }
    }
}
?>