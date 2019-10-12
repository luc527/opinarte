<?php

require_once('autoload.php');

class UsuarioNotaObra {
	private $obra;
	private $nota;

	public function getObra() {
		return $this->obra;
	}

	public function setObra($obra) {
		if ($obra instanceof Obra) {
			$this->obra = $obra;
		}
	}

	public function getNota() {
		return $this->nota;
	}

	public function setNota($nota) {
		$this->nota = $nota;
	}

}

?>