<?php
class Galeria
{
 
 protected $id;
 protected $nome;
 protected $status;
 protected $datahora;
 
 const ATIVADO = 1;
 const DESATIVADO = 0;
 
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
 
 public function getStatus(){
 	 return $this->status;
 }
 
 public function getDatahora(){
 	 return $this->datahora;
 }
 
 public static function getGalerias($paginate, $order, $status = NULL){
	$dao = Dao::factory(__CLASS__);
	return self::makeObjects($dao->getGalerias($paginate, $order, $status));
 }
 
 public function getImagens(){
 	 return Imagem::getImagensPorGaleria($this->id);
 }
 
 public static function getLastId(){
 	 $dao = new ProdutoDao();
	 return $dao->getLastId();
 }

 #-------------------------------------#
 # METHODS
 #-------------------------------------#
 
 public function cadastrar($dados) 
 {
	 $dao = new ProdutoDao();
	 if($dao->cadastrar($dados)){
		 return true;
	 }
	 return false;
 }
 
 public function editar($dados) 
 {
	 $dao = new ProdutoDao();
	 if($dao->editar($dados,$this->id)){
		 return true;
	 }
	 return false;
 }
 
 public function deletar() 
 {
	 $dao = new ProdutoDao();
	 if($dao->deletar($this->id)){
	 	 if($dao->unrelateTagsProduct($this->id)){
	 	 	return true;
		 } else {
		 	return false;
		 }
	 }
	 return false;
 }
 
 public function carregarPorId($id) 
 {
	 $dao = new ProdutoDao();
	 $array = $dao->carregarPorId($id);
	 if($array){
	 
		 $this->id  		= $array['id'];  		
		 $this->nome 		= $array['nome']; 		
		 $this->status 		= $array['status'];
		 $this->datahora 	= $array['datahora']; 	
		 
		 return true;
	 }
	 return false;
 }
 
 public static function makeObjects($vetor){
 	
	if(is_array($vetor)){
		foreach($vetor as $v){
			$object = new self($v[0]);
			$objectArray[] = $object;
		}
	}
	return $objectArray;
	
 }
 	  	
}// end class Produto

?>
