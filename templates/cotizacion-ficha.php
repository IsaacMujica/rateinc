<?php
require_once APP_PUBLIC . "/app/Cotizacion.php";

$cotizacion = new Cotizacion();
$detalle = $cotizacion->getInformacionCotizacion($_GET['ficha']);
$items = $cotizacion->getItemsDetalleCotizacion($_GET['ficha']);

//MARCA DE AGUA
$idcot = $detalle->cot_id;
$folio3 = $detalle->cot_folio_padre3;
$folio2 = $detalle->cot_folio_padre2;

$watermark = $cotizacion->existeReferencia($idcot, $folio3, $folio2);

if (is_null($detalle)) {
    echo "La ficha de cotización no existe";
    exit();
}

if ($detalle->cot_referencia_id == 1) {
    $razonSocial    = 'CENTRO TECNICO INDURA LIMITADA';
    $rutEmpresa     = '87.730.100-1';
    $giroEmpresa    = 'Capacitación';

    $observaciones = $cotizacion->getListaObservaciones($_GET['ficha'], 3);
} else {
    $razonSocial    = 'CETI INSPECCIONES Y CERTIFICACIONES LIMITADA';
    $rutEmpresa     = '77.773.480-6';
    $giroEmpresa    = 'Inspecciones y Certificaciones  de Soldaduras';

    $ofertaTecnica = $cotizacion->getListaObservaciones($_GET['ficha'], 1);
    $plazoEntrega = $cotizacion->getListaObservaciones($_GET['ficha'], 2);
    $observaciones = $cotizacion->getListaObservaciones($_GET['ficha'], 3);
    $inspecciones = $cotizacion->getListaObservaciones($_GET['ficha'], 4);
}

?>

<style type="text/css">
    table.page_header {width: 100%; border: none; padding: .5mm }
    table.page_footer {width: 100%; border: none; padding: .5mm}
    div.note {border: solid 1px #DDDDDD;background-color: #EEEEEE; padding: 2mm; border-radius: 0; width: 100%; }
    ul.main { width: 95%; list-style-type: square; }
    ul.main li { padding-bottom: 2mm; }
    h1 { text-align: center; font-size: 20mm}
    h3 { text-align: center; font-size: 14mm}
    h6 { font-size: 4.5mm}
    hr { border: 0; border-top: 1px solid #cbcdd0; }
    table th { color: #222222; font-size: 3.2mm; height: 6mm; padding: 0; }
    table td { color: #222222; font-size: 3mm; height: 6mm; padding: 0;  }
    table.page_item { width: 100%; }
    .seccion-titulo-item { background-color: #EEEEEE; border: solid 1px #DDDDDD; font-size: 3.5mm; padding: 2mm; width: 100%; }
    p { font-size: 3mm; margin-bottom: 0;}

    .img-wm{
        width: 72%;
    }

</style>

<page backtop="25mm" backbottom="30mm" backleft="8mm" backright="8mm" style="font-size: 12pt" class="page">
    
    <page_header>
        <table class="page_header">
            <tr>
                <td style="width: 100%; text-align: left">
                    <img src="<?=HOST?>/public/images/pdf_header.jpg" style="width: 100%;" alt="">
                </td>
            </tr>
        </table>

        <div align="center" style="width: 100%">
            <?php if ($watermark == true){ ?>
            <img src="<?=HOST?>/public/images/txt_cotmod.png" class="img-wm">
            <?php } ?>
        </div>

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

    <!--<div class="watermark">-->

    <?php 

        if($detalle->cot_folio_padre3 == null || $detalle->cot_folio_padre3 == null){
            $folio_final = $_GET['ficha'];
        }else{
            if($detalle->cot_folio_padre2 == null || $detalle->cot_folio_padre2 == ""){
                $folio_final = intval($detalle->cot_folio_padre3);
            }else{
                $folio_final = intval($detalle->cot_folio_padre2);
            }
        }

    ?>

    <h6>COTIZACION N°:  <?= $folio_final; ?> <?= $detalle->cot_folio_padre2 != "" ? "/ Nº Referencia: ".$detalle->cot_folio_padre2 : "" ?> </h6>

    <!--<h6>COTIZACION N°: <?= $folio_final; ?></h6>-->


    <!--<h6>COTIZACION N°: <?= $detalle->cot_folio_padre2 ?> <?= $detalle->cot_folio_padre != "" ? "/ Nº Referencia: ".$detalle->cot_folio_padre : "" ?> </h6>-->

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
                        <th>Teléfono: </th>
                        <td><?=$detalle->con_telefono?></td>
                    </tr>
                    <tr>
                        <th>Dirección: </th>
                        <td><?= $cotizacion->short_string($detalle->emp_direccion); ?></td>
                    </tr>
                    <tr>
                        <th>Comuna: </th>
                        <td><?= $detalle->com_descripcion; ?></td>
                    </tr>
                    <tr>
                        <th>Fecha: </th>
                        <td><?=date("d-m-Y", strtotime($detalle->cot_fecha_creacion))?></td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%; text-align: left;">
                <table>
                    <tr>
                        <th style="width: 30%; text-align: left; height: 8mm;" colspan="2">
                            DATOS DE CETI <span class="">(Para emisión de OC.)</span>
                        </th>
                    </tr>
                    <tr>
                        <th style="width: 30%; text-align: left;">Razón Social: </th>
                        <td style="width: 70%; text-align: left; font-size: 2.6mm;"><?=$razonSocial?></td>
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

    <?php if ($detalle->cot_referencia_id == 1) { ?>
    
    <div class="seccion-titulo-item">
        1.- Descripción del servicio / Objetivos
    </div>

    <?php }else{ ?>
    
    <div class="seccion-titulo-item">
        1.- Descripción del servicio
    </div>

    <?php } ?>

    <br>

    <table class="page_item">

        <?php
            /*$objetivo = $detalle->cot_servicio;
            $objetivo = str_replace("Objetivo:", "<br><br><b>Objetivo:</b>", $objetivo);
            $objetivo = str_replace("Práctica:", "<br><br><b>Práctica:</b>", $objetivo);
            $objetivo = str_replace("Requisitos:", "<br><br><b>Requisitos:</b>", $objetivo);
            $objetivo = str_replace("Certificación:", "<br><br><b>Certificación:</b>", $objetivo);*/

            if ($detalle->cot_referencia_id != 1) { //inspeccion

                $objetivo = str_replace("Norma :", "<br><b>Norma :</b>", $objetivo);
                $objetivo = str_replace("Proceso a calificar :", "<br><b>Proceso a calificar :</b>", $objetivo);
                $objetivo = str_replace("Posición:", "<br><b>Posición:</b>", $objetivo);
                $objetivo = str_replace("Tipo de unión :", "<br><b>Tipo de unión :</b>", $objetivo);
                $objetivo = str_replace("Dimensiones:", "<br><b>Dimensiones:</b>", $objetivo);
                $objetivo = str_replace("Acero :", "<br><b>Acero :</b>", $objetivo);
                $objetivo = str_replace("Metodo :", "<br><b>Metodo :</b>", $objetivo);
                $objetivo = str_replace("Dirección :", "<br><b>Dirección :</b>", $objetivo);
                $objetivo = str_replace("Ensayo :", "<br><b>Ensayo :</b>", $objetivo);
                $objetivo = str_replace("Tipo de muestra :", "<br><b>Tipo de muestra :</b>", $objetivo);
                $objetivo = str_replace("Detalle:", "<br><b>Detalle:</b>", $objetivo);

            ?>
    
            <tr>
                <td style="width: 100%;"><?=($objetivo)?></td>
            </tr>  

            <?php

                }else if($detalle->cot_referencia_id == 1){ // capacitacion

                }

            ?>

        <?php if ($detalle->cot_referencia_id == 1) {?>

            <?php foreach ($items as $key => $value) {
                /*$objetivo = $value->cotpro_objetivo;
                //$objetivo = str_replace("  ", "", '<b>'.$objetivo);
                $objetivo = str_replace("Objetivo:", "<br><br><b>Objetivo:</b>", $objetivo);
                $objetivo = str_replace("Práctica:", "<br><br><b>Práctica:</b>", $objetivo);
                $objetivo = str_replace("Requisitos:", "<br><br><b>Requisitos:</b>", $objetivo);
                $objetivo = str_replace("Certificación:", "<br><br><b>Certificación:</b>", $objetivo);

                if ($detalle->cot_referencia_id != 1) {
                    $objetivo = str_replace("Norma :", "<br><b>Norma :</b>", $objetivo);
                    $objetivo = str_replace("Proceso a calificar :", "<br><b>Proceso a calificar :</b>", $objetivo);
                    $objetivo = str_replace("Posición:", "<br><b>Posición:</b>", $objetivo);
                    $objetivo = str_replace("Tipo de unión :", "<br><b>Tipo de unión :</b>", $objetivo);
                    $objetivo = str_replace("Dimensiones:", "<br><b>Dimensiones:</b>", $objetivo);
                    $objetivo = str_replace("Acero :", "<br><b>Acero :</b>", $objetivo);
                    $objetivo = str_replace("Metodo :", "<br><b>Metodo :</b>", $objetivo);
                    $objetivo = str_replace("Dirección :", "<br><b>Dirección :</b>", $objetivo);
                    $objetivo = str_replace("Ensayo :", "<br><b>Ensayo :</b>", $objetivo);
                    $objetivo = str_replace("Tipo de muestra :", "<br><b>Tipo de muestra :</b>", $objetivo);
                    $objetivo = str_replace("Detalle:", "<br><b>Detalle:</b>", $objetivo);
                }*/
                ?>

                <tr>
                    <th><?= $value->cotpro_descripcion?></th>
                </tr>

                <!--<tr>
                    <td style="width: 100%;"><?=($objetivo)?></td>
                </tr>-->
                <tr>
                    <td style="width: 100%;"><?=$value->cotpro_objetivo?></td>
                </tr>

            <?php } ?>

        <?php } else { ?>

            <?php foreach ($inspecciones as $key => $value) { ?>

                <tr>
                    <th><?= "2 - ".nl2br($value->cotopc_titulo) ?></th>
                </tr>
                <tr>
                    <td><?= nl2br($value->cotopc_descripcion) ?></td>
                </tr>

            <?php } ?>
        <?php } ?>
    </table>
    <br>
    <div>
        <div class="seccion-titulo-item">
            2.- Oferta Económica
        </div>
        <br>

        <?php 

        $width = "15%";
        $colspan = 7;
        if ($detalle->cot_referencia_id != 1) {  $width = "22%";  $colspan = 6;}?>

        <table class="page_item">
            <tr>
                <?php if ($detalle->cot_referencia_id == 1) { ?>
                    <th style="width: 15%; border-collapse: collapse; border-bottom: solid 1px #cccccc;">Código SENCE</th>
                <?php }else{ ?>
                    <th style="width: 15%; border-collapse: collapse; border-bottom: solid 1px #cccccc;">Código SAP</th>
                <?php } ?>                
                
                <th style="width: <?= $width; ?>; border-collapse: collapse; border-bottom: solid 1px #cccccc;">Detalle</th>

                <th style="width: <?= $width; ?>; border-collapse: collapse; border-bottom: solid 1px #cccccc;">Extra</th>

                <th style="width: 10%; border-collapse: collapse; border-bottom: solid 1px #cccccc;">Cant.</th>

                <?php if ($detalle->cot_referencia_id == 1) { ?>
                <th style="width: 15%; border-collapse: collapse; border-bottom: solid 1px #cccccc;">Horas</th>
                <?php } ?>

                <th style="width: 10%; border-collapse: collapse; border-bottom: solid 1px #cccccc; text-align: right;">Valor</th>
                <th style="width: 10%; border-collapse: collapse; border-bottom: solid 1px #cccccc; text-align: right;">Dscto %</th>
                <th style="width: 10%; border-collapse: collapse; border-bottom: solid 1px #cccccc; text-align: right;">Total</th>
            </tr>
            <?php $valor_total = 0; ?>
            <?php foreach ($items as $key => $value) { ?>

                <?php $valor_total += intval($value->cotdet_total) ?>

                <tr>

                    <?php if ($detalle->cot_referencia_id == 1) { ?>
                        <td style="width: 15%; height: 10mm;"><?=$value->cotpro_codigo_sence?></td>
                    <?php }else{ ?>
                        <td style="width: 15%; height: 10mm;"><?=$value->cotpro_codigo_sap?></td>
                    <?php } ?>

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
    </div>
    <br>

    <?php if ($detalle->cot_referencia_id == 1) { ?>
    
    <br>
    <div>
        <div class="seccion-titulo-item">
            3.- Forma de Pago
        </div>

        <p>El tipo de moneda es Peso Chileno, servicio no afecto a I.V.A.</p>
        <p>La forma de pago puede ser cheque al día, o 30 días con un tope máximo de $1.500.000 (garantizado Via Orsan), Tarjeta de Crédito Bancaria (Hasta 6 cuotas precio contado) o depósito o transferencia bancaria en nuestra cuenta corriente al Banco Scotiabank Azul (ex BBVA) N°0504-0114-0100005522 a nombre de CENTRO TÉCNICO INDURA LTDA.</p>
        <p>CETI verificará la condición de pago en el momento de realizar el servicio.</p>
        <p>Favor emitir Orden de Compra o documentos a nombre de: CENTRO TÉCNICO INDURA LTDA. RUT: 87.730.100-1 Cuenta Corriente de Banco
            Scotiabank Azul (ex BBVA) N°0504-0114-0100005522.</p>
    </div>
    
    <!-- SECCION 4 -->
    <div>
        <br>
        <div class="seccion-titulo-item">
            4.- Horarios de ejecución de cursos
        </div>
        <p>
            <?= $detalle->cot_horario ?>
        </p>
        <br>
    </div>


    <!-- SECCION 5 -->
    <div>
        <div class="seccion-titulo-item" style="margin-top: 10px">
            5.- Observaciones
        </div>

        <?php foreach ($observaciones as $key => $value) { ?>

            <p>
                <b><?= ++$key; ?> )</b>
                <?//= nl2br($value->cotopc_descripcion) ?>
                <?= $value->cotopc_descripcion ?>
            </p>

        <?php } ?>

        <?php if($detalle->cot_otro_observacion != ""){ ?>
            <p><b>OTRO: </b><?= $detalle->cot_otro_observacion?></p>
        <?php } ?>
    </div>

    <!-- OBS ADICIONAL-->
    <?php if($detalle->cot_obs_adicional != null || $detalle->cot_obs_adicional != ""){ ?>
    <div>
        <div class="seccion-titulo-item" style="margin-top: 8px">
            9.- Observación Adicional
        </div>
        <p><?= $detalle->cot_obs_adicional?></p>
    </div>
    <?php } ?>

    <div>
        <p style="text-align: center; font-size: 3.5mm;">Sin otro particular, saludamos cordialmente a Ud.</p>
        <br><br><br>

        <table class="page_item">
            <tr>
                <td style="width: 60%;"></td>
                <td style="width: 30%; text-align: center;">
                    <hr>
                </td>
                <td></td>
            </tr>
            <tr>
                <td style="width: 60%; height: 2mm;"></td>
                <td style="width: 30%; text-align: center; font-size: 3.2mm;"><?= $detalle->usu_nombre . " " . $detalle->usu_ape_paterno ?></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: center; height: 2mm; font-size: 3.2mm;"><?= $detalle->usu_email ?></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: center; height: 2mm; font-size: 3.2mm;"><?= $detalle->usu_celular ?></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: center; height: 3mm; font-size: 3.2mm;"><?= $detalle->usu_profesion ?></td>
                <td></td>
            </tr>
        </table>
    </div>

    <?php } else { ?>
        <div>
            <div class="seccion-titulo-item">
                3.- Oferta técnica
            </div>

            <?php foreach ($ofertaTecnica as $key => $value) { ?>

                <p>
                    <b><?= ++$key; ?> )</b>
                    <?= nl2br($value->cotopc_descripcion) ?>
                </p>

            <?php } ?>

            <?php if($detalle->cot_otro_oferta != ""){ ?>
            <p><b>OTRO: </b><?= $detalle->cot_otro_oferta?></p>
            <?php } ?>
        </div>
        <br>
        <div>
            <div class="seccion-titulo-item">
                4.- Horarios de atención
            </div>

            <p><b>Laboratorios y atención al cliente general:</b></p>
            <p>Lunes a Jueves: 08:30 a 18:00 horas.</p>
            <p>Viernes: 08:30 a 15:30 horas.</p>

        </div>
        <br>
        <div>
            <div class="seccion-titulo-item">
                5.- Plazo de entrega y condiciones
            </div>

            <?php foreach ($plazoEntrega as $key => $value) { ?>

                <p>
                    <b><?= ++$key; ?> )</b>
                    <?= nl2br($value->cotopc_descripcion) ?>
                </p>

            <?php } ?>

            <?php if($detalle->cot_otro_condicion != ""){ ?>
            <p><b>OTRO: </b><?= $detalle->cot_otro_condicion?></p>
            <?php } ?>

        </div>
        <br>
        <div>
            <div class="seccion-titulo-item">
                6.- Forma de Pago
            </div>

            <p><b>1.- El tipo de moneda es en Peso Chileno CLP.</b></p>
            <p><b>2.- Formas de pago:</b></p>
            <p>- Depósito o transferencia de fondos a cuenta corriente del Banco Scotiabank Azul (ex BBVA) N°0504-0114-0100005484 a nombre de CETI INSPECCIONES Y CERTIFICACIONES LIMITADA RUT 77.773.480-6</p>
            <p>- Tarjeta de crédito bancaria.</p>
            <p>- Orden de Compra a 30 días, para las empresas que cuentan con línea de crédito.</p>
            <p>- Cheque al día</p>
            <p>- Cheque a 30 días previa evaluación del documento (máximo $1.500.000).</p>
            <p><b>3.- Favor emitir Orden de Compra o documento a nombre de:</b></p>
            <p>- CETI INSPECCIONES Y CERTIFICACIONES LIMITADA</p>
            <p>- Rut: 77.773.480-6</p>
            <p>- Giro: Inspecciones y Certificaciones  de Soldaduras</p>
            <p>- Dirección: Pedro Aguirre Cerda 7060 - Cerrillos, Cerrillos - Santiago.</p>
            <p>- Dirección envío de muestras: Pedro Aguirre Cerda 7060 - Cerrillos, Cerrillos - Santiago.</p>
            <p><b>4.- CETI verificará la condición de pago en el momento de realizar el servicio.</b></p>

        </div>
        <br>
        <div>
            <div class="seccion-titulo-item">
                7.- Observaciones
            </div>

            <?php
            /*echo "<pre>";
            print_r($observaciones);
            echo "</pre>";*/
            ?>

            <?php foreach ($observaciones as $key => $value) { ?>
                <p>
                    <b><?= ++$key; ?> )</b>
                    <?= $value->cotopc_descripcion ?>
                </p>

            <?php } ?>

            <?php if($detalle->cot_otro_observacion != ""){ ?>
            <p><b>OTRO: </b><?= $detalle->cot_otro_observacion?></p>
            <?php } ?>

            <!-- Valides de la oferta  -->
            <br>
            <div>
                <div class="seccion-titulo-item">
                    8.- Validez de la oferta
                </div>

                <p>1.- La oferta tiene una validez de 30 días corridos.</p>
                <p>Para coordinar servicio, tomar contacto con:</p>
                <p>
                    <?= $detalle->usu_nombre . " " . $detalle->usu_ape_paterno ?>
                    <?= $detalle->usu_email ?>
                    <?= $detalle->usu_telefono ?>
                    <?= $detalle->usu_profesion ?>
                </p>

            </div>
            <br>
            <!-- OBS ADICIONAL-->
            <?php if($detalle->cot_obs_adicional != null || $detalle->cot_obs_adicional != ""){ ?>
            <div>
                <div class="seccion-titulo-item">
                    9.- Observación Adicional
                </div>
                <p><?= $detalle->cot_obs_adicional?></p>
            </div>
            <?php } ?>
            <div>
                <p style="text-align: center; font-size: 3.5mm;">Sin otro particular, saludamos cordialmente a Ud.</p>
                <br><br><br>
                <table class="page_item">
                    <tr>
                        <td style="width: 60%; height: 2mm;"></td>
                        <td style="width: 30%; text-align: center;">
                            <hr>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="width: 60%; height: 2mm;"></td>
                        <td style="width: 30%; text-align: center; font-size: 3.2mm;"><?= $detalle->usu_nombre . " " . $detalle->usu_ape_paterno ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center; height: 2mm; font-size: 3.2mm;"><?= $detalle->usu_email ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center; height: 2mm; font-size: 3.2mm;"><?= $detalle->usu_celular ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center; height: 3mm; font-size: 3.2mm;"><?= $detalle->usu_profesion ?></td>
                        <td></td>
                    </tr>
                </table>
            </div>

        </div>



    <?php } ?>

    <!--</div>-->

</page>