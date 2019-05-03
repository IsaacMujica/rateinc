<?php
require_once APP_PUBLIC . "/app/Cotizacion.php";
require_once APP_PUBLIC . "/app/Empresa.php";

$cotizacion = new Cotizacion();
$empresa = new Empresa();

$detalle = $cotizacion->getInformacionCotizacion($_GET['ficha']);
$items = $cotizacion->getItemsDetalleCotizacion($_GET['ficha']);

$idEmpresa = $_GET['idE']; //id empresa
$idCotPag = $_GET['idcotPag']; //id pago cot
$idCot = $_GET['ficha']; //id cot

$arr = array("idC" => $idCotPag, "tipo_p" => "3");
$datos_encargados_pagos = $cotizacion->getPersonalTipo($arr);

$arr = array("idC" => $idCotPag, "tipo_p" => "4");
$datos_encargados_compras = $cotizacion->getPersonalTipo($arr);

$arr = array("idC" => $idCotPag, "tipo_p" => "5");
$datos_encargados_bodega = $cotizacion->getPersonalTipo($arr);

$detalle = $cotizacion->getInformacionCotizacion($idCot);

$detalle_cotpag = $cotizacion->getInformacionCotizacionPago($idCotPag);

if ($detalle->cot_referencia_id == 1) {

    $razonSocial    = 'CENTRO TECNICO INDURA LIMITADA';
    $rutEmpresa     = '87.730.100-1';
    $giroEmpresa    = 'Capacitación';

} else {

    $razonSocial    = 'CETI INSPECCIONES Y CERTIFICACIONES LIMITADA';
    $rutEmpresa     = '77.773.480-6';
    $giroEmpresa    = 'Inspecciones y Certificaciones  de Soldaduras';

}
?>

<style type="text/css">
    table.page_header {width: 100%; border: none; padding: .5mm }
    table.page_footer {width: 100%; border: none; padding: .5mm }
    div.note {border: solid 1px #DDDDDD;background-color: #EEEEEE; padding: 2mm; border-radius: 0; width: 100%; }
    ul.main { width: 95%; list-style-type: square; }
    ul.main li { padding-bottom: 2mm; }
    h1 { text-align: center; font-size: 20mm }
    h3 { text-align: center; font-size: 14mm }
    h6 { font-size: 4.5mm }
    hr { border: 0; border-top: 1px solid #cbcdd0; }
    table th { color: #222222; font-size: 3.5mm; height: 6mm; padding: 0; }
    table td { color: #222222; font-size: 3mm; height: 6mm; padding: 0; }
    table.page_item { width: 100%; }
    .seccion-titulo-item { background-color: #EEEEEE; border: solid 1px #DDDDDD; font-size: 3.5mm; padding: 2mm; width: 100%; }
    p { font-size: 3mm; margin-bottom: 0; }
</style>

<page backtop="30mm" backbottom="30mm" backleft="8mm" backright="8mm" style="font-size: 12pt">
    <page_header>
        <table class="page_header">
            <tr>
                <td style="width: 100%; text-align: left">
                    <img src="<?=HOST?>/public/images/pdf_header.jpg" style="width: 100%;" alt="">
                </td>
            </tr>
        </table>
    </page_header>
    <page_footer>
        <table class="page_footer">
            <tr>
                <td style="width: 100%; text-align: left;">
                    <img src="<?=HOST?>/public/images/pdf_footer.jpg" style="width: 100%;" alt="">
                </td>
            </tr>
        </table>
    </page_footer>
    <hr>

    <?php 

    if($detalle_cotpag->cotpag_otros_df == null || $detalle_cotpag->cotpag_otros_df == ""){
        $detalle_df = "";
    }else{
        $detalle_df = "<br>/ ".$detalle_cotpag->cotpag_otros_df;
    }

    ?>

    <?php
        $union_txt = "Estado de Pago N°: ".$idCotPag." / Orden de Compra N° ".$detalle_cotpag->cotpag_numero_orden." ".$detalle_df;

        $titulo = $cotizacion->short_string($union_txt, 14);
    ?>

    <!--<h6>Estado de Pago N°: <?=$idCotPag?> / Orden de Compra N° <?= $detalle_cotpag->cotpag_numero_orden?> <?= $detalle_df; ?></h6>-->

    <h6><?=$titulo?></h6>

    <table class="page_item">
        <tr>
            <td style="width: 50%; text-align: left;">
                <table>
                    <tr>
                        <th style="width: 30%; text-align: left; height: 8mm;" colspan="2">
                            DATOS DE CLIENTE
                        </th>
                    </tr>
                    <tr>
                        <th style="width: 30%; text-align: left;">Empresa: </th>
                        <td style="width: 70%; text-align: left;"><?=$detalle->emp_razon_social?></td>
                    </tr>
                    <tr>
                        <th style="text-align: left;">Rut: </th>
                        <td style="text-align: left;"><?=$detalle->emp_rut?></td>
                    </tr>
                    <tr>
                        <th style="text-align: left;">Giro: </th>
                        
                        <!--<td style="text-align: left;"><?=$detalle->emp_giro?></td>-->
                        <td><?= $cotizacion->short_string($detalle->emp_giro); ?></td>
                    </tr>
                    <tr>
                        <th>Nombre: </th>
                        <td><?=ucwords(strtolower($detalle->con_nombre))?></td>
                    </tr>
                    <tr>
                        <th>Email: </th>
                        <td><?=$detalle->con_email?></td>
                    </tr>
                    <tr>
                        <th>Telefono: </th>
                        <td><?=$detalle->con_telefono?></td>
                    </tr>
                    <tr>
                        <th>Dirección: </th>
                        <td><?=$detalle->emp_direccion?></td>
                    </tr>
                    <tr>
                        <th>Comuna: </th>
                        <td><?=$detalle->com_descripcion?></td>
                    </tr>
                    <tr>
                        <th>Fecha: </th>
                        <td><?=date("d-m-Y", strtotime($detalle_cotpag->cotpag_fecha_creacion))?></td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%; text-align: left;">
                <table>
                    <!--<tr>
                        <th style="width: 30%; text-align: left; height: 8mm;" colspan="2">
                            DATOS DE CETI <span class="">(Para emisión de OC.)</span>
                        </th>
                    </tr>-->
                    <tr>
                        <th style="width: 30%; text-align: left;">Razón Social: </th>
                        <td style="width: 70%; text-align: left;"><?=$razonSocial?></td>
                    </tr>
                    <tr>
                        <th>Rut: </th>
                        <td><?=$rutEmpresa?></td>
                    </tr>
                    <tr>
                        <th>Giro: </th>
                        <td><?=$giroEmpresa?></td>
                    </tr>
                    <tr>
                        <th>Sede:</th>
                        <td><?= $detalle->sed_descripcion ?></td>
                    </tr>
                    <tr>
                        <th>Dirección: </th>
                        <td><?=$detalle->sed_direccion?></td>
                    </tr>
                    <tr>
                        <th>Email: </th>
                        <td><?=$detalle->usu_email?></td>
                    </tr>
                    <tr>
                        <th>Contacto: </th>
                        <td><?=$detalle->usu_nombre . " " . $detalle->usu_ape_paterno?></td>
                    </tr>
                    <tr>
                        <th></th>
                        <td></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
    <div class="seccion-titulo-item">
        Detalles
    </div>
    <br>

    <?php
    $width = "12%";
    $colspan = 8;
    if ($detalle->cot_referencia_id != 1) {  $width = "20%";  $colspan = 7;}
    ?>

    <table class="page_item">
        <tr>
            <th style="width: 10%; border-collapse: collapse; border-bottom: solid 1px #cccccc;">C. SAP</th>
            <th style="width: 10%; border-collapse: collapse; border-bottom: solid 1px #cccccc;">OT</th>
            <th style="width: <?= $width; ?>; border-collapse: collapse; border-bottom: solid 1px #cccccc;">Detalle</th>
            <th style="width: <?= $width; ?>; border-collapse: collapse; border-bottom: solid 1px #cccccc;">Extra</th>
            <th style="width: 10%; border-collapse: collapse; border-bottom: solid 1px #cccccc;">Cant.</th>

            <?php if ($detalle->cot_referencia_id == 1) { ?>
            <th style="width: 15%; border-collapse: collapse; border-bottom: solid 1px #cccccc;">Horas</th>
            <?php } ?>

            <th style="width: 10%; border-collapse: collapse; border-bottom: solid 1px #cccccc; text-align: right;">Valor</th>

            <th style="width: 10%; border-collapse: collapse; border-bottom: solid 1px #cccccc; text-align: right;">Dscto</th>
            <th style="width: 10%; border-collapse: collapse; border-bottom: solid 1px #cccccc; text-align: right;">Total</th>
        </tr>


        <?php $valor_total = 0; ?>
        <?php foreach ($items as $key => $value) { ?>

            <?php $valor_total += intval($value->cotdet_total) ?>

            <tr>
                <td style="width: 10%; height: 10mm;"><?=$value->cotpro_codigo_sap?></td>
                <!--<td style="width: 15%; height: 10mm;"><?=$value->cotpro_codigo_sence?></td>-->
                <td style="width: 10%; height: 10mm;"><?= $value->cotpro_codigo_ot ?> </td>
                <td style="width: <?= $width; ?>; height: 10mm;"><?=$value->cotpro_descripcion?></td>
                <td style="width: <?= $width; ?>; height: 10mm;"><?=$value->cotdet_detextra?></td>
                <td style="width: 10%; height: 10mm;"><?=$value->cotdet_cantidad?></td>

                <?php if ($detalle->cot_referencia_id == 1) { ?>
                <td style="width: 15%; height: 10mm;"><?=$value->cotpro_horas?></td>
                <?php } ?>

                <td style="width: 10%; height: 10mm; text-align: right;"><?="$ " . number_format($value->cotdet_valor, 0, ',', '.') ?></td>
                <td style="width: 10%; height: 10mm; text-align: right;"><?= $value->cotdet_descuento; ?></td>
                <td style="width: 10%; height: 10mm; text-align: right;">
                    <?= "$ " . number_format(intval($value->cotdet_total), 0, ',', '.') ?>
                </td>
            </tr>

        <?php } ?>

        <?php if ($detalle->cot_referencia_id == 1) { ?>

            <tr>
                <th style="height: 8mm; text-align: right;" colspan="<?= $colspan; ?>">Valor Total Exento de IVA</th>
                <th style="height: 10mm; text-align: right;">
                    <?= "$ " . number_format($valor_total, 0, ',', '.')  ?>
                </th>
            </tr>

        <?php } else { ?>

            <tr>
                <th style="height: 7mm; text-align: right; border-top: solid 1px #cccccc;" colspan="<?= $colspan; ?>">NETO</th>
                <th style="height: 7mm; text-align: right; border-top: solid 1px #cccccc;">
                    <?= "$ " . number_format($valor_total, 0, ',', '.')  ?>
                </th>
            </tr>
            <tr>
                <th style="height: 7mm; text-align: right;" colspan="<?= $colspan; ?>">IVA 19%</th>
                <th style="height: 7mm; text-align: right;">
                    <?= "$ " . number_format(($valor_total * 0.19), 0, ',', '.')  ?>
                </th>
            </tr>
            <tr>
                <th style="height: 7mm; text-align: right;" colspan="<?= $colspan; ?>">VALOR TOTAL</th>
                <th style="height: 7mm; text-align: right;">
                    <?= "$ " . number_format($valor_total * 1.19, 0, ',', '.')  ?>
                </th>
            </tr>

        <?php } ?>

    </table>

    <br><br><br><br>

    <table class="page_item">
        <tr>
            <th style="width: 25%; text-align: left;">
                Encargado de Pagos
            </th>
            <td style="width: 75%; text-align: left;">
                <?=$datos_encargados_pagos->empper_nombre. " - " .$datos_encargados_pagos->empper_email. " - " .$datos_encargados_pagos->empper_telefono; ?>
            </td>
        </tr>
        <tr>
            <th style="width: 25%; text-align: left;">
                Encargado de Compras
            </th>
            <td style="width: 75%; text-align: left;">
                <?=$datos_encargados_compras->empper_nombre. " - " .$datos_encargados_compras->empper_email. " - " .$datos_encargados_compras->empper_telefono; ?>
            </td>
        </tr>
        <tr>
            <th style="width: 25%; text-align: left;">
                Jefe de Bodega
            </th>
            <td style="width: 75%; text-align: left;">
                <?=$datos_encargados_bodega->empper_nombre. " - " .$datos_encargados_bodega->empper_email. " - " .$datos_encargados_bodega->empper_telefono; ?>
            </td>
        </tr>
    </table>

    <br>

    <table class="page_item">
        <tr>
            <th style="width: 25%; text-align: left;">
                EMITE
            </th>
            <td style="width: 25%; text-align: left;">
                <?=ucwords(strtolower($detalle->usu_nombre . " " . $detalle->usu_ape_paterno))?>
            </td>
        </tr>
        <tr>
            <th style="width: 25%; text-align: left; border: 0">
                
            </th>
            <td style="width: 25%; text-align: left;">
                <?=$detalle->usu_email?>
            </td>
        </tr>
        <tr>
            <th style="width: 25%; text-align: left; border: 0">
                
            </th>
            <td style="width: 25%; text-align: left;">
                <?=$detalle->usu_telefono == "" ? $detalle->usu_celular : $detalle->usu_telefono; ?>
            </td>
        </tr>
    </table>

    <table class="page_item">
        <tr>
            <th style="width: 25%; text-align: left;">
                Forma de Pago:
            </th>

            <?php 

            if($detalle_cotpag->cotpag_forma_pago == 1){
                $formapago = "Orden de Compra";
            }else if($detalle_cotpag->cotpag_forma_pago == 2){
                $formapago = "Pago Directo";
            }else if($detalle_cotpag->cotpag_forma_pago == 3){
                $formapago = "Efectivo";
            }else if($detalle_cotpag->cotpag_forma_pago == 4){
                $formapago = "Cheque al día";
            }else if($detalle_cotpag->cotpag_forma_pago == 5){
                $formapago = "Transferencia Bancaria";
            }else if($detalle_cotpag->cotpag_forma_pago == 6){
                $formapago = "Cheque a 30 días";
            }

            ?>

            <td style="width: 25%; text-align: left;">
                <?= $formapago; ?>
            </td>
        </tr>
    </table>
</page>