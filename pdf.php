<?php

require 'bd.php';
// Prints something like: Monday
//echo date("l");

// Prints something like: Monday 8th of August 2005 03:12:46 PM
//echo date('l jS \of F Y h:i:s A');

$sql = ("SELECT DATE_FORMAT(NOW(), '%d/%m/%Y');");

$dia      = mysqli_query($conexion, $sql);

while ($rows = mysqli_fetch_array($dia)) {

    $day = $rows[0];
    //echo $day;
}

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
                    <th>N°</th>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <?php

            //$sql = "SELECT a.id,a.Anime,a.Temporadas,a.Peliculas,a.Spin_Off,e.Estado,a.Año,t.Temporada FROM anime as a INNER JOIN Estado as e ON a.Estado = e.id INNER join Temporada as t ON a.Temporada=t.ID ORDER by a.id;";

            $sql = "SELECT * FROM `cotizar` ORDER BY `cotizar`.`ID` ASC ";

            $result = mysqli_query($conexion, $sql);
            // echo $sql;

            while ($mostrar = mysqli_fetch_array($result)) {

            ?>
                <tbody>
                    <tr>
                        <td><?php echo $mostrar['ID'] ?></td>
                        <td><?php echo $mostrar['Nombre'] ?></td>
                        <td><?php echo date('d-m-Y', strtotime($mostrar['Fecha'])); ?></td>
                        <td>$ <?php echo number_format($mostrar['Valor'], 0, ',', '.'); ?></td>

                    </tr>

                </tbody>
            <?php
            }

            ?>
            <tfoot>
                <?php

                $sql3 = ("SELECT FORMAT(SUM(Valor),0,'de_DE') FROM cotizar;");

                $total      = mysqli_query($conexion, $sql3);

                while ($rows = mysqli_fetch_array($total)) {

                    $tot = $rows[0];
                    //echo $tot;
                }

                $sql1 = ("SELECT SUM(Valor) FROM cotizar;");

                $subtotal1      = mysqli_query($conexion, $sql1);

                while ($rows = mysqli_fetch_array($subtotal1)) {

                    $subt = $rows[0];
                    //echo $subt;
                }

                echo "<br>";
                $valor = $subt;
                $porcentaje_deseado = "19";
                $porcentaje = intval(($valor * $porcentaje_deseado) / 100);
                //echo $porcentaje;

                $subtotal = $subt - $porcentaje;
                //echo $subtotal;

                ?>
                <tr>
                    <td colspan="3" class="total">Subtotal</td>
                    <td>$ <?php echo number_format($subtotal, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="total">IVA (19%)</td>
                    <td>$ <?php echo number_format($porcentaje, 0, ',', '.')  ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="total">Total</td>
                    <td>$ <?php echo $tot ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>