<?php

class AdministradorDao extends Dao{

	public function __construct(){
	
		parent::__construct();	
		$this->table		= "Administradores";
	}
	
	public function autenticacao($email,$senha){
	
		$sql = "SELECT id_admin,nome FROM {$this->table} WHERE email ='".$email."' AND senha ='".md5($senha)."'";
		$conn = new Database();
		$result =  $conn->execute($sql);
		
		$valor = $conn->fetch_row($result);
		if($valor[0] != NULL){
			return $vetor = array($valor[0],$valor[1]);
		}
		return false;
	}
 
	  	
}// end class

?>
