<?php
include 'valida_secao.php';

require_once("autoload.php");

if (isset($_POST['acao'])) $acao = $_POST['acao'];
else if (isset($_GET['acao'])) $acao = $_GET['acao'];
else $acao = '';

if ($acao == 'Insert' || $acao == 'Update') {
	$lingArte_id = $_POST['lingArte'];
	$nome = $_POST['nome'];
	$descricao = $_POST['descricao'];
	
	$lingArte = new LingArte;
	$lingArte->setId($lingArte_id);

	if ($acao == 'Insert') $id = Funcoes::ProximoId('genero');
	else $id = $_POST['id'];

	$genero = new Genero;
	$genero->setId($id);
	$genero->setNome($nome);
	$genero->setDescricao($descricao);

	$lingArte->setGenero($genero);

	if ($acao == 'Insert') LingArteDao::InsertGeneros($lingArte);
	else LingArteDao::UpdateGeneros($lingArte);

	header("location:genero.php?id=".$id);
}  else if ($acao == 'Delete') {
	$id = $_POST['id'];
	GeneroDao::Delete($id);

	header("location:genero_list.php");
}
