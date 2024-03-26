<?php
//Mostrar index.php para descargar como pdf
include_once "../vendor/autoload.php";

use Dompdf\Dompdf;

$dompdf = new Dompdf();
ob_start();
include "../pdf.php";
$html = ob_get_clean();
$dompdf->loadHtml($html);
$dompdf->render();
$output = $dompdf->output();
header("Content-type: application/pdf");
header("Content-Disposition: inline; filename='pdf1.php'");
echo $output;
$dompdf->stream(time() . "Hola.pdf");
