
<?php
include('bd.php');
$idRegistros = $_REQUEST['id'];


$update = ("DELETE FROM anticipos 
WHERE anticipos.ID='" .$idRegistros. "'
");
$result_update = mysqli_query($conexion, $update);

echo $update;

header("location:index.php");
?>
