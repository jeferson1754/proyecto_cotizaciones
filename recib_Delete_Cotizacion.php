
<?php
include('bd.php');
date_default_timezone_set('America/Santiago');
$fecha_actual = date('Y-m-d H:i:s');

$nombre_cliente = $_REQUEST['nombre_cliente'];

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
            $sql = "INSERT INTO `cotizar_antiguos` (`ID_Cliente`, `Nombre`, `Valor Unitario`, `Cantidad`, `Total`, `Fecha_Cotizacion`) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("issiis", $id_cliente, $dato1, $dato2, $dato3, $dato4, $dato5);
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


header("location:index.php");
?>
