<!DOCTYPE html>

<?php

require_once('autoload.php');
include 'valida_secao.php';

if (isset($_POST['id'])) $id = $_POST['id'];
else if (isset($_GET['id'])) $id = $_GET['id'];

$title = "Gênero";
if (isset($id)) {
	$genero = GeneroDao::SelectPorId($id);
	$nome = $genero->getNome();
	$descricao = $genero->getDescricao();
	$title .= " - " . $nome;

	$lingArte = LingArteDao::SelectPorGenero($genero);
	$artistas = ArtistaDao::SelectPorGenero($genero);
	$obras = ObraDao::SelectPorGenero($genero);
}

?>

<html>

<head>
	<title><?php echo $title; ?></title>
	<meta charset="utf-8">

	<!-- Materialize -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
	<link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
	<!-- Custom CSS -->
	<link type="text/css" rel="stylesheet" href="css/custom.css" />
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

</head>

<body class="light-green lighten-5">
	<header>
		<?php Funcoes::PrintHeader('index'); ?>
	</header>

	<main>
		<div class="container">
			<?php if ($_SESSION['usuario_tipo'] == 1) : ?>
				<a href="genero_cad.php?id=<?php echo $id; ?>" class="btn-flat teal-text waves-effect">
					<i class="material-icons left">edit</i>
					Editar
				</a>
			<?php endif; ?>
			<?php Funcoes::BotaoContribuir($id, 'genero'); ?>
			<div class="card-panel hoverable">
				<?php
				if (!isset($id)) {
					echo "<div class='card-panel'>Não foi recebido o ID do gênero. <code>genero.php?id=0</code></div>";
				} else { ?>
					<div class="row">
						<div class="col s12">
							<center>
								<h3 class='light-green-text text-darken-2'><b><?php echo $nome; ?></b></h3>
							</center>
						</div>
					</div>

					<div class="row">
						<div class="col s12 l4">
							<ul class="collection">

								<li class="collection-item">
									<i class="lime-text text-darken-4">Linguagem: </i>
									<b class="lime-text text-darken-2"><?php echo $lingArte->getNome(); ?></b>
									<a class="secondary-content" href="lingArte.php?id=<?php echo $lingArte->getId(); ?>"> <i class="material-icons">send</i></a>
								</li>
							</ul>
						</div>

						<div class="col s12 l8">
							<p align="justify" class="light-green-text text-darken-4"> <?php echo $descricao; ?> </p>
						</div>
					</div>

					<div class="row">
						<div class="col s12">
							<ul class="tabs">
								<li class="tab col s5"> <a href="#artistas" class="active">Artistas</a> </li>
								<li class="tab col s4"> <a href="#obras">Obras</a> </li>
								<li class="tab col s3"> <a href="#relacoes">Relações</a> </li>
							</ul>
						</div>

						<div id="artistas" class="row">
							<?php for ($i = 0; $i < count($artistas); $i++) { ?>
								<div class="col s12 m6 l4">
									<div class="card medium cyan darken-2 white-text">
										<?php if ($artistas[$i]->getImagemUrl() != '') {
													echo "<div class='card-image'>
												<img class='activator' src='" . $artistas[$i]->getImagemUrl() . "'>
											</div>";
												} ?>

										<div class="card-content">
											<span class="card-title activator"><?php echo $artistas[$i]->getNome(); ?> <i class="material-icons right">more_vert</i> </span>
											<p class="truncate"><?php echo $artistas[$i]->getDescricao(); ?></p>
										</div>

										<div class="card-reveal black-text">
											<span class="card-title activator">
												<?php echo $artistas[$i]->getNome(); ?>
												<i class="material-icons right">close</i>
											</span>
											<p><?php echo $artistas[$i]->getDescricao(); ?></p>
										</div>

										<div class="card-action">
											<a href="artista.php?id=<?php echo $artistas[$i]->getId(); ?>">Ver artista<i class="material-icons left">send</i> </a>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>

						<div id="obras" class="row">
							<?php for ($i = 0; $i < count($obras); $i++) { ?>
								<div class="col s12 m6 l4">
									<div class="card medium blue darken-2 white-text">
										<?php if ($obras[$i]->getImagemUrl() != '') {
													echo "<div class='card-image'>
												<img class='activator' src='" . $obras[$i]->getImagemUrl() . "'>
											</div>";
												} ?>

										<div class="card-content">
											<span class="card-title activator"><?php echo $obras[$i]->getNome(); ?> <i class="material-icons">more_vert</i> </span>
											<p class="truncate"><?php echo $obras[$i]->getDescricao(); ?></p>
										</div>

										<div class="card-reveal black-text">
											<span class="card-title activator">
												<?php echo $obras[$i]->getNome(); ?>
												<i class="material-icons">close</i>
											</span>
											<p><?php echo $obras[$i]->getDescricao(); ?></p>
										</div>

										<div class="card-action">
											<a href="obra.php?id=<?php echo $obras[$i]->getId(); ?>">Ver obra<i class="material-icons left">send</i> </a>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>

						<div class="col s12" id="relacoes">
							<?php Funcoes::GerarRelacao($id, 'genero'); ?>
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