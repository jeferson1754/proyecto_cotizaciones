
<?php
include 'bd.php';
$idRegistros  = $_POST['id'];
$nombre     = $_REQUEST['Nombre'];
$valor      = $_REQUEST['valor'];
$fecha      = $_REQUEST['fecha'];

$update = ("UPDATE
cotizar 
SET 
Nombre ='" . $nombre . "',
Fecha ='" . $fecha . "',
Valor ='" . $valor . "'
WHERE ID='" . $idRegistros . "';
");

$result_update = mysqli_query($conexion, $update);


header("location:index.php");


?>
