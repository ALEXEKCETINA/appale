<?php
/*
  @author Alejandro Ek Cetina <alejandro_17_rock@hotmail.com>
*/
	# Separador de direcciones para Windows y Linux.
	define('DS', DIRECTORY_SEPARATOR);
	# Para obtener el directorio de archivo de inclusión actual
	define('ROOT',dirname(__FILE__). DS);
	define('APP_PATH', ROOT);
	# Para cargar automáticamente las clases
	function __autoload($classname){
		$filename = "class/".$classname.".php";
		include_once ($filename);
	}
	
	$error = new Errores();
	
	/*include_once APP_PATH . DS . 'class'. DS . 'pdo.php';
	include_once APP_PATH . DS . 'class'. DS . 'Errores.php';
	include_once APP_PATH . DS . 'class'. DS . 'Password.php';
	include_once APP_PATH . DS . 'class'. DS . 'Authorization.php';
	include_once APP_PATH . DS . 'class'. DS . 'phpmailer.php';*/
	include_once APP_PATH . DS . 'controllers'. DS . 'appcontroller.php';
	
	//print_r(get_required_files());
	
	if(isset($_GET['url'])){
		$url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
		$url = explode("/", $url);
		$url = array_filter($url);
				
		$controller = array_shift($url);
		$action = array_shift($url);
		$args = $url;
		
	}
	
	if(!isset($controller)){
		$controller = "users";
	}
	if(!isset($action)){
		$action = "index";
	}
	if(empty($args)){
		$args = array(0=>null);
	}
	/*if($action=="login"){
		
	}else{
		Authorization::logged();
	}*/
	# Ruta de las vistas
	$path = APP_PATH.DS."controllers".DS.$controller."controller.php";
	$view = APP_PATH.DS."views".DS.$controller.DS.$action.".php";
	$header = APP_PATH.DS."views".DS."layouts".DS."default".DS."header.php";
	$footer = APP_PATH.DS."views".DS."layouts".DS."default".DS."footer.php";
	
	/*echo $path;
	echo "<br>";
	echo $view;
	echo "<br>";
	echo $header;
	echo "<br>";
	echo $footer;
	exit;*/
	if(file_exists($path)){
		include_once $path;
		
		$className = trim($controller, 's');
		$ob = new $className();
		
		if(isset($args)){
			$ob->$action($args[0]);
		}
		else{
			$ob->$action();
		}
		
		if(file_exists($view)){
			include_once $header;
			include_once $view;
			include_once $footer;
		}
		else{
			echo "La vista para la acción $action no existe";
		}
	}
	else{
		echo "El controlador $controller no existe";
	}
	
	/* echo $controller;
	echo "<br>";
	echo $action;
	echo "<br>";
	print_r($args); */
?>