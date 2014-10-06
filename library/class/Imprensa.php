<?php
class Imprensa
{
 
 protected $id;
 protected $nome;
 protected $tipo;
 protected $link;
 protected $target;
 protected $extensao;
 protected $status;
 protected $datapub;
 protected $datahora;
 
 const TIPO_LINK = 1;
 const TIPO_IMAGEM = 2;
 
 const LINK_BLANK = 1;
 const LINK_SELF = 2;
 
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
 
 public function getTipo(){
 	 return $this->tipo;
 }
 
 public function getDatahora(){
 	 return $this->datahora;
 }

 public function getStatus(){
 	 return $this->status;
 }
 
 public function getDatapub(){
 	 return $this->datapub;
 }
 
 public function getLink(){
 	 return $this->link;
 }
 
 public function getTarget(){
 	 return $this->target;
 }
 
 public function getExtensao(){
 	 return $this->extensao;
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
 	 
	 if($dados['imagem']['tmp_name']){
		 $tmp_type = explode(".", $dados['imagem']['name']);
		 $tmp_type = end($tmp_type);
		 $dados['extensao'] = ".".$tmp_type;
	 }
	 
	 if($dao->cadastrar($dados)){
	 	 $lastId = self::getLastId(); 
	 	 self::uploadImagem($dados['imagem'], md5($lastId), $tipo);
		 return true;
	 }
	 return false;
 }
 
 public function editar($dados) 
 {
	 $dao = Dao::factory(__CLASS__);
	 
	 if($dados['imagem']['tmp_name']){
		 $tmp_type = explode(".", $dados['imagem']['name']);
		 $tmp_type = end($tmp_type);
		 $dados['extensao'] = ".".$tmp_type;
	 }
	 
	 if($dao->editar($dados,$this->id)){
	 	 if(!is_null($dados['imagem']['tmp_name'])){
	 	 	 self::uploadImagem($dados['imagem'], md5($this->id), $tipo);
	 	 }
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
 
 public static function uploadImagem($imagem, $nomeDaImagem, $tipo = '') {
	 
      $tmp_file = $imagem['tmp_name'];
      $tmp_size = $imagem['size'];
      $tmp_type = explode(".", $imagem['name']);
      $tmp_type = end($tmp_type);
      
      $galeria  = 'imprensa/';
      
      if($tmp_file){
      
	      $diretorio = Config::UPLOAD . $galeria . $nomeDaImagem . $tipo . "." . $tmp_type;
	     
	      if(($tmp_size < 10097152)){
			move_uploaded_file($tmp_file, $diretorio);
		  
	      }	else if($tmp_size != 0){
	      } else {
		      die("Imagem maior do que 10mb, recarregue a página");
	      }
      } else {
      	      return false;
      }
 }
 
 public function carregarPorId($id){
 	 
	 $dao = Dao::factory(__CLASS__);
	 $array = $dao->carregarPorId($id);
	 if($array){
	 
		 $this->id  		= $array['id'];  		
		 $this->nome 		= $array['nome'];
		 $this->tipo 		= $array['tipo'];
		 $this->link 		= $array['link'];
		 $this->target 		= $array['target'];
		 $this->extensao	= $array['extensao'];
		 $this->status		= $array['status'];
		 $this->datapub		= $array['datapub'];
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
 	  	
}// end class Imagem

?>
