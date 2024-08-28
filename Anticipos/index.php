<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anticipos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .div1 {
            margin: 20px auto;
            max-width: 800px;
        }
        .tabla {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .tabla th, .tabla td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .text-center {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Conexión a la base de datos
        require '../bd.php';

        // Consulta para obtener el título y el valor formateado
        $sql = "SELECT Nombre, FORMAT(Valor, 0, 'de_DE') as ValorFormateado from titulos where ID=2;";
        $result = mysqli_query($conexion, $sql);

        while ($mostrar = mysqli_fetch_array($result)) {
        ?>
            <div class="div1 text-center">
                <h2><u><?php echo $mostrar['Nombre']  ?> = <?php echo $mostrar['ValorFormateado'] ?></u></h2>
            </div>
        <?php
        }
        ?>

        <div class="text-center">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#CrearA">
                Nuevo Anticipo
            </button>
        </div>

        <!-- Modal Crear Anticipo -->
        <?php include('ModalCrear.php'); ?>

        <div class="main-container div1">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Valor</th>
                        <th>Fecha</th>
                        <th colspan="2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Consulta para obtener anticipos
                    $sql = "SELECT ID, FORMAT(Valor, 0, 'de_DE') as Valor, Fecha FROM anticipos;";
                    $result = mysqli_query($conexion, $sql);

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
                        <!-- Ventana Modal para Actualizar -->
                        <?php include('ModalEditar.php'); ?>

                        <!-- Ventana Modal para la Alerta de Eliminar -->
                        <?php include('ModalDelete.php'); ?>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Archivos de JS de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.9/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
