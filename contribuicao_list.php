<!DOCTYPE html>
<?php
include('valida_secao.php');
require_once('autoload.php');
$title = 'Listagem de contribuições';

$acao = isset($_POST['acao']) ? $_POST['acao'] : 'SelectTodos';
$pesquisa = isset($_POST['pesquisa']) ? $_POST['pesquisa'] : '';
$criterio = isset($_POST['criterio']) ? $_POST['criterio'] : '';

if ($acao == 'SelectTodos') $criterio = 'todos';

if ($criterio == 'informacao' || $criterio == 'fontes' || $criterio == 'todos') {
	$cons = ContribuicaoDao::Select($criterio, $pesquisa);
} else if ($criterio == 'autor') {
	$autor = UsuarioDao::SelectPorNome($_POST['pesquisa']);
	$autor = UsuarioDao::SelectContribuicoes($autor);
	$cons = $autor->getContribuicoes();
} else {
	$cons0 = array();
	if ($criterio == 'obra_id') {
		$objs = ObraDao::Select('nome', $pesquisa);
	} else if ($criterio == 'artista_id') {
		$objs = ArtistaDao::Select('nome', $pesquisa);
	} else if ($criterio == 'genero_id') {
		$objs = GeneroDao::Select('nome', $pesquisa);
	} else if ($criterio == 'linguagensart_id') {
		$objs = LingArteDao::Select('nome', $pesquisa);
	}
	foreach ($objs as $obj) {
		array_push($cons0, ContribuicaoDao::Select($criterio, $obj->getId()));
		// o resultado será um array de arrays
	}
	// esses loops criam um array unidimensional a partir do bidimensional anterior
	$cons = array();
	for ($i=0; $i < count($cons0); $i++) { 
		for ($j=0; $j < count($cons0[$i]); $j++) { 
			array_push($cons, $cons0[$i][$j]);
		}
	}
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
									<option value="informacao" <?php if ($criterio == 'informacao') echo 'selected'; ?>>Informação
									</option>
									<option value="fontes" <?php if ($criterio == 'fontes') echo 'selected'; ?>>Fontes
									</option>
									<option value="autor" <?php if ($criterio == 'autor') echo 'selected'; ?>>Autor
									</option>
									<option value="obra_id" <?php if ($criterio == 'obra_id') echo 'selected'; ?>>Obra
									</option>
									<option value="artista_id" <?php if ($criterio == 'artista_id') echo 'selected'; ?>>Artista
									</option>
									<option value="genero_id" <?php if ($criterio == 'genero_id') echo 'selected'; ?>>Gênero
									</option>
									<option value="linguagensart_id" <?php if ($criterio == 'linguagensart_id') echo 'selected'; ?>>Linguagem
									</option>
								</select>
								<span class="helper-text">Critério</span>
							</div>
							<div class="col s12">
								<p class="blue-grey-text text-darken-2">Para ver contribuições sobre obras/artistas/etc. específicos, vá para a aba "Contribuições" dessa obra/artista/etc.</p>
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

				<div class="divider" style="margin-bottom: 1rem;"></div>

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
								}

								$autor = UsuarioDao::SelectPorContribuicao($con->getId()); ?>
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