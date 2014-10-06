<?php
class ImagemDao extends Dao{

 public function __construct(){
	
	parent::__construct();	
	$this->table		= "imagem";
 }

 public function cadastrar($dados) 
 {
	 $sql = "INSERT INTO {$this->table} (id_galeria,nome,extensao,ordem) values ('".$dados['id_galeria']."','".$dados['nome']."','".$dados['extensao']."','".$dados['ordem']."')";
	 $conn = new Database();
	 return $conn->execute($sql);
 }
 
 public function editar($dados,$id) 
 {
	 $sql = "UPDATE {$this->table} set nome = '".$dados['nome']."', extensao = '".$dados['extensao']."', ordem = '".$dados['ordem']."' WHERE id = {$id}";
	 $conn = new Database();
	 return $conn->execute($sql);
 }
 
 public function apagar($id) 
 {
	 $sql = "DELETE FROM {$this->table} WHERE id = {$id}";
	 $conn = new Database();
	 return $conn->execute($sql);
 }
 
 public function getImagesByGallery($id_galeria) 
 {
	$sql = "SELECT * FROM {$this->table} WHERE id_galeria = ".$id_galeria." order by ordem,id";
	$conn = new Database();
	$result =  $conn->execute($sql);
	
	while($valor = $conn->fetch_assoc($result)){
		$vetor['registros'][] = $valor; 
	}
	
	$sql = "SELECT count(id) FROM {$this->table} WHERE id_galeria = ".$id_galeria;
	
	$conn = new Database();
	$result =  $conn->execute($sql);
	$row = $conn->fetch_row($result);
	
	$vetor['total'] = $row[0];
	
	return $vetor;
	 
 }
 
 public function getLastId() 
 {
	 $sql = "SELECT id FROM {$this->table} ORDER BY id desc";
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
 
 public function getImages($paginate, $order = NULL, $status = NULL){
	
		$sql = "SELECT id FROM {$this->table}  ";
		
		if(!is_null($status)){
			$sql .= " WHERE status ='".$status."' ";
		}
		
		/*if(is_array($order)){
			$orderField = key($order);
			$orderMode = current($order);
				
			$sql .= " ORDER BY $orderField $orderMode";
		}*/
		
		$sql .= " ORDER BY id_galeria, ordem, id";
		
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
