<?php

class LingArte extends AbsIdNomeDescricao{
	private $generos = array();

	public function setGenero($genero){
		if($genero instanceof Genero){
			array_push($this->generos, $genero);
		}
	}
	public function getGeneros(){
		return $this->generos;
	}
}


?>