<?php

require_once('autoload.php');

if (isset($_POST['acao'])) $acao = $_POST['acao'];
else if (isset($_GET['acao'])) $acao = $_GET['acao'];
else $acao = '';

//var_dump($acao);

if ($acao == 'Insert') {
	$id = Funcoes::ProximoId('artista');
	$nome = $_POST['nome'];
	$descricao = $_POST['descricao'];
	$imgUrl = $_POST['imgUrl'];

	$artista = new Artista;
	$artista->setId($id);
	$artista->setNome($nome);
	$artista->setDescricao($descricao);
	$artista->setImagemUrl($imgUrl);

	ArtistaDao::Insert($artista);

	header("location:artista_cad.php?id=".$id);
} else if ($acao == 'Update') {
	$id = $_POST['id'];
	$nome = $_POST['nome'];
	$descricao = $_POST['descricao'];
	$imgUrl = $_POST['imagemUrl'];

	$artista = new Artista;
	$artista->setId($id);
	$artista->setNome($nome);
	$artista->setDescricao($descricao);
	$artista->setImagemUrl($imgUrl);

	ArtistaDao::Update($artista);

	header("location:artista_cad.php?id=".$id);
} else if ($acao == 'Delete') {
	ArtistaDao::Delete($_POST['id']);
	header("location:artista_list.php");
}

else if ($acao == 'InsertGenero' || $acao == 'DeleteGenero') {
	if ($acao == 'InsertGenero') {	
		$art_id = $_POST['id'];
		$gen_id = $_POST['genero_id'];
	} else if ($acao == 'DeleteGenero') {
		$art_id = $_GET['art_id'];
		$gen_id = $_GET['gen_id'];
	}

	$artista = new Artista;
	$artista->setId($art_id);

	$genero = new Genero;
	$genero->setId($gen_id);

	$artista->setGenero($genero);

	if ($acao == 'InsertGenero')
		ArtistaDao::InsertGeneros($artista);
	else if ($acao == 'DeleteGenero')
		ArtistaDao::DeleteGeneros($artista);

	header("location:artista_cad.php?id=".$art_id);
}

else if ($acao == 'InsertObra' || $acao == 'DeleteObra') {
	if ($acao == 'InsertObra') {
		$art_id = $_POST['id'];
		$obra_id = $_POST['obra_id'];
	} else if ($acao == 'DeleteObra') {
		$art_id = $_GET['art_id'];
		$obra_id = $_GET['obra_id'];
	}

	$artista = new Artista;
	$artista->setId($art_id);

	$obra = new Obra;
	$obra->setId($obra_id);

	$artista->setObra($obra);

	if ($acao == 'InsertObra')
		ArtistaDao::InsertObras($artista);
	else if ($acao == 'DeleteObra')
		ArtistaDao::DeleteObras($artista);

	header("location:artista_cad.php?id=".$art_id);
}
?>