<?php
require '../bd.php';
require('./fpdf/fpdf.php');

// Obtener la fecha actual formateada
$day = date("d/m/Y", strtotime("-1 day"));

// Crear una nueva instancia de FPDF
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

// Establecer márgenes
$pdf->SetMargins(15, 15, 15);

// Información de la empresa
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'EMPRESA S.A.', 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5, 'RUT: 900.123.456-7', 0, 1, 'C');
$pdf->Cell(0, 5, 'Direccion: Calle Principal #123', 0, 1, 'C');
$pdf->Cell(0, 5, 'Telefono: (123) 456-7890', 0, 1, 'C');
$pdf->Cell(0, 5, 'Email: contacto@empresa.com', 0, 1, 'C');
$pdf->Ln(5);

// Rectángulo para la sección de cotización
$pdf->SetFillColor(240, 240, 240);
$pdf->Rect(15, $pdf->GetY(), 180, 25, 'F');

// Título y número de cotización
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(90, 10, 'COTIZACION', 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90, 10, 'Num: COT-' . date('Ymd') . '-001', 0, 1, 'R');

// Fecha y validez
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(90, 5, 'Fecha: ' . $day, 0, 0, 'L');
$pdf->Cell(90, 5, 'Valida hasta: ' . date('d/m/Y', strtotime('+30 days')), 0, 1, 'R');
$pdf->Cell(90, 5, 'Forma de pago: 50% anticipado, 50% contra entrega', 0, 1, 'L');
$pdf->Ln(10);

// Información del cliente
$pdf->SetFillColor(220, 220, 220);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 8, 'INFORMACION DEL CLIENTE', 1, 1, 'C', true);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(45, 8, 'Nombre/Razon Social:', 1, 0);
$pdf->Cell(135, 8, 'Cliente Ejemplo S.A.', 1, 1);
$pdf->Cell(45, 8, 'RUT:', 1, 0);
$pdf->Cell(135, 8, '123.456.789-0', 1, 1);
$pdf->Cell(45, 8, 'Direccion:', 1, 0);
$pdf->Cell(135, 8, 'Av. Cliente #456, Ciudad', 1, 1);
$pdf->Cell(45, 8, 'Telefono:', 1, 0);
$pdf->Cell(135, 8, '(987) 654-3210', 1, 1);
$pdf->Cell(45, 8, 'Email:', 1, 0);
$pdf->Cell(135, 8, 'contacto@cliente.com', 1, 1);
$pdf->Ln(10);

// Encabezado de tabla de productos
$pdf->SetFillColor(50, 50, 150);
$pdf->SetTextColor(255);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, 10, 'Item', 1, 0, 'C', true);
$pdf->Cell(90, 10, 'Descripcion', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Cantidad', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'P. Unitario', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Total', 1, 1, 'C', true);

// Restablecer color de texto
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 10);

// Consulta SQL para obtener los detalles de la cotización
$sql = "SELECT * FROM `cotizar` ORDER BY `cotizar`.`ID` ASC";
$result = mysqli_query($conexion, $sql);
$i = 1;

// Establecer colores alternados para las filas
$colorFila = false;

// Recorrer los resultados y agregarlos al PDF
while ($mostrar = mysqli_fetch_array($result)) {
    // Color de fondo alternado para filas
    if ($colorFila) {
        $pdf->SetFillColor(230, 230, 250);
    } else {
        $pdf->SetFillColor(255, 255, 255);
    }
    $colorFila = !$colorFila;

    $pdf->Cell(15, 8, $i, 1, 0, 'C', true);

    $nombre = $mostrar['Nombre'];
    $cantidad = $mostrar['Cantidad'];
    $valorUnitario = $mostrar['Valor Unitario'];
    $total = $mostrar['Total'];

    // Manejar nombres largos con multilínea
    $longitud_maxima = 50;
    if (strlen($nombre) > $longitud_maxima) {
        $pdf->Cell(90, 8, substr($nombre, 0, $longitud_maxima) . '...', 1, 0, 'L', true);
    } else {
        $pdf->Cell(90, 8, $nombre, 1, 0, 'L', true);
    }

    $pdf->Cell(25, 8, $cantidad, 1, 0, 'C', true);
    $pdf->Cell(25, 8, '$ ' . number_format($valorUnitario, 0, ',', '.'), 1, 0, 'R', true);
    $pdf->Cell(25, 8, '$ ' . number_format($total, 0, ',', '.'), 1, 1, 'R', true);

    $i++;
}

// Calcular subtotal, IVA y total
$sql = "SELECT SUM(Total) AS total FROM cotizar";
$result = mysqli_query($conexion, $sql);
$total = mysqli_fetch_assoc($result)['total'];
$subtotal = $total / 1.19; // Subtotal (excluyendo el 19% de IVA)
$iva = $total - $subtotal; // IVA (19%)

// Mostrar subtotal, IVA y total en el PDF con mejor formato
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(130, 8, '', 0, 0);
$pdf->Cell(25, 8, 'Subtotal:', 1, 0, 'L');
$pdf->Cell(25, 8, '$ ' . number_format($subtotal, 0, ',', '.'), 1, 1, 'R');

$pdf->Cell(130, 8, '', 0, 0);
$pdf->Cell(25, 8, 'IVA (19%):', 1, 0, 'L');
$pdf->Cell(25, 8, '$ ' . number_format($iva, 0, ',', '.'), 1, 1, 'R');

$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(130, 8, '', 0, 0);
$pdf->Cell(25, 8, 'TOTAL:', 1, 0, 'L', true);
$pdf->Cell(25, 8, '$ ' . number_format($total, 0, ',', '.'), 1, 1, 'R', true);

// Condiciones de la cotización
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', size: 9);
$pdf->Cell(0, 8, 'TERMINOS Y CONDICIONES', 0, 1, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(0, 5, '1. Esta cotizacion tiene una validez de 30 dias calendario a partir de la fecha de emision.
2. Los precios estan sujetos a cambios sin previo aviso despues del periodo de validez.
3. Los tiempos de entrega son estimados y pueden variar segun disponibilidad.
4. No incluye costos de transporte salvo que se especifique.
5. El pago debe realizarse segun las condiciones establecidas.
6. La garantia de los productos es de acuerdo a politicas del fabricante.');

// Firmas
$pdf->Ln(25);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(90, 5, '_______________________', 0, 0, 'C');
$pdf->Cell(90, 5, '_______________________', 0, 1, 'C');
$pdf->Cell(90, 5, 'Firma Autorizada', 0, 0, 'C');
$pdf->Cell(90, 5, 'Aceptacion Cliente', 0, 1, 'C');

// Salida del PDF
$pdf->Output();
