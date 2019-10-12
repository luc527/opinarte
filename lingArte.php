<!DOCTYPE html>
<html>
<?php

include 'valida_secao.php';
require_once('autoload.php');

if (isset($_POST['id'])) $id = $_POST['id'];
else if (isset($_GET['id'])) $id = $_GET['id'];

?>

<head>
	<title>Linguagem</title>
	<meta charset="utf=8">

	<!-- Materialize -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
	<!-- Custom CSS -->
	<link type="text/css" rel="stylesheet" href="css/custom.css" />
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

</head>

<body class="lime lighten-5">
	<header>
		<?php Funcoes::PrintHeader(); ?>
	</header>

	<main>
		<div class="container">
			<?php if ($_SESSION['usuario_tipo'] == 1) : ?>
				<a href="lingArte_cad.php?id=<?php echo $id; ?>" class="btn-flat teal-text waves-effect">
					<i class="material-icons left">edit</i>
					Editar
				</a>
			<?php endif; ?>
			<?php Funcoes::BotaoContribuir($id, 'lingarte'); ?>
			<div class="card-panel hoverable">
				<?php
				if (!isset($id)) {
					echo "Não foi recebido o ID da linguagem. <code>lingArte.php?id=0</code>";
				} else {
					$lingArte = LingArteDao::SelectPorId($id);

					$nome = $lingArte->getNome();
					$descricao = $lingArte->getDescricao();

					?>

					<div class="row">
						<div class="col s12">
							<center>
								<h3 class="lime-text text-darken-2"><b><?php echo $nome ?></b></h3>
							</center>
						</div>
					</div>

					<div class="row">
						<div class="col s12">
							<p class="lime-text text-darken-4" align="justify"> <?php echo $descricao; ?> </p>
						</div>
					</div>


					<?php
						$lingArte = LingArteDao::SelectGeneros($lingArte);
						$generos = $lingArte->getGeneros();
						?>
					<div id="generos">
						<ul class="collection with-header">
							<li class="collection-header">
								<h5 class="light-green-text text-darken-1"><b>Gêneros</b></h5>
							</li>
							<?php
								for ($i = 0; $i < count($generos); $i++) {
									echo "<li class='light-green-text text-darken-3 collection-item'>
										<span class='title'><b>" . $generos[$i]->getNome() . "</b></span>
										<a class='secondary-content' href='genero.php?id=" . $generos[$i]->getId() . "'>
											<i class='material-icons'>send</i>
										</a>
										<i class='truncate'>" . $generos[$i]->getDescricao() . "</i>
									</li>";
								}
								?>
						</ul>
					</div>
			</div>
		<?php } ?>
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