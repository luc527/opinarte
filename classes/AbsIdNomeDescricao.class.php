<?php
require_once "autoload.php";

abstract class AbsIdNomeDescricao extends AbsIdNome {
	private $descricao;

	public function setDescricao($descricao){
		$this->descricao = $descricao;
	}
	public function getDescricao(){
		return $this->descricao;
	}
}

?>