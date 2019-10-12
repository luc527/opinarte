<?php
require_once("autoload.php");

class Relacao extends AbsId {
	private $descricao;
	private $obj1, $obj2; // Os dois objetos da relação
	// Qualquer combinação possível com artista, obra e gênero
	private $fontes;
	private $noVotos;

	public function setDescricao($d){$this->descricao=$d;}
	public function getDescricao(){return $this->descricao;}
	
	private static function podeSerObj($obj) {
		return $obj instanceof Genero || $obj instanceof Artista || $obj instanceof Obra;
	}
	
	public function setObj1($o1){
		if(self::podeSerObj($o1)) {
			$this->obj1 = $o1;
		}
	}
	public function getObj1(){return $this->obj1;}

	public function setObj2($o2){
		if(self::podeSerObj($o2)) {
			$this->obj2 = $o2;
		}
	}
	public function getObj2(){return $this->obj2;}

	public function setFontes($f){$this->fontes=$f;}
	public function getFontes(){return $this->fontes;}

	public function setVotos($v){$this->noVotos=$v;}
	public function getVotos(){return $this->noVotos;}

	
}
?>