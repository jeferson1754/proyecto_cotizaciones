<?php
include('bd.php');
$nombre     = $_REQUEST['nombre'];
$valor      = $_REQUEST['valor'];
$fecha      = $_REQUEST['fecha'];

/*
$QueryInsert = ("INSERT INTO `registros`
( `Usuario`,
`KM`, 
`Tiempo`,
`Ubicacion`,
`Fecha`) 
VALUES (
    '" . $nombre . "',
    '" . $km . "',
    '" . $tiempo . "',
    '" . $ubi . "',
    '" . $fecha . "',
);");
$inserInmueble = mysqli_query($conexion, $QueryInsert);
echo $inserInmueble;


try {
    $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO kilometros (kilometros)
    VALUES ( '" . $km . "')";
    $conn->exec($sql);
    $last_id1 = $conn->lastInsertId();
    echo $sql;
    echo 'ultimo usuario insertado ' . $last_id1;
    echo "<br>";
} catch (PDOException $e) {
    $conn = null;
}

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql1 = "INSERT INTO tiempo (Tiempo)
    VALUES ( '" . $tiempo . "')";
    $conn->exec($sql1);
    $last_id2 = $conn->lastInsertId();
    echo $sql1;
    echo 'ultimo usuario insertado ' . $last_id2;
    echo "<br>";
} catch (PDOException $e) {
    $conn = null;
}
*/
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
