<?php

require_once "autoload.php";

class Obra extends AbsIdNomeDescricao
{
	private $data_lancamento, $imagemUrl;
	private $generos = array();
	private $comentarios = [];
	private $notaMedia;

	public function setData_lancamento($data)
	{
		$this->data_lancamento = $data;
	}
	public function getData_lancamento()
	{
		return $this->data_lancamento;
	}

	public function setImagemUrl($imgurl)
	{
		$this->imagemUrl = $imgurl;
	}
	public function getImagemUrl()
	{
		return $this->imagemUrl;
	}

	public function setGenero($genero)
	{
		if ($genero instanceof Genero) {
			array_push($this->generos, $genero);
		}
	}
	public function getGeneros()
	{
		return $this->generos;
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

	public function setNotaMedia($notamedia)
	{
		$this->notaMedia = $notamedia;
	}
	public function getNotaMedia()
	{
		return $this->notaMedia;
	}
}
