<?php
include 'bd.php';

$idRegistros = $_POST['id'];
$nombre = $_POST['nombre'];
$valor = $_POST['valor'];

for ($i = 0; $i < count($idRegistros); $i++) {
    $update = "UPDATE titulos 
               SET Nombre = '" . $nombre[$i] . "', Valor = '" . $valor[$i] . "'
               WHERE ID = '" . $idRegistros[$i] . "'";

    $result_update = mysqli_query($conexion, $update);

    echo $update . "<br>";
}

header("location:index.php");
