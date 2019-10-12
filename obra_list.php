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
	if ($criterio == 'genero') {
		$generos = GeneroDao::Select('nome', $pesquisa);

		$obras0 = array();
		for ($i=0; $i < count($generos); $i++) {
			$obras0[$i] = ObraDao::SelectPorGenero($generos[$i]);
		}

		$obras = array();
		for ($i=0; $i < count($obras0); $i++) {
			for ($j=0; $j < count($obras0[$i]); $j++) {
				array_push($obras, $obras0[$i][$j]);
			}
		}
	} else if ($criterio == 'artista') {
		$artistas = ArtistaDao::Select('nome', $pesquisa);

		$obras0 = array();
		for ($i=0; $i < count($artistas); $i++) {
			$artistas[$i] = ArtistaDao::SelectObras($artistas[$i]);
			$obras0[$i] = $artistas[$i]->getObras();
		}

		$obras = array();
		for ($i=0; $i < count($obras0); $i++) {
			for ($j=0; $j < count($obras0[$i]); $j++) {
				array_push($obras, $obras0[$i][$j]);
			}
		}
	} else {
		if ($criterio == 'dtLancamento') {
			$pesquisa = Funcoes::Data_user_para_BD($pesquisa);
		}
		$criterio = $criterio == 'id' ? 'id_obra' : $criterio;
		$obras = ObraDao::Select($criterio, $pesquisa);
	}
} else if ($acao == 'SelectTodos') {
	$obras = ObraDao::Select('todos', '');
}
?>

<html>
<head>
	<title>Listagem de obras</title>
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
								<option value="dtLancamento" <?php if($criterio=='dtLancamento')echo('selected'); ?>>Data de lançamento</option>

								<option value="genero">Gênero</option>
								<option value="artista">Artista</option>
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
					<?php for ($i=0; $i < count($obras); $i++) {
						$obras[$i] = ObraDao::SelectGeneros($obras[$i]);
						$generos = $obras[$i]->getGeneros();

						$artistas = ArtistaDao::SelectPorObra($obras[$i]);

						$fav = UsuarioDao::Obra_favoritada($obras[$i]->getId(), $usuario->getId());
						$rel = UsuarioDao::SelectObrasRel_porObra($usuario->getId(), $obras[$i]->getId());
						$nota = UsuarioDao::SelectNotaObra($usuario->getId(), $obras[$i]->getId());

						echo "<li class='collection-item avatar'>";

						if ($obras[$i]->getImagemUrl() != '') {
							echo "<img class='circle materialboxed' src='".$obras[$i]->getImagemUrl()."'>";
						} else {
							echo "<i class='circle blue darken-2 material-icons'>photo</i>";
						}

						echo "<div class='row'>
							<div class='col s6 m9'>
								<span class='title'><b class='blue-text text-darken-2'>".$obras[$i]->getNome()."</b></span> <code>#".$obras[$i]->getId()."</code>
								<a class='secondary-content' href='obra.php?id=".$obras[$i]->getId()."'> <i class='material-icons'>send</i> </a>
								<i class='truncate blue-text text-darken-4'>".$obras[$i]->getDescricao()."</i>

								<i class='blue-grey-text text-darken-2'>Data de lançamento: </i>
								<b class='blue-grey-text'>".Funcoes::Data_BD_para_user($obras[$i]->getData_lancamento())."</b> <br/>

								<i class='light-green-text text-darken-4'>Gêneros: </i>
								<b class='light-green-text text-darken-2'>";
								for ($j=0; $j < count($generos); $j++) {
									echo $generos[$j]->getNome();
									if ($j != (count($generos)-1)) echo ", ";
								}
								echo "</b> <br/>

								<i class='cyan-text text-darken-4'>Artista(s): </i>
								<b class='cyan-text text-darken-2'>";
								for ($j=0; $j < count($artistas); $j++) {
									echo $artistas[$j]->getNome();
									if ($j != (count($artistas)-1)) echo ", ";
								}
								echo "</b>
							</div>
						<div class='col s6 m3'>";

								if(isset($nota)) { $cor_nota = 'blue-grey-text text-darken-2'; }
								else { $cor_nota = 'grey-text'; $nota = 0;}

							echo " <b style='vertical-align:super; font-size: 1.5em' class='tooltipped ".$cor_nota."' data-tooltip='Nota'>".$nota."</b> ";

								if($fav) echo " <i class='tooltipped material-icons small yellow-text text-darken-3' data-tooltip='Favorita' >star</i>";
								else echo " <i class='tooltipped material-icons small grey-text' data-tooltip='Favorita' >star_border</i>";

								if($rel=='Desejo') $cor_rel='orange-text';
								else if ($rel=='Atual') $cor_rel=' green-text ';
								else if ($rel=='Completa') $cor_rel='blue-text';
								else $cor_rel='grey-text';

							echo "<i class='tooltipped material-icons small ".$cor_rel."' data-tooltip='Relação (".$rel.")'>room</i> ";

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
