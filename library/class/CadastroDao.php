<?php
class CadastroDao extends Dao{

 public function __construct(){
	
	parent::__construct();	
	$this->table		= "cadastrados";
 }

 public function cadastrar($dados) 
 {
	$sql = "INSERT INTO {$this->table} (id_evento,id_aluno,inscrito, data_inscricao) values ('".$dados['id_evento']."','".$dados['id_aluno']."','".$dados['inscrito']."','".$dados['data_inscricao']."')";
	 $conn = new Database();
	 return $conn->execute($sql);
 }
 
 public function editar($dados,$id) 
 {
	 $sql = "UPDATE {$this->table} set id_evento = '".$dados['id_evento']."', id_aluno = '".$dados['id_aluno']."', inscrito = '".$dados['inscrito']."', data_inscricao = '".$dados['data_inscricao']."' WHERE id_cadastro = {$id}";
	 $conn = new Database();
	 return $conn->execute($sql);
 }
 
 public function apagar($id_cadastro, $id_evento, $id_aluno) 
 {
	 $sql = "DELETE FROM {$this->table} WHERE id_cadastro = {$id_cadastro} AND id_evento = {$id_evento} AND id_aluno = {$id_aluno} ";
	 $conn = new Database();
	 return $conn->execute($sql);
 }
 
 public function getLastId() 
 {
	 $sql = "SELECT id_cadastro FROM {$this->table} ORDER BY id_cadastro desc";
	 $conn = new Database();
	 $result = $conn->execute($sql);
	 
	 $valor = $conn->fetch_assoc($result);
	 
	 return $valor['id_cadastro'];
 }
 
 public function carregarPorId($id) 
 {
	 $sql = "SELECT * FROM {$this->table} WHERE id_cadastro = ".$id;
	 $conn = new Database();
	 $result = $conn->execute($sql);
	 
	 $valor = $conn->fetch_assoc($result);
	 
	 return $valor;
 }

 public function carregarCadastrado($id_aluno) 
 {
	 $sql = "SELECT * FROM {$this->table} WHERE id_aluno = ".$id_aluno;
	 $conn = new Database();
	 $result = $conn->execute($sql);
	 
	 $valor = $conn->fetch_assoc($result);
	 
	 return $valor;
 }
 
 public function getRegistros($paginate, $order = NULL, $status = NULL){
	
		$sql = "SELECT id_cadastro FROM {$this->table}  ";
		
		if(!is_null($status)){
			$sql .= " WHERE inscrito ='".$status."' ";
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
		
		$sql = "SELECT count(id_cadastro) FROM {$this->table} ";
		
		if(!is_null($status)){
			$sql .= " WHERE inscrito ='".$status."' ";
		}
		
		$conn = new Database();
		$result =  $conn->execute($sql);
		$row = $conn->fetch_row($result);
		
		$vetor['total'] = $row[0];
		
		return $vetor;
	}
 	  	
}// end class 

?>
