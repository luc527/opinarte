<?php
require_once "autoload.php";

class Artista extends AbsIdNomeDescricao
{
	private $imagemUrl;
	private $obras = array();
	private $generos = array();
	private $comentarios = [];

	public function setImagemUrl($imgurl)
	{
		$this->imagemUrl = $imgurl;
	}
	public function getImagemUrl()
	{
		return $this->imagemUrl;
	}

	public function setObra($obra)
	{
		if ($obra instanceof Obra) {
			array_push($this->obras, $obra);
		}
	}
	public function getObras()
	{
		return $this->obras;
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
}
