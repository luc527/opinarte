<?php
require_once "autoload.php";

abstract class AbsIdNome extends AbsId {
	private $nome;

	public function setNome($nome) {
		$this->nome = $nome;
	}
	public function getNome() {
		return $this->nome;
	}
}
?>