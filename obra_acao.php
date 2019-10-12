<?php

include 'valida_secao.php';

require_once('autoload.php');

if (isset($_POST['acao'])) $acao = $_POST['acao'];
else if (isset($_GET['acao'])) $acao = $_GET['acao'];
else $acao = '';

echo $acao;


if ($acao == 'Insert' || $acao == 'Update') {
	$obra = new Obra;
	
	if ($acao == 'Insert') $id = Funcoes::ProximoId('obra');
	else $id = $_POST['id'];

	$obra->setId( $id );
	$obra->setNome( $_POST['nome'] );
	$obra->setDescricao( $_POST['descricao'] );
	$obra->setData_lancamento( $_POST['dtLancamento'] );
	$obra->setImagemUrl( $_POST['imagemUrl'] );

	if ($acao == 'Insert') ObraDao::Insert($obra);
	else ObraDao::Update($obra);

	if ($acao == 'Insert') {
		$artista = new Artista;
		$artista->setId( $_POST['artista_id'] );

		$artista->setObra($obra);

		ArtistaDao::InsertObras($artista);
	}

	header("location:obra_cad.php?id=".$id);
} else if ($acao == 'Delete') {

	ObraDao::Delete($_POST['id']);
	header("location:obra_list.php");

} else if ($acao == 'InsertGenero' || $acao == 'DeleteGenero') {
	if ($acao == 'InsertGenero') {
		$obra_id = $_POST['id'];
		$gen_id = $_POST['genero_id'];
	} else if ($acao == 'DeleteGenero') {
		$gen_id = $_GET['gen_id'];
		$obra_id = $_GET['obra_id'];
	}

	$obra = new Obra;
	$obra->setId($obra_id);

	$genero = new Genero;
	$genero->setId($gen_id);

	$obra->setGenero($genero);

	if ($acao == 'InsertGenero')
		ObraDao::InsertGeneros($obra);
	else if ($acao == 'DeleteGenero')
		ObraDao::DeleteGeneros($obra);

	header("location:obra_cad.php?id=".$obra_id);
}


?>