<?php

require '../bd.php';
require('./fpdf/fpdf.php');

// Obtener la fecha actual formateada
$day = date("d/m/Y", strtotime("-1 day"));

// Crear una nueva instancia de la clase FPDF
$pdf = new FPDF();
$pdf->AddPage();

// Establecer la fuente
$pdf->SetFont('Arial', 'B', 14);

// Título
$pdf->Cell(0, 10, 'Cotizacion', 0, 1, 'C');

// Establecer la fuente para el contenido de la factura
$pdf->SetFont('Arial', '', 12);

// Fecha
$pdf->Cell(0, 10, 'Fecha: ' . $day, 0, 1);

// Detalles de la factura
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, 10, 'Item', 1, 0, 'C');
$pdf->Cell(90, 10, 'Nombre', 1, 0, 'C');
$pdf->Cell(30, 10, 'Cantidad', 1, 0, 'C');
$pdf->Cell(30, 10, 'P. Unitario', 1, 0, 'C');
$pdf->Cell(30, 10, 'Total', 1, 1, 'C');


$pdf->SetFont('Arial', '', 10);
// Consulta SQL para obtener los detalles de la factura
$sql = "SELECT * FROM `cotizar` ORDER BY `cotizar`.`ID` ASC";
$result = mysqli_query($conexion, $sql);
$i = 1;

// Recorrer los resultados y agregarlos al PDF
while ($mostrar = mysqli_fetch_array($result)) {
    $pdf->Cell(15, 10, $i, 1, 0, 'C');
    $nombre = $mostrar['Nombre'];
    $longitud_maxima = 50; // Define la longitud máxima del texto para el nombre
    $cantidad = $mostrar['Cantidad'];

    if (strlen($nombre) > $longitud_maxima) {
        // Trunca el nombre y añade "..."
        $nombre = substr($nombre, 0, $longitud_maxima - 3) . '...';
    }

    // Muestra el texto en una sola línea
    $pdf->Cell(90, 10, $nombre, 1, 0);
    $pdf->Cell(30, 10, $cantidad, 1, 0, 'C');
    $pdf->Cell(30, 10, '$ ' . number_format($mostrar['Valor Unitario'], 0, ',', '.'), 1, 0, 'C');
    $pdf->Cell(30, 10, '$ ' . number_format($mostrar['Total'], 0, ',', '.'), 1, 1, 'C');

    $i++;
}
// Calcular subtotal, IVA y total
$sql = "SELECT SUM(Total) AS total FROM cotizar";
$result = mysqli_query($conexion, $sql);
$total = mysqli_fetch_assoc($result)['total'];
$subtotal = $total * 0.81; // Subtotal (excluyendo el 19% de IVA)
$iva = $total * 0.19; // IVA (19%)

// Mostrar subtotal, IVA y total en el PDF
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(165, 10, 'Subtotal', 1, 0, 'C');
$pdf->Cell(30, 10, '$ ' . number_format($subtotal, 0, ',', '.'), 1, 1, 'C');
$pdf->Cell(165, 10, 'IVA (19%)', 1, 0, 'C');
$pdf->Cell(30, 10, '$ ' . number_format($iva, 0, ',', '.'), 1, 1, 'C');
$pdf->Cell(165, 10, 'Total', 1, 0, 'C');
$pdf->Cell(30, 10, '$ ' . number_format($total, 0, ',', '.'), 1, 1, 'C');

// Salida del PDF
$pdf->Output();
