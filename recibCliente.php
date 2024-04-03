<?php
include('bd.php');
$nombre     = $_REQUEST['nombre'];
$valor      = $_REQUEST['valor'];
$fecha      = $_REQUEST['fecha'];

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql2 = "INSERT INTO `cotizar`( `Nombre`, `Valor`, `Fecha`)
    VALUES (
    '" . $nombre . "',
    '" . $valor . "',
    '" . $fecha . "')";

    $conn->exec($sql2);

    echo $sql2;
    //echo 'ultimo usuario insertado ' . $last_id1;
    //echo 'ultimo usuario insertado ' . $last_id2;
    echo "<br>";
} catch (PDOException $e) {
    echo $sql2;
    $conn->exec($sql2);
}


header("location:index.php");
