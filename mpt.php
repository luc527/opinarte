<!DOCTYPE html>
<?php
require_once('autoload.php');
include('valida_secao.php');

// Recebe ID da MP por get. Se não há id, redireciona o usuário para o perfil
if (isset($_GET['id']))
	$id = $_GET['id'];
else
	header("location:perfil.php?id=".$_SESSION['usuario_id']);

// Verifica se o usuário acessando a MP Thread faz parte dela. Se não, redireciona-o
$usuario_na_mp = MPThreadDao::Usuario_na_MPT($_SESSION['usuario_id'], $id);
if (!$usuario_na_mp)
	header("location:perfil.php?id=".$_SESSION['usuario_id']);

$title = 'Mensagem privada';

$mpt = MPThreadDao::SelectPorId($id);
$mpt = MPThreadDao::SelectUsuarios($mpt);
$mpt = MPThreadDao::SelectMensagens($mpt);

$usuarios = $mpt->usuarios();
$msgs = $mpt->mensagens();

?>
<html>

<head>
	<title><?php echo $title; ?></title>
  <meta charset="utf-8">
  <!-- Materialize -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
  <!-- Custom CSS -->
  <link type="text/css" rel="stylesheet" href="css/custom.css" />
  <!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<style type="text/css">
		a.link_underline:hover { text-decoration: underline; }
	</style>
</head>

<body class="orange lighten-5">
	<header><?php Funcoes::PrintHeader(); ?></header>
	<main>
		<div class="container">
			<div class="card-panel hoverable">

				<!-- Título da página -->
				<div class="row">
					<div class="col s12 center-align">
						<h4><b class="orange-text text-darken-3">
							<?php echo $title; ?>
						</b></h4>
					</div>
				</div>

				<!-- Informações sobre a thread -->
				<div class="row">
					<div class="col s12">
						<ul class="collection">

							<!-- Título -->
							<li class="collection-item">
								<h5><b class="orange-text text-darken-3"><?=$mpt->titulo();?></b></h5>
							</li>

							<!-- Lista de usuários -->
							<li class="collection-item">
								<b class="brown-text text-darken">Usuários: </b>
								<?php for($i=0; $i < count($usuarios); $i++): ?>
									<a href="perfil.php?id=<?=$usuarios[$i]->getId(); ?>" class="link_underline brown-text text-darken-2">
										<?=$usuarios[$i]->getNome();?>
									</a>
									<?php if ($i != count($usuarios)-1):
										echo(', ');
									endif; ?>
								<?php endfor; ?>
								<a href="#modalGerUsuarios" class="secondary-content modal-trigger">
									<i class="material-icons">edit</i>
								</a>
							</li>

							<!-- Modal de gerenciamento de usuários -->
							<div id="modalGerUsuarios" class="modal">
								<div class="modal-content">
									<div class="row">
										<div class="col s12">
											
											<!-- Lista de usuários + botão de remover -->
											<ul class="collection">
												<?php foreach($usuarios as $usuario): ?>
													<li class="collection-item">
														<a href="perfil.php?id=<?=$usuario->getId()?>"
														class="brown-text link_underline">
															<?=$usuario->getNome()?>
														</a>
														<a href="mpt_acao.php?acao=DeleteUsuario&mpt=<?=$id?>&id=<?=$usuario->getId()?>"
														class="secondary-content">
															<i class="material-icons red-text text-darken-2 tooltipped"
															data-tooltip="Remover da thread" data-position="left">
																delete
															</i>
														</a>
													</li>
												<?php endforeach; ?>
											</ul>

											<div class="divider" style="margin: 2.5rem 0 2rem 0;"></div>

											<h4><b class="brown-text">Adicionar usuários</b></h4>

											<form action="mpt_acao.php" method="POST" class="row">												
												<!-- Input oculto (thread) -->
												<input type="hidden" name="mpt" id="mpt" value="<?=$id?>">
												
												<!-- Input a ser separado ("user1; user2; user3" -> ["user1", "user2", "user3"]) -->
												<div class="input-field col s12">
													<i class="material-icons prefix">person</i>
													<label for="usuarios">Usuários (separar por ";" - exemplo: user1; user2; john33; dbqp)</label>
													<input type="text" name="usuarios" id="usuarios">
												</div>
												
												<!-- Botão submit -->
												<div class="input-field col s12">
													<button type="submit" name="acao" id="acao" value="AddUsuarios"
													class="btn brown darken-2 waves-effect waves-light">
														<i class="material-icons left">add</i>
														Adicionar
													</button>
												</div>
											</form>

										</div>
									</div>
								</div>
							</div>

							<!-- Número de mensagens -->
							<li class="collection-item">
								<b class="blue-grey-text">Nº de mensagens: </b>
								<i class="blue-grey-text text-darken-2">
									<?=count($msgs); ?>
								</i>
							</li>

							<!-- Tempo desde a última mensagem -->
							<?php if (count($msgs)>0): ?>
								<li class="collection-item">
									<b class="blue-grey-text">Última mensagem: </b>
									<i class="blue-grey-text text-darken-2">
										Há <?=$mpt->tempoDesdeUltimaMsg();?>
									</i>
								</li>
							<?php endif; ?>
						</ul>

					</div>
				</div>


				
				<!-- Botão para abrir o formulário (em modal) de resposta -->
				<div class="fixed-action-btn">
					<a href="#modalResposta"
					class="btn-floating btn-large orange darken-2 waves-effect waves-light modal-trigger">
						<i class="large material-icons">reply</i>
					</a>
				</div>
				
				<!-- Formulário para responder à thread -->
				<div id="modalResposta" class="modal">
					<div class="modal-content">

						<form action="mpt_acao.php" method="POST" class="row">
							<!-- Inputs ocultos (usuário e mpt_id) -->
							<input type="hidden" name="usuario_id" id="usuario_id" value="<?=$_SESSION['usuario_id']?>">
							<input type="hidden" name="mpt_id" id="mpt_id" value="<?=$id?>">
						
							<!-- Textarea para a resposta -->
							<div class="input-field col s12">
								<i class="material-icons prefix">mode_comment</i>
								<label for="texto">Resposta à thread</label>
								<textarea name="texto" class="materialize-textarea"></textarea>
							</div>

							<!-- Botão -->
							<div class="input-field col s12 right-align">
								<button class="btn orange darken-2 waves-effect waves-light"
								type="submit" name="acao" id="acao" value="ResponderMPT">
									<i class="material-icons left">send</i>
									Enviar
								</button>
							</div>

						</form>
					</div>
				</div>
				
				

				<!-- Mensagens da thread -->
				<div class="row">
					<div class="col s12">

						<ul class="collection">
							<?php foreach($msgs as $msg):
								$us = $msg->usuario(); ?>
								<li class="collection-item avatar">
									
									<?php // Determina o avatar do usuário
										if ($us->getImgPerfil() !== null) {
											echo "<img src='".$us->getImgPerfil()."' class=' circle'/>";
										} else {
											echo "<i class='material-icons circle brown'>person</i>";
										}
									?>

									<!-- Cabeçalho da mensagem -->
									<div class="row">

										<!-- Nome do usuário com link para perfil -->
										<div class="col s8">
											<b class="brown-text">
												<a href="perfil.php?id=<?=$us->getId()?>" class="brown-text link_underline">
													<?=$us->getNome()?>
												</a>
											</b>
										</div>

										<!-- Data da mensagem -->
										<div class="col s4 right-align">
											<i class="grey-text">
												<?=date("d/m/Y H:i:s", strtotime($msg->data_hora()));?>
											</i>
										</div>
									</div>

									<!-- Texto da mensagem -->
									<div class="row">
										<div class="col s12">											
											<p><?=$msg->texto()?></p>												
										</div>
									</div>
								
								</li>
							<?php endforeach; ?>
						</ul>

					</div>
				</div>


			</div>
		</div>
	</main>
	<footer><?php Funcoes::PrintFooter(); ?></footer>
	<footer><?php Funcoes::PrintFooter(); ?></footer>
  <!-- Scripts -->
  <script type="text/javascript" src="js/jquery-3.4.1.js"></script> <!-- OBS: jQuery deve estar sempre acima -->
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <!-- Materialize auto init -->
  <script type="text/javascript">
    M.AutoInit();
  </script>
</body>

</html>