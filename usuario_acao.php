<?php

require_once('autoload.php');

include 'valida_secao.php';
$usuario_id = $_SESSION['usuario_id'];

if (isset($_POST['acao'])) $acao = $_POST['acao'];
else if (isset($_GET['acao'])) $acao = $_GET['acao'];
echo $acao;

$usuario = new Usuario;
$usuario->setId($usuario_id);

if ($acao == 'Update') {
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	$imgPerfil = isset($_POST['img_perfil']) ? $_POST['img_perfil'] : '';
	$email = isset($_POST['email']) ? $_POST['email'] : '';
	$data_nasc = isset($_POST['data_nasc']) ? $_POST['data_nasc'] : '';
	$sobre_mim = isset($_POST['sobre_mim']) ? $_POST['sobre_mim'] : '';

	$usuario = new Usuario;
	$usuario->setId($id);
	$usuario->setImgPerfil($imgPerfil);
	$usuario->setEmail($email);
	$usuario->setData_nasc($data_nasc);
	$usuario->setSobre_mim($sobre_mim);

	UsuarioDao::Update($usuario);

	header("location:perfil.php?id=$id");
} else if ($acao == 'InsertObra_fav' || $acao == 'DeleteObra_fav') {
	$obra_id = $_GET['obra_id'];
	$obra = new Obra;
	$obra->setId($obra_id);

	$usuario->setObra_fav($obra);

	if ($acao == 'InsertObra_fav')
		UsuarioDao::InsertObrasFav($usuario);
	else
		UsuarioDao::DeleteObrasFav($usuario);

	header("location:obra.php?id=" . $obra_id);
} else if ($acao == 'InsertArtista_fav' || $acao == 'DeleteArtista_fav') {
	$art_id = $_GET['art_id'];
	$artista = new Artista;
	$artista->setId($art_id);

	$usuario->setArtista_fav($artista);

	if ($acao == 'InsertArtista_fav')
		UsuarioDao::InsertArtistasFav($usuario);
	else
		UsuarioDao::DeleteArtistasFav($usuario);

	header("location:artista.php?id=" . $art_id);
} else if ($acao == 'InsertRelacao' || $acao == 'DeleteRelacao') {
	$obra = new Obra;
	$obra->setId($_GET['obra_id']);

	$obra_rel = new UsuarioRelObra;
	$obra_rel->setObra($obra);
	$obra_rel->setRelacao($_GET['rel']);

	$usuario->setObra_rel($obra_rel);

	if ($acao == 'InsertRelacao') {
		UsuarioDao::InsertObrasRel($usuario);
	} else {
		UsuarioDao::DeleteObrasRel($usuario);
	}

	header("location:obra.php?id=" . $_GET['obra_id']);
} else if ($acao == 'InsertNotaObra' || $acao == 'DeleteNotaObra') {
	$obra = new Obra;
	$obra->setId($_POST['obra']);

	$obra_nota = new UsuarioNotaObra;
	$obra_nota->setObra($obra);
	if ($acao == 'InsertNotaObra') {
		$obra_nota->setNota($_POST['nota']);
	}

	$usuario->setObra_nota($obra_nota);

	if ($acao == 'InsertNotaObra') {
		UsuarioDao::InsertObrasNota($usuario);
	} else {
		UsuarioDao::DeleteObrasNota($usuario);
	}

	header("location:obra.php?id=" . $obra->getId());
} else if ($acao == 'pedidoAmizade') {

	$pedido = new Usuario;
	$pedido->setId($_GET['user2_id']);
	$usuario->setPedidoAmizadeFeito($pedido);
	UsuarioDao::InsertPedidosAmizade($usuario);
	header("location:perfil.php?id={$_GET['user2_id']}");

} else if ($acao == 'rejeitarPedido') {

	UsuarioDao::DeletePedidoAmizade($usuario_id, $_POST['user_id']);
	header("location:pedidos_amizade.php");

} else if ($acao == 'cancelarPedido') {

	UsuarioDao::DeletePedidoAmizade($usuario_id, $_GET['user_id']);
	header("location:perfil_listaAmigos.php?id={$usuario_id}");

} else if ($acao == 'addAmigo') {

	$amigo = new Usuario;
	$amigo->setId($_POST['user_id']);
	$usuario->setAmigo($amigo);
	UsuarioDao::InsertAmigos($usuario);
	header("location:perfil.php?id={$_POST['user_id']}");

} else if ($acao == 'deleteAmigo') {

	UsuarioDao::DeleteAmizade($usuario_id, $_GET['user2_id']);
	header("location:perfil.php?id={$_GET['user2_id']}");

}
