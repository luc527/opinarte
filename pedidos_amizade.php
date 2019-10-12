<!DOCTYPE html>
<?php

include 'valida_secao.php';
require_once 'autoload.php';

$title = 'Pedidos de amizade';

$usuario = UsuarioDao::SelectPorId($_SESSION['usuario_id']);

$usuario = UsuarioDao::SelectPedidosAmizade($usuario);
$pedidos = $usuario->getPedidosAmizadeRecebidos();

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

				<h4 class="center-align"><b class="blue-text text-darken-2"><?= $title; ?></b></h4>

				<div class="row">
					<div class="col s12">

						<?php foreach ($pedidos as $pedido) : ?>

							<div class="card-panel col s12 m6 center-align" style="padding: 1.2rem;">
								<span class="title brown-text">
									<a href="perfil.php?id=<?= $pedido->getId(); ?>">
										<?= $pedido->getNome(); ?>
									</a>
									quer ser seu amigo.
								</span>

								<form action="usuario_acao.php" method="POST" class="row">
									<input type="hidden" name="user_id" value="<?= $pedido->getId() ?>">
									<div class="input-field col s6 center-align">
										<button name="acao" value="addAmigo" class="btn waves-effect waves-light green darken-2">Aceitar</button>
									</div>
									<div class="input-field col s6 center-align">
										<button name="acao" value="rejeitarPedido" class="btn waves-effect waves-light red darken-2">Rejeitar</button>
									</div>
								</form>
							</div>

						<?php endforeach; ?>

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