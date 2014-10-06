<?php

abstract class Dao{

	protected $database;
	protected $table;	
	
	public $cacheKey = __CLASS__;
	
	public function __construct(){
	
		$this->database		= "raulferr_teste";
		$this->cacheKey 	= get_class($this);
	}
	
	public function cadastrar($dados) {
	
		if(is_array($dados) and !is_null($dados)){
			return false;
		}
		
		$idx = $vlx = '';
		
		foreach($dados as $index => $value){
		 $idx .= $index. ",";
		 $vlx .= "'".$value. "',";
		}
		
		$idx = substr($idx,0,-1);
		$vlx = substr($vlx,0,-1);
		
		
		$sql = "INSERT INTO {$this->table} ($idx) VALUES ($vlx)";
		
		$conn = new Database();
		return $conn->execute($sql);
	}
	
	public function editar($dados,$id) {
	
		if(is_array($dados) and is_null($dados)){
			return false;
		}
		
		if(is_null($Id)){
			return false;
		}
		
		$idx = $vlx = '';
		
		foreach($dados as $index => $value){
			$idx .= $index. " = '".$value."',";
		}
		
		$idx = substr($idx,0,-1);
		
		$sql = "UPDATE {$this->table} $idx WHERE id = $id";
		
		$conn = new Database();
		return $conn->execute($sql);
	}
	
	public function deletar($id) {
		$sql = "DELETE FROM {$this->table} WHERE id = $id";
		
		$conn = new Database();
		return $conn->execute($sql);
	}
	
	public function getLastId() {
		
		$sql = "SELECT id FROM {$this->table} ORDER BY datahora DESC";
		
		$conn = new Database();
		$result = $conn->execute($sql);
		
		$valor = $conn->fetch_assoc($result);
		
		return $valor['id'];
	}
 
	public function carregarPorId($id) {
		
		$sql = "SELECT * FROM {$this->table} WHERE id =  $id";
		
		$conn = new Database();
		$result = $conn->execute($sql);
		
		$valor = $conn->fetch_assoc($result);
		
		return $valor;
	}
	  	
}// end class DAO

?>
