<?php include 'header.php';   // Incluir el header ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Reservas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Historial de Reservas</h1>
    </header>
    
    <div class="contenido">
        <h2>Reservas</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Reserva</th>
                    <th>Fecha Entrada</th>
                    <th>Fecha Salida</th>
                    <th>Estado</th>
                    <th>Servicios Contratados</th>
                </tr>
            </thead>
            <tbody id="historial-body">
                <!-- Los datos se insertarán aquí dinámicamente -->
            </tbody>
        </table>
    </div>

    <script>
        // Usar fetch para obtener los datos del historial desde el archivo PHP
        fetch("gestionHistorial.php")
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById("historial-body");

                if (data.error) {
                    tbody.innerHTML = `<tr><td colspan="5">${data.error}</td></tr>`;
                    return;
                }

                // Insertar los datos obtenidos en la tabla
                data.forEach(reserva => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${reserva.id_reserva}</td>
                        <td>${reserva.fecha_entrada}</td>
                        <td>${reserva.fecha_salida}</td>
                        <td>${reserva.estado.charAt(0).toUpperCase() + reserva.estado.slice(1)}</td>
                        <td>${reserva.servicios_contratados || 'Ninguno'}</td>
                    `;
                    tbody.appendChild(row);
                });
            })
            .catch(error => {
                console.error("Error al obtener el historial:", error);
                document.getElementById("historial-body").innerHTML = `<tr><td colspan="5">Error al cargar los datos</td></tr>`;
            });
    </script>

    <?php include 'footer.php';   // Incluir el footer ?>
</body>
</html>
