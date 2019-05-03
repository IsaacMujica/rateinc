<?php
require_once ("vendor/PHPMailer/class.phpmailer.php");
require_once ("vendor/PHPMailer/class.smtp.php");
require_once ("Database.php");
include_once "../../config/app.php";

class Correo{
	
	private $email;

	function __construct(){
		
		$this->email = new PHPMailer;
		//$this->email->SMTPDebug = 3;                        	// Para debug
		$this->email->CharSet = 'UTF-8';						// Codificación del mensaje
		$this->email->setLanguage('es',"PHPMailer/languaje");	// Establecer lenguaje
		$this->email->isSMTP();                             	// Usar SMTP
		
		$this->email->Host        = 'rateinc.cl';  					// Servidor(es) SMTP (separar por coma)
		$this->email->SMTPAuth    = true;                          // autenticación SMTP 
		$this->email->Username    = 'admin@rateinc.cl';       // SMTP username
		$this->email->Password    = 'admin';                    // SMTP password
		$this->email->SMTPAutoTLS = false;
		$this->email->SMTPSecure  = 'TLS';                       // Activar encriptado TLS , o SSL
		$this->email->From        = 'admin@rateinc.cl';				//
		$this->email->FromName    = 'Rate Inc';						//
		$this->email->isHTML(true);                        // Set email format to HTML		
		$this->email->SMTPOptions = array(
		   'ssl' => array(
			   'verify_peer' => false,
			   'verify_peer_name' => false,
			   'allow_self_signed' => true
			)
		);
	}
	function replyTo($correoDestinatario,$nombreDestinatario="Usuario"){
		if($correoDestinatario!=''){			
			$this->email->addReplyTo($correoDestinatario, $nombreDestinatario);	
		}		
	}
	function CCO($correoDestinatario){
		if($correoDestinatario!=''){
			$this->email->AddBCC($correoDestinatario);
		}
	}
	function CC($correoDestinatario){
		if($correoDestinatario!=''){
			$this->email->AddCC($correoDestinatario);
		}
	}
	//------------------------------------------------------------------------------------------------------------
	function enviaCorreo ($asunto, $correo, $body, $directorioTemplates, $archivoAdjunto = "", $type = ""){
		
		$this->email->addAddress($correo);
		$this->email->Subject = $asunto;

		if ($archivoAdjunto != "")
            try {
            	$ruta = $type == "cotpag" ? APP_PUBLIC . "/storage/cotizacion_pago/" . $archivoAdjunto : APP_PUBLIC . "/storage/cotizacion/" . $archivoAdjunto;
                //$ruta = APP_PUBLIC . "/storage/cotizacion/" . $archivoAdjunto;
                $this->email->AddAttachment($ruta, $archivoAdjunto);
            } catch (phpmailerException $e) {
            }

        $this->email->AddEmbeddedImage(getcwd()."/".$directorioTemplates.$src[1][$key], 'img'.$key, 'img'.$key.$ext);
		
				
		for($i=0;$i<count($src);$i++){
			$tagImg =  $src[0][$i];
			preg_match_all( '/<img.*src=["\']([^ ^"^\']*)["\']/ims' , $tagImg , $matches );
			
			$imagesInMyHtml = $matches[1];
			$ext = substr($imagesInMyHtml[0], strrpos($imagesInMyHtml[0], ".")); 			
			$this->email->AddEmbeddedImage(getcwd()."/".$directorioTemplates.$imagesInMyHtml[0], 'img'.$i, 'img'.$i.$ext);			
			$body = str_replace($imagesInMyHtml[0], "cid:".'img'.$i, $body);
		}

		$this->email->Body = $body;

        try {
            if ($this->email->send()) {
                $this->email->clearAddresses();
                $this->email->clearCCs();
                $this->email->clearBCCs();

                return true;
            } else {
                $this->email->clearAddresses();
                $this->email->clearCCs();
                $this->email->clearBCCs();

                return false;
            }
        } catch (phpmailerException $e) {
        }
        return false;
    }

    public function getCuerpoCorreo ($tipoNotificacion) {
	    $body="";
	    switch ($tipoNotificacion) {
            case 1:
                break;
            default:
                return "";
        }
    }
	
	//------------------------------------------------------------------------------------------------------------	
	
	function sanear_string($cadena){
		$originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
		$modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
		$cadena = utf8_decode($cadena);
		$cadena = strtr($cadena, utf8_decode($originales), $modificadas);
		$cadena = strtolower($cadena);
		return utf8_encode($cadena);
	}
	
}