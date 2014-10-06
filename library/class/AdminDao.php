<?php

class AdminDao extends Dao{

	public function __construct(){
	
		parent::__construct();	
		$this->table	= "alunos";
	}
	
	public function autenticacao($email,$senha){
	
		$sql = "SELECT id_aluno,nome FROM {$this->table} WHERE email ='".$email."' AND senha ='".md5($senha)."'";
		$conn = new Database();
		$result =  $conn->execute($sql);
		
		$valor = $conn->fetch_row($result);
		if($valor[0] != NULL){
			return $vetor = array($valor[0],$valor[1]);
		}
		return false;
	}
	
	 public function getLastId() 
	 {
		 $sql = "SELECT id_aluno FROM {$this->table} ORDER BY id_aluno desc";
		 $conn = new Database();
		 $result = $conn->execute($sql);
		 
		 $valor = $conn->fetch_assoc($result);
		 
		 return $valor['id_aluno'];
	 }
	 
	 public function apagar($id_aluno) 
	 {
		 $sql = "DELETE FROM {$this->table} WHERE id_aluno = {$id_aluno}";
		 $conn = new Database();
		 return $conn->execute($sql);
	 }
 
	
	 public function getUsuarios($paginate, $order, $status){
	
		$sql = "SELECT id_aluno FROM {$this->table}  ";
		
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
		
		$sql = "SELECT count(id_aluno) FROM {$this->table} ";
		
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
