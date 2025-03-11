<?php
include('bd.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $materiales = $_POST['material'];
    $valoresUnitarios = $_POST['valor_uni'];
    $cantidades = $_POST['cantidad'];

    if (!empty($materiales) && !empty($valoresUnitarios) && !empty($cantidades)) {
        echo "<h1>Materiales creados con éxito:</h1>";
        echo "<ul>";

        try {
            // Conectar a la base de datos solo una vez
            $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Preparamos la consulta SQL para insertar los materiales
            $sql2 = "INSERT INTO `cotizar`(`Nombre`, `Valor Unitario`, `Cantidad`, `Total`) VALUES (:material, :valorUnitario, :cantidad, :total)";
            $stmt = $conn->prepare($sql2);

            for ($i = 0; $i < count($materiales); $i++) {
                // Escapamos el nombre del material (texto)
                $material = htmlspecialchars($materiales[$i]);

                // Los valores unitarios no necesitan htmlspecialchars() ya que son números
                $valorUnitario = formatearMonto($valoresUnitarios[$i]);  // Asumimos que ya es un número flotante
                $cantidad = htmlspecialchars($cantidades[$i]);  // También escapamos la cantidad (si es necesario)

                $total = $valorUnitario * $cantidad;

                // Ejecutamos la consulta con los valores específicos
                $stmt->bindParam(':material', $material);
                $stmt->bindParam(':valorUnitario', $valorUnitario);
                $stmt->bindParam(':cantidad', $cantidad);
                $stmt->bindParam(':total', $total);

                $stmt->execute(); // Ejecutar la inserción

                echo "<li>Material: $material, Valor Unitario: $valorUnitario, Cantidad: $cantidad, Total: $total</li>";

                header("location:index.php");
            }
        } catch (PDOException $e) {
            echo "<h1>Error al guardar los materiales: " . $e->getMessage() . "</h1>";
        }

        echo "</ul>";
    } else {
        echo "<h1>No se han recibido materiales.</h1>";
    }
} else {
    echo "<h1>Método de solicitud no válido.</h1>";
}
