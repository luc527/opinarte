<?php

date_default_timezone_set('America/Sao_Paulo');

require_once "autoload.php";

if (isset($_POST['acao'])) $acao = $_POST['acao'];
else if (isset($_GET['acao'])) $acao = $_GET['acao'];

if (isset($acao)) {
	if ($acao == "Login") {
		$usuario = new Usuario;
		$usuario->setNome($_POST['nome']);
		$usuario->setSenha($_POST['senha']);

		$login = UsuarioDao::Login($usuario);

		if ($login[0] == 'usuario_inexistente') {
			header("location:entrar.php?erro=usuario_inexistente");
		} else if ($login[0] == 'senha_incorreta') {
			header("location:entrar.php?erro=senha_incorreta");
		} else if ($login[0] == 'fazer_login') {
			session_start();
			$_SESSION['usuario_id'] = $login[1];
			$_SESSION['usuario_nome'] = $usuario->getNome();
			$_SESSION['usuario_tipo'] = $login[2];

			header("location:perfil.php?id={$_SESSION['usuario_id']}");
		}
	} else if ($acao == 'Logoff') {
		session_start();
		session_destroy();
		header("location:index.php");
	}
}
