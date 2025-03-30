document.addEventListener("DOMContentLoaded", () => {

    // === VALIDACIÓN DE DNI ===
    const dniInputs = document.querySelectorAll(".dniInput");
    dniInputs.forEach(input => {
        input.addEventListener("input", function () {
            const dni = this.value.toUpperCase();
            const regex = /^[0-9]{8}[A-Z]$/;

            this.value = dni;

            if (regex.test(dni)) {
                const numero = dni.slice(0, 8);
                const letra = dni.slice(8, 9);
                const letras = "TRWAGMYFPDXBNJZSQVHLCKE";
                const letraEsperada = letras[numero % 23];

                if (letra === letraEsperada) {
                    this.style.borderColor = "green";
                    this.title = "";
                } else {
                    this.style.borderColor = "red";
                    this.title = `La letra del DNI no coincide.`;
                }
            } else {
                this.style.borderColor = "red";
                this.title = "DNI inválido";
            }

            const hidden = this.closest("form").querySelector(".dniHidden");
            if (hidden) hidden.value = dni;
        });
    });

    // === VALIDACIÓN DE NÚMERO DE SOPORTE ===
    const soporteInputs = document.querySelectorAll(".numSoporte");
    soporteInputs.forEach(input => {
        input.addEventListener("input", function () {
            const valor = this.value.toUpperCase();
            const regex = /^[A-Z]{3}[0-9]{6}$/;

            this.value = valor;

            if (regex.test(valor)) {
                this.style.borderColor = "green";
                this.title = "";
            } else {
                this.style.borderColor = "red";
                this.title = "Número de soporte inválido.";
            }
        });
    });

    // === VALIDACIÓN DE CORREO ===
    const correoInputs = document.querySelectorAll(".correoInput");
    correoInputs.forEach(input => {
        input.addEventListener("input", function () {
            const correo = this.value.trim();
            const regex = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;

            if (regex.test(correo)) {
                this.style.borderColor = "green";
                this.title = "";
            } else {
                this.style.borderColor = "red";
                this.title = "Correo electrónico inválido.";
            }
        });
    });

    // === VALIDACIÓN EN TIEMPO REAL DE EDAD ===
    const fechaNacInputs = document.querySelectorAll(".fechaNacimiento");
    fechaNacInputs.forEach(input => {
        const validarEdad = () => {
            const fechaNac = new Date(input.value);
            if (isNaN(fechaNac)) return;

            const hoy = new Date();
            let edad = hoy.getFullYear() - fechaNac.getFullYear();
            const m = hoy.getMonth() - fechaNac.getMonth();
            if (m < 0 || (m === 0 && hoy.getDate() < fechaNac.getDate())) {
                edad--;
            }

            const form = input.closest("form");

            const tipoDocumento = form.querySelector(".tipoDocumento");
            const fechaExpedicion = form.querySelector(".fechaExpedicion");
            const numSoporte = form.querySelector(".numSoporte");
            const dniInput = form.querySelector(".dniInput");

            if (edad < 14) {
                if (tipoDocumento) tipoDocumento.disabled = true;
                if (fechaExpedicion) fechaExpedicion.disabled = true;
                if (numSoporte) numSoporte.disabled = true;
                if (dniInput) dniInput.disabled = true;
            } else {
                if (tipoDocumento) tipoDocumento.disabled = false;
                if (fechaExpedicion) fechaExpedicion.disabled = false;
                if (numSoporte) numSoporte.disabled = false;
                if (dniInput) dniInput.disabled = false;
            }
        };
        input.addEventListener("change", validarEdad);
        validarEdad();
    });

});
