<?php
include '../bd.php'; // Archivo de conexión a la base de datos

// Obtén los datos de la base de datos utilizando el ID de la factura
$sql = "SELECT * FROM `cotizar` WHERE ID='1' ORDER BY `cotizar`.`ID` ASC";
$result = mysqli_query($conexion, $sql);
$datosFactura = mysqli_fetch_assoc($result);

// Incluir la biblioteca TCPDF o MPDF

// Crear una instancia de TCPDF o MPDF

// Agregar el contenido al PDF
$pdf = new TCPDF(); // Reemplaza TCPDF con el nombre correcto de la clase de la biblioteca que estés utilizando
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);
$pdf->writeHTML('
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <h1>Factura</h1>
    <p>Cliente: ' . $datosFactura['Nombre'] . '</p>
    <p>Total: ' . $datosFactura['Valor'] . '</p>
</body>
</html>
');

// Salida del PDF
$pdf->Output('factura.pdf', 'I');
