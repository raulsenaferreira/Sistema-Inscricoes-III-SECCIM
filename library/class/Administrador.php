<?php
class Administrador extends Model{
 
	protected $nome;
	protected $email;
	protected $senha;
	protected $status;
	
	const ATIVADO = 1;
	const DESATIVADO = 0;
	
	public function __construct($id = NULL)	{
		parent::__construct($id);	
	}
	
	#-------------------------------------#
	# GET
	#-------------------------------------#
	
	public function getNome(){
		return $this->nome;
	}
	
	public function getEmail(){
		return $this->email;
	}
	
	public function getSenha(){
		return $this->senha;
	}
	
	
	public static function getUsuarios(array $paginate){
		$dao = Dao::factory(__CLASS__);
		return $dao->getUsuarios($paginate);
	}
	
	#-------------------------------------#
	# METHODS
	#-------------------------------------#
	
	public function autenticacao($email,$senha){
		$dao = Dao::factory(__CLASS__);
		return $dao->autenticacao($email,$senha);
	}
	
	public function cadastrar($dados){
		
		$dados['senha'] = md5($dados['senha']);
		
		return parent::cadastrar($dados);
	}
	
	public function editar($dados){
		
		if($dados['senha']){
			$dados['senha'] = md5($dados['senha']);
		}
		
		return parent::cadastrar($dados);
	}
	
	public function carregarPorId($id) 
	{
		parent::__construct($id);	
		
		if($array){
	 
			$this->id  		= $array['id_admin'];  		
			$this->nome 		= $array['nome'];
			$this->email 		= $array['email'];	
			$this->senha 		= $array['senha'];
			
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
 	  	
}// end class

?>