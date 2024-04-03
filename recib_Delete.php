
<?php
include('bd.php');
$idRegistros = $_REQUEST['id'];


$update = ("DELETE FROM cotizar 
WHERE cotizar.ID='" .$idRegistros. "'
");
$result_update = mysqli_query($conexion, $update);

echo $update;

header("location:index.php");
?>
