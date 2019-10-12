<?php
require_once('autoload.php');
class Lista extends AbsIdNomeDescricao
{
  private $itens = array();
  private $ordem; //ordenada ou não-ordenada
  private $datahr; //data e ora
  private $comentarios = [];

  public function setItem($i)
  {
    if ($i instanceof ListaItem) {
      array_push($this->itens, $i);
    }
  }
  public function itens()
  {
    return $this->itens;
  }

  public function setOrdem($o)
  {
    $this->ordem = $o;
  }
  public function ordem()
  {
    return $this->ordem;
  }

  public function setDatahr($d)
  {
    $this->datahr = $d;
  }
  public function datahr()
  {
    return $this->datahr;
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
