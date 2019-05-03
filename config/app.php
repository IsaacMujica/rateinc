<?php
define('APP_PUBLIC', $_SERVER['DOCUMENT_ROOT'] . "/rateinc_test");
define('APP_ROOT', dirname(__FILE__));
define('REQUEST_SCHEME', $_SERVER['REQUEST_SCHEME'] . "://");
define('SERVER_NAME', REQUEST_SCHEME . $_SERVER['SERVER_NAME']);

define('CONTROLLERS', SERVER_NAME . "/rateinc_test/controller");
define('INCLUDE_ROOT', APP_ROOT . "/includes");
define('HOST', SERVER_NAME . "/rateinc_test");

//Variables
$HOST = "http://".$_SERVER['HTTP_HOST']."/rateinc_test/";
$RUTA_ABSOLUTA = getcwd();
