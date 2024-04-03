
<?php
include 'bd.php';
$idRegistros  = $_POST['id'];
$valor      = $_REQUEST['valor'];
$fecha      = $_REQUEST['fecha'];

$update = ("UPDATE
anticipos 
SET 
Fecha ='" . $fecha . "',
Valor ='" . $valor . "'
WHERE ID='" . $idRegistros . "';
");

$result_update = mysqli_query($conexion, $update);

echo $update;

header("location:index.php");


?>
