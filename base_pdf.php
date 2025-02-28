<?php
require 'bd.php';
$day = date("d/m/Y");

// Company information - you can modify this
$company_name = "Su Empresa";
$company_address = "Dirección de la Empresa #123";
$company_city = "Santiago, Chile";
$company_phone = "+56 9 1234 5678";
$company_email = "contacto@suempresa.cl";
$company_web = "www.suempresa.cl";
$company_tax_id = "RUT: 12.345.678-9";

// Get invoice number (you can implement this based on your system)
$invoice_number = "FC-" . date('Ymd') . "-001";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura <?php echo $invoice_number; ?></title>
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
    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <div class="company-info">
                <h1><?php echo $company_name; ?></h1>
                <p><?php echo $company_address; ?></p>
                <p><?php echo $company_city; ?></p>
                <p><?php echo $company_tax_id; ?></p>
            </div>
            <div class="invoice-title">
                <h2>FACTURA</h2>
                <p class="invoice-number"><?php echo $invoice_number; ?></p>
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <div class="invoice-details-group">
                <h3>Fecha</h3>
                <p><strong><?php echo $day; ?></strong></p>
            </div>
            <div class="invoice-details-group">
                <h3>Contacto</h3>
                <p><?php echo $company_phone; ?></p>
                <p><?php echo $company_email; ?></p>
                <p><?php echo $company_web; ?></p>
            </div>
            <div class="invoice-details-group">
                <h3>Cliente</h3>
                <?php
                // If you have client information, you can add it here
                $client_name = "Nombre del Cliente";
                $client_address = "Dirección del Cliente";
                $client_rut = "RUT: XX.XXX.XXX-X";
                ?>
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
                    $sql = "SELECT * FROM `cotizar` ORDER BY `cotizar`.`ID` ASC ";
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
                            <td><?php echo $i; ?></td>
                            <td class="item-name"><?php echo $nombre; ?></td>
                            <td><?php echo $cantidad; ?></td>
                            <td class="text-right">$ <?php echo number_format($mostrar['Valor Unitario'], 0, ',', '.'); ?></td>
                            <td class="text-right">$ <?php echo number_format($mostrar['Total'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php
                        $i++;
                    }

                    $sql = ("SELECT SUM(Total) AS total FROM cotizar");
                    $result = mysqli_query($conexion, $sql);
                    $total = mysqli_fetch_assoc($result)['total'];
                    $subtotal = $total * 0.81; // Subtotal (excluding 19% VAT)
                    $iva = $total * 0.19; // VAT (19%)
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right">Subtotal:</td>
                        <td class="text-right">$ <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">IVA (19%):</td>
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
                <p>Banco: Banco de Chile</p>
                <p>Cuenta Corriente: 123-456-789</p>
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
</body>

</html>