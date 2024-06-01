
<?php
include 'bd.php';
$idRegistros  = $_POST['id'];
$nombre     = $_REQUEST['nombre'];
$valor      = $_REQUEST['valor'];
$cantidad   = $_REQUEST['cantidad'];

$total = $valor * $cantidad;

$update = ("UPDATE
cotizar 
SET 
`Nombre` ='" . $nombre . "',
`Valor Unitario` ='" . $valor . "',
`Cantidad` ='" . $cantidad . "',
`Total` ='" . $total . "'
WHERE ID='" . $idRegistros . "';
");

$result_update = mysqli_query($conexion, $update);


header("location:index.php");


?>
