<?php
class Admin extends Model{
 
	protected $nome;
	protected $matricula;
	protected $curso;
	protected $rural;
	protected $email;
	protected $senha;
	protected $status;
	protected $datahora;
	
	const ATIVADO = 1;
	const DESATIVADO = 0;
	
	public function __construct($id_aluno = NULL)	{
		 if($id_aluno!=NULL){
			 $this->carregarPorid_aluno($id_aluno);
		 }
	}
	
	#-------------------------------------#
	# GET
	#-------------------------------------#

	public function getId_aluno(){
		return $this->id_aluno;
	}
	
	public function getNome(){
		return $this->nome;
	}
	
	public function getMatricula(){
		return $this->matricula;
	}

	public function getCurso(){
		return $this->curso;
	}
	public function isRural(){
		return $this->rural;
	}

	public function getEmail(){
		return $this->email;
	}
	
	public function getSenha(){
		return $this->senha;
	}
	
	public function getDatahora(){
		return $this->datahora;
	}

	#-------------------------------------#
	# GET
	#-------------------------------------#	
	
	public function setNome(){
		return $this->nome;
	}
	public function setMatricula(){
		return $this->matricula;
	}
	public function setCurso(){
		return $this->curso;
	}
	public function setRural(){
		return $this->rural;
	}
	
	public function setEmail(){
		return $this->email;
	}
	
	public function setSenha(){
		return md5($this->senha);
	}
	
	 public static function getLastId(){
		 $dao = new AlunoDao();
		 return $dao->getLastId();
	 }
	#-------------------------------------#
	# METHODS
	#-------------------------------------#

	public static function getUsuarios($paginate, $order, $status = NULL){
		$dao = Dao::factory(__CLASS__);
		return self::makeObjects($dao->getUsuarios($paginate, $order, $status));
	}

	public function autenticacao($email,$senha){
		$dao = Dao::factory(__CLASS__);
		return $dao->autenticacao($email,$senha);
	}
	
	public function cadastrar($dados){
		
		$dados['senha'] = md5($dados['senha']);
		
		$dao = Dao::factory(__CLASS__);
		if($dao->cadastrar($dados)){
			return true;
		}
		return false;
	}
	
	public function editar($dados){
		
		if($dados['senha']){
			$dados['senha'] = md5($dados['senha']);
		}
		
		$dao = Dao::factory(__CLASS__);
		if($dao->editar($dados,$this->id_aluno)){
			return true;
		}
		return false;
	}
	
	public function deletar() 
	{
		$dao = Dao::factory(__CLASS__);
		if($dao->deletar($this->id_aluno)){
			return true;
		}
		return false;
	}
	
	public static function getAdministradores($paginate, $order, $status = NULL){
		$dao = Dao::factory(__CLASS__);
		return self::makeObjects($dao->getAdministradores($paginate, $order, $status));
	}
	
	public function apagar(){
		$dao = Dao::factory(__CLASS__);
		 if($dao->apagar($this->id_aluno)){
			 return true;
		 }
		 return false;
	}


	public function getEmailExists($email){
		$dao = Dao::factory(__CLASS__);
		if($dao->getEmailExists($email) == TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function carregarPorId($id_aluno) 
	{
		 $dao = new AlunoDao();
		 $array = $dao->carregarPorId($id_aluno);
		
		if($array){
	 
			$this->id_aluno		= $array['id_aluno'];  		
			$this->nome 		= $array['nome'];
			$this->matricula	= $array['matricula'];
			$this->curso 		= $array['curso'];
			$this->rural 		= $array['rural'];
			$this->email 		= $array['email'];	
			$this->status 		= $array['status'];
			$this->senha 		= $array['senha'];
			$this->datahora 	= $array['datahora']; 	
		 
			return true;
		}
		return false;
	}
	
	public static function makeObjects($vetor){
	
		if(is_array($vetor)){
			foreach($vetor['registros'] as $v){
				$object = new self($v[0]);
				$objectArray[] = $object;
			}
		}
		return $objectArray;
	}
 	  	
}// end class

?>
