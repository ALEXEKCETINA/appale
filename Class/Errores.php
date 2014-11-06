<?php
class Errores{
	public $errorTipos = array(
		1 => "ERROR",
		2 => "WARNING",
		4 => "PARSE ERROR",
		8 => "NOTICE",
		16 => "CORE ERROR",
		32 => "CORE WARNING",
		64 => "COMPILE EROR",
		128 => "COMPILE WARNING",
		256 => "USER ERROR",
		512 => "USER WARNING",
		1024 => "USER NOTICE");
	private $mostrarErrores = TRUE;
	private $loguearErrores = TRUE;
	private $archivoErrores = 'tmp/PHP_errores.log';
	
	public function __construct(){
		$gestor = set_error_handler(array($this, 'gestionErrores'));
		error_reporting(E_ALL);
	}
	
	public function gestionErrores($errno,$errstr,$file,$line,$context){
		$StrErr = "<pre>";
		$StrErr .= "-- ERROR ".$this->errorTipos[$errno]." --".PHP_EOL;
		$StrErr .= "fecha: ".date("y-m-d h:i:s").PHP_EOL;
		$StrErr .= "archivo: ".$file.PHP_EOL;
		$StrErr .= "line: ".$line.PHP_EOL;
		$StrErr .= "IP servidor: ".$_SERVER['SERVER_ADDR'].PHP_EOL;
		$StrErr .= "IP usuario: ".$_SERVER['REMOTE_ADDR'].PHP_EOL;
		$StrErr .= "Mensaje: ".$errstr.PHP_EOL;
		$StrErr .= "-- ERROR ".$this->errorTipos[$errno]." --".PHP_EOL;
		$StrErr .= "</pre>";
		if($this->loguearErrores){
			if(is_writable($this->archivoErrores)){
				$logtxt = file_get_contents($this->archivoErrores);
				$logtxt .= $StrErr.PHP_EOL;
				file_put_contents($this->archivoErrores,$logtxt);
			}
		}
		if($this->mostrarErrores){
			echo $StrErr;
		}else{
			echo "ERROR".PHP_EOL;
		}
	}
}
$error = new Errores();
?>