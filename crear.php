<?php

require 'bd.php';
date_default_timezone_set('America/Santiago');
$fecha_actual = date('Y-m-d');


$sql_sum = "SELECT SUM(Total) FROM cotizar;";
$result_sum = mysqli_query($conexion, $sql_sum);

while ($mostrar_sum = mysqli_fetch_array($result_sum)) {
    $suma_total = $mostrar_sum[0];
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Cotizaciones</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --warning-color: #f9c74f;
            --danger-color: #e63946;
            --success-color: #2a9d8f;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }

        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background-color: var(--primary-color);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            color: white;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
            border: none;
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            font-weight: 600;
            padding: 1rem 1.5rem;
        }

        .action-buttons {
            margin-bottom: 1.5rem;
        }

        .btn-custom-primary {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .btn-custom-primary:hover {
            background-color: var(--secondary-color);
            color: white;
            transform: translateY(-2px);
        }

        .btn-custom-warning {
            background-color: var(--warning-color);
            color: var(--dark-color);
            border: none;
        }

        .btn-custom-warning:hover {
            background-color: #e9b949;
            transform: translateY(-2px);
        }

        .btn-custom-danger {
            background-color: var(--danger-color);
            color: white;
            border: none;
        }

        .btn-custom-danger:hover {
            background-color: #d62828;
            transform: translateY(-2px);
        }

        .table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .table thead {
            background-color: var(--primary-color);
            color: white;
        }

        .table th {
            font-weight: 600;
            padding: 1rem;
        }

        .table td {
            padding: 0.75rem 1rem;
            vertical-align: middle;
        }

        .table tr:nth-child(even) {
            background-color: rgba(67, 97, 238, 0.05);
        }

        .total-summary {
            background-color: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.08);
            margin-top: 1.5rem;
        }

        .total-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .material-input {
            display: grid;
            grid-template-columns: 3fr 1fr 1fr 1fr 1fr;
            gap: 10px;
            margin-bottom: 10px;
            align-items: center;
        }

        .mostrar-celu {
            display: none;
        }


        @media (max-width: 992px) {
            .material-input {
                grid-template-columns: 1fr;
            }

            .action-buttons .card-body {
                flex-direction: column;
                /* Alineación vertical en móvil */
                align-items: center;
                /* Centrar botones */
            }

            .action-buttons .btn {
                width: 100%;
                /* Ocupar todo el ancho disponible */
                text-align: center;
            }


            .mostrar-celu {
                display: flex;
            }

            .ocultar {
                display: none !important;
            }

            .table-responsive {
                overflow-x: auto;
                /* Permite desplazamiento horizontal */
                -webkit-overflow-scrolling: touch;
                /* Suaviza el desplazamiento en móviles */
            }

            table.table {
                width: 100%;
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            thead {
                display: none;
                /* Ocultar encabezado en móvil */
            }

            tbody,
            tr,
            td {
                display: block;
                width: 100%;
            }

            tr {
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 5px;
                padding: 10px;
                background: #fff;
            }

            td {
                text-align: center;
                padding: 8px;
                position: relative;
            }

            td:before {
                content: attr(data-label);
                font-weight: bold;
                display: block;
                margin-bottom: 5px;
                color: #333;
            }

            td:last-child {
                text-align: center;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start !important;
                text-align: left;
            }

            .input-group {
                width: 100% !important;
                /* Hace que la barra de búsqueda ocupe todo el ancho */
                margin-top: 10px;
            }

            .col-md-2 {
                margin-top: 10px;
            }

            .col-md-2 .btn {
                width: 100%;
                /* Ocupar todo el ancho disponible */
                text-align: center;
            }
        }

        .modal-content {
            border-radius: 12px;
            border: none;
        }

        .modal-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            background-color: var(--primary-color);
            color: white;
            border-radius: 12px 12px 0 0;
        }

        .modal-footer {
            border-top: 1px solid rgba(0, 0, 0, 0.08);
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-file-invoice-dollar me-2"></i>Sistema de Cotizaciones
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <!-- Action Buttons -->
        <div class="card action-buttons">
            <div class="card-body d-flex flex-wrap gap-2">
                <a href="./" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Atrás
                </a>
                <button type="button" class="btn btn-custom-warning" data-bs-toggle="modal" data-bs-target="#Nueva_Cotizacion">
                    <i class="fas fa-plus-circle me-1"></i> Nueva Cotización
                </button>
                <button type="button" class="btn btn-custom-primary" data-bs-toggle="modal" data-bs-target="#Crear">
                    <i class="fas fa-cube me-1"></i> Nuevo Material
                </button>
                <button type="button" class="btn btn-custom-primary" data-bs-toggle="modal" data-bs-target="#Crear2">
                    <i class="fas fa-cubes me-1"></i> Nuevos Materiales
                </button>
                <a href="base_pdf.php" class="btn btn-custom-danger mostrar">
                    <i class="fas fa-file-pdf me-1"></i> Visualizar Cotizacion
                </a>

            </div>
        </div>

        <!-- Materials Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Lista de Materiales</h5>
                <div class="input-group" style="max-width: 300px;">
                    <input type="search" id="searchInput" class="form-control" placeholder="Buscar material..." onkeyup="filtrarMateriales()">
                </div>
            </div>
            <div class="card-body">
                <?php
                $sql = "SELECT * FROM `cotizar`;";
                $result = mysqli_query($conexion, $sql);

                if (mysqli_num_rows($result) > 0) {
                ?>
                    <div class="table-responsive">
                        <table class="table table-hover" id="materialTable">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Valor Unitario</th>
                                    <th>Cantidad</th>
                                    <th>Total</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                function formatCurrency($value)
                                {
                                    return '$' . number_format($value, 0, ',', '.');
                                }

                                while ($mostrar = mysqli_fetch_array($result)) {
                                ?>
                                    <tr>
                                        <td data-label="Nombre" class="nombre"><?= htmlspecialchars($mostrar['Nombre']); ?></td>
                                        <td data-label="Valor Unitario"><?= formatCurrency($mostrar['Valor Unitario']); ?></td>
                                        <td data-label="Cantidad"><?= htmlspecialchars($mostrar['Cantidad']); ?></td>
                                        <td data-label="Total"><?= formatCurrency($mostrar['Total']); ?></td>
                                        <td data-label="Acciones" class="action-buttons">

                                            <div class="mostrar-celu card-body flex-wrap gap-2">
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editChildresn<?php echo $mostrar['ID']; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#editChildresn1<?php echo $mostrar['ID']; ?>">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>

                                            <div class="ocultar">
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editChildresn<?php echo $mostrar['ID']; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#editChildresn1<?php echo $mostrar['ID']; ?>">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>

                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="total-summary text-center">
                        <h5 class="mb-2">Suma Total</h5>
                        <div class="total-value">$<?php echo number_format($suma_total, 0, ',', '.'); ?>
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h4>Sin registros</h4>
                        <p class="text-muted">No hay materiales en la cotización actual</p>
                        <button type="button" class="btn btn-custom-primary" data-bs-toggle="modal" data-bs-target="#Crear">
                            <i class="fas fa-plus-circle me-1"></i> Agregar Material
                        </button>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>

        <script>
            function filtrarMateriales() {
                let input = document.getElementById("searchInput").value.toLowerCase();
                let filas = document.querySelectorAll("#materialTable tbody tr");

                filas.forEach(fila => {
                    let nombreMaterial = fila.querySelector(".nombre").textContent.toLowerCase();
                    fila.style.display = nombreMaterial.includes(input) ? "" : "none";
                });
            }
        </script>

    </div>

    <!-- Modals -->
    <?php
    include('ModalNueva_Cotizacion.php');
    include('ModalCrear.php');
    include('ModalCrear-Varios.php');
    ?>

    <!-- Edit and Delete Modals -->
    <?php
    if (isset($result) && mysqli_num_rows($result) > 0) {
        mysqli_data_seek($result, 0);
        while ($mostrar = mysqli_fetch_array($result)) {
            include('ModalEditar.php');
            include('ModalDelete.php');
        }
    }
    ?>

    <script>
        // Función para formatear el número como pesos chilenos
        function formatPesoChile(value) {
            value = value.replace(/\D/g, ''); // Eliminar todo lo que no sea un número
            return new Intl.NumberFormat('es-CL', {
                style: 'currency',
                currency: 'CLP'
            }).format(value);
        }

        // Obtener todos los campos de entrada con la clase 'monto_gasto'
        const montoInputs = document.querySelectorAll('.valor_formateado');

        // Evento para formatear el valor mientras el usuario escribe en cada campo
        montoInputs.forEach(function(montoInput) {
            montoInput.addEventListener('input', function() {
                let value = montoInput.value;
                montoInput.value = formatPesoChile(value); // Aplicar el formato de peso chileno
            });
        });
    </script>
    <script>
        function formatCurrency(input) {
            // Elimina caracteres no numéricos excepto el punto decimal
            let value = input.value.replace(/[^0-9.]/g, '');

            // Si hay más de un punto decimal, elimina los adicionales
            let parts = value.split('.');
            if (parts.length > 2) {
                value = parts[0] + '.' + parts.slice(1).join('');
            }
        }

        function parseCurrency(value) {
            return parseFloat(value.replace(/[^0-9.]/g, '')) || 0;
        }
    </script>


    <!-- Bootstrap 5 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>