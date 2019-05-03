<?php
require_once "../../app/InputFilter.php";
require_once "../../app/Cotizacion.php";
require_once "../../app/Producto.php";
require_once "../../app/Empresa.php";

$sanitizer = new InputFilter();
foreach($_POST as $key=>$val){
    $arr[$key] =  $sanitizer->process($val);
}

$cotizacion = new Cotizacion();
$producto = new Producto();
$empresa = new Empresa();

$accion = intval($arr['acc']);

//print_r($arr);


switch ($accion){
    case 1:
        // Lista de cotizaciones
        $cotizacion->getListaCotizacion($arr);
        break;
    case 2:
        // Lista de cotizaciones
        $producto->getListaProducto($arr);
        break;
    case 3:
        // Lista de Contactos
        $empresa->getListaContacto($arr, true);
        break;
    case 4:
        // Guardar Cotización
        $cotizacion->guardarCotizacion($arr);
        break;/*
    case 5:
        // Lista de cotizaciones
        $cotizacion->getListaCotizacionPago($arr);
        break;*/
    case 6:
        $cotizacion->guardarEstadoPagoCotizacion($arr);
    break;
    case 7:
        $cotizacion->getListaEstadoPagoCotizacion();
    break;
    case 8:

        //echo '<pre>';
        //var_dump($_POST);
        //echo '</pre>';
        //echo '<pre>';
        //var_dump($arr["file"]);
        //echo '</pre>';
        //echo '\n\n';
        //echo '<pre>';
        //print_r($_FILE);
        //echo '</pre>';

        //$cotizacion->guardarEstadoPagoCotizacion($arr);
    break;
    default:
        exit();
        break;
}