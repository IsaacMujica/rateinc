<?php
require_once "../app/InputFilter.php";
require_once "../app/Localidad.php";

$sanitizer = new InputFilter();
foreach($_POST as $key=>$val){
    $arr[$key] =  $sanitizer->process($val);
}

$localidad = new Localidad($arr);
$accion = intval($arr['acc']);

switch ($accion){
    case 1:
        // Lista de empresas
        $localidad->getComunas($arr['idR'],$arr['ajax']);
        //echo json_encode(["data" => []]);
        break;
}