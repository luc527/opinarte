<!DOCTYPE html>

<?php
include 'valida_secao.php';
if ($_SESSION['usuario_tipo'] != 1) { // Se o usuário não é adm (0=normal, 1=adm)
	header("artista_list.php");
}

require_once('autoload.php');

$acao = 'Insert';

if (isset($_POST['id'])) $id = $_POST['id'];
else if (isset($_GET['id'])) $id = $_GET['id'];

if (isset($id)) $acao = 'Update';
else $id = "ID preenchido automaticamente.";

$title = "Cadastro de artista";

$nome = '';
$descricao = '';
$imgUrl = '';

if ($acao == 'Update') {
	$artista = ArtistaDao::Select('id_artista', $id)[0];
	$id = $artista->getId();
	$nome = $artista->getNome();
	$descricao = $artista->getDescricao();
	$imgUrl = $artista->getImagemUrl();
}
?>

<html>

<head>
	<title><?= $title ?></title>
	<meta charset="utf=8">

	<!-- Materialize -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
	<!-- Custom CSS -->
	<link type="text/css" rel="stylesheet" href="css/custom.css" />
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body class="blue-grey lighten-5">
	<header><?php Funcoes::printHeader(); ?></header>

	<main>
		<div class="container">
			<?php if ($acao == 'Update') : ?>
				<a href="artista.php?id=<?= $id; ?>" class="link">
					Voltar para página do artista
				</a>
			<?php endif; ?>
			<div class="card-panel hoverable">

				<form action="artista_acao.php" method="POST">
					
					<div class="row">
						<div class="input-field col s6">
							<label for="nome">Nome</label>
							<input type="text" name="nome" id="nome" value="<?= $nome; ?>" required />
						</div>

						<div class="input-field col s6">
							<label for="id">ID</label>
							<input type="text" value="<?= $id ?>" disabled /> <!-- Mostra ao usuário -->
							<input type="hidden" name="id" id="id" value="<?= $id ?>" /> <!-- O que o formulário envia -->
							<!-- Os dois são necessários porque o disabled não é enviado -->
						</div>
					</div>

					<div class="row">
						<div class="input-field col s12">
							<label for="descricao">Descrição</label>
							<textarea name="descricao" id="descricao" class="materialize-textarea"><?= $descricao; ?></textarea>
						</div>
					</div>

					<div class="row">
						<div class="input-field col s12">
							<label for="imgUrl">Imagem (URL)</label>
							<input type="url" name="imagemUrl" id="imagemUrl" value="<?= $imgUrl; ?>" />
						
							<?php if ($imgUrl != null) { ?>
								<img
									src="<?= $artista->getImagemUrl(); ?>"
									alt="Imagem de <?= $artista->getNome(); ?>"
									class="materialboxed" style="max-height: 225px;"
								/>
							<?php } ?>

						</div>
					</div>

					<div class="row card-panel">
						<h5 class="blue-text text-darken-2"><b>Obras</b></h5>

						<?php if ($acao == 'Update') :
							$artista = ArtistaDao::SelectObras($artista);
							$obras = $artista->getObras();	?>

							<ul class="collection">
								<?php foreach ($obras as $obra) : ?>
									<li class="collection-item">
										<span class="title">
											<a href="obra.php?id=<?= $obra->getId(); ?>" class="link">
												<?= $obra->getNome(); ?>
											</a>
										</span>
										<a
											href="artista_acao.php?acao=DeleteObra&art_id=<?= $id; ?>&obra_id=<?= $obra->getId(); ?>"
											class="secondary-content tooltipped"
											data-tooltip="Remover obra"
										>
											<i class="material-icons red-text text-darken-2">close</i>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
							
							<div class="row">
								<div class="input-field col s12">
									<?php Funcoes::GerarSelect('obra_id', 'obra', 'id_obra', 'nome', 0); ?>
									<span class="helper-text">Adicionar obras</span>
								</div>
								<div class="input-field col s12">
									<button
										type="submit" name="acao" value="InsertObra"
										class="btn blue darken-2 waves-effect waves-right"
									>
										<i class="material-icons left">add	</i>
										Adicionar
									</button>
								</div>
							</div>

						<?php else : ?>
							<i class="yellow-text text-darken-3">Gêneros só podem ser adicionados a uma obra após seu cadastro.</i>
						<?php endif; ?>

					</div>

					<div class="row card-panel">
						<h5 class="light-green-text text-darken-2"><b>Gêneros</b></h5>

						<?php if ($acao == 'Update') :
							$artista = ArtistaDao::SelectGeneros($artista);
							$generos = $artista->getGeneros();	?>

							<ul class="collection">
								<?php foreach ($generos as $genero) : ?>
									<li class="collection-item">
										<span class="title">
											<a href="genero.php?id=<?= $genero->getId(); ?>" class="link">
												<?= $genero->getNome(); ?>
											</a>
										</span>
										<a
											href="artista_acao.php?acao=DeleteGenero&art_id=<?= $id; ?>&gen_id=<?= $genero->getId(); ?>"
											class="secondary-content tooltipped"
											data-tooltip="Remover gênero"
										>
											<i class="material-icons red-text text-darken-2">close</i>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>

							<div class="row">
								<div class="input-field col s12">
									<?php Funcoes::GerarSelect_gen('genero_id', 0); ?>
									<span class="helper-text">Adicionar gêneros</span>
								</div>
								<div class="input-field col s12">
									<button
										type="submit" name="acao" value="InsertGenero"
										class="btn light-green darken-2 waves-effect waves-right"
									>
										<i class="material-icons left">add	</i>
										Adicionar
									</button>
								</div>
							</div>

						<?php else : ?>
							<i class="yellow-text text-darken-3">Gêneros só podem ser adicionados a uma obra após seu cadastro.</i>
						<?php endif; ?>

					</div>

					<div class="row">
						<div class="input-field col s6">
							<?php
								if ($acao == 'Insert') {
									$acao_txt = 'Cadastrar';
									$acao_ico = 'add';
								} else if ($acao == 'Update') {
									$acao_txt = 'Editar';
									$acao_ico = 'edit';
								}
							?>

							<button
								class="btn waves-effect waves-light blue-grey"
								type="submit" name="acao" id="acao" value="<?= $acao ?>"
							>
								<i class="material-icons left"><?= $acao_ico; ?></i>
								<?= $acao_txt; ?>
							</button>
						</div>

						<div class="input-field col s6">
							<button
								class="btn waves-effect waves-light red"
								type="submit" name="acao" value="Delete"
							>
								<i class="material-icons left">delete</i>
								Excluir
							</button>
						</div>
					</div>

				</form>

			</div>
		</div>
	</main>

	<!-- Scripts -->
	<script type="text/javascript" src="js/jquery-3.4.1.js"></script> <!-- OBS: jQuery deve estar sempre acima -->
	<script type="text/javascript" src="js/materialize.min.js"></script>
	<!-- Materialize auto init -->
	<script type="text/javascript">
		M.AutoInit();
	</script>
</body>

</html>