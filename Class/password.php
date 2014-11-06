<?php
#MD5
class Password{
	public function __construct(){
		$this->checkBlowFish();
	}
	
	private function checkBlowFish(){
		if(!defined("CRYPT_BLOWFISH") && !CRYPT_BLOWFISH){
			echo "Algoritmo Blowfish no reportado";
			die();
		}
	}
	
	public function getPassword($password, $dig = 7){
		$set_salt = './1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$salt = sprintf('$2a$%02d$', $dig);
		for ($i=0;$i<22;$i++){
			$salt .= $set_salt[mt_rand(0,22)];
		}
		
		return crypt($password, $salt);
	}
	
	public function isValid($pass1, $pass2){
		if(crypt($pass1,$pass2) == $pass2){
			return true;
		}
		
		return false;
	}
	
	public function passwordVerify($pass1,$pass2){
		if(password_verify($pass1,$pass2)){
			return true;
		}
		
		return false;
	}
}
/*$pass = new Password();
$hashDB = '$2a$07$28/GAJ9/C21C99G9I0331uFHVPmw6AjBblMT3a5YTZN/owsCn82hq';

if ($pass -> isValid("hola", $hashDB)){
	echo "Usuario valido";
}else{
	echo "Usuario invalido";
}*/
