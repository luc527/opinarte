<?php

require_once('autoload.php');
include('valida_secao.php');

date_default_timezone_set('America/Sao_Paulo');

if (isset($_POST['acao'])) $acao = $_POST['acao'];
else if (isset($_GET['acao'])) $acao = $_GET['acao'];
else $acao = '';

if ($acao == 'Cadastrar') {
  $usuario_id = $_SESSION['usuario_id'];
  $componente_id = $_POST['componente_id'];
  $componente_nome = $_POST['componente'];

  $componente = [
    'componente' => $componente_nome,
    'componente_id' => $componente_id
  ];

  $comentario = new Comentario;
  $comentario->setTexto(htmlspecialchars($_POST['texto']));
  $comentario->setData_hora(date("Y-m-d H:i:s"));

  ComentarioDao::InsertComentario($comentario, $usuario_id, $componente);
  $componente['componente'] == 'usuario' ?
    header("location:perfil.php?id={$componente_id}")
    : header("location:{$componente['componente']}.php?id={$componente_id}");
} else if ($acao == 'Like') {

  $comentario_id = $_GET['id'];
  $componente = $_GET['componente'];
  $componente_id = $_GET['componente_id']; // para redirecionamento

  ComentarioDao::AddLike($comentario_id, $componente);

  $componente == 'usuario' ?
    header("location:perfil.php?id={$componente_id}")
    : header("location:{$componente}.php?id={$componente_id}");
}
