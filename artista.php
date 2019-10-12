<!DOCTYPE html>
<html>
<?php

include 'valida_secao.php';
require_once('autoload.php');

if (isset($_POST['id'])) $id = $_POST['id'];
else if (isset($_GET['id'])) $id = $_GET['id'];

$listas = ListaDao::SelectPorItem($id, 'artista');

?>

<head>
	<title>Artista</title>
	<meta charset="utf=8">

	<!-- Materialize -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
	<!-- Custom CSS -->
	<link type="text/css" rel="stylesheet" href="css/custom.css" />
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

</head>

<body class="cyan lighten-5">
	<header>
		<?php Funcoes::PrintHeader(); ?>
	</header>

	<main>
		<div class="container">
			<?php if ($_SESSION['usuario_tipo'] == 1) : ?>
				<a href="artista_cad.php?id=<?php echo $id; ?>" class="btn-flat teal-text waves-effect">
					<i class="material-icons left">edit</i>
					Editar
				</a>
			<?php endif; ?>
			<?php Funcoes::BotaoContribuir($id, 'artista'); ?>
			<div class="card-panel hoverable">
				<?php
				if (!isset($id)) {
					echo "<div class='card-panel'>Não foi recebido o ID do artista. <code> artista.php?id=0</code></div>";
				} else {

					$artista = ArtistaDao::SelectPorId($id);
					$artista = ArtistaDao::SelectGeneros($artista); // função que incrementa o objeto com os gêneros
					$artista = ArtistaDao::SelectObras($artista);

					$nome = $artista->getNome();
					$descricao = $artista->getDescricao();
					$imgUrl = $artista->getImagemUrl();
					$generos = $artista->getGeneros();
					$obras = $artista->getObras();
					?>

					<div class="row">
						<div class="col s12">
							<center>
								<h3 class="cyan-text text-darken-2">
									<b> <?php echo $nome ?> </b>
								</h3>
							</center>
						</div>
					</div>

					<div class="row">
						<div class="col s12 l4">
							<ul class="collection">
								<li> <img class='materialboxed' style='width:100%' src='<?php echo $imgUrl; ?>'> </li>
							</ul>

							<ul class="collection header">
								<li class="collection-item header">
									<h6><i class="light-green-text text-darken-4">Gêneros </i></h6>
								</li>
								<?php for ($i = 0; $i < count($generos); $i++) {
										echo "<li class='collection-item'>
										<b class='light-green-text text-darken-2'>" . $generos[$i]->getNome() . "</b>
										<a href='genero.php?id=" . $generos[$i]->getId() . "' class='secondary-content'> <i class='material-icons'>send</i> </a>
									</li>";
									} ?>
							</ul>
						</div>

						<div class="col s12 l8">
							<div class="row">
								<div class="col s12">
									<?php $favoritado = UsuarioDao::Artista_favoritado($id, $_SESSION['usuario_id']);
										if ($favoritado) {
											$cor = 'yellow-text text-darken-3';
											$tooltip = 'Remover dos favoritos';
											$acao = 'DeleteArtista_fav';
											$ico = 'star';
										} else {
											$cor = 'grey-text';
											$tooltip = 'Favoritar';
											$acao = 'InsertArtista_fav';
											$ico = 'star_border';
										} ?>
									<center> <a href="usuario_acao.php?acao=<?php echo $acao; ?>&art_id=<?php echo $id; ?>" class="tooltipped <?php echo $cor; ?>" data-position="bottom" data-tooltip="<?php echo $tooltip; ?>">
											<i class="small material-icons"><?php echo $ico; ?></i>
										</a> </center>
								</div>
							</div>

							<div class="row">
								<p align="justify" class="cyan-text text-darken-4"> <?php echo $descricao; ?> </p>
							</div>
						</div>
					</div>

					<div class="row">
						<ul class="tabs col s12">
							<li class="tab col s5"> <a href="#obras">Obras</a> </li>
							<li class="tab col s3"> <a href="#listas">Listas</a> </li>
							<li class="tab col s2"> <a href="#comentarios">Comentários</a> </li>
							<li class="tab col s2"> <a href="#relacoes">Relações</a> </li>
						</ul>

						<div class="" id="obras">
							<div class="row">
								<?php for ($i = 0; $i < count($obras); $i++) { ?>
									<div class='col s12 m6 l4'>
										<div class='card medium blue darken-2 white-text'>
											<?php if ($obras[$i]->getImagemUrl() != '') {
														echo "<div class='card-image'>";
														echo "<img class='activator' src='" . $obras[$i]->getImagemUrl() . "'>";
														echo "</div>";
													} ?>
											<div class="card-content">
												<span class="card-title activator">
													<?php echo $obras[$i]->getNome(); ?>
													<i class="material-icons right">more_vert</i>
												</span>
												<p class="truncate"> <?php echo $obras[$i]->getDescricao(); ?> </p>
											</div>

											<div class="card-reveal black-text">
												<span class="card-title activator">
													<?php echo $obras[$i]->getNome(); ?>
													<i class="material-icons right">close</i>
												</span>
												<p> <?php echo $obras[$i]->getDescricao(); ?> </p>
											</div>

											<div class="card-action">
												<a href="obra.php?id=<?php echo $obras[$i]->getId(); ?>"> <i class="material-icons left">send</i> Ver obra </a>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>

						<div class="" id="listas">
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

						<div class="" id="comentarios">
							<?php Funcoes::GerarComentariosHTML('artista', $id); ?>
						</div>

						<div class="col s12" id="relacoes">
							<?php Funcoes::GerarRelacao($id, 'artista'); ?>
						</div>
					</div>

				<?php } ?>
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