<?php
require_once('autoload.php');

date_default_timezone_set('America/Sao_Paulo');

class MP extends AbsId
{
	private $texto;
	private $data_hora;
	private $usuario;

	public function setTexto($texto) {
		$this->texto = $texto;
	}
	public function texto() {
		return $this->texto;
	}

	public function setData_hora($datahr) {
		$this->data_hora = $datahr;
	}
	public function data_hora() {
		return $this->data_hora;
	}

	public function setUsuario($usuario) {
		if($usuario instanceof Usuario) {
			$this->usuario = $usuario;
		}
	}
	public function usuario() {
		return $this->usuario;
	}
}
?>