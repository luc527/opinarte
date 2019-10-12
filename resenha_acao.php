<?php require_once('autoload.php');
include('valida_secao.php');

date_default_timezone_set('America/Sao_Paulo');

if (isset($_POST['acao'])) $acao = $_POST['acao'];
else if (isset($_GET['acao'])) $acao = $_GET['acao'];
else $acao = '';

if ($acao == 'Insert') {
	$obra = new Obra;
	$obra->setId($_POST['obra_id']);

	$resenha = new Resenha;
	$resenha->setObra($obra);
	$resenha->setTexto($_POST['texto']);
	$resenha->setDataHora(date('Y-m-d H:i:s'));

	$usuario = new Usuario;
	$usuario->setId($_SESSION['usuario_id']);
	$usuario->setResenha($resenha);

	ResenhaDao::InsertResenhas($usuario);

	header("location:obra.php?id=".$obra->getId());
} else if ($acao == 'Update') {
	$resenha = new Resenha;
	$resenha->setId($_POST['res_id']);
	$resenha->setTexto($_POST['texto']);
	$resenha->setDataHora(date('Y-m-d H:i:s'));

	ResenhaDao::UpdateResenha($resenha);

	header("location:resenha.php?id=".$resenha->getId());
} else if ($acao == 'Delete') {
	ResenhaDao::DeleteResenha($_POST['res_id']);
	header("location:perfil.php?id=".$_SESSION['usuario_id']);
}
?>
