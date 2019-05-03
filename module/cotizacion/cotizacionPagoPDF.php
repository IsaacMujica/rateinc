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

$template = APP_PUBLIC . "/templates/cotizacion-pago.php";

try {
    ob_start();
    include $template;
    $content = ob_get_clean();

    $html2pdf = new Html2Pdf('P', 'A4', 'fr');
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content);
    //$html2pdf->createIndex('Sommaire', 30, 12, false, true, 1, null, '10mm');
    $html2pdf->output('cotizacion_pago_ficha_' . $_GET['idcotPag'] . '.pdf');
} catch (Html2PdfException $e) {
    $html2pdf->clean();
    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
}