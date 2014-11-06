<?php
/**
 *@author Alejandro Ek Cetina <alejandro_17_rock@hotmail.com>
 *Clase ClassPDO sirve para realizar la conección y las operaciones con la BD
**/
class ClassPDO{
	private $connection;
	private $dsn;
	private $username;
	private $password;
	
	/**
	 * Función Construct.
	 * Se inicializan las variables.
	 * @param $connection Para realizar la conexión a la base de datos.
	 * @param $dns La dirección del host y la base de datos.
	 * @param $username El usuario.
	 * @param $password La contraseña del usuario.
	**/
	public function __construct(){
		$this->dsn = 'mysql:host=localhost;dbname=test';
		$this->username = 'root';
		$this->password = '';
		$this->connection();
	}
	/**
	 * Función connection.
	 * Se hace la conexión a la base de datos utilizando PDO.
	 * @param $connection Para realizar la conexión a la base de datos.
	 * @param $dns La dirección del host y la base de datos.
	 * @param $username El usuario.
	 * @param $password La contraseña del usuario.
	**/
	private function connection(){
		try{
			$this->connection = new PDO(
				$this->dsn,
				$this->username,
				$this->password
			);
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			echo "ERROR: " . $e->getMessage();
			die();
		}	
	}
	/**
	 * Función find.
	 * Se hacen las diferentes consultas a la base de datos.
	 * @param $table La tabla en la que se hará la consulta.
	 * @param $query La sentecia que se va a realizar a la base de datos.
	 * @param $option Las diferentes opciones que hay para hacer la consulta.
	 * @return $result Devuelve el resultado dependiendo el tipo de consulta.
	**/
	public function find($table = null, $query = null, $options = array()){
		$fields = '*';
		$parameters = '';
		
		if(!empty($options['conditions'])){
			$parameters = ' WHERE '.$options['conditions'];
		}
		if(!empty($options['fields'])){
			$fields = $options['fields'];
		}
		if(!empty($options['group'])){
			$parameters .= ' Group By '.$options['group'];
		}
		if(!empty($options['order'])){
			$parameters .= ' Order By '.$options['order'];
		}
		if(!empty($options['limit'])){
			$parameters .= ' limit '.$options['limit'];
		}
		switch ($query){
			case 'all':{
				$sql = "Select $fields From ".$table.' '.$parameters;
				$this->result = $this->connection->query($sql);
				break;
			}
			case 'count':{
				$sql = "Select COUNT(*) From ".$table.' '.$parameters;
				$result = $this->connection->query($sql);
				$this->result = $result->fetchColumn();
				break;
			}
			case 'first':{
				$sql = "Select $fields From ".$table.' '.$parameters;
				$result = $this->connection->query($sql);
				$this->result = $result->fetch();
				break;
			}
			default:
				$sql = "Select $fields From ".$table.' '.$parameters;
				$this->result = $this->connection->query($sql);
				break;
		}
		
		
		#$sql = "Select $fields From ".$table.$parameters;
		#$this->result = $this->connection->query($sql);
		return $this->result;
	}
	/**
	 * Función save.
	 * Se agrega y guarda la información(id, name) a la base de datos.
	 * @param $table La tabla en la que se hará la consulta.
	 * @param $data Los datos que serán guardados en la tabla users.
	 * @return $result Devuelve la información (id, name) de la tabla users con los nuevos datos insertados.
	**/
	public function save($table = null, $data = array()){
		$sql = "select * from $table";
		$result = $this->connection->query($sql);
		
		for($i=0;$i<$result->columnCount();$i++){
			$meta = $result->getColumnMeta($i);
			$fields[$meta['name']] = null;
		}
		$fieldsToSave="id";
		$valueToSave="null";
		
		foreach($data as $key => $value){
			if(array_key_exists($key,$fields)){
				$fieldsToSave .= ", ".$key;
				$valueToSave .= ", "."\"$value\"";
			}
		}
		
		$sql = "INSERT INTO $table ($fieldsToSave) VALUES ($valueToSave);";
		$this->result = $this->connection->query($sql);
		return $this->result;
	}
	/**
	 * Función update.
	 * Se actualiza la información(id, name) en la tabla users.
	 * @param $table La tabla en la que se hará la consulta.
	 * @param $data Los datos que serán actualizados de la tabla users.
	 * @return $result Devuelve la información actualizada (id, name) de la tabla users.
	**/
	public function update($table = null, $data = array()){
		$sql = "select * from $table";
		$result = $this->connection->query($sql);

		for($i=0;$i<$result->columnCount();$i++){
			$meta = $result->getColumnMeta($i);
			$fields[$meta['name']] = null;
		}
		if(array_key_exists("id", $data)){
			//Update
			$fieldsToSave = "";
			$id = $data["id"];
			unset($data["id"]);
			$i = 0;
			foreach ($data as $key => $value) {
				if(array_key_exists($key, $fields)){
					if($i==0){
						$fieldsToSave .= $key."="."\"$value\", ";
					}elseif($i == count($data)-1){
						$fieldsToSave .= $key."="."\"$value\"";
					}else{
						$fieldsToSave .= $key."="."\"$value\", ";
					}
				}
				$i++;
			}
		
			$sql = "UPDATE $table SET $fieldsToSave WHERE $table.id = $id";
		}
		$this->result = $this->connection->query($sql);
		return $this->result;
	}
	/**
	 * Función delete.
	 * Se elimina la información de la tabla.
	 * @param $table La tabla en la que se hará la consulta.
	 * @param $id El id del usuario/grupo que serán eliminados.
	 * @return $result Devuelve la información (id, name) de la tabla users menos el que se elimino.
	**/
	public function delete($table = null, $id){
		//$sql = "select * from $table";
		//$result = $this->connection->query($sql);
		//$id = $args[0];
		
		$sql = "DELETE FROM $table WHERE id = $id";
		$this->result = $this->connection->query($sql);
		return $this->result;
	}
	/**
	 * Función getLastId.
	 * Se obtiene los ùltimos datos insertados de la tabla users.
	 * @param $table La tabla en la que se hará la consulta.
	 * @param $data Los datos que serán visualizados de la tabla users.
	 * @return $result Devuelve la última información (id, name) de la tabla users.
	**/
	public function getLastId($table = null, $data = array()){
		$sql = "select * from $table";
		$result = $this->connection->query($sql);
	}
	/*public function query($table = null, $data = null){
		$username = $data["username"];
		$password = $data["password"];
		
		$sql = "select * FROM users WHERE username = '{$username}' and password = '{$password}'";
		$result = $this->connection->query($sql);
		$this->result = $result->fetch();
		return $this->result;*/
		/*SOLUCION MYSQL
		$username = mysql_real_escape_string($data["username"]);
		$password = mysql_real_escape_string($data["password"]);
		$sql = sprintf("select * FROM users WHERE username = '%s' and password = '%s'", $username, $password);*/
		/*SOLUCION PDO
		$sql = $this->connection->prepare("select * FROM users WHERE username = ? and password = ?");
		$sql->execute(array($username, $password));
		$this->result = $result->fetchAll();
		return $this->result;*/
	/*}*/
}

$db = new ClassPDO();

$datos = array();

