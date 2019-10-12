<?php
class Resenha extends AbsId
{
	private $texto;
	private $obra;
	private $dataHora;
	private $comentarios = [];

	public function setTexto($t)
	{
		$this->texto = $t;
	}
	public function getTexto()
	{
		return $this->texto;
	}

	public function setObra($o)
	{
		if ($o instanceof Obra) $this->obra = $o;
	}
	public function getObra()
	{
		return $this->obra;
	}

	public function setDataHora($dt)
	{
		$this->dataHora = $dt;
	}
	public function getDatahora()
	{
		return $this->dataHora;
	}

	public function setComentario($cmt)
	{
		if ($cmt instanceof Comentario) {
			$this->comentarios[] = $cmt;
		}
	}
	public function comentarios()
	{
		return $this->comentarios;
	}
}
