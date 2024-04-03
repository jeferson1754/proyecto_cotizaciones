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
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.css">

    <title>Aplicacion Cotizacion
    </title>
</head>
<style>
    .div1 {
        text-align: center;
    }

    .main-container {
        margin: 30px 20px auto !important;
    }

    .tabla {
        width: 30%;
        margin: auto;
    }

    @media screen and (max-width: 600px) {
        .tabla {
            width: 100%;
        }


    }
</style>

<body>
    <div class="col-sm text-center">
        <!--- Formulario para registrar Cliente --->

        <button type="button" class="btn btn-info " data-toggle="modal" data-target="#Crear">
            Nuevo Material
        </button>


        <button type="button" class="btn btn-info " data-toggle="modal" data-target="#Titulos">
            Cambiar Titulos
        </button>
        <a href="factura.php" class="btn btn-primary"><b>PDF</b> </a>
    </div>
    <?php

    include('ModalUpdate.php');
    include('ModalCrear.php');

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
    ?>

    <div class="main-container">

        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Valor</th>
                    <th>Fecha de Compra</th>
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
                    <td><?php echo $mostrar['Nombre'] ?></td>
                    <td><?php echo $mostrar['Valor'] ?></td>
                    <td><?php echo $mostrar['Fecha'] ?></td>
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
        $sql = "SELECT FORMAT(SUM(Valor),0,'de_DE') FROM cotizar;";
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
    <?php
    $sql = "SELECT Nombre, FORMAT (Valor, 0, 'de_DE') from titulos where ID=2;";
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
    ?>
    <br>
    <div class="text-center">
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#CrearA">
            Nuevo Anticipo
        </button>
    </div>

    <?php include('ModalCrear copy.php');  ?>
    <div class="main-container div1">

        <table class="tabla">
            <thead>
                <tr>

                    <th>Valor</th>
                    <th>Fecha</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <?php
            $sql = "SELECT ID, Valor,Fecha FROM `anticipos`;";
            $result = mysqli_query($conexion, $sql);
            //echo $sql;

            while ($mostrar = mysqli_fetch_array($result)) {
            ?>
                <tr>

                    <td><?php echo $mostrar['Valor'] ?></td>
                    <td><?php echo $mostrar['Fecha'] ?></td>
                    <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Anticipos<?php echo $mostrar['ID']; ?>">
                            Editar
                        </button>

                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#Anticiposos<?php echo $mostrar['ID']; ?>">
                            Eliminar
                        </button>
                    </td>
                </tr>
                <!--Ventana Modal para Actualizar--->
                <?php include('ModalEditar copy.php'); ?>

                <!--Ventana Modal para la Alerta de Eliminar--->
                <?php include('ModalDelete copy.php'); ?>
            <?php
            }
            ?>
        </table>

    </div>
    <br>
    <br>

</body>
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<script>
    //Funciona
    function alerta() {
        Swal.fire({
            title: 'How old are you?',
            icon: 'question',
            input: 'range',
            inputLabel: 'Your age',
            inputAttributes: {
                min: 8,
                max: 120,
                step: 1
            },
            inputValue: 25
        })

    }
</script>


</html>