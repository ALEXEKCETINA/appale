<?php
/**
 *@author Cointo Amador Barrera Cortés <rockstarcointo@gmail.com>
 *Clase User que hereda de la clase principal AppController.
 *Clase para agregar y editar un usuario.
**/
	class User  extends AppController{
		/**
		 * Función construct.
		 * Inicializa las variables heredadas a utilizar.
		**/
		public function __construct(){
			parent::__construct();
		}
		/**
	 	 * Función index.
	 	 * Se visualizarán los usuarios que se han creado, así como la opción de agregar, editar y eliminar usuario.
	 	 * @param $users Para visualizar los usuarios.
		**/
		public function index(){
			$users = $this->User->find("users","all");
			$this->set("users",$users);
		}
		/**
		 * Función edit.
		 * Para editar cualquier usuario creado anteriormente.
		 * @param $id El id del usuario que se va a modificar.
		**/
		public function edit($id = null){
			if($_POST){
				$filter = new Validations();
				$pass = new Password();
			
				$_POST["password"] = $filter->sanitizeText($_POST["password"]);
				$_POST["password"] = $pass->getPassword($_POST["password"]);
			
				if($this->User->update("users", $_POST)){
					$this->redirect(array("controller"=>"users","action"=>"index"));
				}else{
					$this->redirect(array("controller"=>"users","action"=>"edit"));
				}
			}
			$user = $this->User->find("users","first",
			array(
				"conditions"=>"users.id=$id"
			));
			$this->set("user", $user);
		}
		/**
	 	 * Función add.
		 * Función que sirve para agregar un nuevo usuario.
		**/
		public function add(){
			if($_POST){
				if($this->User->save("users", $_POST)){
					
					$this->redirect(array("controller"=>"users","action"=>"index"));
				}else{
					$this->redirect(array("controller"=>"users","action"=>"add"));
				}
			}
		}
		/**
		* Función delete.
		*
		* Función que sirve para eliminar usuarios de la base de datos.
		* @param  $id Identifica el usuario a eliminar.
		**/
		public function delete($id){
			if($this->User->delete("users", $id)){
				$this->redirect(array("controller"=>"users","action"=>"index"));
			}
			$user = $this->User->find("users","all",
			array(
				"conditions"=>"users.id=$id"
			));
			$this->set("user", $user);
		}
		/**
		* Función login.
		* Función que sirve para iniciar sesión.
		**/
		public function login(){
			if($_POST){
				$pass = new Password();
				$filter = new Validations();
				$auth = new Authorization();
				
				$username = $filter->sanitizeText($_POST["username"]);
				$password = $filter->sanitizeText($_POST["password"]);
				
				$options['conditions'] = "username = '$username'";
				$user = $this->User->find("users", "first", $options);
				
				if($pass->isValid($password, $user['password'])){
					$auth->login($user);
					$this->redirect(array("controller"=>"users","action"=>"index"));
				}else{
					echo "usuario invalido";
				}
			}
		}
		/**
		* Función login.
		* Función que sirve para iniciar sesión.
		**/
		public function logout(){
			$auth = new Authorization();
			$auth->logout();
		}
		
	}