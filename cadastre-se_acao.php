<?php

require_once "autoload.php";

if (isset($_POST['acao'])) $acao = $_POST['acao'];
else if (isset($_GET['acao'])) $acao = $_GET['acao'];

if (isset($acao)) {
	if ($acao == "Inserir") {
		$em_uso = Funcoes::VerifNomeEmUso($_POST['nome']);

		if ($em_uso) {
			header("location:cadastre-se.php?erro=nome_em_uso");
		}
		else {
			$usuario = new Usuario;
			$usuario->setNome($_POST['nome']);
			$usuario->setSenha($_POST['senha']);
			$usuario->setData_nasc($_POST['data_nasc']);
			$usuario->setEmail($_POST['email']);
			$usuario->setSobre_mim($_POST['sobre_mim']);
			$usuario->setData_criaConta(date("Y-m-d"));

			UsuarioDao::Insert($usuario);

			header("location:entrar.php?success=cadastro_sucesso");
		}


	}
}


?>
