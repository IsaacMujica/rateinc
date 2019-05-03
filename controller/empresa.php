<?php
require_once "../app/InputFilter.php";
require_once "../app/Empresa.php";

$sanitizer = new InputFilter();
foreach($_POST as $key=>$val){
    $arr[$key] =  $sanitizer->process($val);
}

$empresa = new Empresa($arr);
$accion = intval($arr['acc']);

switch ($accion){
    case 1:
        // LISTA DE EMPRESAS
        $empresa->getListaEmpresa();
        //echo json_encode(["data" => []]);
        break;
    case 2:
        // CRUD EMPRESA
        switch ($arr['type']) {
        	case 'create':
		        // CREAR
		        $empresa->setNuevaEmpresa($arr);
        		break;
        	case 'edit':
		        // EDITAR
		        $empresa->setActualizacionEmpresa($arr);
        		break;
        	case 'desable':
		        // DESHABILITAR
		        $empresa->setEstadoEmpresa();
        		break;
        }
        break;
    case 3:
        // CRUD CONTACTO
        switch ($arr['type']) {
            case 'create':
                // CREAR
                $empresa->setNuevoContacto();
                break;
            case 'edit':
                // EDITAR
                $empresa->setActualizacionContacto();
                break;
            case 'desable':
                // DESHABILITAR
                $empresa->setEstadoContacto();
                break;
        }
        break;
    case 4:
        // CRUD PERSONAL
        switch ($arr['type']) {
            case 'create':
                // CREAR
                $empresa->setNuevoPersonal();
                break;
            case 'edit':
                // EDITAR
                $empresa->setActualizacionPersonal();
                break;
            case 'desable':
                // DESHABILITAR
                $empresa->setEstadoPersonal();
                break;
        }
        //$empresa->setNuevoPersonal();
        break;
    case 5:
        // CARGAR LISTA PERSONAL
        $empresa->getListaPersonal($arr, true);
        break;
    case 6:
        // CARGAR LISTA CONTACTO
        $empresa->getListaContacto($arr, true);
        break;
    default:
        exit();
        break;
}