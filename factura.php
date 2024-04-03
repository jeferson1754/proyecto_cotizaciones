<?php

require '../bd.php';
require('./fpdf/fpdf.php');

// Obtener la fecha actual formateada
$day = date("d/m/Y", strtotime("-1 day"));

// Crear una nueva instancia de la clase FPDF
$pdf = new FPDF();
$pdf->AddPage();

// Establecer la fuente
$pdf->SetFont('Arial', 'B', 16);

// Título
$pdf->Cell(0, 10, 'Factura', 0, 1, 'C');

// Establecer la fuente para el contenido de la factura
$pdf->SetFont('Arial', '', 12);

// Fecha
$pdf->Cell(0, 10, 'Fecha: ' . $day, 0, 1);

// Detalles de la factura
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(30, 10, 'N.-', 1, 0, 'C');
$pdf->Cell(60, 10, 'Nombre', 1, 0, 'C');
$pdf->Cell(40, 10, 'Fecha', 1, 0, 'C');
$pdf->Cell(60, 10, 'Precio', 1, 1, 'C');

// Consulta SQL para obtener los detalles de la factura
$sql = "SELECT * FROM `cotizar` ORDER BY `cotizar`.`ID` ASC";
$result = mysqli_query($conexion, $sql);

// Recorrer los resultados y agregarlos al PDF
while ($mostrar = mysqli_fetch_array($result)) {
    $pdf->Cell(30, 10, $mostrar['ID'], 1, 0, 'C');
    $pdf->Cell(60, 10, $mostrar['Nombre'], 1, 0, 'C');
    $pdf->Cell(40, 10, date('d-m-Y', strtotime($mostrar['Fecha'])), 1, 0, 'C');
    $pdf->Cell(60, 10, '$ ' . number_format($mostrar['Valor'], 0, ',', '.'), 1, 1, 'C');
}

// Calcular subtotal, IVA y total
$sql = "SELECT SUM(Valor) AS total FROM cotizar";
$result = mysqli_query($conexion, $sql);
$total = mysqli_fetch_assoc($result)['total'];
$subtotal = $total * 0.81; // Subtotal (excluyendo el 19% de IVA)
$iva = $total * 0.19; // IVA (19%)

// Mostrar subtotal, IVA y total en el PDF
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(130, 10, 'Subtotal', 1, 0, 'C');
$pdf->Cell(60, 10, '$ ' . number_format($subtotal, 0, ',', '.'), 1, 1, 'C');
$pdf->Cell(130, 10, 'IVA (19%)', 1, 0, 'C');
$pdf->Cell(60, 10, '$ ' . number_format($iva, 0, ',', '.'), 1, 1, 'C');
$pdf->Cell(130, 10, 'Total', 1, 0, 'C');
$pdf->Cell(60, 10, '$ ' . number_format($total, 0, ',', '.'), 1, 1, 'C');

// Salida del PDF
$pdf->Output();
