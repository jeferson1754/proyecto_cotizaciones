
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

echo $update;

/*
$local = "01:22:00";

$NuevaFecha = strtotime ( '-1 hour' , strtotime ($tiempo) ) ; 
$NuevaFecha = date ( 'H:i:s' , $NuevaFecha); 

echo "<br>";
echo $NuevaFecha;
echo "<br>";
echo $tiempo;
echo "<br>";
echo $local;
*/

echo "<script type='text/javascript'>
        window.location='index.php';
    </script>";


?>
