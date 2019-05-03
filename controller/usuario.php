<?php
require_once "../app/InputFilter.php";
require_once "../app/Usuario.php";

$sanitizer = new InputFilter();
foreach($_POST as $key=>$val){
    $arr[$key] = $sanitizer->process($val);
}

$usuario = new Usuario();
$accion = intval($arr['acc']);

switch ($accion) {
    case 8:
        $usuario->updateQuestions($arr['validate']);
    break;
    case 9:
        //$usuario->updateQuestions($arr['validate']);
    break;
}
