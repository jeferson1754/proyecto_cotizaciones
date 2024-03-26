<?php
include('bd.php');
$valor      = $_REQUEST['valor'];
$fecha      = $_REQUEST['fecha'];

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql2 = "INSERT INTO `anticipos`( `Valor`, `Fecha`)
    VALUES (
    '" . $valor . "',
    '" . $fecha . "')";

    $conn->exec($sql2);

    echo $sql2;
    echo "<br>";
} catch (PDOException $e) {
    echo $sql2;
    $conn->exec($sql2);
}


header("location:index.php");
