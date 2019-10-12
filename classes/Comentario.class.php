<?php
require_once('autoload.php');

class Comentario extends AbsId
{
  private $texto;
  private $data_hora;
  private $noLikes;

  public function setTexto($texto)
  {
    $this->texto = $texto;
  }
  public function texto()
  {
    return $this->texto;
  }

  public function setData_hora($dthr)
  {
    $this->data_hora = $dthr;
  }
  public function data_hora()
  {
    return $this->data_hora;
  }

  public function setNoLikes($no)
  {
    $this->noLikes = $no;
  }
  public function noLikes()
  {
    return $this->noLikes;
  }
}
