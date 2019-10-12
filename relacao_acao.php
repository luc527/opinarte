<?php
include('valida_secao.php');
require_once('autoload.php');

if (isset($_POST['acao'])) $acao = $_POST['acao'];
else if (isset($_GET['acao'])) $acao = $_GET['acao'];
else $acao = '';

if ($acao == 'Cadastrar') {	
	// Objetos da relação
  $objs = array();
  for ($i=1; $i <= 2; $i++) {
		if ($_POST["obj$i"] == "obra$i") {
			$objs[$i] = new Obra;
			$objs[$i]->setId( $_POST["obra$i"] );
		} else if ($_POST["obj$i"] == "artista$i") {
			$objs[$i] = new Artista;
			$objs[$i]->setId($_POST["artista$i"]);
		} else if ($_POST["obj$i"] == "genero$i") {
			$objs[$i] = new Genero;
			$objs[$i]->setId($_POST["genero$i"]);
		}
	}
  
  $id_relacao = Funcoes::ProximoId('relacao');
  $relacao = new Relacao;
  $relacao->setId( $id_relacao );
  $relacao->setDescricao( $_POST['descricao'] );
  $relacao->setFontes( $_POST['fontes'] );
  $relacao->setObj1( $objs[1] );
  $relacao->setObj2( $objs[2] );

  $usuario_id = $_SESSION['usuario_id'];
  RelacaoDao::Insert($relacao, $usuario_id);

	header("location:relacao.php?id=".$id_relacao);
	
} else if ($acao == 'Editar') {

	// Objetos da relação
	$objs = array();
	for ($i = 1; $i <= 2; $i++) {
		if ($_POST["obj$i"] == "obra$i") {
			$objs[$i] = new Obra;
			$objs[$i]->setId($_POST["obra$i"]);
		} else if ($_POST["obj$i"] == "artista$i") {
			$objs[$i] = new Artista;
			$objs[$i]->setId($_POST["artista$i"]);
		} else if ($_POST["obj$i"] == "genero$i") {
			$objs[$i] = new Genero;
			$objs[$i]->setId($_POST["genero$i"]);
		}
	}

	$id_relacao = $_POST['id_relacao'];
	$relacao = new Relacao;
	$relacao->setId($id_relacao);
	$relacao->setDescricao($_POST['descricao']);
	$relacao->setFontes($_POST['fontes']);
	$relacao->setObj1($objs[1]);
	$relacao->setObj2($objs[2]);
	RelacaoDao::Update($relacao);

	header("location:relacao.php?id=" . $id_relacao);
}
?>