<?php
require_once "../app/InputFilter.php";
require_once "../app/Login.php";
require_once "../app/Usuario_desarrollo.php";

$sanitizer = new InputFilter();
foreach($_POST as $key=>$val){
    $arr[$key] =  $sanitizer->process($val);
}

$login = new Login();
$usuario = new Usuario();

$accion = intval($arr['acc']);

switch ($accion){
    case 1:
        // login de usuario
        $valor = $login->login($arr['txtEmail'], $arr['txtPasswd']);

        if($valor){
            echo 'var r = {resultado:"OK", mensaje:"Acceso correcto, redireccionando...", irURL:"dashboard.php"};';
        }else{
            echo 'var r = {resultado:"FAIL", mensaje:"Usuario o Contraseña es incorrecto."};';
        }
        break;
    case 2:
        // login de usuario

        $valor = $login->destruyeSesiones();
        if($valor==1){
            echo 'var r = {resultado:"OK", mensaje:"Cerrando sesión...", irURL:"/cetialumnos"};';
        }else{
            echo 'var r = {resultado:"FAIL", mensaje:"No es posible cerrar la sessión, intente nuevamente", irURL:"/cetialumnos"};';
        }
        break;
    case 3:
        $usuario->crearUsuario($arr);
        break;
    case 4:
        $usuario->recuperarClave($arr);
        break;
    default:
        exit();
        break;
}
?>