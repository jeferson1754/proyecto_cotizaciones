<?php

require 'bd.php';
date_default_timezone_set('America/Santiago');
$fecha_actual = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="./css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.css?v=<?php echo time(); ?>">

    <script>
        function addMaterialInput() {
            const container = document.getElementById('materials-container');
            const newMaterialInput = document.createElement('div');
            newMaterialInput.classList.add('material-input');
            newMaterialInput.innerHTML = `
            <input type="text" class="form-control" name="material[]" placeholder="Nombre del Material" required>
                            <input type="number" class="form-control" name="valor_uni[]"
                                placeholder="Valor Uni." required oninput="calculateTotal(this)">
                            <input type="number" class="form-control" name="cantidad[]" placeholder="Cantidad" required
                                oninput="calculateTotal(this)">
                            <input type="number" class="form-control" name="total[]" placeholder="00" disabled>
                            <button type="button" style="height: 38px;line-height: normal;" class="btn btn-danger"
                                onclick="removeMaterialInput(this)">Eliminar</button>
            `;
            container.appendChild(newMaterialInput);
        }

        function removeMaterialInput(button) {
            const materialInput = button.parentElement;
            materialInput.remove();
        }

        function calculateTotal(element) {
            const materialInput = element.parentElement;
            const valorUniInput = materialInput.querySelector('input[name="valor_uni[]"]');
            const cantidadInput = materialInput.querySelector('input[name="cantidad[]"]');
            const totalInput = materialInput.querySelector('input[name="total[]"]');

            const valorUni = parseFloat(valorUniInput.value) || 0;
            const cantidad = parseFloat(cantidadInput.value) || 0;
            const total = valorUni * cantidad;

            totalInput.value = total;
        }

        // Modal functions
        function openModal() {
            document.getElementById('myModal').style.display = "block";
        }

        function closeModal() {
            document.getElementById('myModal').style.display = "none";
        }

        // Close the modal when clicking outside of the modal
        window.onclick = function(event) {
            if (event.target == document.getElementById('myModal')) {
                closeModal();
            }
        }
    </script>

    <title>Aplicacion Cotizacion</title>
</head>


<body>
    <div class="col-sm text-center">
        <!--- Formulario para registrar Cliente --->

        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#Nueva_Cotizacion">
            Nueva Cotizacion
        </button>

        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#Crear">
            Nuevo Material
        </button>
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#Crear2">
            Nuevo Materiales
        </button>

        <a href="factura.php" target="_blank" class="btn btn-danger ocultar"><b>PDF</b> </a>

        <a href="base_pdf.php" target="_blank" class="btn btn-danger mostrar"><b>PDF</b> </a>

    </div>
    <?php
    include('ModalCrear.php');
    include('ModalNueva_Cotizacion.php');
    include('ModalCrear-Varios.php');
    ?>

<div class="main-container">
    <?php
    $sql = "SELECT * FROM `cotizar`;";
    $result = mysqli_query($conexion, $sql);

    // Verificar si hay registros
    if (mysqli_num_rows($result) > 0) {
        echo "<table>
            <thead>
                <tr>
                    <th class='nombre'>Nombre</th>
                    <th>Valor</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th colspan='2'>Acciones</th>
                </tr>
            </thead>";

        while ($mostrar = mysqli_fetch_array($result)) {
            ?>
            <tr>
                <td class="nombre"><?php echo $mostrar['Nombre'] ?></td>
                <td><?php echo '$' . number_format($mostrar['Valor Unitario'], 0, ',', '.'); ?></td>
                <td><?php echo $mostrar['Cantidad'] ?></td>
                <td><?php echo '$' . number_format($mostrar['Total'], 0, ',', '.'); ?></td>
                <td>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editChildresn<?php echo $mostrar['ID']; ?>">
                        Editar
                    </button>

                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#editChildresn1<?php echo $mostrar['ID']; ?>">
                        Eliminar
                    </button>
                </td>
            </tr>
            <!--Ventana Modal para Actualizar--->
            <?php include('ModalEditar.php'); ?>

            <!--Ventana Modal para la Alerta de Eliminar--->
            <?php include('ModalDelete.php'); ?>
            <?php
        }
        echo "</table>";

        // Mostrar la suma total
        $sql_sum = "SELECT FORMAT(SUM(Total),0,'de_DE') FROM cotizar;";
        $result_sum = mysqli_query($conexion, $sql_sum);

        while ($mostrar_sum = mysqli_fetch_array($result_sum)) {
            ?>
            <br><br>
            <div class="div1">
                <h2><?php echo "Suma Total: $" . $mostrar_sum[0] ?> </h2>
            </div>
            <?php
        }
    } else {
        // Si no hay registros, mostrar "Sin registros"
        echo " <div class='div1'><h2>Sin registros</h2></div>";
    }
    ?>
</div>


    <br>

    <br>
    <br>

</body>
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>



</html>