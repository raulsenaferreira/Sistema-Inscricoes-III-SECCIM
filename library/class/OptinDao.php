<?php
class OptinDao extends Dao{

 public function __construct(){
	
	parent::__construct();	
	$this->table		= "optin";
 }

 public function cadastrar($dados) 
 {
	 $sql = "INSERT INTO {$this->table} (nome,email) values ('".$dados['nome']."','".$dados['email']."')";
	 $conn = new Database();
	 return $conn->execute($sql);
 }
 
 public function editar($dados,$id) 
 {
	 $sql = "UPDATE {$this->table} set nome = '".$dados['nome']."', email = '".$dados['email']."' WHERE id = {$id}";
	 $conn = new Database();
	 return $conn->execute($sql);
 }
 
 public function apagar($id) 
 {
	 $sql = "DELETE FROM {$this->table} WHERE id = {$id}";
	 $conn = new Database();
	 return $conn->execute($sql);
 }
 
 public function getLastId() 
 {
	 $sql = "SELECT id FROM {$this->table} ORDER BY id desc";
	 $conn = new Database();
	 $result = $conn->execute($sql);
	 
	 $valor = $conn->fetch_assoc($result);
	 
	 return $valor['id'];
 }

 public function getPorNomeEmail($nome,$email){
 	
 	 $sql = "SELECT * FROM {$this->table} WHERE nome = '".$nome."' AND email = '".$email."'";
	 $conn = new Database();
	 $result = $conn->execute($sql);
	 
	 while($valor = $conn->fetch_row($result)){
		$vetor['registros'][] = $valor; 
	}
	
	return $vetor;
 }
 
 public function carregarPorId($id) 
 {
	 $sql = "SELECT * FROM {$this->table} WHERE id = ".$id;
	 $conn = new Database();
	 $result = $conn->execute($sql);
	 
	 $valor = $conn->fetch_assoc($result);
	 
	 return $valor;
 }
 
 public function getRegistros($paginate, $order = NULL, $status = NULL){
	
		$sql = "SELECT id FROM {$this->table}  ";
		
		if(!is_null($status)){
			$sql .= " WHERE status ='".$status."' ";
		}
		
		if(is_array($order)){
			$orderField = key($order);
			$orderMode = current($order);
				
			$sql .= " ORDER BY $orderField $orderMode";
		}
		
		if(is_array($paginate)){
			if(isset($paginate['start']) and isset($paginate['limit'])){
				$sql .= " LIMIT ".$paginate['start'].",".$paginate['limit'];
			} else if(isset($paginate['limit'])) {
				$sql .= " LIMIT ".$paginate['limit'];
			}
		}
		
		$conn = new Database();
		$result =  $conn->execute($sql);
		
		while($valor = $conn->fetch_row($result)){
			$vetor['registros'][] = $valor; 
		}
		
		$sql = "SELECT count(id) FROM {$this->table} ";
		
		if(!is_null($status)){
			$sql .= " WHERE status ='".$status."' ";
		}
		
		$conn = new Database();
		$result =  $conn->execute($sql);
		$row = $conn->fetch_row($result);
		
		$vetor['total'] = $row[0];
		
		return $vetor;
	}
 	  	
}// end class 

?>
