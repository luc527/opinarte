<?php
include('valida_secao.php');
require_once('autoload.php');

if (isset($_POST['acao'])) $acao = $_POST['acao'];
else if (isset($_GET['acao'])) $acao = $_GET['acao'];
else $acao = '';

echo $acao;

date_default_timezone_set('America/Sao_Paulo');

if ($acao == 'CriarMPT') {
	
	$titulo = $_POST['titulo'];
	$id = Funcoes::ProximoId('msgPrivadaThread');
	
	$mpt = new MPThread;
	$mpt->setId($id);
	$mpt->setTitulo($titulo);

	$usuarios = $_POST['usuarios'];
	$usuarios = explode(';', $usuarios);
	
	for ($i=0; $i < count($usuarios); $i++) { 

		$usuario_existe = UsuarioDao::Usuario_existe($usuarios[$i]);
		if (!$usuario_existe) { 
			header("location:mpt_cad.php?erro=usuario_inexistente");
		}

		// Substitui os nomes informados pelos objetos Usuario correspondentes
		$usuarios[$i] = UsuarioDao::Select('nome-exato', $usuarios[$i])[0];
		// se pesquisar por 'nome' e a pesquisa por 'luc', os resultados poderão ser luc, luc2, lucas etc.
		// Foi adicionado o caso nome-exato por isso

		$mpt->setUsuario($usuarios[$i]);
	}

	$autor = UsuarioDao::SelectPorId($_POST['autor']);
	$mpt->setUsuario($autor);

	MPThreadDao::Insert($mpt);
	header("location:mpt.php?id=".$id);

} else if ($acao == 'ResponderMPT') {

	// Informações do formulário
	$usuario = new Usuario;
	$usuario->setId($_POST['usuario_id']);	
	$dtHr = date("Y-m-d H:i:s");
	$texto = $_POST['texto'];
	$mpt_id = $_POST['mpt_id'];
	
	// Mensagem é instanciada e populada
	$mp = new MP;
	$mp->setUsuario($usuario);
	$mp->setData_hora($dtHr);
	$mp->setTexto($texto);

	// Mensagem é colocada na thread
	$mpt = new MPThread;
	$mpt->setId($mpt_id);
	$mpt->setMensagem($mp);

	MPThreadDao::InsertMensagens($mpt);
	header("location:mpt.php?id=".$mpt_id);

} else if ($acao == 'AddUsuarios') {

	$mpt_id = $_POST['mpt'];
	$mpt = MPThreadDao::SelectPorId($mpt_id);

	$usuarios = explode(';', $_POST['usuarios']);
	for ($i=0; $i < count($usuarios); $i++) { 
		$usuario_existe = UsuarioDao::Usuario_existe($usuarios[$i]);
		if (!$usuario_existe) {
			header("location:mpt.php?id=".$mpt_id."?erro=usuario_inexistente");
		}
		// Substitui os nomes informados pelos objetos Usuario correspondentes
		$usuarios[$i] = UsuarioDao::Select('nome-exato', $usuarios[$i])[0];

		$mpt->setUsuario($usuarios[$i]);
	}

	MPThreadDao::InsertUsuarios($mpt);
	header("location:mpt.php?id=".$mpt_id);

} else if ($acao == 'DeleteUsuario') {

	$mpt_id = $_GET['mpt'];
	$usuario_id = $_GET['id'];

	MPThreadDao::DeleteUsuario($mpt_id, $usuario_id);
	header("location:mpt.php?id=".$mpt_id);
}
?>