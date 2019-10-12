<?php
include('valida_secao.php');
require_once('autoload.php');
date_default_timezone_set('America/Sao_Paulo');

if (isset($_POST['acao'])) $acao = $_POST['acao'];
else if (isset($_GET['acao'])) $acao = $_GET['acao'];
else $acao = '';
//echo($acao);

if ($acao == 'Insert') {
  $id = Funcoes::ProximoId('lista');

  $lista = new Lista;
  $lista->setId($id);
  $lista->setNome($_POST['nome']);
  $lista->setDescricao($_POST['descricao']);
  $lista->setOrdem($_POST['ordem']);
  $lista->setDatahr(date("Y-m-d H:i:s"));

  $autor_id = $_POST['autor'];

  ListaDao::Insert($lista, $autor_id);
  header("location:lista_edit.php?id=".$id);
} else if ($acao == 'Update') {
  $lista = new Lista;
  $lista->setId($_POST['id']);
  $lista->setNome($_POST['nome']);
  $lista->setDescricao($_POST['descricao']);
  $lista->setOrdem($_POST['ordem']);
  $lista->setDatahr(date("Y-m-d H:i:s"));

  ListaDao::Update($lista);
  header("location:lista_edit.php?id=".$_POST['id']);
} else if ($acao == 'Delete') {
  ListaDao::Delete($_POST['id']);
  header("location:lista_cad.php");
} else if ($acao == 'InsertItem') {
  $lista = $_POST['lista'];

  if ( isset($_POST['item_obra']) ) $item = ObraDao::SelectPorId($_POST['item_obra']);
  else if ( isset($_POST['item_artista']) ) $item = ArtistaDao::SelectPorId($_POST['item_artista']);

  if (isset($_POST['posicao'])) $posicao = $_POST['posicao'];

  $item_obj = new ListaItem;
  $item_obj->setItem($item);
  $item_obj->setDescricao($_POST['descricao']);
  if (isset($posicao)) $item_obj->setPosicao($posicao);

  ListaItemDao::Insert($item_obj, $lista);
  header("location:lista_edit.php?id=".$lista);

} else if ($acao == 'DeleteItem') {

  ListaItemDao::Delete($_GET['id_item']);
  header("location:lista_edit.php?id=".$_GET['lista']);
}
?>
