<!DOCTYPE html>
<?php

include 'valida_secao.php';
require_once 'autoload.php';

$acao = isset($_POST['acao']) ? $_POST['acao'] : 'SelectTodos';
$pesquisa = isset($_POST['pesquisa']) ? $_POST['pesquisa'] : '';
$criterio = 'nome';

$title = 'Listagem de usuários';

$usuarios = $acao == 'SelectTodos'
	? UsuarioDao::Select('todos', '')
	: UsuarioDao::Select($criterio, $pesquisa);

?>
<html lang="en">
<head>
	<title><?= $title; ?></title>
	<meta charset="utf-8">

	<!-- Materialize -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
	<!-- Custom CSS -->
	<link type="text/css" rel="stylesheet" href="css/custom.css"/>
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body class="blue-grey lighten-5">
	<header><?php Funcoes::PrintHeader(); ?></header>

	<main>
		<div class="container">
			<div class="card-panel">
				
				<div class="row">
					<div class="col s12 center-align">
						<h4><b class="blue-grey-text"> <?= $title; ?> </b></h4>
					</div>
				</div>

				<form action="" method="POST">
					<div class="row">
						<div class="input-field col s12">
							<i class="material-icons prefix">search</i>
							<label for="pesquisa">Pesquisa</label>
							<input type="text" name="pesquisa" value="<?= $pesquisa; ?>">
						</div>
					</div>
					<div class="row">
						<div class="input field col s6 center-align">
							<button type="submit" name="acao" value="Select" class="btn blue waves-effect waves-light">
								<i class="material-icons left">search</i>
								Pesquisar
							</button>
						</div>
						<div class="input field col s6 center-align">
							<button type="submit" name="acao" value="SelectTodos" class="btn yellow darken-2 waves-effect waves-light">
								<i class="class material-icons left">search</i>
								Pesquisar todos
							</button>
						</div>
					</div>
				</form>

				<div class="row card-opanel">
					<div class="col s12">
						<ul class="collection">
							<?php foreach($usuarios as $user): ?>
								<?php
									$avatar = $user->getImgPerfil() !== null ?
										"<img class='circle' src='{$user->getImgPerfil()}'/>"
										: "<i class='brown material-icons circle'>person</i>";
								?>
								<li class="collection-item avatar">
									<?= $avatar; ?>
									<span class="title brown-text"><b> <?= $user->getNome(); ?> </b></span>
									<a href="perfil.php?id=<?= $user->getId(); ?>" class="secondary-content">
										<i class="material-icons">send</i>
									</a>
									<i class="truncate brown-text text-darken-2">
										<?= $user->getSobre_mim(); ?>
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
	<script type="text/javascript"> M.AutoInit(); </script>
</body>
</html>