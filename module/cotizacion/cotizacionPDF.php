<?php
header("Content-Type: text/html;charset=utf-8");
include_once "../../config/app.php";
include_once "../../config/session.php";
include_once APP_PUBLIC . "/app/Database.php";
include_once APP_PUBLIC . '/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

if (!isset($_GET['ficha']) || !is_numeric($_GET['ficha'])) {
    echo "La ficha de cotización seleccionada no existe";
    exit();
}

$template = APP_PUBLIC . "/templates/cotizacion-ficha.php";
$dir = APP_PUBLIC . "/storage/cotizacion/";

try {
    ob_start();
    include $template;
    $content = ob_get_clean();

    $html2pdf = new Html2Pdf('P', array("216", "279"), 'es'); //A4 //Letter
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content);
    $html2pdf->output('cotizacion_ficha_' . $_GET['ficha'] . '.pdf');
    //$html2pdf->output($dir . 'cotizacion_ficha_' . $_GET['ficha'] . '.pdf');
} catch (Html2PdfException $e) {
    $html2pdf->clean();
    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
}

exit();

//funcion de respaldo

if (isset($_GET['ficha']) && is_numeric($_GET['ficha']) && $_GET['ficha'] != '') {
    $id = $_GET['ficha'] * 1;
    session_start();
    include '../model/config/connection.php';

    if (true) {

        $sql = "
		SELECT
			 c.emprnombre
			,c.atsenor
			,c.telefono
			,c.direccion
			,c.email
			,c.fechahora

			,c.ckbx1, c.ckbx2, c.ckbx3, c.ckbx4, c.ckbx5, c.ckbx6, c.ckbx7, c.ckbx8, c.ckbx010, c.textareahec, c.ckbx9text,

			c.obs1,c.obs2,c.obs3,c.obs4,c.obs5,c.obs6,c.obs7,c.obs8,c.obs9,c.obs10,c.obs11,c.obstext,

			c.ckbx10,c.ckbx11,c.ckbx12,c.ckbx13,c.ckbx14,c.ckbx15,c.ckbx16,
			c.ckbx20,c.ckbx21,c.ckbx22,
			c.ckbx30,c.ckbx31,c.ckbx32,c.ckbx33,c.ckbx34,c.ckbx35,
			c.ckbx40,c.ckbx41,c.ckbx42,c.ckbx43,c.ckbx44,
			c.ckbx50,c.ckbx51,c.ckbx52,c.ckbx53,c.ckbx54,
			c.ckbx60,c.ckbx61,c.ckbx62,c.ckbx63,c.ckbx64,c.ckbx65,c.ckbx66,c.ckbx67,c.ckbx68,c.ckbx69,c.ckbx610


			,concat(u.usu_nombre,' ',u.usu_ape_paterno,' ',u.usu_ape_materno) as instructor
			,concat(uu.usu_nombre,' ',uu.usu_ape_paterno,' ',uu.usu_ape_materno) as contacto
			,u.usu_email
			,u.usu_fono_celular
			,u.usu_desc_cargo

			,uu.usu_email as usu_email2
			,uu.usu_fono_celular as usu_fono_celular2
			,uu.usu_desc_cargo as usu_desc_cargo2


			,e.emp_nombre
			,e.emp_rut
			,s.sed_nombre
			,c.id_cotizacion_tipo
			,c.SERVICIO
			,c.OTRO
			,c.ckbx1002
		FROM cotizacion c
		LEFT JOIN usuario u ON u.usu_codigo = c.id_usuario
		LEFT JOIN usuario uu ON uu.usu_codigo = c.contacto
		LEFT JOIN empresa e ON e.emp_codigo = c.id_empresa
        LEFT JOIN sede s ON s.sed_codigo = c.sede
		WHERE c.id  = '$id' ";
        $res = mysql_query($sql, $link);
        if ($res) {
            $fila = mysql_fetch_array($res);
            if ($fila[0] !== NULL) {
                $arrayAll = array(
                    array($fila['emprnombre']),
                    array($fila['atsenor']),
                    array($fila['telefono']),
                    array($fila['direccion']),
                    array($fila['email']),
                    array($fila['fechahora']),

                    array($fila['instructor']),
                    array($fila['usu_email']),
                    array($fila['usu_fono_celular']),
                    array($fila['usu_desc_cargo']),

                    array($fila['emp_nombre']),//10
                    array($fila['emp_rut']),

                    array($fila['ckbx1']),
                    array($fila['ckbx2']),
                    array($fila['ckbx3']),
                    array($fila['ckbx4']),
                    array($fila['ckbx5']),
                    array($fila['ckbx6']),
                    array($fila['ckbx7']),
                    array($fila['ckbx8']),
                    array($fila['textareahec']),//20
                    array($fila['ckbx9text']),
                    array($fila['ckbx010']),
                    array($fila['sed_nombre']),

                    array($fila['obs1']),//24
                    array($fila['obs2']),//25
                    array($fila['obs3']),//26
                    array($fila['obs4']),//27
                    array($fila['obs5']),//28
                    array($fila['obs6']),//29
                    array($fila['obs7']),//30
                    array($fila['obs8']),//31
                    array($fila['obs9']),//32
                    array($fila['obs10']),//33
                    array($fila['obs11']),//34
                    array($fila['obstext']),//35

                );

                $tipoc = $fila['id_cotizacion_tipo'];
                $contacto1 = $fila['contacto'];
                $contacto2 = $fila['usu_email2'];
                $contacto3 = $fila['usu_fono_celular2'];
                $contacto4 = $fila['usu_desc_cargo2'];
                $SERVICIO = $fila['SERVICIO'];
                $OTRO = $fila['OTRO'];
                $ckbx1002 = $fila['ckbx1002'];


//3.2.4 OFERTA TECNICA
                //3 Calificación de Soldador
                $arrayAll1 = array($fila['ckbx10'], $fila['ckbx11'], $fila['ckbx12'], $fila['ckbx13'], $fila['ckbx14'], $fila['ckbx15'], $fila['ckbx16']);
                //2 Ensayos No Destructivos (END)
                $arrayAll2 = array($fila['ckbx20'], $fila['ckbx21'], $fila['ckbx22']);
                //4 Laboratorios
                $arrayAll3 = array($fila['ckbx30'], $fila['ckbx31'], $fila['ckbx32'], $fila['ckbx33'], $fila['ckbx34'], $fila['ckbx35']);
//3.2.4 PLAZO DE ENTREGA Y CONDICIONES
                $arrayAll4 = array($fila['ckbx40'], $fila['ckbx41'], $fila['ckbx42'], $fila['ckbx43'], $fila['ckbx44']);
//3.2.4 TIPO DE MONEDA Y FORMA DE PAGO
                $arrayAll5 = array($fila['ckbx50'], $fila['ckbx51'], $fila['ckbx52'], $fila['ckbx53'], $fila['ckbx54']);
//3.2.4 OBSERVACIONES
                $arrayAll6 = array($fila['ckbx60'], $fila['ckbx61'], $fila['ckbx62'], $fila['ckbx63'], $fila['ckbx64'], $fila['ckbx65'], $fila['ckbx66'], $fila['ckbx67'], $fila['ckbx68'], $fila['ckbx69'], $fila['ckbx610']);

                $sql = "
					SELECT
						c.CODSAP
						,c.CANTIDAD
						,c.VALOR
						,c.TOTAL
						,c.DETALLE
						,c.DESC as descuento
						,cp.horas
						,cp.objetivo
						,c.OBJETIVOS
					FROM cotizacion_oferta c
					INNER JOIN
					(SELECT cp.horas,cp.objetivo,cp.codigo FROM cotizacion_precios cp group by cp.codigo
					) cp
					on cp.codigo = c.CODSAP
					WHERE c.id_cotizacion = '$id'
					";
                $res = mysql_query($sql, $link);
                $m = array();
                $descuentoactivado = false;
                while ($fi = mysql_fetch_array($res)) {
                    $m[count($m)] = $fi;

                    if ($fi['descuento'] != 0) {
                        $descuentoactivado = true;
                    }
                }

            }
        }
    }

    mysql_close($link);
} else {
    return;
}

//top
if (true) {
    require('../js/plugins/pdf/fpdf.php');
    $pdf = new PDF_HTML('P', 'mm', 'Letter');
    $pdf->SetAutoPageBreak(true, 2);
    $pdf->SetLeftMargin(10);
    $pdf->AddPage();
    $pdf->cMargin = 2;
    $pdf->Image('logofinal2.jpg', 5, 5, 200, 265, 'JPG');
    $brd = 0;
    $y = 20;
    $pdf->SetFillColor(192, 192, 192);
}


/*
'DATOS EMPRESA'
'Nuestros Datos para la emisión de la Orden de Compra:
Razón social : CENTRO TECNICO INDURA LIMITADA
RUT : 87.730.100-1
Giro : Capacitación
Dirección : Avda. Pedro Aguirre Cerda 7060, Cerrillos - Santiago'
*/


//pagina uno
if (true) {
    if (count($m) == 1) {
        $pdf->SetXY(10, 43);
    } else {
        $pdf->SetXY(10, 28);
    }
    $pdf->Cell(195, 64, utf8_decode(''), 1, 0, 'C');


    if (count($m) == 1) {
        $pdf->SetXY(10, 25);
    } else {
        $pdf->SetXY(10, 10);
    }


    if ($tipoc != 1) {
        $Razon = 'CETI INSPECCIONES Y CERTIFICACIONES LIMITADA';
        $RUTaa = '77.773.480-6';
        $GIROa = 'Inspecciones y Certificaciones  de Soldaduras';
    } else {
        $Razon = 'CENTRO TECNICO INDURA LIMITADA';
        $RUTaa = '87.730.100-1';
        $GIROa = 'Capacitación';
    }


    $sep = 6;

    $pdf->Cell(195, 15, utf8_decode(''), $brd, 0, 'C');
    $pdf->Ln(17);
    $pdf->SetFont('arial', 'B', 12);
    $pdf->Cell(100, 15, utf8_decode('COTIZACIÓN N° ' . $id . ' / ' . date('Y')), $brd, 0, 'C');
    $pdf->Cell(95, 15, utf8_decode('DATOS CETI'), $brd, 0, 'C');
    $pdf->Ln(13);
    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(30, $sep, utf8_decode('EMPRESA'), $brd, 0, 'C');
    $pdf->Cell(5, $sep, utf8_decode(':'), $brd, 0, 'C');
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(65, $sep, utf8_decode(html_entity_decode(ucwords(strtolower($arrayAll[10][0])))), $brd, 0, 'L');
    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(95, $sep, utf8_decode('Nuestros Datos para la emisión de la Orden de Compra'), $brd, 0, 'C');
    $pdf->Ln($sep);
    $pdf->Cell(30, $sep, utf8_decode('RUT'), $brd, 0, 'C');
    $pdf->Cell(5, $sep, utf8_decode(':'), $brd, 0, 'C');
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(65, $sep, utf8_decode($arrayAll[11][0]), $brd, 0, 'L');
    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(20, $sep, utf8_decode('Razón social'), $brd, 0, 'C');
    $pdf->Cell(3, $sep, utf8_decode(':'), $brd, 0, 'C');
    $pdf->SetFont('arial', '', 7.5);
    $pdf->Cell(60, $sep, utf8_decode(html_entity_decode($Razon)), $brd, 0, 'L');
    $pdf->Ln($sep);
    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(30, $sep, utf8_decode('AT. SEÑOR'), $brd, 0, 'C');
    $pdf->Cell(5, $sep, utf8_decode(':'), $brd, 0, 'C');
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(65, $sep, utf8_decode(html_entity_decode(ucwords(strtolower($arrayAll[1][0])))), $brd, 0, 'L');
    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(20, $sep, utf8_decode('RUT'), $brd, 0, 'C');
    $pdf->Cell(3, $sep, utf8_decode(':'), $brd, 0, 'C');
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(60, $sep, utf8_decode($RUTaa), $brd, 0, 'L');
    $pdf->Ln($sep);
    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(30, $sep, utf8_decode('TELEFONO'), $brd, 0, 'C');
    $pdf->Cell(5, $sep, utf8_decode(':'), $brd, 0, 'C');
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(65, $sep, utf8_decode(html_entity_decode($arrayAll[2][0])), $brd, 0, 'L');
    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(20, $sep, utf8_decode('GIRO'), $brd, 0, 'C');
    $pdf->Cell(3, $sep, utf8_decode(':'), $brd, 0, 'C');
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(60, $sep, utf8_decode(html_entity_decode($GIROa)), $brd, 0, 'L');
    $pdf->Ln($sep);
    $pdf->SetFont('arial', 'B', 8);

    $pdf->Cell(30, $sep, utf8_decode('DIRECCIÓN'), $brd, 0, 'C');
    $pdf->Cell(5, $sep, utf8_decode(':'), $brd, 0, 'C');
    $pdf->SetFont('arial', '', 8);

    $yy = $pdf->GetY();
    $xx = $pdf->GetX();


    $pdf->MultiCell(65, $sep, utf8_decode(html_entity_decode($arrayAll[3][0])), $brd, 'L');
    $pdf->SetFont('arial', 'B', 8);

    $yy2 = $pdf->GetY();
    $xx2 = $pdf->GetX();

    $pdf->SetXY($xx + 65, $yy);

    $pdf->Cell(20, $sep, utf8_decode('DIRECCIÓN'), $brd, 0, 'C');
    $pdf->Cell(3, $sep, utf8_decode(':'), $brd, 0, 'C');
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(60, $sep, utf8_decode('Avda. Pedro Aguirre Cerda 7060, Cerrillos - Santiago'), $brd, 0, 'L');
    $pdf->Ln($sep);

    $pdf->SetXY(10, $yy2);


    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(30, $sep, utf8_decode('E-MAIL'), $brd, 0, 'C');
    $pdf->Cell(5, $sep, utf8_decode(':'), $brd, 0, 'C');
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(65, $sep, utf8_decode(html_entity_decode($arrayAll[4][0])), $brd, 0, 'L');
    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(20, $sep, utf8_decode('E-MAIL'), $brd, 0, 'C');
    $pdf->Cell(3, $sep, utf8_decode(':'), $brd, 0, 'C');
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(60, $sep, utf8_decode(html_entity_decode($arrayAll[7][0])), $brd, 0, 'L');
    $pdf->Ln($sep);
    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(30, $sep, utf8_decode('FECHA'), $brd, 0, 'C');
    $pdf->Cell(5, $sep, utf8_decode(':'), $brd, 0, 'C');
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(65, $sep, utf8_decode($arrayAll[5][0]), $brd, 0, 'L');
    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(20, $sep, utf8_decode('CONTACTO'), $brd, 0, 'C');
    $pdf->Cell(3, $sep, utf8_decode(':'), $brd, 0, 'C');
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(60, $sep, utf8_decode(html_entity_decode(ucwords(strtolower($arrayAll[6][0])))), $brd, 0, 'L');
    $pdf->Ln(10);
    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(195, $sep, utf8_decode('1.- DESCRIPCION DEL SERVICIO / OBJETIVOS'), 1, 0, 'L');
    $pdf->Ln($sep);
    $pdf->SetFont('arial', '', 8);


    if ($tipoc != 1) {
        $mmm = 1;
    } else {
        $mmm = $m;
    }

    for ($i = 0; $i < count($mmm); $i++) {

        if ($tipoc != 1) {
            $objetivo = $SERVICIO;
        } else {
            $objetivo = $m[$i]['objetivo'];
        }

        if ($objetivo != '') {
            $pdf->Line(10, $pdf->GetY(), 205, $pdf->GetY());
            $yy = $pdf->GetY();
            if ($yy > 210) {
                $pdf->AddPage();
                $pdf->SetXY(10, 30);
                $pdf->Image('logofinal2.jpg', 5, 5, 200, 265, 'JPG');
                $pdf->Line(10, $pdf->GetY(), 205, $pdf->GetY());
                $yy = 10;
            }
            $objetivo = str_replace("  ", "", '<b>' . $objetivo);
            $objetivo = str_replace("Objetivo:", "<br>Objetivo:</b>", $objetivo);
            $objetivo = str_replace("Práctica:", "<br><b>Práctica:</b>", $objetivo);
            $objetivo = str_replace("Requisitos:", "<br><b>Requisitos:</b>", $objetivo);
            $objetivo = str_replace("Certificación:", "<br><b>Certificación:</b>", $objetivo);

            if ($tipoc != 1) {
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
            }

            $pdf->WriteHTML(utf8_decode($objetivo));
            $pdf->Ln(7);
            $pdf->Line(10, $yy, 10, $pdf->GetY());
            $pdf->Line(205, $yy, 205, $pdf->GetY());
            $pdf->Line(10, $pdf->GetY(), 205, $pdf->GetY());
        }
    }


    if ($pdf->GetY() > 200) {
        $pdf->AddPage();
        $pdf->SetXY(10, 30);
        $pdf->Image('logofinal2.jpg', 5, 5, 200, 265, 'JPG');
    }

    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(195, 7, utf8_decode('2.- OFERTA ECONOMICA'), 1, 0, 'L');
    $pdf->Ln(7);


    if ($tipoc != 1) {
        $pdf->Cell(20, 7, utf8_decode('COD SAP'), 1, 0, 'C');
        $DETALLEXX = 115;
        $horasXX = 0;
    } else {
        $pdf->Cell(20, 7, utf8_decode('COD SENCE'), 1, 0, 'C');
        $DETALLEXX = 85;
        $horasXX = 30;
    }


    $pdf->Cell($DETALLEXX, 7, utf8_decode('DETALLE'), 1, 0, 'C');
    $pdf->Cell(10, 7, utf8_decode('CANT'), 1, 0, 'C');


    if ($tipoc == 1) {
        $pdf->Cell(30, 7, utf8_decode('HORAS'), 1, 0, 'C');
    }


    $pdf->Cell(20, 7, utf8_decode('VALOR $'), 1, 0, 'C');
    if ($descuentoactivado) {
        $pdf->Cell(10, 7, utf8_decode('DES %'), 1, 0, 'C');
        $tott = 20;
    } else {
        $tott = 30;
    }
    $pdf->Cell($tott, 7, utf8_decode('TOTAL $'), 1, 0, 'C');
    $pdf->SetFont('arial', '', 8);
    $pdf->Ln(7);
    $total1 = 0;
    $y11y = $pdf->GetY();


    for ($i = 0; $i < count($m); $i++) {


        if ($m[$i]['CODSAP'] != '') {
            $pdLn = 0;
            $pdf->Cell(20, 7, utf8_decode($m[$i]['CODSAP']), 0, 0, 'C');
            $xx = $pdf->GetX();
            $yy = $pdf->GetY();
            $yy11 = $pdf->GetY();
            $pdf->MultiCell($DETALLEXX, 7, utf8_decode($m[$i]['DETALLE']), 0);
            $xx2 = $pdf->GetX();
            $yy2 = $pdf->GetY();
            $yy3 = $yy2 - $yy;
            $pdf->SetXY($xx + $DETALLEXX, $yy);
            $pdf->Cell(10, 7, utf8_decode($m[$i]['CANTIDAD']), 0, 0, 'C');
            $xx = $pdf->GetX();
            $yy = $pdf->GetY();
            $pdf->MultiCell($horasXX, 7, utf8_decode($m[$i]['horas']), 0);
            $xx2 = $pdf->GetX();
            $yy2 = $pdf->GetY();
            $yy4 = $yy2 - $yy;
            $pdf->SetXY($xx + $horasXX, $yy);
            $pdf->Cell(20, 7, utf8_decode('$ ' . number_format($m[$i]['VALOR'], 0, '', '.')), 0, 0, 'C');
            if ($descuentoactivado) {
                $pdf->Cell(10, 7, utf8_decode($m[$i]['descuento'] . '%'), 0, 0, 'C');
                $tott = 20;
            } else {
                $tott = 30;
            }
            $pdf->Cell($tott, 7, utf8_decode('$ ' . number_format($m[$i]['TOTAL'], 0, '', '.')), 0, 0, 'C');
            $total1 = $total1 + $m[$i]['TOTAL'];
            $yy5 = $yy4 >= $yy3 ? $yy4 : $yy3;

            $pdf->Line(10, $yy11 + $yy5, 205, $yy11 + $yy5);


            $pdf->Ln($yy5);
        }
    }


    $pdf->Cell(125, 7, utf8_decode(''), 0, 0, 'C');

    $pdf->Line(10, $y11y, 10, $pdf->GetY());
    $pdf->Line(205, $y11y, 205, $pdf->GetY());
    $pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX(), $pdf->GetY() + 7);
    $pdf->Line($pdf->GetX(), $pdf->GetY() + 7, $pdf->GetX() + 50, $pdf->GetY() + 7);


    $pdf->SetFont('arial', 'B', 8);
    if ($tipoc != 1) {


        $pdf->Cell(50, 7, utf8_decode('NETO'), 0, 0, 'C');
        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(20, 7, utf8_decode('$' . number_format($total1, 0, '', '.')), 1, 0, 'C');

        $pdf->Ln(7);

        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(125, 7, utf8_decode(''), 0, 0, 'C');
        $pdf->Cell(50, 7, utf8_decode('IVA 19%'), 1, 0, 'C');
        $pdf->SetFont('arial', '', 8);

        $total1iva = $total1 * 0.19;

        $pdf->Cell(20, 7, utf8_decode('$' . number_format($total1iva, 0, '', '.')), 1, 0, 'C');
        $pdf->Ln(7);
        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(125, 7, utf8_decode(''), 0, 0, 'C');
        $pdf->Cell(50, 7, utf8_decode('VALOR TOTAL'), 1, 0, 'C');
        $pdf->SetFont('arial', '', 8);

        $total12 = number_format($total1 + $total1iva, 0, '', '.');

        $pdf->Cell(20, 7, utf8_decode('$' . $total12), 1, 0, 'C');
        $pdf->Ln(7);
    } else {
        $pdf->Cell(25, 7, utf8_decode('VALOR TOTAL'), 0, 0, 'R');
        $pdf->Cell(25, 7, utf8_decode('EXENTO DE IVA'), 0, 0, 'L');
        $pdf->SetFont('arial', '', 8);

        $pdf->Cell(20, 7, utf8_decode('$' . number_format($total1, 0, '', '.')), 1, 0, 'C');
        $pdf->Ln(7);
    }


    if ($pdf->GetY() > 200) {
        $pdf->AddPage();
        $pdf->SetXY(10, 30);
        $pdf->Image('logofinal2.jpg', 5, 5, 200, 265, 'JPG');
    }

    $valordefila = 3;

    if ($tipoc == 3 || $tipoc == 5 || $tipoc == 6 || $tipoc == 7) {
        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(195, 7, utf8_decode($valordefila . '.- OFERTA TECNICA'), 1, 0, 'L');
        ++$valordefila;
        $pdf->SetFont('arial', '', 8);
        $pdf->Ln(7);
        $OBSERVACIONES = '';
        $OBSERVACIONESnum = 1;
        $OBSERVACIONEStotal = count($arrayAll1);
        $arraylist = array(
            'Respaldo y firma de Inspector Soldadura Certificado por AWS, nivel CWI'
        , 'Especialistas experimentados y/o certificados por la Sociedad Americana de Soldadura (AWS).'
        , 'Entrega a cada alumno el "Manual de calificación de soldador".'
        , 'Entrega de credencial con la información del soldador calificado.'
        , 'Posibilidad de validar la calificación en línea, a travez de nuestras plataformas virtuales. '
        , 'Entrega de informe de rechazo con respaldo fotográfico.'
        , $arrayAll1[$OBSERVACIONEStotal - 1]);
        for ($i = 0; $i < $OBSERVACIONEStotal; $i++) {
            if ($arrayAll1[$i] != '0' && $arrayAll1[$i] != '') {
                $OBSERVACIONES .= $OBSERVACIONESnum . ') ' . $arraylist[$i] . '
';
                ++$OBSERVACIONESnum;
            }
        }
        $pdf->MultiCell(195, 4, utf8_decode($OBSERVACIONES), 1);
    }
    if ($tipoc == 2) {
        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(195, 7, utf8_decode($valordefila . '.- OFERTA TECNICA'), 1, 0, 'L');
        ++$valordefila;
        $pdf->SetFont('arial', '', 8);
        $pdf->Ln(7);
        $OBSERVACIONES = '';
        $OBSERVACIONESnum = 1;
        $OBSERVACIONEStotal = count($arrayAll2);
        $arraylist = array(
            'Respaldo y firma de Inspector Soldadura Certificado por AWS, nivel CWI'
        , 'Inspector END Certificado nivel II en líquidos penetrantes, particular magnetizables y ultrasonido'
        , $arrayAll2[$OBSERVACIONEStotal - 1]);
        for ($i = 0; $i < $OBSERVACIONEStotal; $i++) {
            if ($arrayAll2[$i] != '0') {
                $OBSERVACIONES .= $OBSERVACIONESnum . ') ' . $arraylist[$i] . '
';
                ++$OBSERVACIONESnum;
            }
        }
        $pdf->MultiCell(195, 4, utf8_decode($OBSERVACIONES), 1);
    }
    if ($tipoc == 4) {
        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(195, 7, utf8_decode($valordefila . '.- OFERTA TECNICA'), 1, 0, 'L');
        ++$valordefila;
        $pdf->SetFont('arial', '', 8);
        $pdf->Ln(7);
        $OBSERVACIONES = '';
        $OBSERVACIONESnum = 1;
        $OBSERVACIONEStotal = count($arrayAll3);
        $arraylist = array(
            'Respaldo y firma de Inspector Soldadura Certificado por AWS, nivel CWI.'
        , 'Laboratorios de análisis químico elemental basado en técnicas validadas por ASTM.'
        , 'Laboratorios de ensayos mecánicos basado en técnicas validadas por ASTM.'
        , 'Respaldo y firma de ingeniero Químico.'
        , 'Respaldo y firma de ingeniero Metalúrgico.'
        , $arrayAll3[$OBSERVACIONEStotal - 1]);
        for ($i = 0; $i < $OBSERVACIONEStotal; $i++) {
            if ($arrayAll3[$i] != '0' && $arrayAll3[$i] != '') {
                $OBSERVACIONES .= $OBSERVACIONESnum . ') ' . $arraylist[$i] . '
';
                ++$OBSERVACIONESnum;
            }
        }
        $pdf->MultiCell(195, 4, utf8_decode($OBSERVACIONES), 1);
    }

    if ($tipoc != 1) {

        if ($pdf->GetY() > 200) {
            $pdf->AddPage();
            $pdf->SetXY(10, 30);
            $pdf->Image('logofinal2.jpg', 5, 5, 200, 265, 'JPG');
        }


        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(195, 7, utf8_decode($valordefila . '.- HORARIOS DE ATENCION'), 1, 0, 'L');
        ++$valordefila;
        $pdf->SetFont('arial', '', 8);
        $pdf->Ln(7);
        $pdf->MultiCell(195, 4, utf8_decode('Laboratorios y atención al cliente general:
Lunes a Jueves: 08:30 a 18:00 horas.
Viernes: 08:30 a 15:50 horas.
Calificación de soldador:
Lunes a Jueves: 08:30 a 17:00 horas.
Consulte horarios especiales.
'), 1);


        if ($pdf->GetY() > 200) {
            $pdf->AddPage();
            $pdf->SetXY(10, 30);
            $pdf->Image('logofinal2.jpg', 5, 5, 200, 265, 'JPG');
        }


        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(195, 7, utf8_decode($valordefila . '.- PLAZO DE ENTREGA Y CONDICIONES'), 1, 0, 'L');
        ++$valordefila;
        $pdf->SetFont('arial', '', 8);
        $pdf->Ln(7);
        $OBSERVACIONES = '';
        $OBSERVACIONESnum = 1;
        $OBSERVACIONEStotal = count($arrayAll4);
        $arraylist = array(
            'Los servicios serán realizados previo pago o una vez recibida la orden de compra, para proceder a emisión de factura.'
        , 'Plazo de entrega de informes, calificación de procedimientos y soldadores será en un máximo de 07 días hábiles posteriores al ensayo.'
        , 'La entrega de resultados y/o informes queda sujeta a la regularización del pago.'
        , 'Las muestras ensayadas permanecerán en el laboratorio por un período de 30 días. Pasado este plazo, serán reducidas a chatarra.'
        , 'CETI se reserva a emitir facturas previa ejecución de servicios.'
        , $arrayAll4[$OBSERVACIONEStotal - 1]);
        for ($i = 0; $i < $OBSERVACIONEStotal; $i++) {
            if ($arrayAll4[$i] != '0' && $arrayAll4[$i] != '') {
                $OBSERVACIONES .= $OBSERVACIONESnum . ') ' . $arraylist[$i] . '
';
                ++$OBSERVACIONESnum;
            }
        }
        $pdf->MultiCell(195, 4, utf8_decode($OBSERVACIONES), 1);
    }

    if ($pdf->GetY() > 190) {
        $pdf->AddPage();
        $pdf->SetXY(10, 30);
        $pdf->Image('logofinal2.jpg', 5, 5, 200, 265, 'JPG');
    }


    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(195, 7, utf8_decode($valordefila . '.- TIPO DE MONEDA Y FORMA DE PAGO'), 1, 0, 'L');
    ++$valordefila;
    $pdf->SetFont('arial', '', 8);
    $pdf->Ln(7);


    if ($tipoc != 1) {

        $OBSERVACIONES = '';
        $OBSERVACIONEStotal = count($arrayAll5);
        $arraylist = array(
            'Depósito o transferencia de fondos a cuenta corriente del Banco Scotiabank Azul (ex BBVA) N°0504-0114-0100005484 a nombre de CETI INSPECCIONES Y CERTIFICACIONES LIMITADA CENTRO TÉCNICO INDURA LTDA., Rut 77.773.480-6'
        , 'Tarjeta de crédito bancaria (Hasta 6 cuotas).'
        , 'Orden de Compra a 30 días, para las empresas que cuentan con línea de crédito.'
        , 'Cheque al día o a 30 días (garantizado con Orsan, hasta $1.500.000).'
        , $arrayAll5[$OBSERVACIONEStotal - 1]);
        for ($i = 0; $i < $OBSERVACIONEStotal; $i++) {
            if ($arrayAll5[$i] != '0' && $arrayAll5[$i] != '') {
                $OBSERVACIONES .= ' - ' . $arraylist[$i];
                ++$OBSERVACIONESnum;
            }
        }
        $OBSERVACIONES = '1.- El tipo de moneda es en Peso Chileno CLP.
2.- Formas de pago:
' . $OBSERVACIONES . '
3.- Favor emitir Orden de Compra o documento a nombre de:
- CETI INSPECCIONES Y CERTIFICACIONES LIMITADA
-  Rut: 77.773.480-6
- Giro: Inspecciones y Certificaciones  de Soldaduras
- Dirección: Av. Las Américas #585 Cerrillos – Santiago
- Dirección envío de muestras: Camino a Melipilla #7060, Cerrillos - Santiago.
';
        $OBSERVACIONES = '1.- El tipo de moneda es en Peso Chileno CLP.
2.- Formas de pago:
- Depósito o transferencia de fondos a cuenta corriente del Banco Scotiabank Azul (ex BBVA) N°0504-0114-0100005484 a nombre de CETI INSPECCIONES Y CERTIFICACIONES LIMITADA., Rut 77.773.480-6
- Tarjeta de crédito bancaria (Hasta 6 cuotas).
- Orden de Compra a 30 días, para las empresas que cuentan con línea de crédito.
- Cheque al día
- Cheque a 30 días (máximo $1.500.000).
3.- Favor emitir Orden de Compra o documento a nombre de:
- CETI INSPECCIONES Y CERTIFICACIONES LIMITADA
- Rut: 77.773.480-6
- Giro: Inspecciones y Certificaciones  de Soldaduras
- Dirección: Pedro Aguirre Cerda 7060 - Cerrillos, Cerrillos - Santiago.
- Dirección envío de muestras: Pedro Aguirre Cerda 7060 - Cerrillos, Cerrillos - Santiago.

';


    } else {
        $OBSERVACIONES = '- El tipo de moneda es Peso Chileno, servicio no afecto a I.V.A.
- La forma de pago puede ser cheque al día, o a 30 días (garantizado Via Orsan), Tarjeta de Crédito Bancaria (Hasta 6 cuotas precio contado) o bien con deposito o Transferencia bancaria en nuestra cuenta corriente al Banco Scotiabank Azul (ex BBVA) N°0504-0114-0100005522 a nombre de CENTRO TÉCNICO INDURA LTDA.
- CETI verificara la condición de pago en el momento de realizar el servicio.
- Favor emitir Orden de Compra o documentos a nombre de: CENTRO TÉCNICO INDURA LTDA Rut. 87.730.100-1 Cuenta Corriente de Banco Scotiabank Azul (ex BBVA) N°0504-0114-0100005522.
';
    }

    $pdf->MultiCell(195, 4, utf8_decode($OBSERVACIONES), 1);


    if ($tipoc == 1) {

        if ($pdf->GetY() > 200) {
            $pdf->AddPage();
            $pdf->SetXY(10, 30);
            $pdf->Image('logofinal2.jpg', 5, 5, 200, 265, 'JPG');
        }

        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(195, 7, utf8_decode($valordefila . '.- HORARIOS EJECUCIÓN DE CURSOS'), 1, 0, 'L');
        ++$valordefila;
        $pdf->SetFont('arial', '', 8);
        $pdf->Ln(7);
        $pdf->MultiCell(195, 4, utf8_decode($arrayAll[20][0]), 1);

    }


    if ($pdf->GetY() > 150) {
        $pdf->AddPage();
        $pdf->SetXY(10, 30);
        $pdf->Image('logofinal2.jpg', 5, 5, 200, 265, 'JPG');
    }


    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(195, 7, utf8_decode($valordefila . '.- OBSERVACIONES'), 1, 0, 'L');
    ++$valordefila;
    $pdf->SetFont('arial', '', 8);
    $pdf->Ln(7);


    if ($tipoc != 1) {

        $OBSERVACIONES = '';
        $OBSERVACIONESnum = 1;
        $OBSERVACIONEStotal = count($arrayAll6);
        $arraylist = array(
            'Las calificaciones de soldador son de lunes a jueves, desde las 09:00 hasta 17:00 hrs (consulte horario especial)'
        , 'El soldador debe presentarse con ropa de trabajo, zapato de seguridad y gorro de tela.'
        , 'En caso de servicios en instalaciones del cliente, donde no se logre realizar la actividad de Calificación por razones ajenas a la responsabilidad de CETI, se cobrará el 100% del valor de la visita y eventualmente un porcentaje dependiendo del tiempo transcurrido.'
        , 'El hecho de no calificar constituye el 100% del costo ofertado, pero generar un descuento de un 5% en la próxima calificación.'
        , 'La reserva de cabinas solo es previo pago del servicio.'
        , 'Será de responsabilidad del cliente el proporcionar acceso directo a las zonas a inspeccionar, y los accesorios  necesarios para poder realizar la inspección, tales como andamios, escalas, rampas, iluminación, etc. Además el cliente deberá acatar y tomar todas las medidas de seguridad que sean necesarias para ejecutar los trabajos.'
        , 'Nuestro personal está instruido para negarse a efectuar trabajos que pongan en riesgo su integridad, la de otras personas y el medio ambiente; en este caso rige el punto anterior. Las zonas a inspeccionar deberán estar libres de aceites, grasas, pinturas, recubrimientos, etc.'
        , 'CETI Inspecciones se hará responsable por cualquier daño a la infraestructura de las instalaciones de nuestros clientes que sea causado por la ejecución de nuestros trabajos hasta por el 100% del valor de los servicios ejecutados o a ejecutar. El cliente tiene un plazo máximo de 5 días hábiles luego de ejecutada la visita para hacer la reclamación correspondiente.'
        , 'CETI Inspecciones se reserva el derecho de informar oportunamente modificaciones en los plazos de entrega de informar, por condiciones propias de los ensayos a realizar. '
        , 'CETI inspecciones y Certificaciones Ltda informa que, para realizar devoluciones de dinero o dejara sin efecto Órdenes de compra, los clientes deberán informar con anticipación de 48 horas antes de la fecha programada. La devolución de dineros o documentos se realizara a través de cheque, vale vista o deposito,  en un plazo mínimo de 15 días hábiles.'
        , $arrayAll6[$OBSERVACIONEStotal - 1]);
        for ($i = 0; $i < $OBSERVACIONEStotal; $i++) {
            if ($arrayAll6[$i] != '0' && $arrayAll6[$i] != '') {
                $OBSERVACIONES .= $OBSERVACIONESnum . ') ' . $arraylist[$i] . '
';
                ++$OBSERVACIONESnum;
            }
        }
        $pdf->MultiCell(195, 4, utf8_decode($OBSERVACIONES), 1);

    } else {

        $OBSERVACIONES = '';
        $OBSERVACIONESnum = 1;
        if ($arrayAll[12][0] == '1') {
            $OBSERVACIONES .= $OBSERVACIONESnum . ') Todos nuestros cursos cuentan con código Sence por lo que las empresas pueden optar a la franquicia tributaria  Sence, el único requisito para hacerla efectiva es que los trabajadores que participen en los cursos registren puntualmente su asistencia, marcando su huella digital al ingreso y salida de la jornada de clases, durante todos los días de ejecución. Si los alumnos llegan tarde o no registran su ingreso o salida, podrían obtener un porcentaje de asistencia inferior al 75 % (requisito mínimo exigido por Sence para la aprobación de un curso). Esto  significaría perder la franquicia y en este caso la empresa tendría que cancelar el valor completo del curso.
Centro Técnico Indura, no se hace responsable en caso de que la empresa pierda la franquicia tributaria por este motivo.
';
            ++$OBSERVACIONESnum;
        }
        if ($arrayAll[13][0] == '1') {
            $OBSERVACIONES .= $OBSERVACIONESnum . ') Para la realización del curso, se le proporcionará al alumno los siguientes elementos de protección personal: coleto, polainas, chaqueta (todo de descarne), tapones auditivos, guantes, lentes de seguridad y máscara de soldar.
';
            ++$OBSERVACIONESnum;
        }
        if ($arrayAll[14][0] == '1') {
            $OBSERVACIONES .= $OBSERVACIONESnum . ') Para las clases prácticas  los participantes deben presentarse con ropa de trabajo, calzado de seguridad, gorro de tela soldador y un candado para guardar sus pertenencias en un casillero que les será asignado (aplica sede Santiago).
';
            ++$OBSERVACIONESnum;
        }
        if ($arrayAll[15][0] == '1') {
            $OBSERVACIONES .= $OBSERVACIONESnum . ') No reservamos cupos, estos sólo son asignados una vez que se encuentran cancelados los cursos.
';
            ++$OBSERVACIONESnum;
        }
        if ($arrayAll[16][0] == '1') {
            $OBSERVACIONES .= $OBSERVACIONESnum . ') La oferta tiene una validez de 30 días.
';
            ++$OBSERVACIONESnum;
        }
        if ($arrayAll[17][0] == '1') {
            $OBSERVACIONES .= $OBSERVACIONESnum . ') Si la parte interesada cancela su participación en el curso ya facturado, Centro Técnico Indura Ltda. sólo realizará la devolución del dinero si esta comunicación es hecha 03 días hábiles antes del inicio del curso.
';
            ++$OBSERVACIONESnum;
        }
        if ($arrayAll[18][0] == '1') {
            $OBSERVACIONES .= $OBSERVACIONESnum . ') Todos los cursos son impartidos en horario diurno y vespertino, según elección del cliente. Comienzan cada semana, no requieren de quórum mínimo, sin embargo, el ingreso de los participantes dependerá de la disponibilidad de cabinas. Se recomienda agendar cursos con, a lo menos, dos semanas de anticipación.
';
            ++$OBSERVACIONESnum;
        }
        if ($arrayAll[19][0] == '1') {
            $OBSERVACIONES .= $OBSERVACIONESnum . ') Respecto a la alimentación, en horario diurno los alumnos reciben almuerzo y en horario vespertino once.
';
            ++$OBSERVACIONESnum;
        }
        if ($arrayAll[22][0] == '1') {
            $OBSERVACIONES .= $OBSERVACIONESnum . ') Actividad de capacitación financiada, total o parcialmente, a través de la franquicia tributaria de capacitación, administrada por el Servicio Nacional de Capacitación y Empleo, Gobierno de Chile. Actividad no conducente al otorgamiento de un título o grado académico.
';
            ++$OBSERVACIONESnum;
        }
        if ($arrayAll[21][0] != '') {
            $OBSERVACIONES .= $OBSERVACIONESnum . ') ' . $arrayAll[21][0];
            ++$OBSERVACIONESnum;
        }


        if ($arrayAll[24][0] == '1') {
            $OBSERVACIONES .= $OBSERVACIONESnum . ') Nuestros cursos cuentan con Código SENCE por lo que las empresas pueden optar a la Franquicia Tributaria SENCE, el único requisito para hacer efectiva es que los trabajadores que participen en los cursos registren puntualmente su asistencia, marcando su huella digital al ingreso y salida de la jornada de clases, durante todos los días de ejecución.
Si los alumnos llegan tarde o no registran su ingreso o salida, podrían obtener un porcentaje de asistencia inferior al 75 % (requisito mínimo exigido por SENCE para la aprobación de un curso). Esto significaría que su empresa no podría hacer uso de la Franquicia Tributaria SENCE a través del Programa Impulsa persona y por ende  tendrá que pagar el valor íntegro del curso.
';
            ++$OBSERVACIONESnum;
        }
        if ($arrayAll[25][0] == '1') {
            $OBSERVACIONES .= $OBSERVACIONESnum . ') Para la realización del curso, se le proporcionará al alumno los siguientes elementos de protección personal de uso obligatorio: coleto, polainas, chaqueta (todo de descarne), tapones auditivos, guantes, lentes de seguridad y máscara de soldar.
';
            ++$OBSERVACIONESnum;
        }
        if ($arrayAll[26][0] == '1') {
            $OBSERVACIONES .= $OBSERVACIONESnum . ') Para las clases prácticas los participantes deben presentarse con ropa de trabajo, calzado de seguridad, gorro de tela soldador y un candado para guardar sus pertenencias en un casillero que les será asignado (aplica sede Santiago).
';
            ++$OBSERVACIONESnum;
        }
        if ($arrayAll[27][0] == '1') {
            $OBSERVACIONES .= $OBSERVACIONESnum . ') No reservamos cupos, estos sólo son asignados una vez que se encuentran pagados los cursos.
';
            ++$OBSERVACIONESnum;
        }
        if ($arrayAll[28][0] == '1') {
            $OBSERVACIONES .= $OBSERVACIONESnum . ') La oferta tiene una validez de 30 días.
';
            ++$OBSERVACIONESnum;
        }
        if ($arrayAll[29][0] == '1') {
            $OBSERVACIONES .= $OBSERVACIONESnum . ') Si la parte interesada cancela su participación en el curso ya facturado, Centro Técnico Indura Ltda. Sólo realizará la devolución del dinero si esta comunicación es efectuada 03 días hábiles antes del inicio del curso.
';
            ++$OBSERVACIONESnum;
        }
        if ($arrayAll[30][0] == '1') {
            $OBSERVACIONES .= $OBSERVACIONESnum . ') Todos los cursos son impartidos en horario diurno y vespertino, según elección del cliente. Comienzan cada semana, no requieren de quórum mínimo, sin embargo, el ingreso de los participantes dependerá de la disponibilidad de cabinas. Se recomienda agendar cursos con, a lo menos, dos semanas de anticipación.
';
            ++$OBSERVACIONESnum;
        }
        if ($arrayAll[31][0] == '1') {
            $OBSERVACIONES .= $OBSERVACIONESnum . ') Respecto a la alimentación, en horario diurno los alumnos reciben almuerzo en nuestro casino (que cuenta con tres menús diarios, ensaladas, postre, sopa y jugo); y en horario vespertino recibe once (sándwich con té, café o yogurt).
';
            ++$OBSERVACIONESnum;
        }
        if ($arrayAll[32][0] == '1') {
            $OBSERVACIONES .= $OBSERVACIONESnum . ') "Actividad de Capacitación autorizada por el SENCE para los efectos de la Franquicia Tributaria, no conducente por norma a los procedimientos y requisitos para un otorgamiento de un título o grado académico, emanado según ley de la República 20.370"
';
            ++$OBSERVACIONESnum;
        }
        if ($arrayAll[33][0] == '1') {
            $OBSERVACIONES .= $OBSERVACIONESnum . ') La documentación del curso será enviada a su empresa en el plazo de 10 días hábiles, los alumnos no podrán retirar en forma personal dicha documentación a menos que el mandante autorice vía correo electrónico.
';
            ++$OBSERVACIONESnum;
        }
        if ($arrayAll[34][0] == '1') {
            $OBSERVACIONES .= $OBSERVACIONESnum . ') Teniendo en consideración lo previsto en el artículo 79 bis del Decreto N° 250 y el Oficio de Contraloría General de la República N° 7.561, de fecha 19 de marzo de 2018, que imparte instrucciones sobre el Pago Oportuno a los Proveedores en los Procesos de Contratación Pública Regulados por la Ley N° 19.886, el pago del precio ofrecido por  (CETI) deberá realizarse dentro del plazo máximo de 30 días corridos siguientes a la recepción de la factura o del respectivo instrumento tributario de cobro
';
            ++$OBSERVACIONESnum;
        }


        if ($arrayAll[35][0] != '') {
            $OBSERVACIONES .= $OBSERVACIONESnum . ') ' . $arrayAll[35][0];
            ++$OBSERVACIONESnum;
        }


        $pdf->MultiCell(195, 4, utf8_decode($OBSERVACIONES), 1);
    }

    if ($pdf->GetY() > 200) {
        $pdf->AddPage();
        $pdf->SetXY(10, 30);
        $pdf->Image('logofinal2.jpg', 5, 5, 200, 265, 'JPG');
    }


    if ($tipoc != 1) {

        if ($arrayAll[6][0] != '') {
            $arr1111 = ' - ' . ucwords(strtolower($arrayAll[6][0])) . '  ' . $arrayAll[7][0] . '  ' . $arrayAll[8][0] . '  ' . $arrayAll[9][0] . '
';
        }
        if ($contacto1 != '') {
            $arr2222 = ' - ' . $contacto1 . '  ' . $contacto2 . '  ' . $contacto3 . '  ' . $contacto4;
        }

        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(195, 7, utf8_decode($valordefila . '.- VALIDEZ DE LA OFERTA'), 1, 0, 'L');
        ++$valordefila;
        $pdf->SetFont('arial', '', 8);
        $pdf->Ln(7);
        $pdf->MultiCell(195, 4, utf8_decode('1.- La oferta tiene una validez de 30 días hábiles.
Para coordinar servicio, tomar contacto con:
' . $arr1111 . $arr2222), 1);


    } else {
        if ($ckbx1002) {
            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(195, 7, utf8_decode($valordefila . '.- OTROS'), 1, 0, 'L');
            ++$valordefila;
            $pdf->SetFont('arial', '', 8);
            $pdf->Ln(7);
            $pdf->MultiCell(195, 4, utf8_decode($OTRO), 1);
        }

    }


    $pdf->SetFont('arial', '', 10);
    $pdf->Cell(195, 10, utf8_decode('Sin otro particular, saludamos cordialmente a Ud.'), 0, 0, 'C');
    $pdf->Ln(18);


    $pdf->Line(133, $pdf->GetY() + 2, 182, $pdf->GetY() + 2);

    $pdf->SetFont('arial', '', 10);
    $pdf->Cell(100, 10, utf8_decode(''), 0, 0, 'C');
    $pdf->Cell(95, 10, utf8_decode(ucwords(strtolower($arrayAll[6][0]))), 0, 0, 'C');
    $pdf->Ln(5);

    if ($tipoc == 1) {

        $pdf->Cell(100, 10, utf8_decode(''), 0, 0, 'C');
        $pdf->Cell(95, 10, utf8_decode($arrayAll[7][0]), 0, 0, 'C');
        $pdf->Ln(5);
        $pdf->Cell(100, 10, utf8_decode(''), 0, 0, 'C');
        $pdf->Cell(95, 10, utf8_decode($arrayAll[8][0]), 0, 0, 'C');
        $pdf->Ln(5);

    }


    $pdf->Cell(100, 10, utf8_decode(''), 0, 0, 'C');
    $pdf->Cell(95, 10, utf8_decode($arrayAll[9][0]), 0, 0, 'C');


    // $pdf->Ln(5);
    // $pdf->Cell(100 , 10, utf8_decode(''), 0, 0, 'C');
    // $pdf->Cell( 95 , 10, utf8_decode($arrayAll[23][0]), 0, 0, 'C');

}


$pdf->Output();

return;