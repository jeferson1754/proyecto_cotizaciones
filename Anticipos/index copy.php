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