<?php

require 'bd.php';

// Consulta SQL para obtener las cotizaciones
$sql = "SELECT cotizacion_clientes.*, clientes_cotizacion.Nombre FROM `cotizacion_clientes` INNER JOIN clientes_cotizacion ON clientes_cotizacion.ID = cotizacion_clientes.ID_Cliente ORDER BY `cotizacion_clientes`.`Fecha_Cotizacion`DESC, `cotizacion_clientes`.`ID` DESC;";
$resultado = $conexion->query($sql);

$datos = [];

if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {

        // Agregar la cotización al array
        $datos[] = [
            "id" => $fila["ID"],
            "cliente" => $fila["Nombre"],
            "fecha" => $fila["Fecha_Cotizacion"],
            "monto" => (float) $fila["Total_General"]
        ];
    }
}

// Cerrar conexión
$conexion->close();

json_encode($datos, JSON_PRETTY_PRINT);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Cotizaciones</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .cotizacion-card {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            background-color: white;
            cursor: pointer;
        }

        .cotizacion-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .cotizacion-id {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: var(--primary-color);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
            z-index: 10;
        }

        .cotizacion-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .cotizacion-details {
            padding: 15px;
        }

        .cotizacion-cliente {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 5px;
        }

        .cotizacion-fecha {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .cotizacion-monto {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--accent-color);
        }

        .page-title {
            color: var(--secondary-color);
            border-bottom: 3px solid var(--primary-color);
            padding-bottom: 10px;
            margin-bottom: 30px;
        }

        .filtro-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .ver-mas {
            position: absolute;
            bottom: 15px;
            right: 15px;
            background-color: var(--primary-color);
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.9rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .cotizacion-card:hover .ver-mas {
            opacity: 1;
        }

        @media (max-width: 768px) {
            .cotizacion-image {
                height: 150px;
            }

            .cotizacion-details {
                padding: 10px;
            }

            .cotizacion-cliente {
                font-size: 1rem;
            }

            .cotizacion-monto {
                font-size: 1.2rem;
            }

            .ver-mas {
                opacity: 1;
                position: static;
                display: block;
                text-align: center;
                margin-top: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <h1 class="page-title text-center mb-5">
            <i class="fas fa-file-invoice-dollar me-2"></i>Sistema de Cotizaciones
        </h1>

        <div class="filtro-container mb-4">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" id="buscar" class="form-control" placeholder="Buscar cliente...">
                    </div>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <select id="ordenar" class="form-select">
                        <option value="reciente">Más reciente</option>
                        <option value="antiguo">Más antiguo</option>
                        <option value="monto-alto">Mayor monto</option>
                        <option value="monto-bajo">Menor monto</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <div class="d-flex justify-content-md-end">
                        <button id="btn-nueva-cotizacion" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Nueva Cotización
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4" id="cotizaciones-grid">
            <!-- Las cotizaciones se generarán dinámicamente aquí -->
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Obtener cotizaciones desde PHP y asegurarse de que sean interpretadas correctamente en JavaScript
        const cotizaciones = <?php echo json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); ?>;

        // Verificar si hay cotizaciones o si se recibió un mensaje en lugar de un array
        if (Array.isArray(cotizaciones) && cotizaciones.length > 0) {
            mostrarCotizaciones(cotizaciones);
        } else {
            document.getElementById('cotizaciones-grid').innerHTML = `
                <div class="alert alert-warning text-center">
                    ${cotizaciones.mensaje ?? "No hay cotizaciones disponibles en este momento."}
                </div>
            `;
        }

        // Función para formatear la fecha
        function formatearFecha(fecha) {
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            return new Date(fecha).toLocaleDateString('es-CL', options);
        }

        // Función para formatear el monto
        function formatearMonto(monto) {
            return new Intl.NumberFormat('es-CL', {
                style: 'currency',
                currency: 'CLP'
            }).format(monto);
        }

        // Función para generar el HTML de cada cotización
        function generarCotizacionHTML(cotizacion) {
            return `
                <div class="col-md-6 col-lg-4 cotizacion-item">
                    <div class="cotizacion-card" onclick="irADetalleCotizacion('${cotizacion.id}')">
                        <span class="cotizacion-id">COT-${cotizacion.id}</span>
                        <div class="cotizacion-details">
                            <div class="cotizacion-cliente">${cotizacion.cliente}</div>
                            <div class="cotizacion-fecha">${formatearFecha(cotizacion.fecha)}</div>
                            <div class="cotizacion-monto">${formatearMonto(cotizacion.monto)}</div>
                            <div class="ver-mas">Ver detalles <i class="fas fa-arrow-right ms-1"></i></div>
                        </div>
                    </div>
                </div>
            `;
        }

        // Función para mostrar las cotizaciones
        function mostrarCotizaciones(cotizacionesArr) {
            const gridContainer = document.getElementById('cotizaciones-grid');
            gridContainer.innerHTML = '';

            if (cotizacionesArr.length === 0) {
                gridContainer.innerHTML = '<div class="col-12 text-center py-5"><h3>No se encontraron cotizaciones</h3></div>';
                return;
            }

            cotizacionesArr.forEach(cotizacion => {
                gridContainer.innerHTML += generarCotizacionHTML(cotizacion);
            });
        }

        // Función para buscar cotizaciones
        function buscarCotizaciones() {
            const textoBusqueda = document.getElementById('buscar').value.toLowerCase();
            const cotizacionesFiltradas = cotizaciones.filter(cotizacion =>
                cotizacion.cliente.toLowerCase().includes(textoBusqueda) ||
                cotizacion.id.toLowerCase().includes(textoBusqueda)
            );
            mostrarCotizaciones(cotizacionesFiltradas);
        }

        // Función para ordenar cotizaciones
        function ordenarCotizaciones() {
            const criterio = document.getElementById('ordenar').value;
            let cotizacionesOrdenadas = [...cotizaciones];

            switch (criterio) {
                case 'reciente':
                    cotizacionesOrdenadas.sort((a, b) => new Date(b.fecha) - new Date(a.fecha));
                    break;
                case 'antiguo':
                    cotizacionesOrdenadas.sort((a, b) => new Date(a.fecha) - new Date(b.fecha));
                    break;
                case 'monto-alto':
                    cotizacionesOrdenadas.sort((a, b) => b.monto - a.monto);
                    break;
                case 'monto-bajo':
                    cotizacionesOrdenadas.sort((a, b) => a.monto - b.monto);
                    break;
            }

            mostrarCotizaciones(cotizacionesOrdenadas);
        }

        // Función para ir a la página de detalle de cotización
        function irADetalleCotizacion(idCotizacion) {
            // En una aplicación real, aquí redirigirías a la página de detalle
            window.location.href = `cotizaciones.php?id=${idCotizacion}`;


        }

        // Event listeners
        document.getElementById('buscar').addEventListener('input', buscarCotizaciones);
        document.getElementById('ordenar').addEventListener('change', ordenarCotizaciones);
        document.getElementById('btn-nueva-cotizacion').addEventListener('click', () => {
            window.location.href = `crear.php`;
        });

    </script>
</body>

</html>