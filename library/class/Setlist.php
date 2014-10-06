<?php
class Setlist
{
 
 protected $id;
 protected $nome;
 protected $url_play;
 protected $url_download;
 protected $extensao;
 protected $ordem;
 protected $status;
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
 
 public function getUrlPlay(){
 	 return $this->url_play;
 }
 
 public function getUrlDownload(){
 	 return $this->url_download;
 }
 
 public function getDatahora(){
 	 return $this->datahora;
 }

 public function getStatus(){
 	 return $this->status;
 }
 
 public function getExtensao(){
 	 return $this->extensao;
 }
 
 public function getOrdem(){
 	 return $this->ordem;
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
 	 
 	  if($dados['arquivo']['tmp_name']){
		 $tmp_type = explode(".", $dados['arquivo']['name']);
		 $tmp_type = end($tmp_type);
		 $dados['extensao'] = ".".$tmp_type;
	 }
	 
	 if($dao->cadastrar($dados)){
	 	 $lastId = self::getLastId(); 
	 	 self::uploadData($dados['arquivo'], md5($lastId));
		 return true;
	 }
	 return false;
 }
 
 public function editar($dados) 
 {
	 $dao = Dao::factory(__CLASS__);
	 
	 if($dados['arquivo']['tmp_name']){
		 $tmp_type = explode(".", $dados['arquivo']['name']);
		 $tmp_type = end($tmp_type);
		 $dados['extensao'] = ".".$tmp_type;
	 }
	 
	 if($dao->editar($dados,$this->id)){
	 	 if(!is_null($dados['arquivo']['tmp_name'])){
	 	 	 self::uploadData($dados['arquivo'], md5($this->id));
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
 
 public function carregarPorId($id){
 	 
	 $dao = Dao::factory(__CLASS__);
	 $array = $dao->carregarPorId($id);
	 if($array){
	 
		 $this->id  		= $array['id'];  		
		 $this->nome 		= $array['nome'];
		 $this->url_play	= $array['url_play'];
		 $this->url_download	= $array['url_download'];
		 $this->extensao 	= $array['extensao'];
		 $this->status		= $array['status'];
		 $this->ordem		= $array['ordem'];
		 $this->datahora	= $array['datahora'];
	 
		 return true;
	 }
	 return false;
 }
 
 public static function uploadData($arquivo, $nomeArquivo) {
	 
      $tmp_file = $arquivo['tmp_name'];
      $tmp_size = $arquivo['size'];
      $tmp_type = explode(".", $arquivo['name']);
      $tmp_type = end($tmp_type);
      
      if($tmp_file){
      
	      $diretorio = Config::UPLOAD . "sets/" .  $nomeArquivo . "." . $tmp_type;
	     
	      if(($tmp_size < 16097152)){
		      
			move_uploaded_file($tmp_file, $diretorio);
		  
	      }	else if($tmp_size != 0){
	      } else {
		      die("Timeout: Arquivo maior do que 16mb, recarregue a página");
	      }
      } else {
      	      return false;
      }
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
