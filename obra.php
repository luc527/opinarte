<!DOCTYPE html>
<html>
<?php

include 'valida_secao.php';
require_once('autoload.php');

if (isset($_POST['id'])) $id = $_POST['id'];
else if (isset($_GET['id'])) $id = $_GET['id'];

$usuario = new Usuario;
$usuario->setId($_SESSION['usuario_id']);

$title = 'Obra';
if (isset($id)) {
	$obra = ObraDao::SelectPorId($id);
	$nome = $obra->getNome();
	$descricao = $obra->getDescricao();
	$dtLanc = $obra->getData_lancamento();
	$imgUrl = $obra->getImagemUrl();

	$obra = ObraDao::SelectNotaMedia($obra);

	$obra = ObraDao::SelectGeneros($obra);
	$generos = $obra->getGeneros();

	$artistas = ArtistaDao::SelectPorObra($obra);

	$title .= " - " . $nome;
}

$listas = ListaDao::SelectPorItem($id, 'obra');

?>

<head>
	<title><?php echo $title; ?></title>
	<meta charset="utf=8">

	<!-- Materialize -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
	<!-- Custom CSS -->
	<link type="text/css" rel="stylesheet" href="css/custom.css" />
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

</head>

<body class="blue lighten-5">
	<header>
		<?php Funcoes::PrintHeader(); ?>
	</header>

	<main>
		<div class="container">
			<?php if ($_SESSION['usuario_tipo'] == 1) : ?>
				<a href="obra_cad.php?id=<?php echo $id; ?>" class="btn-flat teal-text waves-effect">
					<i class="material-icons left">edit</i>
					Editar
				</a>
			<?php endif; ?>
			<?php Funcoes::BotaoContribuir($id, 'obra'); ?>
			<div class="card-panel hoverable">


				<!--

					TÍTULO E INFORMAÇÕES (pseudo-sidenav) ################################

				-->


				<div class="row">
					<div class="col s12">
						<center>
							<h3 class="blue-text text-darken-2"><b> <?php echo $nome; ?> </b></h3>
						</center>
					</div>
				</div>

				<div class="row">
					<div class="col s12 l4">
						<ul class="collection">
							<li>
								<center>
									<img class='materialboxed' style='max-height:200px; max-width:100%' src='<?php echo $imgUrl; ?>'>
								</center>
							</li>
						</ul>

						<ul class="collection">
							<li class="collection-item">
								<i class="left blue-grey-text text-darken-2">Nota média: </i>
								<b style="font-size: 1.5em;" class="center blue-grey-text"><?= number_format($obra->getNotaMedia(), 1, ',', '.'); ?></b>
							</li>
						</ul>

						<ul class="collection with-header">
							<li class="collection-item header">
								<h6 class="light-green-text text-darken-4"> <i>Gêneros</i> </h6>
							</li>
							<?php for ($i = 0; $i < count($generos); $i++) {
								echo "<li class='collection-item'>
									<b class='light-green-text text-darken-2'>" . $generos[$i]->getNome() . "</b>
									<a href='genero.php?id=" . $generos[$i]->getId() . "' class='secondary-content'> <i class='material-icons'>send</i> </a>
								</li>";
							} ?>
						</ul>

						<ul class="collection with-header">
							<li class="collection-item header">
								<h6 class="cyan-text text-darken-4"> <i>Artista(s)</i> </h6>
							</li>
							<?php for ($i = 0; $i < count($artistas); $i++) {
								echo "<li class='collection-item'>
									<b class='cyan-text text-darken-2'>" . $artistas[$i]->getNome() . "</b>
									<a href='artista.php?id=" . $artistas[$i]->getId() . "' class='secondary-content'> <i class='material-icons'>send</i> </a>
								</li>";
							} ?>
						</ul>

						<ul class="collection">
							<li class="collection-item"> <i class="blue-grey-text text-darken-2">Data de lançamento:</i> <b class="blue-grey-text"><?php echo Funcoes::Data_BD_para_user($dtLanc); ?></b> </li>
						</ul>
					</div>


					<!--

						PAINEL DE RELAÇÕES DO USUÁRIO (fav, relaçao, nota, resenha) ########

					-->

					<div class="col s12 l8">
						<div class="row">



							<!--
								OBRA FAVORITA
							-->


							<div class="col s2">
								<?php $favoritada = UsuarioDao::Obra_favoritada($id, $_SESSION['usuario_id']);
								if ($favoritada) {
									$cor = 'yellow-text text-darken-3';
									$tooltip = 'Remover das favoritas';
									$acao = 'DeleteObra_fav';
									$ico = 'star';
								} else {
									$cor = 'grey-text';
									$tooltip = 'Favoritar';
									$acao = 'InsertObra_fav';
									$ico = 'star_border';
								} ?>
								<center> <a href="usuario_acao.php?acao=<?php echo $acao; ?>&obra_id=<?php echo $id; ?>" class="tooltipped <?php echo $cor; ?>" data-tooltip="<?php echo $tooltip; ?>">
										<i class="small material-icons"><?php echo $ico; ?></i>
									</a> </center>
							</div>



							<!--
								RELAÇÃO COM A OBRA
							-->


							<div class="col s4">
								<?php $relacao = UsuarioDao::SelectObrasRel_porObra($usuario->getId(), $id);

								if ($relacao != '') {
									if ($relacao == 'Desejo') $cor_rel = ' orange ';
									else if ($relacao == 'Atual') $cor_rel = 'green';
									else if ($relacao == 'Completa') $cor_rel = 'blue';
								} else $cor_rel = ' grey ';
								?>

								<center>
									<a href="#usuario-relacao" class="tooltipped modal-trigger btn <?php echo $cor_rel; ?>" data-tooltip="Sua relação com a obra">
										<i class="material-icons left">link</i>
										<i class="material-icons right">person</i>
									</a>
								</center>


								<div class="modal" id="usuario-relacao">
									<div class="modal-content">
										<CENTER>
											<div class="row">
												<div class="col s12">


													<a href="usuario_acao.php?acao=InsertRelacao&rel=Desejo&obra_id=<?php echo $id; ?>" class="btn orange tooltipped" data-tooltip="Você quer ler/ouvir/ver/etc. esta obra" data-position="top">
														<?php if ($relacao == 'Desejo') echo "<i class='material-icons left'>room</i>"; ?>
														Desejo
													</a>

													<a href="usuario_acao.php?acao=InsertRelacao&rel=Atual&obra_id=<?php echo $id; ?>" class="btn green tooltipped" data-tooltip="Você está lendo/ouvindo/vendo/etc. essa obra" data-position="bottom">
														<?php if ($relacao == 'Atual') echo "<i class='material-icons left'>room</i>"; ?>
														Atual
													</a>

													<a href="usuario_acao.php?acao=InsertRelacao&rel=Completa&obra_id=<?php echo $id; ?>" class="btn blue tooltipped" data-tooltip="Você já leu/ouviu/viu/etc. essa obra" data-position="top">
														<?php if ($relacao == 'Completa') echo "<i class='material-icons left'>room</i>"; ?>
														Completa
													</a>
												</div>
											</div>

											<div class="row">
												<div class="col s12">
													<a href="usuario_acao.php?acao=DeleteRelacao&obra_id=<?php echo $id; ?>" class="btn red">
														Remover
													</a>
												</div>
											</div>
										</CENTER>
									</div>

									<div class="modal-footer">
										<center> <a class="btn-flat modal-close">Voltar</a> </center>
									</div>
								</div>
							</div>



							<!--
								NOTA DA ORA
							-->


							<?php $nota = UsuarioDao::SelectNotaObra($usuario->getId(), $id);
							if (isset($nota)) {
								$cor = 'blue-grey-text text-darken-2';
							} else {
								$nota = 0;
								$cor = 'grey-text text-darken-1';
							} ?>
							<div class="col s2">
								<center>
									<a href="#nota" class="tooltipped modal-trigger btn-flat <?php echo $cor; ?>" data-tooltip="Sua nota para a obra">
										<b style='font-size: 1.5em'><?php echo $nota; ?></b>
									</a>
								</center>

								<div class="modal" id="nota">
									<div class="modal-content">
										<div class="container">
											<form action="usuario_acao.php" method="post">
												<div class="row">
													<input type="hidden" name="obra" value="<?php echo $id; ?>">
													<center>
														<h6><b class="blue-grey-text">Selecionar nota</b></h6>
													</center>
													<?php $cnt = 0;

													for ($i = 0; $i < 2; $i++) {
														echo "<div class='col s6'>";
														for ($j = 1; $j <= 5; $j++) {
															$n = $cnt + $j;
															echo "<p>
																<label>
																	<input type='radio' name='nota' value='$n'>
																	<span>$n</span>
																</label>
															</p>";
														}
														echo "</div>";
														$cnt = 5;
													}
													?>
												</div>
												<div class="row">
													<div class="col s12">
														<center> <button class="btn green darken-2" type="submit" name="acao" value="InsertNotaObra">Confirmar</button> </center>
													</div>
												</div>
												<div class="row">
													<div class="col s12">
														<center> <button class="btn red darken-2" type="submit" name="acao" value="DeleteNotaObra">Remover</button> </center>
													</div>
												</div>
											</form>
										</div>
									</div>

									<div class="modal-footer">
										<CENTER> <button class="btn-flat modal-close">Voltar</button> </CENTER>
									</div>
								</div>
							</div>


							<!--
								Resenha
							-->

							<div class="col s4">
								<a class="tooltipped btn waves-effect waves-light indigo" href="resenha_cad.php?obra_id=<?php echo $id; ?>" data-tooltip="Escreva uma resenha sobre essa obra">Resenha</a>
							</div>


						</div>
						<div class="row">
							<div class="col s12">
								<p align="justify" class="blue-text text-darken-4"> <?php echo $descricao; ?> </p>
							</div>
						</div>
					</div>
				</div>



				<!--

					TABS (VER CONTEÚDOS RELACIONADOS A OBRA)

				-->


				<div class="row">
					<div class="col s12">
						<ul class="tabs">
							<li class="tab col s6 m4"> <a href="#resenhas">Resenhas</a> </li>
							<li class="tab col s6 m3"> <a href="#listas">Listas</a> </li>
							<li class="tab col s6 m3"> <a href="#comentarios">Comentários</a> </li>
							<li class="tab col s6 m2"> <a href="#relacoes">Relações</a> </li>
						</ul>
					</div>


					<!--
						RESENHAS
					-->


					<div class="col s12" id="resenhas">
						<ul class="collection">
							<?php $usuarios = ResenhaDao::SelectPorObra($id);
							for ($i = 0; $i < count($usuarios); $i++) {
								$resenha = $usuarios[$i]->getResenhas()[0];

								$usuario = UsuarioDao::SelectPorId($usuarios[$i]->getId()); ?>

								<li class="collection-item avatar">
									<?php $imgPerfil = $usuario->getImgPerfil();
										if (isset($imgPerfil)) {
											echo "<img class='circle materialboxed' src='" . $usuario->getImgPerfil() . "'>";
										} else {
											echo "<i class='circle material-icons orange darken-2'>person</i>";
										} ?>
									<span class="title"><b class="indigo-text">Resenha de </b>
										<a class='tooltipped brown-text' data-tooltip="Ver perfil" href="perfil.php?id=<?php echo $usuario->getId(); ?>">
											<b><?php echo $usuario->getNome(); ?></b>
										</a>
										</b>

										<a class="secondary-content" href="resenha.php?id=<?php echo $resenha->getId(); ?>"><i class="material-icons">send</i></a>

										<p class='indigo-text text-darken-4'><?php echo $resenha->getTexto(); ?></p>
								</li>

							<?php }
							?>
						</ul>
					</div>


					<!--
						LISTAS
					-->


					<div class="col s12" id="listas">
						<ul class="collection">
							<?php foreach ($listas as $lista) : ?>
								<li class="collection-item">
									<span class="title"><b class="purple-text">
											<?php echo $lista->getNome(); ?>
										</b></span>

									<a href="lista.php?id=<?php echo $lista->getId(); ?>" class="secondary-content">
										<i class="material-icons">send</i>
									</a>

									<i class="truncate purple-text text-darken-2">
										<?php echo $lista->getDescricao(); ?>
									</i>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>


					<!--
						COMENTÁRIOS
					-->


					<div class="col s12" id="comentarios">
						<?php Funcoes::GerarComentariosHTML('obra', $id); ?>
					</div>


					<!--
						RELAÇÕES
					-->


					<div class="col s12" id="relacoes">
						<?php Funcoes::GerarRelacao($id, 'obra'); ?>
					</div>

				</div>

			</div>
		</div>
	</main>

	<footer>
		<?php Funcoes::PrintFooter(); ?>
	</footer>

	<!-- Scripts -->
	<script type="text/javascript" src="js/jquery-3.4.1.js"></script> <!-- OBS: jQuery deve estar sempre acima -->
	<script type="text/javascript" src="js/materialize.min.js"></script>
	<!-- Materialize auto init -->
	<script type="text/javascript">
		M.AutoInit();
	</script>
</body>


</html>