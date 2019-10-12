<?php

// Página intermediária entre o formulário que o usuário insere e o objeto de acesso a dados (LingArteDao)
include 'valida_secao.php';

require_once "autoload.php";

if (isset($_POST['acao'])) $acao = $_POST['acao'];
else if (isset($_GET['acao'])) $acao = $_GET['acao'];

echo $acao;

if (isset($acao)) {
	if ($acao == 'Insert') {
		$lingArte = new LingArte;

		if (isset($_POST['nome'])) $nome = $_POST['nome'];
		if (isset($_POST['descricao'])) $descricao = $_POST['descricao'];
		$id = Funcoes::ProximoId('linguagensArt');

		$lingArte->setId($id);
		$lingArte->setNome($nome);
		$lingArte->setDescricao($descricao);

		/*echo $lingArte->getId()."<br/>";
		echo $lingArte->getNome()."<br/>";
		echo $lingArte->getDescricao()."<br/>";
		*/

		LingArteDao::Insert($lingArte);

		header("location:lingArte.php?id={$id}");
	} else if ($acao == 'Update') {
		$lingArte = new LingArte;

		if (isset($_POST['id'])) $id = $_POST['id'];
		if (isset($_POST['nome'])) $nome = $_POST['nome'];
		if (isset($_POST['descricao'])) $descricao = $_POST['descricao'];

		$lingArte->setId($id);
		$lingArte->setNome($nome);
		$lingArte->setDescricao($descricao);

		/*echo $lingArte->getId()."<br/>";
		echo $lingArte->getNome()."<br/>";
		echo $lingArte->getDescricao()."<br/>";
		*/

		LingArteDao::Update($lingArte);

		header("location:lingArte.php?id={$id}");
	} else if ($acao == 'Delete') {
		LingArteDao::Delete($_POST['id']);

		header("location:lingArte_list.php");
	}
}
