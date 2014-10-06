<?php
class Cadastro
{
 
 protected $id_cadastro;
 protected $id_evento;
 protected $id_aluno;
 protected $inscrito;
 protected $data_inscricao;
 
 public function __construct($id=NULL) 
 {
 	 if($id!=NULL){
		 $this->carregarPorId($id);
	 }
 }
 
 #-------------------------------------#
 # GET
 #-------------------------------------#
 
 public function getIdCadastro(){
 	 return $this->id_cadastro;
 }
 
 public function getIdEvento(){
 	 return $this->id_evento;
 }
 
 public function getIdAluno(){
 	 return $this->id_aluno;
 }

 public function getInscrito(){
 	 return $this->inscrito;
 }

 public function getData_inscricao(){
 	return $this->data_inscricao;
 }
	 
 public static function getRegistros($paginate, $order = NULL, $status = NULL){
	$dao = Dao::factory(__CLASS__);
	return self::makeObjects($dao->getRegistros($paginate, $order, $status));
 }
 
 public static function getLastId(){
 	 $dao = Dao::factory(__CLASS__);
	 return $dao->getLastId();
 }

 #-------------------------------------#
 # METHODS
 #-------------------------------------#
 
 
 public function cadastrar($dados) 
 {
 	 $dao = Dao::factory(__CLASS__);
	 
	 if($dao->cadastrar($dados)){
	 	 $lastId = self::getLastId(); 
		 return true;
	 }
	 return false;
 }
 
 public function editar($dados) 
 {
	 $dao = Dao::factory(__CLASS__);
	 
	 if($dao->editar($dados,$this->id_cadastro)){
		 return true;
	 }
	 return false;
 }
 
 public function apagar() 
 {
	 $dao = Dao::factory(__CLASS__);
	 if($dao->apagar($this->id_cadastro,$this->id_evento,$this->id_aluno)){
		 return true;
	 }
	 return false;
 }
 
 public function carregarPorId($id){
 	 
	 $dao = Dao::factory(__CLASS__);
	 $array = $dao->carregarPorId($id);
	 if($array){
		 $this->id_cadastro = $array['id_cadastro'];  		
		 $this->id_evento 	= $array['id_evento'];
		 $this->id_aluno 	= $array['id_aluno'];
		 $this->inscrito	= $array['inscrito'];
		 $this->data_inscricao	= $array['data_inscricao'];

		 return true;
	 }
	 return false;
 }

 public function carregarCadastrado($id){
 	 
	 $dao = Dao::factory(__CLASS__);
	 $array = $dao->carregarCadastrado($id);
	 if($array){
		 $this->id_cadastro = $array['id_cadastro'];  		
		 $this->id_evento 	= $array['id_evento'];
		 $this->id_aluno 	= $array['id_aluno'];
		 $this->inscrito	= $array['inscrito'];
		 $this->data_inscricao	= $array['data_inscricao'];

		 return true;
	 }
	 return false;
 }
 
 public static function makeObjects($vetor){
	
		if(is_array($vetor)){
			if($vetor['total']>0){
				foreach($vetor['registros'] as $v){
					$object = new self($v[0]);
					$objectArray[] = $object;
				}
			}
		}
		return $objectArray;
	}
 	  	
}// end class Imagem

?>
