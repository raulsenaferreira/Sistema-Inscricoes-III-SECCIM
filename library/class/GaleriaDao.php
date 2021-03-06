<?php
class galeriaDao
{

 public function __construct() 
 {
 	$this->table		= "art_produto";
 }

 public function cadastrar($dados) 
 {
	 $sql = "INSERT INTO {$this->table} (nome, status) values ('".$dados['nome']."','".$dados['status']."')";
	 $conn = new Database();
	 return $conn->execute($sql);
 }
 
 public function editar($dados,$id) 
 {
	 $sql = "UPDATE {$this->table} set nome = '".$dados['nome']."' WHERE id = {$id}";
	 $conn = new Database();
	 return $conn->execute($sql);
 }
 
 public function deletar($id) 
 {
	 $sql = "DELETE FROM {$this->table} WHERE id = ".$id;
	 $conn = new Database();
	 return $conn->execute($sql);
 }
 
 public function getGallery($paginate) 
 {
 	 
	 $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM {$this->table} ORDER BY status desc,nome asc ";

	 if(is_array($paginate)){
		if(isset($paginate['start']) and isset($paginate['limit'])){
			$sql .= " LIMIT ".$paginate['start'].",".$paginate['limit'];
		} else if(isset($paginate['limit'])) {
			$sql .= " LIMIT ".$paginate['limit'];
		}
	}

	 $conn = new Database();
	 $result =  $conn->execute($sql);
	 
	 while($row = $conn->fetch_assoc($result)){
		$vetor['registros'][] = $row;
	 }
	 
	 $sql = "SELECT FOUND_ROWS() ";
	 $result = $conn->execute($sql);
	 $valor = $conn->fetch_row($result);
	 $vetor['total'] = $valor[0];
	 
	 return $vetor;
 }

 public function getLastId() 
 {
	 $sql = "SELECT id FROM {$this->table} ORDER BY datahora DESC";
	 $conn = new Database();
	 $result = $conn->execute($sql);
	 
	 $valor = $conn->fetch_assoc($result);
	 
	 return $valor['id'];
 }
 
 public function carregarPorId($id) 
 {
	 $sql = "SELECT * FROM {$this->table} WHERE id = ".$id;
	 $conn = new Database();
	 $result = $conn->execute($sql);
	 
	 $valor = $conn->fetch_assoc($result);
	 
	 return $valor;
 }
 
 	  	
}// end class 

?>
