<?php

$usuario  = "root";
$password = "";
$servidor = "localhost";
$basededatos = "epiz_32740026_r_user";
$conexion = mysqli_connect($servidor, $usuario, $password) or die("No se ha podido conectar al Servidor");
mysqli_query($conexion, "SET SESSION collation_connection ='utf8_unicode_ci'");
$db = mysqli_select_db($conexion, $basededatos) or die("Upps! Error en conectar a la Base de Datos");


function formatearMonto($monto)
{
    // Eliminar el símbolo de dólar, puntos y comas (separadores de miles)
    $monto = str_replace(['$', '.', ','], '', $monto);

    // Convertir el valor a float
    $monto = (float)$monto;

    return $monto;
}

try {
    $connect = new PDO("mysql:host={$servidor};dbname={$basededatos}", $usuario, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    die("Connection error: " . $exception->getMessage());
}
