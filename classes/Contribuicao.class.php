<?php
require_once("autoload.php");

class Contribuicao extends AbsId {
  private $informacao, $fontes;
  private $obj; // a obra, artista, gênero ou linguagem sobre que informa
  private $tipo, $estado;
  private $comentario; // do adm sobre a contribuicao

  public function setInformacao ($i) {
    $this->informacao = $i;
  }

  public function getInformacao () {
    return $this->informacao;
  }

  public function setFontes ($f) {
    $this->fontes = $f;
  }

  public function getFontes () {
    return $this->fontes;
  }

  
  private function podeSerObj ($o) {
    return $o instanceof Obra || $o instanceof Artista || $o instanceof Genero || $o instanceof LingArte;
  }
  public function setObj ($o) {
    if ($this->podeSerObj($o)) {
      $this->obj = $o;
    }
  }

  public function getObj () {
    return $this->obj;
  }

  public function setTipo ($t) {
    if ($t instanceof ContribuicaoTipo) {
      $this->tipo = $t;
    }
  }

  public function getTipo () {
    return $this->tipo;
  }

  public function setEstado ($e) {
    if ($e instanceof ContribuicaoEstado) {
      $this->estado = $e;
    }
  }

  public function getEstado () {
    return $this->estado;
  }

  public function setComentario ($c) {
    $this->comentario = $c;
  }

  public function getComentario () {
    return $this->comentario;
  }
}

?>