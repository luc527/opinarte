<!DOCTYPE html>
<?php

include 'valida_secao.php';
require_once 'autoload.php';

if (!isset($_GET['id'])) {
	die("<center><b>Não foi informado nenhum ID (<code>perfil_lista_Amigos.php?id=n</code>)</b></center>");
}

$title = 'Lista de amigos ';

$usuario = UsuarioDao::SelectPorId($_GET['id']);

$title .= "de {$usuario->getNome()}";

$usuario = UsuarioDao::SelectAmigos($usuario);
$amigos = $usuario->getAmigos();

$usuario = UsuarioDao::SelectPedidosFeitos($usuario);
$pedidos_feitos = $usuario->getPedidosAmizadeFeitos();

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
			<div class="card-panel hoverable">

				<div class="row card-panel">
					<div class="col s12">
						<h4><b class="blue-grey-text">Pedidos de amizade enviados</b></h4>
						<ul class="collection">
							<?php foreach($pedidos_feitos as $ped): ?>
								<?php
									$avatar = $ped->getImgPerfil() !== null ?
										"<img class='circle' src='{$ped->getImgPerfil()}' />"
										: "<i class='material-icons person brown circle'>person</i>";
								?>

								<li class="collection-item avatar">
									<?= $avatar; ?>

									<span class="title">
										<b class="brown-text">
											<?= $ped->getNome(); ?>
										</b>
									</span>

									<a href="perfil.php?id=<?= $ped->getId(); ?>" class="secondary-content">
										<i class="material-icons">send</i>
									</a>

									<i class="brown-text text-darken 2 truncate">
										<?= $ped->getSobre_mim(); ?>
									</i>

									<a class="btn red darken-2 waves-effect waves-light" style="margin-top: 1rem; margin-left: 1rem;"
									href="usuario_acao.php?acao=cancelarPedido&user_id=<?= $ped->getId(); ?>">
										<i class="material-icons left">close</i>
										Cancelar pedido
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>

				<div class="row">
					<div class="col s12 center-align">
						<h4><b class="green-text text-darken-2"><?= $title; ?></b></h4>
					</div>
				</div>

				<div class="row">
					<div class="col s12">
						<ul class="collection">

							<?php foreach ($amigos as $amigo) : ?>
								<?php
									$avatar = $amigo->getImgPerfil() !== null ?
										"<img class='circle' src='{$amigo->getImgPerfil()}' />"
										: "<i class='material-icons person brown circle'>person</i>";
								?>

								<li class="collection-item avatar">
									<?= $avatar; ?>

									<span class="title">
										<b class="brown-text">
											<?= $amigo->getNome(); ?>
										</b>
									</span>

									<a href="perfil.php?id=<?= $amigo->getId(); ?>" class="secondary-content">
										<i class="material-icons">send</i>
									</a>

									<i class="brown-text text-darken 2 truncate">
										<?= $amigo->getSobre_mim(); ?>
									</i>
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