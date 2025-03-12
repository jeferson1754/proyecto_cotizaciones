
<?php
include('bd.php');
date_default_timezone_set('America/Santiago');
$fecha_actual = date('Y-m-d H:i:s');

$nombre_cliente = $_REQUEST['nombre_cliente'];
$total = $_REQUEST['total'];

if (isset($_POST['Nueva'])) {
    $delete = ("DELETE FROM cotizar");
    $result_update = mysqli_query($conexion, $delete);
    echo $delete;
} else {

    $clientes = $conexion->query("SELECT * FROM `clientes_cotizacion` where Nombre='$nombre_cliente';");
    $nombres = $clientes->fetch_assoc();

    if (!$nombres) {
        $sql = "INSERT INTO `clientes_cotizacion` (`Nombre`) VALUES ('$nombre_cliente')";

        if ($conexion->query($sql) === TRUE) {
            $id_cliente = $conexion->insert_id;
        } else {
            // Manejar errores si es necesario
        }
    } else {
        $id_cliente = $nombres['ID'];
    }

    try {
        $sql = "INSERT INTO `cotizacion_clientes` (`ID_Cliente`, `Fecha_Cotizacion`, `Total_General`) VALUES (?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("isi", $id_cliente, $fecha_actual, $total);
        $stmt->execute();

        // Obtener el ID insertado
        $id_cotizacion = $stmt->insert_id;
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
    }


    $sql = "SELECT * FROM `cotizar`";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    $resultado = $consulta->get_result();

    // Recorrer todos los resultados
    while ($mostrar = $resultado->fetch_assoc()) {
        $dato1 = $mostrar['Nombre'];
        $dato2 = $mostrar['Valor Unitario'];
        $dato3 = $mostrar['Cantidad'];
        $dato4 = $mostrar['Total'];
        $dato5 = $fecha_actual;

        try {
            $sql = "INSERT INTO `cotizar_antiguos` (`ID_Cotizacion`, `Nombre`, `Valor Unitario`, `Cantidad`, `Total`) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("isiii", $id_cotizacion, $dato1, $dato2, $dato3, $dato4);
            $stmt->execute();
            echo "<br>";
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
            echo "<br>";
        }
    }

    // Elimina la manga de la tabla original
    $delete = ("DELETE FROM cotizar");
    $result_update = mysqli_query($conexion, $delete);
    echo $delete;
}


header("location:crear.php");
?>
