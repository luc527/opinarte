<!DOCTYPE html>
<?php
include('valida_secao.php');
require_once('autoload.php');
$title = 'Edição de relação';

$id = isset($_GET['id']) ? $_GET['id'] : '';
$rel = RelacaoDao::SelectPorId($id);

$objs[1] = $rel->getObj1();
$objs[2] = $rel->getObj2();

for ($i = 1; $i <= 2; $i++) {
	if ($objs[$i] instanceof Obra) {
		$tipos[$i] = 'obra';
	} else if ($objs[$i] instanceof Artista) {
		$tipos[$i] = 'artista';
	} else if ($objs[$i] instanceof Genero) {
		$tipos[$i] = 'genero';
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
</head>

<body class="teal lighten-5">
	<header><?php Funcoes::PrintHeader(); ?></header>


	<main>
		<div class="container">
			<div class="card-panel hoverable">
				<div class="row">
					<div class="col s12">
						<center>
							<h4>
								<b class="teal-text text-darken-2">
									<?php echo $title; ?>
								</b>
							</h4>
						</center>
					</div>
				</div>

				<div class="row">
					<form class="col s12" action="relacao_acao.php" method="post">
						<div class="row">
							<?php for ($i = 1; $i <= 2; $i++) : ?>
								<div class="col s12 m9">
									<ul class="tabs">
										<li class="tab col s4">
											<a class="<?php if ($tipos[$i] == 'obra') {
																		echo ('active');
																	} ?>" href="#obra<?php echo $i; ?>">Obra</a>
										</li>
										<li class="tab col s4">
											<a class="<?php if ($tipos[$i] == 'artista') {
																		echo ('active');
																	} ?>" href="#artista<?php echo $i; ?>">Artista</a>
										</li>
										<li class="tab col s4">
											<a class="<?php if ($tipos[$i] == 'genero') {
																		echo ('active');
																	} ?>" href="#genero<?php echo $i; ?>">Gênero</a>
										</li>
									</ul>

									<div id="obra<?php echo $i; ?>">
										<?php Funcoes::GerarSelect('obra' . $i, 'obra', 'id_obra', 'nome', $objs[$i]->getId()); ?>
									</div>

									<div id="artista<?php echo $i; ?>">
										<?php Funcoes::GerarSelect('artista' . $i, 'artista', 'id_artista', 'nome', $objs[$i]->getId()); ?>
									</div>

									<div id="genero<?php echo $i; ?>">
										<?php Funcoes::GerarSelect('genero' . $i, 'genero', 'id_genero', 'nome', $objs[$i]->getId()); ?>
									</div>
								</div>

								<div class="col s12 m3">
									<p>
										<label>
											<input <?php if ($tipos[$i] == 'obra') {
																	echo ('checked');
																} ?> name="obj<?php echo $i ?>" type="radio" value="obra<?php echo $i ?>" required />
											<span>Obra</span>
										</label>
									</p>
									<p>
										<label>
											<input <?php if ($tipos[$i] == 'artista') {
																	echo ('checked');
																} ?> name="obj<?php echo $i ?>" type="radio" value="artista<?php echo $i ?>" />
											<span>Artista</span>
										</label>
									</p>
									<p>
										<label>
											<input <?php if ($tipos[$i] == 'genero') {
																	echo ('checked');
																} ?> name="obj<?php echo $i ?>" type="radio" value="genero<?php echo $i ?>" />
											<span>Gênero</span>
										</label>
									</p>
								</div>
							<?php endfor; ?>
						</div>

						<div class="row">
							<div class="input-field col s12">
								<label for="descricao">Descrição</label>
								<textarea class='materialize-textarea' name="descricao" id="descricao"><?php echo $rel->getDescricao(); ?></textarea>
							</div>
						</div>

						<div class="row">
							<div class="input-field col s12">
								<label for="fontes">Fontes</label>
								<textarea class='materialize-textarea' name="fontes" id="fontes"><?php echo $rel->getFontes(); ?></textarea>
							</div>
						</div>

						<div class="row">
							<div class="input-field col s12 center-align">
								<button type="submit" name="acao" value="Editar" class="btn waves-effect waves-light teal darken-2">
									<i class="material-icons left">edit</i>
									Editar
								</button>
							</div>
						</div>
						<input type="hidden" name="id_relacao" value="<?php echo $rel->getId(); ?>" />
					</form>
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