<?php
class UsuarioNivel extends AbsId {
  private $descricao;
  public function setDescricao($d){$this->descricao=$d;}
  public function getDescricao(){return $this->descricao;}
}
?>
