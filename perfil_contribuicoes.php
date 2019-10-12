<!DOCTYPE HTML>
<?php
include('valida_secao.php');
require_once('autoload.php');

if (!isset($_GET['id'])) header("location:index.php");
$id = $_GET['id'];

$usuario = UsuarioDao::SelectPorId($id);
$usuario = UsuarioDao::SelectContribuicoes($usuario);
$cons = $usuario->getContribuicoes();

$title = 'Contribuições';
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
</head>

<body class="brown lighten-5">
	<header><?php Funcoes::PrintHeader(); ?></header>

	<main>
		<div class="container">
			<a href="perfil.php?id=<?php echo $id; ?>" class="btn-flat teal-text waves-effect">
				<i class="material-icons left">keyboard_return</i>
				Voltar
			</a>

			<div class="card-panel hoverable">

				<div class="row">
					<div class="col s12 center-align">
						<h4><b class="brown-text"><?php echo $title; ?></b></h4>
					</div>
				</div>

				<div class="row">
					<div class="col s12">
						<ul class="collection">
							<?php foreach ($cons as $con) :
								if ($con->getObj() !== null) {
									$obj = $con->getObj();
									$classe_obj = get_class($obj);
									$link = $classe_obj . ".php";
									if ($obj instanceof Obra) $obj = ObraDao::SelectPorId($obj->getId());
									else if ($obj instanceof Artista) $obj = ArtistaDao::SelectPorId($obj->getId());
									else if ($obj instanceof Genero) $obj = GeneroDao::SelectPorId($obj->getId());
									else if ($obj instanceof LingArte) $obj = LingArteDao::SelectPorId($obj->getId());
								} ?>

								<li class="collection-item">
									<?php if ($con->getObj() !== null) : ?>
										<ul class="collection">
											<li class="collection-item">
												<span class="title">
													<b class="blue-grey-text text-darken-2">
														<?php echo $obj->getNome(); ?>
													</b>
													(<?php echo $classe_obj; ?>)
												</span>
												<a href="<?php echo $link; ?>?id=<?php echo $obj->getId(); ?>" class="secondary-content">
													<i class="material-icons">send</i>
												</a>
											</li>
										</ul>
									<?php endif; ?>

									<a href="contribuicao.php?id=<?php echo $con->getId() ?>" class="secondary-content">
										<i class="material-icons">send</i>
									</a>

									<p>
										<b class="blue-grey-text text-darken-2">Informação: </b>
										<i class="blue-grey-text text-darken-4">
											<?php echo $con->getInformacao(); ?>
										</i>
									</p>

									<p>
										<b class="blue-grey-text text-darken-2">Fontes: </b>
										<i class="blue-grey-text text-darken-4">
											<?php echo $con->getFontes(); ?>
										</i>
									</p>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>

			</div>

		</div>
	</main>

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