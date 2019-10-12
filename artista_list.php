<!DOCTYPE html>

<?php
include 'valida_secao.php';

require_once('autoload.php');

$usuario = new Usuario;
$usuario->setId($_SESSION['usuario_id']);

$acao = isset($_POST['acao']) ? $_POST['acao'] : 'SelectTodos';
$criterio = isset($_POST['criterio']) ? $_POST['criterio'] : 'todos';
$pesquisa = isset($_POST['pesquisa']) ? $_POST['pesquisa'] : '';

if ($acao == 'Select') {
	$artistas = ArtistaDao::Select($criterio, $pesquisa);
} else if ($acao == 'SelectTodos') {
	$artistas = ArtistaDao::Select('todos', '');
}
?>

<html>
<head>
	<title>Listagem de artistas</title>
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
				<form action="" method="post">
					<div class="row">	
						<div class="input-field col s12">	
							<label for="pesquisa">Pesquisa</label>
							<input type="text" name="pesquisa" id="pesquisa" value="<?php $pesquisa; ?>">
						</div>
					</div>

					<div class="row">
						<div class="input-field col s12">
							<label for="criterio">Critério</label> <br/>
							<select name="criterio">
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
					<?php for ($i=0; $i < count($artistas); $i++) { 
						$artistas[$i] = ArtistaDao::SelectGeneros($artistas[$i]);
						$generos = $artistas[$i]->getGeneros();

						echo "<li class='collection-item avatar'>";

						if ($artistas[$i]->getImagemUrl() != '') {
							echo "<img class='circle materialboxed' src='".$artistas[$i]->getImagemUrl()."'>";
						} else {
							echo "<i class='material-icons circle cyan darken-2'>person</i>";
						}
							
							$fav = UsuarioDao::Artista_favoritado($artistas[$i]->getId(), $usuario->getId());
							echo "<div class='row'>
								<div class='col s8 m10'>
									<code>#".$artistas[$i]->getId()."</code> <br/>
									<span class='title'><b class='cyan-text text-darken-2'>".$artistas[$i]->getNome()."</b></span>
									<a href='artista.php?id=".$artistas[$i]->getId()."' class='secondary-content'> <i class='material-icons'>send</i> </a>
									<i class='truncate cyan-text text-darken-4'> ".$artistas[$i]->getDescricao()." </i>
									<i class='light-green-text text-darken-4'>Gêneros: </i>
									<b class='light-green-text text-darken-2'>";
									for ($j=0; $j < count($generos); $j++) { 
										echo $generos[$j]->getNome();
										if ($j != (count($generos)-1)) echo ", ";
									}
								echo "</b>
								</div>
								<div class='col s4 m2'>";
								if($fav) echo " <i class='tooltipped material-icons small yellow-text text-darken-3' data-tooltip='Favorito' >star</i>";
								else echo " <i class='tooltipped material-icons small grey-text' data-tooltip='Favorito' >star_border</i>";
								echo "</div>
							</div>							
						</li>";
					} ?>
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