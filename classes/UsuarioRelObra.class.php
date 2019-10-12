<?php

require_once('autoload.php');

class UsuarioRelObra {
	private $obra;
	private $relacao; // Desejo (0), Atual (1) ou Completa (2)

	public function getObra() {
		return $this->obra;
	}

	public function setObra($obra) {
		if ($obra instanceof Obra) {
			$this->obra = $obra;
		}
	}

	public function getRelacao() {
		return $this->relacao;
	}

	public function setRelacao($rel) {
		$this->relacao = $rel;
	}

}

?>