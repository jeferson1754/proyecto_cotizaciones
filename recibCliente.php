<?php
include('bd.php');
$nombre     = $_REQUEST['nombre'];
$valor = formatearMonto($_POST['valor']);
$cantidad   = $_REQUEST['cantidad'];

$total = $valor * $cantidad;

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql2 = "INSERT INTO `cotizar`( `Nombre`, `Valor Unitario`, `Cantidad`,`Total`)
    VALUES (
    '" . $nombre . "',
    '" . $valor . "',
    '" . $cantidad . "',
    '" . $total . "')";

    $conn->exec($sql2);

    echo $sql2;
    echo "<br>";
} catch (PDOException $e) {
    echo $sql2;
    $conn->exec($sql2);
}


header("location:crear.php");
