<?php
require_once('autoload.php');
class ListaItem extends AbsId {
  private $descricao;
  private $item; // obra ou artista, pode ser qqr um dos dois
  private $posicao;

  public function setDescricao($d){$this->descricao=$d;}
  public function getDescricao(){return $this->descricao;}

  public function setItem($i){
    if($i instanceof Obra || $i instanceof Artista){
      $this->item = $i;
    }
  }
  public function item(){return $this->item;}

  public function setPosicao($p){$this->posicao=$p;}
  public function posicao(){return $this->posicao;}
}
?>
