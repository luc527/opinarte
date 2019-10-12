<?php
include('valida_secao.php');
require_once('autoload.php');

if (isset($_POST['acao'])) $acao = $_POST['acao'];
else if (isset($_GET['acao'])) $acao = $_GET['acao'];
else $acao = '';

if ($acao == 'Insert') {

  $con = new Contribuicao;
  $id = Funcoes::ProximoId('contribuicao');
  $con->setId($id);
  $con->setInformacao($_POST['informacao']);
  $con->setFontes($_POST['fontes']);
  $tipo = new ContribuicaoTipo;
  $tipo->setId($_POST['tipo']);
  $con->setTipo($tipo);
  if (isset($_POST['obj'])) {
    $tipo_obj = $_POST['tipo_obj'];
    if ($tipo_obj == 'obra') {
      $obj = new Obra;
    } else if ($tipo_obj == 'artista') {
      $obj = new Artista;
    } else if ($tipo_obj == 'genero') {
      $obj = new Genero;
    } else if ($tipo_obj == 'lingarte') {
      $obj = new LingArte;
    }
    $obj->setId($_POST['obj']);
    $con->setObj($obj);
  }

  ContribuicaoDao::Insert($con, $_SESSION['usuario_id']);
  header("location:contribuicao.php?id=" . $id);
} else if ($acao == 'UpdateAval') {
  $con = new Contribuicao;
  $con->setId($_POST['id']);
  $con->setComentario($_POST['comentario']);
  $est = new ContribuicaoEstado;
  $est->setId($_POST['estado']);
  $con->setEstado($est);
  $adm = new Usuario;
  $adm->setId($_POST['adm_id']);
  $adm->setContribuicaoAval($con);
  ContribuicaoDao::UpdateAval($adm);
  header("location:contribuicao.php?id=" . $_POST['id']);
} else if ($acao == 'Delete') {

  ContribuicaoDao::Delete($_GET['id']);
  header("location:index.php");
}
