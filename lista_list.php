<!DOCTYPE html>
<?php
include('valida_secao.php');
require_once('autoload.php');
$title = 'Listagem de listas';

$acao = isset($_POST['acao']) ? $_POST['acao'] : 'SelectTodos';
$pesquisa = isset($_POST['pesquisa']) ? $_POST['pesquisa'] : '';
$criterio = isset($_POST['criterio']) ? $_POST['criterio'] : '';

if ($acao == 'SelectTodos') $criterio = 'todos';

if ($criterio != 'autor') {
	$listas = ListaDao::Select($criterio, $pesquisa);
} else {
	$autor = UsuarioDao::SelectPorNome($_POST['pesquisa']);
	$autor = UsuarioDao::SelectListas($autor);
	$listas = $autor->listas();
}
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

	<style>
		.link_autor:hover {
			text-decoration: underline;
		}
	</style>
</head>

<body class="blue-grey lighten-5">
	<header><?php Funcoes::PrintHeader(); ?></header>

	<main>
		<div class="container">
			<div class="card-panel hoverable">

				<div class="row">
					<div class="col s12 center-align">
						<h4><b class="blue-grey-text">
								<?php echo $title; ?>
							</b></h4>
					</div>
				</div>

				<div class="row">
					<form class="col s12" action="" method="post">

						<div class="row">
							<div class="input-field col s12">
								<i class="material-icons prefix">search</i>
								<input type="text" name="pesquisa" id="pesquisa" value="<?php echo $pesquisa; ?>" />
								<label for="pesquisa">Pesquisa</label>
							</div>
						</div>

						<div class="row">
							<div class="input-field col s12">
								<select name="criterio" id="criterio">
									<option value="nome" <?php if ($criterio == 'nome') echo 'selected'; ?>>Nome
									</option>
									<option value="descricao" <?php if ($criterio == 'descricao') echo 'selected'; ?>>Descrição
									</option>
									<option value="autor" <?php if ($criterio == 'autor') echo 'selected'; ?>>Autor
									</option>
								</select>
								<span class="helper-text">Critério</span>
							</div>
							<div class="col s12">
								<p class="blue-grey-text text-darken-2">Para ver listas em que uma obra/artista/etc.
									em particular é um item, vá para a aba "Listas" dessa obra/artista/etc.</p>
							</div>
						</div>

						<div class="row">
							<div class="input-field col s12 m6 center-align">
								<button type="submit" name="acao" id="acao" value="Select" class="blue darken-3 btn waves-effect waves-light">
									<i class="material-icons left">search</i>
									Pesquisar
								</button>
							</div>
							<div class="input-field col s12 m6 center-align">
								<button type="submit" name="acao" id="acao" value="SelectTodos" class="yellow darken-3 btn waves-effect waves-light">
									<i class="material-icons left">search</i>
									Pesquisar todos
								</button>
							</div>
						</div>

					</form>
				</div>

				<div class="divider"></div>

				<div class="row">
					<div class="col s12">
						<ul class="collection">
							<?php foreach ($listas as $lista) :
								$autor = UsuarioDao::SelectPorLista($lista->getId()); ?>
								<li class="collection-item">
									<span class="title"><b class="purple-text text-darken-2">
											<?php echo $lista->getNome(); ?>
										</b></span>

									<a href="lista.php?id=<?php echo $lista->getId() ?>" class="secondary-content">
										<i class="material-icons">send</i>
									</a>

									<i class="truncate purple-text text-darken-4">
										<?php echo $lista->getDescricao(); ?>
									</i>

									<b class="brown-text">Autor: </b>
									<a href="perfil.php?id=<?php echo $autor->getId(); ?>" class="brown-text text-darken-2 link_autor">
										<?php echo $autor->getNome(); ?>
									</a>
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