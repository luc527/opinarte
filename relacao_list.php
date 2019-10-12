<!DOCTYPE html>
<?php
include('valida_secao.php');
require_once('autoload.php');
$title = 'Listagem de relações';

$acao = isset($_POST['acao']) ? $_POST['acao'] : 'SelectTodos';
$pesquisa = isset($_POST['pesquisa']) ? $_POST['pesquisa'] : '';
$criterio = isset($_POST['criterio']) ? $_POST['criterio'] : '';

if ($acao == 'SelectTodos') $criterio = 'todos';

if ($criterio != 'autor') {
	$relacoes = RelacaoDao::Select($criterio, $pesquisa);
} else {
	$autor = UsuarioDao::SelectPorNome($_POST['pesquisa']);
	$autor = UsuarioDao::SelectRelacoes($autor);
	$relacoes = $autor->getRelacoes();
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
		.link_underline:hover {
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
									<option value="descricao" <?php if ($criterio == 'descricao') echo 'selected'; ?>>Descrição
									</option>
									<option value="autor" <?php if ($criterio == 'autor') echo 'selected'; ?>>Autor
									</option>
								</select>
								<span class="helper-text">Critério</span>
							</div>
							<div class="col s12">
								<p class="blue-grey-text text-darken-2">Para ver relações de uma obra/artista/etc.
									em particular, vá para a aba "relações" na página dessa obra/artista/etc.</p>
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
							<?php foreach ($relacoes as $rel) :
								$autor = UsuarioDao::SelectPorRelacao($rel->getId());
								$obj[1] = $rel->getObj1();
								$obj[2] = $rel->getObj2();
								for ($i = 1; $i <= 2; $i++) {
									if ($obj[$i] instanceof Obra) {
										$cor[$i] = 'blue';
										$link[$i] = 'obra.php';
									} else if ($obj[$i] instanceof Artista) {
										$cor[$i] = 'cyan';
										$link[$i] = 'artista.php';
									} else if ($obj[$i] instanceof Genero) {
										$cor[$i] = 'light-green';
										$link[$i] = 'genero.php';
									} else if ($obj[$i] instanceof LingArte) {
										$cor[$i] = 'lime';
										$link[$i] = 'lingArte.php';
									}
								}
								?>
								<li class="collection-item">
									<span class="title">
										<?php for ($i = 1; $i <= 2; $i++) : ?>
											<a href="<?php echo $link[$i]; ?>?id=<?php echo $obj[$i]->getId(); ?>"
											class="link_underline">
												<b class="<?php echo $cor[$i]; ?>-text text-darken-2">
													<?php echo $obj[$i]->getNome(); ?>
												</b>
											</a>
											<?php if ($i == 1) echo " - "; ?>
										<?php endfor; ?>
									</span>

									<a href="relacao.php?id=<?php echo $rel->getId() ?>" class="secondary-content">
										<i class="material-icons">send</i>
									</a>

									<i class="truncate cyan-text text-darken-4">
										<?php echo $rel->getDescricao(); ?>
									</i>

									<b class="brown-text">Autor: </b>
									<a href="perfil.php?id=<?php echo $autor->getId(); ?>" class="brown-text text-darken-2 link_underline">
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