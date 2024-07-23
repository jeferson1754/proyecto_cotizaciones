<?php
include('bd.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $materiales = $_POST['material'];
    $valoresUnitarios = $_POST['valor_uni'];
    $cantidades = $_POST['cantidad'];

    if (!empty($materiales) && !empty($valoresUnitarios) && !empty($cantidades)) {
        echo "<h1>Materiales creados con éxito:</h1>";
        echo "<ul>";
        for ($i = 0; $i < count($materiales); $i++) {
            $material = htmlspecialchars($materiales[$i]);
            $valorUnitario = htmlspecialchars($valoresUnitarios[$i]);
            $cantidad = htmlspecialchars($cantidades[$i]);
            $total = $valorUnitario * $cantidad;

            echo "<li>Material: $material, Valor Unitario: $valorUnitario, Cantidad: $cantidad, Total: $total</li>";
            try {
                $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql2 = "INSERT INTO `cotizar`( `Nombre`, `Valor Unitario`, `Cantidad`,`Total`)
                VALUES (
                '" . $material . "',
                '" . $valorUnitario . "',
                '" . $cantidad . "',
                '" . $total . "')";

                $conn->exec($sql2);

                echo $sql2;
                echo "<br>";
            } catch (PDOException $e) {
                echo $sql2;
                $conn->exec($sql2);
            }
            // Aquí puedes añadir la lógica para guardar los materiales en una base de datos.
        }
        echo "</ul>";
    } else {
        echo "<h1>No se han recibido materiales.</h1>";
    }
} else {
    echo "<h1>Método de solicitud no válido.</h1>";
}
