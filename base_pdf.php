<?php

require 'bd.php';
// Prints something like: Monday
//echo date("l");

// Prints something like: Monday 8th of August 2005 03:12:46 PM
//echo date('l jS \of F Y h:i:s A');

$day = date("d/m/Y", strtotime("-1 day"));

?>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .factura {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
        }

        .factura h2 {
            margin: 0 0 10px;
        }

        .factura .datos {
            text-align: left;
        }

        .factura .datos .cliente {
            font-weight: bold;
        }

        .factura .datos .numero {
            font-size: larger;
        }

        .factura table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .factura table th,
        .factura table td {
            padding: 5px;
        }

        .factura table th {
            background-color: #eee;
            text-align: left;
        }

        .factura table td {
            border-top: 1px solid #ccc;
        }

        .factura table td.total {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="factura">
        <h2>Factura</h2>

        <table>
            <tr>
                <th>Fecha:</th>
                <td><?php echo $day; ?></td>
            </tr>
        </table>
        <h4>Detalles de la factura:</h4>
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>P. Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <?php

            //$sql = "SELECT a.id,a.Anime,a.Temporadas,a.Peliculas,a.Spin_Off,e.Estado,a.Año,t.Temporada FROM anime as a INNER JOIN Estado as e ON a.Estado = e.id INNER join Temporada as t ON a.Temporada=t.ID ORDER by a.id;";

            $sql = "SELECT * FROM `cotizar` ORDER BY `cotizar`.`ID` ASC ";

            $result = mysqli_query($conexion, $sql);
            // echo $sql;
            $i = 1;

            while ($mostrar = mysqli_fetch_array($result)) {
                $nombre = $mostrar['Nombre'];
                $longitud_maxima = 50; // Define la longitud máxima del texto para el nombre
                $cantidad = $mostrar['Cantidad'];

                if (strlen($nombre) > $longitud_maxima) {
                    // Trunca el nombre y añade "..."
                    $nombre = substr($nombre, 0, $longitud_maxima - 3) . '...';
                }
            ?>
                <tbody>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $nombre ?></td>
                        <td><?php echo $cantidad ?></td>
                        <td>$ <?php echo number_format($mostrar['Valor Unitario'], 0, ',', '.'); ?></td>
                        <td>$ <?php echo number_format($mostrar['Total'], 0, ',', '.'); ?></td>

                    </tr>

                </tbody>
            <?php
                $i++;
            }

            ?>
            <tfoot>
                <?php

                $sql = ("SELECT SUM(Total) AS total FROM cotizar");
                $result = mysqli_query($conexion, $sql);
                $total = mysqli_fetch_assoc($result)['total'];
                $subtotal = $total * 0.81; // Subtotal (excluyendo el 19% de IVA)
                $iva = $total * 0.19; // IVA (19%)
                //echo $subtotal;

                ?>
                <tr>
                    <td colspan="4" class="total">Subtotal</td>
                    <td>$ <?php echo number_format($subtotal, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td colspan="4" class="total">IVA (19%)</td>
                    <td>$ <?php echo number_format($iva, 0, ',', '.')  ?></td>
                </tr>
                <tr>
                    <td colspan="4" class="total">Total</td>
                    <td>$ <?php echo number_format($total, 0, ',', '.')  ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>