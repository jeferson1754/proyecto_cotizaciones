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
                            <input type="number" class="form-control" step="10" name="valor_uni[]"
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

        <button type="button" class="btn btn-info " data-toggle="modal" data-target="#Crear">
            Nuevo Material
        </button>
        <button id="open-modal-button"  class="btn btn-success" onclick="openModal()">Crear Múltiples Materiales</button>
        <div id="myModal" class="modal">
            <div class="modal-content-crear">
                <span class="close" onclick="closeModal()">&times;</span>
                <div class="form-container">
                    <h1 style="text-align: center;">Crear Múltiples Materiales</h1>
                    <form id="create-materials-form" action="procesar_materiales.php" method="post">
                        <div id="materials-container">
                            <div class="material-input">
                                <input type="text" class="form-control" name="material[]" placeholder="Nombre del Material" required>
                                <input type="number" class="form-control" step="10" name="valor_uni[]" placeholder="Valor Uni." required oninput="calculateTotal(this)">
                                <input type="number" class="form-control" name="cantidad[]" placeholder="Cantidad" required oninput="calculateTotal(this)">
                                <input type="number" class="form-control" name="total[]" placeholder="00" disabled>
                                <button type="button" style="height: 38px;line-height: normal;" class="btn btn-danger" onclick="removeMaterialInput(this)" disabled="true">Eliminar</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" id="add-material-button" onclick="addMaterialInput()">Añadir Material</button>
                        <button type="submit" class="btn btn-info" id="create-materials-button">Crear Materiales</button>
                    </form>
                </div>
            </div>
        </div>
        <!--- 
        <button type="button" class="btn btn-info " data-toggle="modal" data-target="#Titulos">
            Cambiar Titulos
        </button>
        --->
        <a href="factura.php" target="_blank" class="btn btn-danger"><b>PDF</b> </a>
    </div>
    <?php

    include('ModalUpdate.php');
    include('ModalCrear.php');

    /*
    $sql = "SELECT Nombre, FORMAT (Valor, 0, 'de_DE') from titulos where ID=1;";
    $result = mysqli_query($conexion, $sql);
    //echo $sql;

    while ($mostrar = mysqli_fetch_array($result)) {
    ?>
        <br>
        <br>
        <div class="div1">
            <u>
                <h2><?php echo $mostrar['Nombre']  ?>=<?php echo $mostrar["FORMAT (Valor, 0, 'de_DE')"]  ?> </h2>
            </u>

        </div>

    <?php
    }

    */
    ?>

    <div class="main-container">

        <table>
            <thead>
                <tr>
                    <th class="nombre">Nombre</th>
                    <th>Valor</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <?php
            $sql = "SELECT * FROM `cotizar`;";
            $result = mysqli_query($conexion, $sql);
            //echo $sql;

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
            ?>
        </table>

        <?php
        $sql = "SELECT FORMAT(SUM(Total),0,'de_DE') FROM cotizar;";
        $result = mysqli_query($conexion, $sql);
        //echo $sql;

        while ($mostrar = mysqli_fetch_array($result)) {
        ?>
            <br>
            <br>
            <div class="div1">
                <h2>Suma Total: <?php echo $mostrar[0] ?> </h2>
            </div>



        <?php
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