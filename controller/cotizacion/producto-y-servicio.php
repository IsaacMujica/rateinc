<?php
require_once "../../app/InputFilter.php";
require_once "../../app/Producto.php";

$sanitizer = new InputFilter();
foreach($_POST as $key=>$val){
    $arr[$key] =  $sanitizer->process($val);
}

$producto = new Producto($arr);

$accion = intval($arr['acc']);

switch ($accion){
    case 1:
        // Lista de productos
        $producto->getListaProducto($arr);
        break;
    case 2:
        // CRUD EMPRESA
        switch ($arr['type']) {
        	case 'create':
		        // CREAR
		        $producto->setNuevoProducto();
        		break;
        	case 'edit':
		        // EDITAR
		        $producto->setActualizacionProducto();
        		break;
        	case 'desable':
		        // DESHABILITAR
		        $producto->setEstadoProducto();
        		break;
        }
        break;
    default:
        exit();
        break;
}