<?php
class Optin
{
 
 protected $id;
 protected $nome;
 protected $email;
 protected $datahora;
 
 public function __construct($id=NULL) 
 {
 	 if($id!=NULL){
		 $this->carregarPorId($id);
	 }
 }
 
 #-------------------------------------#
 # GET
 #-------------------------------------#
 
 public function getId(){
 	 return $this->id;
 }
 
 public function getNome(){
 	 return $this->nome;
 }
 
 public function getDatahora(){
 	 return $this->datahora;
 }

 public function getEmail(){
 	 return $this->email;
 }
 
 public static function getRegistros($paginate, $order = NULL, $status = NULL){
	$dao = Dao::factory(__CLASS__);
	return self::makeObjects($dao->getRegistros($paginate, $order, $status));
 }
 
 public static function getLastId(){
 	 $dao = Dao::factory(__CLASS__);
	 return $dao->getLastId();
 }
 
 public static function getPorNomeEmail($nome,$email){
 	 $dao = Dao::factory(__CLASS__);
	 return $dao->getPorNomeEmail($nome,$email);
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
	 
	 if($dao->editar($dados,$this->id)){
		 return true;
	 }
	 return false;
 }
 
 public function apagar() 
 {
	 $dao = Dao::factory(__CLASS__);
	 if($dao->apagar($this->id)){
		 return true;
	 }
	 return false;
 }
 
 public function carregarPorId($id){
 	 
	 $dao = Dao::factory(__CLASS__);
	 $array = $dao->carregarPorId($id);
	 if($array){
	 
		 $this->id  		= $array['id'];  		
		 $this->nome 		= $array['nome'];
		 $this->email 		= $array['email'];
		 $this->datahora	= $array['datahora'];
	 
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
