<?php
class Agenda
{
 
 protected $id_evento;
 protected $tipo;
 protected $titulo;
 protected $descricao;
 protected $vagas;
 protected $data;
 protected $inicio; 
 protected $termino; 
 
 public function __construct($id=NULL) 
 {
 	 if($id!=NULL){
		 $this->carregarPorId($id);
	 }
 }
 
 #-------------------------------------#
 # GET
 #-------------------------------------#
 
 public function getIdEvento(){
 	 return $this->id_evento;
 }
 
 public function getTipo(){
 	 return $this->tipo;
 }
 
 public function getTitulo(){
 	 return $this->titulo;
 }

 public function getDescricao(){
 	 return $this->descricao;
 }
 
 public function getVagas(){
 	 return $this->vagas;
 }
 
 public function getData(){
 	 return $this->data;
 }
 
 public function getInicio(){
	 return $this->inicio;
 }

 public function getTermino(){
 	return $this->termino;
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
	 
	 if($dao->editar($dados,$this->id_evento)){
		 return true;
	 }
	 return false;
 }
 
 public function apagar() 
 {
	 $dao = Dao::factory(__CLASS__);
	 if($dao->apagar($this->id_evento)){
		 return true;
	 }
	 return false;
 }
 
 public function carregarPorId($id){
 	 
	 $dao = Dao::factory(__CLASS__);
	 $array = $dao->carregarPorId($id);
	 if($array){

		 $this->id_evento  	= $array['id_evento'];  		
		 $this->titulo 		= $array['titulo'];
		 $this->descricao 	= $array['descricao'];
		 $this->vagas		= $array['vagas'];
		 $this->data		= $array['data'];
		 $this->inicio		= $array['inicio'];
		 $this->termino		= $array['termino'];
		 $this->tipo		= $array['tipo'];
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
 	  	
}// end class

?>
