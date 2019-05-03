<?php

	require_once "../app/InputFilter.php";
	require_once "../app/Sede.php";

	$sanitizer = new InputFilter();
	foreach($_POST as $key=>$val){
	    $arr[$key] =  $sanitizer->process($val);
	}

	$sede = new Sede($arr);
	$accion = intval($arr['acc']);

	switch ($accion) {
		case 1:
			$sede->getListaSede();
		break;
		case 2:
			switch ($arr['type']) {
				case 'create':
					$sede->crear_sede();
				break;
				case 'edit':
					$sede->edit_sede($arr['idS']);
				break;
				case 'desable':
					$sede->disable_sede($arr['idS']);
				break;
			}
		break;
	}

?>