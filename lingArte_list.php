<!DOCTYPE html>

<?php
include 'valida_secao.php';

require_once('autoload.php');

$acao = isset($_POST['acao']) ? $_POST['acao'] : 'SelectTodos';
$criterio = isset($_POST['criterio']) ? $_POST['criterio'] : 'todos';
$pesquisa = isset($_POST['pesquisa']) ? $_POST['pesquisa'] : '';

if ($acao == 'Select') {
	$lingArtes = LingArteDao::Select($criterio, $pesquisa);
} else if ($acao == 'SelectTodos') {
	$lingArtes = LingArteDao::Select('todos', '');
}
?>

<html>
<head>
	<title>Listagem de linguagens</title>
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

	<header>
		<?php Funcoes::PrintHeader(); ?>
	</header>

	<main>
		<div class="container">
			<div class="card-panel hoverable">
				<form class="" action="" method="post">
					<div class="row">
						<div class="input-field col s12">
							<label for="pesquisa">Pesquisa</label> 
							<input type="text" name="pesquisa" id="pesquisa" value="<?php $pesquisa; ?>">
						</div>

						<div class="input-field col s12">
							<label for="criterio">Critério</label> <br/>
							<select name="criterio" id="criterio">
								<option value="id" <?php if($criterio=='id')echo('selected'); ?>>ID</option>
								<option value="nome" <?php if($criterio=='nome')echo('selected'); ?>>Nome</option>
								<option value="descricao" <?php if($criterio=='descricao')echo('selected'); ?>>Descrição</option>
							</select>
						</div>
					</div>

					<div class="row">
						<div class="input-field col s12 m6">
							<center> <button class="btn waves-effect waves-light blue darken-3" type="submit" name="acao" value="Select"><i class="material-icons left">search</i>Pesquisar</button> </center>
						</div>

						<div class="input-field col s12 m6">
							<center> <button class="btn waves-effect waves-light yellow darken-3" type="submit" name="acao" value="SelectTodos"><i class="material-icons left">search</i>Pesquisar todos</button> </center>
						</div>
					</div>
				</form>

				<ul class="collection">
					<?php
						for ($i=0; $i < count($lingArtes); $i++) { 
							echo "<li class='collection-item'>
								<code class='blue-grey-text'>#".$lingArtes[$i]->getId()."</code> <br/>
								<span class='title'><b class='lime-text text-darken-2'>".$lingArtes[$i]->getNome()."</b></span>";
								//echo "<a class='secondary-content' href='lingArte_cad.php?id=".$lingArtes[$i]->getId()."'><i class='material-icons'>edit</i></a>";
								echo "<a class='secondary-content' href='lingArte.php?id=".$lingArtes[$i]->getId()."'>
									<i class='material-icons'>send</i>
								</a>
								<i class=' truncate lime-text text-darken-4'>".$lingArtes[$i]->getDescricao()."</i>
							</li>";
						}
					?>
			</ul>
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
	<script type="text/javascript"> M.AutoInit(); </script>
</body>
</html>