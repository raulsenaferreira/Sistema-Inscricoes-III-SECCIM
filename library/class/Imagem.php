<?php
class Artigo
{
 
 protected $id;
 protected $nome;
 protected $extensao;
 protected $status;
 protected $datapub;
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
 
 public function getIdGaleria(){
 	 return $this->id_galeria;
 }

 public function getNome(){
 	 return $this->nome;
 }
 
 public function getOrdem(){
 	 return $this->ordem;
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
	 
 public static function getImagensPorGaleria($id_galeria,$is_object = false){
 	 $dao = new ImagemDao();
 	 if($is_object){
 	 	 return self::makeObjects($dao->getImagesByGallery($id_galeria));
 	 }
	 return $dao->getImagesByGallery($id_galeria);
 }
 
 public static function getImagens($paginate, $order = NULL, $status = NULL){
	$dao = Dao::factory(__CLASS__);
	return self::makeObjects($dao->getImages($paginate, $order, $status));
}
 
 public static function getLastId(){
 	 $dao = new ImagemDao();
	 return $dao->getLastId();
 }

 #-------------------------------------#
 # METHODS
 #-------------------------------------#
 
 
 public function cadastrar($dados) 
 {
	 $dao = new ImagemDao();
	 
	 if($dados['imagem']['tmp_name']){
		 $tmp_type = explode(".", $dados['imagem']['name']);
		 $tmp_type = end($tmp_type);
		 $dados['extensao'] = ".".$tmp_type;
	 }
	 
	 if($dao->cadastrar($dados)){
	 	 $lastId = self::getLastId(); 
	 	 self::uploadImagem($dados['imagem'], md5($lastId), $tipo, $dados['id_galeria']);
	 	 self::uploadImagem($dados['thumb'], md5($lastId), 't', $dados['id_galeria']);
		 return true;
	 }
	 return false;
 }
 
 public function editar($dados) 
 {
	 $dao = new ImagemDao();
	 
	 if($dados['imagem']['tmp_name']){
		 $tmp_type = explode(".", $dados['imagem']['name']);
		 $tmp_type = end($tmp_type);
		 $dados['extensao'] = ".".$tmp_type;
	 }
	 
	 if($dao->editar($dados,$this->id)){
	 	 if(!is_null($dados['imagem']['tmp_name'])){
	 	 	 self::uploadImagem($dados['imagem'], md5($this->id), $tipo, $dados['id_galeria']);
	 	 }
	 	 if(!is_null($dados['thumb']['tmp_name'])){
	 	 	 self::uploadImagem($dados['thumb'], md5($this->id), 't', $dados['id_galeria']);
	 	 }
		 return true;
	 }
	 return false;
 }
 
 public function apagar() 
 {
	 $dao = new ImagemDao();
	 if($dao->apagar($this->id)){
		 return true;
	 }
	 return false;
 }
 
 public static function uploadImagem($imagem, $nomeDaImagem, $tipo = '', $id_galeria) {
	 
      $tmp_file = $imagem['tmp_name'];
      $tmp_size = $imagem['size'];
      $tmp_type = explode(".", $imagem['name']);
      $tmp_type = end($tmp_type);
      
      if($tmp_file){
      
	      switch($id_galeria){
		case 1:
			$galeria = "ensaios/";
			break;
		case 2:
			$galeria = "familia/";	
			break;
		case 3:
			$galeria = "fotografando/";
			break;
	      }
	      
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
	 $dao = new ImagemDao();
	 $array = $dao->carregarPorId($id);
	 if($array){
	 
		 $this->id  		= $array['id'];  		
		 $this->id_galeria	= $array['id_galeria'];  		
		 $this->nome 		= $array['nome']; 		
		 $this->extensao	= $array['extensao'];
		 $this->ordem		= $array['ordem'];
		 $this->status		= $array['status'];
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
