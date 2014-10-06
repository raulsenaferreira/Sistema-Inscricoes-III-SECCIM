<?php
class Cadastro
{
 
 protected $id_cadastro;
 protected $id_evento;
 protected $id_aluno;
 protected $inscrito;
 protected $data_inscricao;
 
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
 }// end class Cadastros

?>