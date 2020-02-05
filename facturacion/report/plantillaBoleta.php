<style>
    body {
        font-family: Arial, Helvetica, sans-serif !important;
        font-size: 11px;
    }

    .my-bordes{
        border-collapse: collapse;
    }
    .my-bordes th{
        padding: 10px;
        text-align: center;
    }
    .my-bordes td{
        padding: 5px;
    }
    .my-tam-img{
        width: 80px;
        height: 80px;
        margin-top: 12px;
    }

    .my-sdg-estilo{
        line-height: 0;
        margin-bottom: 0px;
        padding-bottom: 0px;
        font-weight: none;
    }

    /*TAMANIO ANCHO 754px - A4 - VERTICAL
      TAMANIO ALTO 1082px - A4 - VERTICAL*/ 
    .miContenedor{
        position: absolute;
        width: 754px;
        height: 1082px;
    }
    .miBoleta1{
        position:absolute;
        left: 20px;
        width: 377px;
        height: 1082px;
        /*border: 1px solid black;*/
    
    }
    .miBoleta2{
        position:absolute;
        left: 395px;
        width: 377px;
        height: 1082px;
        /*border: 1px solid red;*/
    }

    .my-linea{
        width: 345px;
        border-top: 0.5px solid black;
    }

    .my-descripcion{
        width: 170px;
    }

    .my-descripcion-a{
        width: 135px;
    }
    .my-descripcion-b{
        width: 70px;
    }
    .my-descripcion-c{
        width: 130px;
    }

</style>

<?php

require("./../model/pagoCreacion.php");
$miPagoCreacion = new pagoCreacion();

$surface_imprimir = "";
$surface_total = 0.00;
$surface_fecha = null;
$surface_razon_social = "";
$surface_ruc = "";

$datos = $miPagoCreacion->imprimirBoleta($surface_numero_boleta);


if($datos != false){
    $escribir = "";
    $cont = 1;
    foreach ($datos as $fila) {
        if($cont == 1){
            $surface_numero_boleta = $fila[2];
            $surface_razon_social = $fila[4];
            $surface_ruc = $fila[3];
            $surface_fecha = (($fila[7] != null) ? $fila[7]->format('d/m/Y h:i:s A') : '00/00/0000'); 
            $cont = 0;
        }
        $escribir.='<tr>
                        <td style="text-align: left;">'.$fila[5].'</td>
                        <td style="text-align: right;">'.$fila[6].'</td>
                    </tr>';
        $surface_total += $fila[6];
    }
    $surface_imprimir = $escribir;
}else{
    $surface_imprimir = 'null';
}
?>

<page class="cuerpo_imp">

    <div class="miContenedor">
        <div class="miBoleta1">
            <table align="center">
                <tr>
                    <td align="center">
                        <img src="../../include/img/sistema.png" alt="Sistema" class="my-tam-img">
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <h5 align="center" class="my-sdg-estilo">SISTEMA DE FACTURACIÓN</h5>
                        <h5 align="center" class="my-sdg-estilo">DNI: 72689311</h5>
                        <h5 align="center" class="my-sdg-estilo">AGRUP. FAMILIAR 28 DE FEBRERO S/N</h5>
                        <h5 align="center" class="my-sdg-estilo">LIMA - SAN JUAN DE LURIGANCHO</h5>
                    </td>  
                </tr>

                <tr>
                    <td align="center">
                        <h5 align="center" class="my-sdg-estilo">BOLETA DE VENTA</h5>
                        <h5 align="center" class="my-sdg-estilo"><?php echo $surface_numero_boleta; ?></h5>
                    </td>  
                </tr>
            </table>
            <table>
                <tr>
                    <td>
                        <h5 class="my-sdg-estilo">RUC: <?php echo $surface_ruc; ?></h5>
                        <h5 class="my-sdg-estilo">Razón Social: <?php echo $surface_razon_social; ?></h5>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td>
                        <h5 class="my-sdg-estilo">Descripción:</h5>
                    </td>
                </tr>
                <tr>
                    <td class="my-linea">
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td class="my-descripcion" style="text-align: left;"></td>
                    <td class="my-descripcion" style="text-align: right;"></td>
                </tr>
                <?php echo $surface_imprimir; ?>
            </table>
            <table>
                <tr>
                    <td class="my-linea">
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td class="my-descripcion-a" style="text-align: left;"></td>
                    <td class="my-descripcion-b" style="text-align: center;"></td>
                    <td class="my-descripcion-c" style="text-align: right;"></td>
                </tr>
                <tr>
                
                    <td style="text-align: left;"></td>
                    <td style="text-align: center;">S/</td>
                    <td style="text-align: right;"><?php echo number_format($surface_total, 2); ?></td>
                </tr>
                <tr>
                    <td style="text-align: left;">EXONERADA</td>
                    <td style="text-align: center;">S/</td>
                    <td style="text-align: right;"><?php echo number_format(0, 2); ?></td>
                </tr>
                <tr>
                    <td style="text-align: left;">INAFECTADA</td>
                    <td style="text-align: center;">S/</td>
                    <td style="text-align: right;"><?php echo number_format($surface_total, 2); ?></td>
                </tr>
                <tr>
                    <td style="text-align: left;">GRAVADA</td>
                    <td style="text-align: center;">S/</td>
                    <td style="text-align: right;"><?php echo number_format(0, 2); ?></td>
                </tr>
                <tr>
                    <td style="text-align: left;">I.G.V</td>
                    <td style="text-align: center;">S/</td>
                    <td style="text-align: right;"><?php echo number_format(0, 2); ?></td>
                </tr>
                <tr>
                    <td style="text-align: left;">TOTAL</td>
                    <td style="text-align: center;">S/</td>
                    <td style="text-align: right;"><?php echo number_format($surface_total, 2); ?></td>
                </tr>
            </table>
            <table>
                <tr>
                    <td class="my-linea">
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td>
                        <h5 class="my-sdg-estilo">Fecha: <?php echo $surface_fecha; ?></h5>
                    </td>
                </tr>
            </table>
        </div>
        <div class="miBoleta2">
        <table align="center">
                <tr>
                    <td align="center">
                        <img src="../../include/img/sistema.png" alt="Sistema" class="my-tam-img">
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <h5 align="center" class="my-sdg-estilo">SISTEMA DE FACTURACIÓN</h5>
                        <h5 align="center" class="my-sdg-estilo">DNI: 72689311</h5>
                        <h5 align="center" class="my-sdg-estilo">AGRUP. FAMILIAR 28 DE FEBRERO S/N</h5>
                        <h5 align="center" class="my-sdg-estilo">LIMA - SAN JUAN DE LURIGANCHO</h5>
                    </td>  
                </tr>

                <tr>
                    <td align="center">
                        <h5 align="center" class="my-sdg-estilo">BOLETA DE VENTA</h5>
                        <h5 align="center" class="my-sdg-estilo"><?php echo $surface_numero_boleta; ?></h5>
                    </td>  
                </tr>
            </table>
            <table>
                <tr>
                    <td>
                        <h5 class="my-sdg-estilo">RUC: <?php echo $surface_ruc; ?></h5>
                        <h5 class="my-sdg-estilo">Razón Social: <?php echo $surface_razon_social; ?></h5>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td>
                        <h5 class="my-sdg-estilo">Descripción:</h5>
                    </td>
                </tr>
                <tr>
                    <td class="my-linea">
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td class="my-descripcion" style="text-align: left;"></td>
                    <td class="my-descripcion" style="text-align: right;"></td>
                </tr>
                <?php echo $surface_imprimir; ?>
            </table>
            <table>
                <tr>
                    <td class="my-linea">
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td class="my-descripcion-a" style="text-align: left;"></td>
                    <td class="my-descripcion-b" style="text-align: center;"></td>
                    <td class="my-descripcion-c" style="text-align: right;"></td>
                </tr>
                <tr>
                
                    <td style="text-align: left;"></td>
                    <td style="text-align: center;">S/</td>
                    <td style="text-align: right;"><?php echo number_format($surface_total, 2); ?></td>
                </tr>
                <tr>
                    <td style="text-align: left;">EXONERADA</td>
                    <td style="text-align: center;">S/</td>
                    <td style="text-align: right;"><?php echo number_format(0, 2); ?></td>
                </tr>
                <tr>
                    <td style="text-align: left;">INAFECTADA</td>
                    <td style="text-align: center;">S/</td>
                    <td style="text-align: right;"><?php echo number_format($surface_total, 2); ?></td>
                </tr>
                <tr>
                    <td style="text-align: left;">GRAVADA</td>
                    <td style="text-align: center;">S/</td>
                    <td style="text-align: right;"><?php echo number_format(0, 2); ?></td>
                </tr>
                <tr>
                    <td style="text-align: left;">I.G.V</td>
                    <td style="text-align: center;">S/</td>
                    <td style="text-align: right;"><?php echo number_format(0, 2); ?></td>
                </tr>
                <tr>
                    <td style="text-align: left;">TOTAL</td>
                    <td style="text-align: center;">S/</td>
                    <td style="text-align: right;"><?php echo number_format($surface_total, 2); ?></td>
                </tr>
            </table>
            <table>
                <tr>
                    <td class="my-linea">
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td>
                        <h5 class="my-sdg-estilo">Fecha: <?php echo $surface_fecha; ?></h5>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</page>