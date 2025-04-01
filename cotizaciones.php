<?php
include('bd.php');

// Company information - you can modify this
$company_name = "Su Empresa";
$company_address = "Dirección de la Empresa #123";
$company_city = "Santiago, Chile";
$company_phone = "+56 9 1234 5678";
$company_email = "contacto@suempresa.cl";
$company_web = "www.suempresa.cl";
$company_tax_id = "12.345.678-9";
$company_bank = " Banco de Chile";
$company_num_count = "123-456-789";

$iva_porcentaje = 19;

// Get invoice number (you can implement this based on your system)

$id_cotizacion = isset($_GET['id']) ? urldecode($_GET['id']) : null;
$cotizacion = null;
$error = null;

$invoice_number = "CT-" . str_pad($id_cotizacion, 4, "0", STR_PAD_LEFT);

if ($id_cotizacion) {
    try {
        // Consulta SQL para obtener los datos de la tarjeta por ID
        $stmt = $connect->prepare("SELECT cotizacion_clientes.*, clientes_cotizacion.Nombre FROM `cotizacion_clientes`
        INNER JOIN clientes_cotizacion ON clientes_cotizacion.ID = cotizacion_clientes.ID_Cliente WHERE cotizacion_clientes.ID=:id");
        $stmt->bindParam(':id', $id_cotizacion);
        $stmt->execute();

        // Verifica si hay resultados
        if ($stmt->rowCount() > 0) {
            $cotizacion = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $error = "No se encontró la cotizacion con el ID proporcionado.";
        }
    } catch (PDOException $e) {
        $error = "Error al conectar con la base de datos: " . $e->getMessage();
    }
} else {
    $error = "Se requiere un ID de cotizacion válido.";
}

// Fecha de emisión formateada
$fechaEmision = isset($cotizacion['Fecha_Cotizacion']) ? date("d/m/Y", strtotime($cotizacion['Fecha_Cotizacion'])) : date("d/m/Y");
$total = $cotizacion['Total_General'];

$client_name = !empty($cotizacion['Nombre']) ? $cotizacion['Nombre'] : 'Nombre del Cliente';
$client_rut = "RUT: XX.XXX.XXX-X";
$client_address = "Dirección del Cliente";

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizacion #<?php echo $invoice_number; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Libraries for PDF/Image generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #f3f4f6;
            --accent-color: #1e40af;
            --text-color: #1f2937;
            --light-text: #6b7280;
            --border-color: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
            background-color: #f9fafb;
            padding: 20px;
            line-height: 1.5;
        }

        .invoice-container {
            background-color: white;
            max-width: 800px;
            margin: 0 auto;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 30px;
            background-color: var(--primary-color);
            color: white;
        }

        .company-info h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .company-info p {
            margin: 0;
            font-size: 14px;
            opacity: 0.9;
        }

        .invoice-title {
            text-align: right;
        }

        .invoice-title h2 {
            font-size: 36px;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .invoice-title .invoice-number {
            font-size: 16px;
            font-weight: 500;
        }

        .invoice-details {
            display: flex;
            justify-content: space-between;
            padding: 30px;
            border-bottom: 1px solid var(--border-color);
        }

        .invoice-details-group h3 {
            font-size: 16px;
            color: var(--light-text);
            text-transform: uppercase;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .invoice-details-group p {
            margin: 4px 0;
            font-size: 15px;
        }

        .invoice-details-group p strong {
            font-weight: 600;
        }

        .invoice-items {
            padding: 30px;
        }

        .invoice-items h3 {
            font-size: 18px;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
        }

        .items-table thead th {
            background-color: var(--secondary-color);
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            color: var(--text-color);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .items-table tbody td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border-color);
            font-size: 14px;
        }

        .items-table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .items-table .item-name {
            max-width: 300px;
        }

        .items-table .text-right {
            text-align: right;
        }

        .items-table tfoot td {
            padding: 12px 15px;
            font-weight: 600;
            font-size: 14px;
        }

        .items-table tfoot tr:first-child td {
            border-top: 2px solid var(--border-color);
        }

        .items-table tfoot tr:last-child {
            background-color: var(--secondary-color);
            font-size: 16px;
            color: var(--primary-color);
        }

        .invoice-footer {
            padding: 30px;
            text-align: center;
            font-size: 14px;
            color: var(--light-text);
            border-top: 1px solid var(--border-color);
            background-color: var(--secondary-color);
        }

        .invoice-footer p {
            margin: 5px 0;
        }

        .payment-info {
            margin-top: 15px;
            padding: 15px;
            background-color: #f3f4f6;
            border-radius: 5px;
            font-size: 13px;
        }

        .payment-info h4 {
            margin-bottom: 10px;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .invoice-header {
                flex-direction: column;
                text-align: left;
            }

            .invoice-title {
                order: -1;
                /* Mueve la cotización arriba */
            }

            .company-info {
                text-align: left;
            }

            .invoice-number {
                text-align: left;
            }

            .invoice-details {
                flex-direction: column;
                text-align: left;

            }

            .invoice-details-group {
                margin-bottom: 10px;
            }

            .invoice-details-group h3 {
                font-weight: 800;
            }

            .invoice-items h3 {
                text-align: center;
            }

            .items-table thead {
                display: none;
                /* Oculta los encabezados */
            }

            .items-table tr {
                display: block;
                margin-bottom: 10px;
                border: 1px solid #ddd;
                padding: 10px;
            }

            .items-table td {
                display: block;
                text-align: right;
                position: relative;
                padding-left: 50%;
            }

            .items-table td:before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                font-weight: bold;
                text-align: left;
            }

            .total {
                font-weight: 600;
            }

        }

        @media print {
            body {
                background-color: white;
                padding: 0;
            }

            .invoice-container {
                box-shadow: none;
                max-width: 100%;
            }

            .payment-info {
                break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="page-container">
        <div class="container card-container">

            <?php if ($error): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($error); ?>
                </div>
                <div class="text-center mt-4">
                    <a href="index.php" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i>Volver al inicio
                    </a>
                </div>
            <?php endif; ?>

            <?php if ($cotizacion): ?>

                <div class="invoice-container" id="preview-design">
                    <!-- Header -->
                    <div class="invoice-header">
                        <div class="company-info">
                            <h1><?php echo $company_name; ?></h1>
                            <p><?php echo $company_address; ?></p>
                            <p><?php echo $company_city; ?></p>
                            <p><?php echo $company_tax_id; ?></p>
                        </div>
                        <div class="invoice-title">
                            <h2>COTIZACION </h2>
                            <p class="invoice-number"><?php echo $invoice_number; ?></p>
                        </div>
                    </div>

                    <!-- Invoice Details -->
                    <div class="invoice-details">
                        <div class="invoice-details-group">
                            <h3>Fecha</h3>
                            <p><strong><?php echo $fechaEmision; ?></strong></p>
                        </div>
                        <div class="invoice-details-group">
                            <h3>Contacto</h3>
                            <p><?php echo $company_phone; ?></p>
                            <p><?php echo $company_email; ?></p>
                            <p><?php echo $company_web; ?></p>
                        </div>
                        <div class="invoice-details-group">
                            <h3>Cliente</h3>
                            <p><strong><?php echo $client_name; ?></strong></p>
                            <p><?php echo $client_address; ?></p>
                            <p><?php echo $client_rut; ?></p>
                        </div>
                    </div>

                    <!-- Invoice Items -->
                    <div class="invoice-items">
                        <h3>Detalle de Factura</h3>
                        <table class="items-table">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="45%">Descripción</th>
                                    <th width="10%">Cant.</th>
                                    <th width="20%">P. Unitario</th>
                                    <th width="20%">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM `cotizar_antiguos` WHERE ID_Cotizacion=$id_cotizacion";
                                $result = mysqli_query($conexion, $sql);
                                $i = 1;

                                while ($mostrar = mysqli_fetch_array($result)) {
                                    $nombre = $mostrar['Nombre'];
                                    $longitud_maxima = 80; // Extended max length
                                    $cantidad = $mostrar['Cantidad'];

                                    if (strlen($nombre) > $longitud_maxima) {
                                        $nombre = substr($nombre, 0, $longitud_maxima - 3) . '...';
                                    }
                                ?>
                                    <tr>
                                        <td data-label="#"> <?php echo $i; ?> </td>
                                        <td data-label="Descripción" class="item-name"><?php echo $nombre; ?></td>
                                        <td data-label="Cantidad"><?php echo $cantidad; ?></td>
                                        <td data-label="P. Unitario" class="text-right">$ <?php echo number_format($mostrar['Valor Unitario'], 0, ',', '.'); ?></td>
                                        <td data-label="Total" class="text-right total">$ <?php echo number_format($mostrar['Total'], 0, ',', '.'); ?></td>
                                    </tr>
                                <?php
                                    $i++;
                                }

                                $subtotal = $total * (1 - $iva_porcentaje / 100); // Subtotal (excluyendo el IVA del 19%)
                                $iva = $total * ($iva_porcentaje / 100); // IVA (19%)
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right">Subtotal:</td>
                                    <td class="text-right">$ <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right">IVA (<?php echo $iva_porcentaje ?>%):</td>
                                    <td class="text-right">$ <?php echo number_format($iva, 0, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>TOTAL:</strong></td>
                                    <td class="text-right"><strong>$ <?php echo number_format($total, 0, ',', '.'); ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>

                        <!-- Payment Info -->
                        <div class="payment-info">
                            <h4>Información de Pago</h4>
                            <p>Banco: <?php echo $company_bank; ?></p>
                            <p>Cuenta Corriente: <?php echo $company_num_count; ?></p>
                            <p>Titular: <?php echo $company_name; ?></p>
                            <p>RUT: <?php echo $company_tax_id; ?></p>
                            <p>Correo: <?php echo $company_email; ?></p>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="invoice-footer">
                        <p><strong>Gracias por su preferencia</strong></p>
                        <p>Esta factura es un documento legal y tributario</p>
                        <p>&copy; <?php echo date('Y') . ' ' . $company_name; ?> - Todos los derechos reservados</p>
                    </div>
                </div>

                <div id="tarjeta-container" class="mt-4" style="color:white !important;">

                    <div class="d-flex justify-content-center gap-3 mb-5">
                        <button class="btn btn-primary btn-lg btn-download" onclick="descargarComoPNG()">
                            <i class="fas fa-image me-2"></i>Descargar como PNG
                        </button>
                        <button class="btn btn-danger btn-lg btn-download" onclick="descargarComoPDF()">
                            <i class="fas fa-file-pdf me-2"></i>Descargar como PDF
                        </button>
                    </div>

                    <div class="text-center mb-4">
                        <a href="./" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Atrás
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Función para descargar como PNG
        function descargarComoPNG() {
            const previewDesign = document.getElementById("preview-design");

            // Mostrar indicador de carga
            showLoading('Generando imagen...');

            setTimeout(() => {
                html2canvas(previewDesign, {
                    scale: 2
                }).then(canvas => {
                    // Ocultar indicador de carga
                    hideLoading();

                    const enlace = document.createElement('a');
                    enlace.href = canvas.toDataURL("image/png");
                    enlace.download = "cotizacion_#<?php echo $invoice_number; ?>.png";
                    enlace.click();
                }).catch(error => {
                    hideLoading();
                    showError("Error al generar la imagen: " + error.message);
                });
            }, 500);
        }

        // Función para descargar como PDF
        function descargarComoPDF() {
            const previewDesign = document.getElementById("preview-design");

            // Mostrar indicador de carga
            showLoading('Generando PDF...');

            setTimeout(() => {
                html2canvas(previewDesign, {
                    scale: 2
                }).then(canvas => {
                    // Ocultar indicador de carga
                    hideLoading();

                    const imgData = canvas.toDataURL("image/png");
                    const {
                        jsPDF
                    } = window.jspdf;

                    const pdf = new jsPDF({
                        orientation: "portrait", // <-- Ahora en vertical
                        unit: "mm"
                    });

                    const imgProps = pdf.getImageProperties(imgData);
                    const pdfWidth = pdf.internal.pageSize.getWidth();
                    const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                    pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                    pdf.save("cotizacion_#<?php echo $invoice_number; ?>.pdf");
                }).catch(error => {
                    hideLoading();
                    showError("Error al generar el PDF: " + error.message);
                });
            }, 500);
        }

        // Funciones auxiliares para mostrar/ocultar indicadores de carga
        function showLoading(message) {
            // Crear un div de carga si no existe
            if (!document.getElementById('loading-indicator')) {
                const loadingDiv = document.createElement('div');
                loadingDiv.id = 'loading-indicator';
                loadingDiv.style.position = 'fixed';
                loadingDiv.style.top = '0';
                loadingDiv.style.left = '0';
                loadingDiv.style.width = '100%';
                loadingDiv.style.height = '100%';
                loadingDiv.style.backgroundColor = 'rgba(0,0,0,0.5)';
                loadingDiv.style.display = 'flex';
                loadingDiv.style.justifyContent = 'center';
                loadingDiv.style.alignItems = 'center';
                loadingDiv.style.zIndex = '9999';

                const loadingContent = document.createElement('div');
                loadingContent.style.backgroundColor = 'white';
                loadingContent.style.padding = '20px 30px';
                loadingContent.style.borderRadius = '10px';
                loadingContent.style.textAlign = 'center';

                const spinner = document.createElement('div');
                spinner.className = 'spinner-border text-primary';
                spinner.setAttribute('role', 'status');

                const loadingText = document.createElement('p');
                loadingText.id = 'loading-text';
                loadingText.style.marginTop = '10px';
                loadingText.style.marginBottom = '0';
                loadingText.textContent = message || 'Cargando...';

                loadingContent.appendChild(spinner);
                loadingContent.appendChild(loadingText);
                loadingDiv.appendChild(loadingContent);
                document.body.appendChild(loadingDiv);
            } else {
                document.getElementById('loading-text').textContent = message || 'Cargando...';
                document.getElementById('loading-indicator').style.display = 'flex';
            }
        }

        function hideLoading() {
            const loadingDiv = document.getElementById('loading-indicator');
            if (loadingDiv) {
                loadingDiv.style.display = 'none';
            }
        }

        function showError(message) {
            // Crear alerta temporal
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
            alertDiv.style.zIndex = '9999';
            alertDiv.style.maxWidth = '500px';

            alertDiv.innerHTML = `
                <i class="fas fa-exclamation-circle me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;

            document.body.appendChild(alertDiv);

            // Eliminar automáticamente después de 5 segundos
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }
    </script>
</body>

</html>