document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const id_reserva = urlParams.get('id_reserva');
    const usuariosContainer = document.getElementById("usuarios-container");

    if (id_reserva) {
        fetch(`getCheckInData.php?id_reserva=${id_reserva}`)
            .then(response => response.json())
            .then(usuarios => {
                if (usuarios.length === 0) {
                    usuariosContainer.innerHTML = "<p>No hay usuarios registrados para esta reserva.</p>";
                    return;
                }

                usuarios.forEach(usuario => {
                    const formHTML = `
                        <form class="form-container" data-id-usuario="${usuario.id_usuario}">
                            <input type="hidden" name="id_usuario" value="${usuario.id_usuario}">
                            <input type="hidden" name="id_reserva" value="${id_reserva}">

                            <div class="form-row">
                                <div class="form-group col-2">
                                    <label>Tipo de Documento</label>
                                    <select name="tipo_documento" class="tipo-documento">
                                        <option value="DNI" ${usuario.tipo_documento === "DNI" ? "selected" : ""}>DNI</option>
                                        <option value="Pasaporte" ${usuario.tipo_documento === "Pasaporte" ? "selected" : ""}>Pasaporte</option>
                                    </select>
                                </div>
                                <div class="form-group col-2">
                                    <label>Número de Documento</label>
                                    <input type="text" name="numero_documento" class="dni-input" value="${usuario.numero_documento || ''}">
                                </div>
                                <div class="form-group col-1">
                                    <label>&nbsp;</label>
                                    <button type="button" class="buscar-usuario btn btn-secondary">Buscar</button>
                                </div>
                                <div class="form-group col-2">
                                    <label>Fecha de Expedición</label>
                                    <input type="date" name="fecha_expedicion" value="${usuario.fecha_expedicion || ''}">
                                </div>
                                <div class="form-group col-2">
                                    <label>Número de Soporte</label>
                                    <input type="text" name="num_soporte" class="num-soporte" value="${usuario.num_soporte || ''}" disabled>
                                </div>
                                <div class="form-group col-2">
                                    <label>Relación de Parentesco</label>
                                    <input type="text" name="relacion_parentesco" class="relacion-parentesco" value="${usuario.relacion_parentesco || ''}" disabled>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-2">
                                    <label>Nombre</label>
                                    <input type="text" name="nombre" value="${usuario.nombre || ''}">
                                </div>
                                <div class="form-group col-4">
                                    <label>Apellidos</label>
                                    <input type="text" name="apellidos" value="${usuario.apellidos || ''}">
                                </div>
                                <div class="form-group col-2">
                                    <label>Fecha de Nacimiento</label>
                                    <input type="date" name="fecha_nacimiento" class="fecha-nacimiento" value="${usuario.fecha_nacimiento || ''}">
                                </div>
                                <div class="form-group col-2">
                                    <label>Nacionalidad</label>
                                    <input type="text" name="nacionalidad" value="${usuario.nacionalidad || ''}">
                                </div>
                                <div class="form-group col-2">
                                    <label>País</label>
                                    <input type="text" name="pais" class="pais-input" value="${usuario.pais || ''}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-4">
                                    <label>Dirección</label>
                                    <input type="text" name="direccion" value="${usuario.direccion || ''}">
                                </div>
                                <div class="form-group col-4">
                                    <label>Correo</label>
                                    <input type="email" name="correo" value="${usuario.correo || ''}">
                                </div>
                                <div class="form-group col-4">
                                    <label>&nbsp;</label>
                                    <button type="button" class="update-btn btn btn-primary" disabled>Actualizar</button>
                                </div>
                            </div>
                        </form>
                        <hr>
                    `;

                    usuariosContainer.innerHTML += formHTML;
                });

                agregarEventosFormulario();
            })
            .catch(error => console.error("Error al cargar los datos:", error));
    }

    function agregarEventosFormulario() {
        document.querySelectorAll(".form-container").forEach(form => {
            const tipoDocumento = form.querySelector(".tipo-documento");
            const dniInput = form.querySelector(".dni-input");
            const numSoporte = form.querySelector(".num-soporte");
            const paisInput = form.querySelector(".pais-input");
            const fechaNacimiento = form.querySelector(".fecha-nacimiento");
            const relacionParentesco = form.querySelector(".relacion-parentesco");
            const updateBtn = form.querySelector(".update-btn");

            form.addEventListener("input", () => validarCampos(form));
            form.querySelector(".buscar-usuario").addEventListener("click", () => buscarUsuario(form));
            form.querySelector(".update-btn").addEventListener("click", () => actualizarUsuario(form));

            function validarCampos(form) {
                const edad = calcularEdad(fechaNacimiento.value);
                dniInput.required = paisInput.value.toLowerCase() === "españa";

                if (dniInput.value) {
                    dniInput.setCustomValidity(validarDNI(dniInput.value) ? "" : "DNI inválido");
                }

                numSoporte.disabled = tipoDocumento.value !== "DNI";
                if (!numSoporte.disabled && numSoporte.value) {
                    const regex = /^[A-Z]{3}\d{6}$/;
                    numSoporte.setCustomValidity(regex.test(numSoporte.value.toUpperCase()) ? "" : "Debe tener 3 letras y 6 números.");
                }

                const deshabilitarDocumentos = edad < 14;
                tipoDocumento.disabled = deshabilitarDocumentos;
                dniInput.disabled = deshabilitarDocumentos;
                numSoporte.disabled = deshabilitarDocumentos;

                verificarParentesco();
                updateBtn.disabled = !form.checkValidity();
            }
        });
    }

    function calcularEdad(fechaNacimiento) {
        if (!fechaNacimiento) return 0;
        const hoy = new Date();
        const nacimiento = new Date(fechaNacimiento);
        let edad = hoy.getFullYear() - nacimiento.getFullYear();
        if (hoy.getMonth() < nacimiento.getMonth() || (hoy.getMonth() === nacimiento.getMonth() && hoy.getDate() < nacimiento.getDate())) {
            edad--;
        }
        return edad;
    }

    function validarDNI(dni) {
        const regex = /^[0-9]{8}[A-Z]$/;
        return regex.test(dni);
    }
});
