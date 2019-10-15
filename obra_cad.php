<!DOCTYPE html>
<?php

include 'valida_secao.php';
if ($_SESSION['usuario_tipo'] != 1) { // Se o usuário não é adm (0=normal, 1=adm)
	header("obra_list.php");
}

require_once 'autoload.php';

$title = 'Cadastro de obra';

if (isset($_POST['id'])) $id = $_POST['id'];
else if (isset($_GET['id'])) $id = $_GET['id'];

$acao = 'Insert';
if (isset($id)) $acao = 'Update';
else $id = 'ID preenchido automaticamente';

$nome = '';
$descricao = '';
$dtLancamento = '';
$imgUrl = '';

if ($acao == 'Update') {
	$obra = ObraDao::SelectPorId($id);
	$nome = $obra->getNome();
	$descricao = $obra->getDescricao();
	$dtLancamento = $obra->getData_lancamento();
	$imgUrl = $obra->getImagemUrl();
}

?>
<html>

<head>
	<title><?php echo $title; ?></title>
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
	<header>
		<?php Funcoes::PrintHeader(); ?>
	</header>

	<main>
		<div class="container">

			<?php if ($acao == 'Update') : ?>
				<a href="obra.php?id=<?= $id; ?>" class="link">
					Voltar para página da obra
				</a>
			<?php endif; ?>

			<div class="card-panel hoverable">

				<form action="obra_acao.php" method="POST" class="row">

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
						<div class="input-field col s6 m4">
							<input type="date" name="dtLancamento" id="dtLancamento" value="<?= $dtLancamento; ?>" />
							<span class="helper-text">Data de lançamento</span>
						</div>

						<div class="input-field col s6 m8">
							<label for="imagemUrl">Imagem (url)</label>
							<input type="url" name="imagemUrl" id="imagemUrl" value="<?= $imgUrl; ?>" />

							<?php if ($acao == 'Update') : ?>
								<img src="<?= $imgUrl; ?>" style='width: 200px;' class="materialboxed responsive-img">
							<?php endif; ?>
						</div>
					</div>

					<div class="row card-panel">
						<div class="input-field col s12">

							<?php if ($acao == 'Insert') : ?>
								<?php Funcoes::GerarSelect('artista_id', 'artista', 'id_artista', 'nome', 0);  ?>
								<span class="helper-text">Artista</span>
							<?php else : ?>
								<i class="yellow-text text-darken-2">Para editar os artistas de uma obra, vá para a página do artista e adicione ou remova artistas.</i>
							<?php endif; ?>

						</div>
					</div>

					<div class="row card-panel">
						<div class="class col s12">

							<?php if ($acao == 'Update') :
								$obra = ObraDao::SelectGeneros($obra);
								$generos = $obra->getGeneros();
								?>

								<h4 class="header lightgreen darken-2">Gêneros</h4>
								<ul class="collection">
									<?php foreach ($generos as $genero) : ?>

										<li class="collection-item">
											<span class="title">
												<a href="genero.php?id=<?= $genero->getId(); ?>" class="link">
													<?= $genero->getNome(); ?>
												</a>
											</span>

											<a href="obra_acao.php?acao=DeleteGenero&obra_id=<?= $obra->getId(); ?>&gen_id=<?= $genero->getId(); ?>" class="secondary-content tooltipped" data-tooltip="Remover do artista">
												<i class="material-icons red-text text-darken-2">close</i>
											</a>
										</li>

									<?php endforeach; ?>
								</ul>

								<div class="input-field col s12">
									<?php Funcoes::GerarSelect_gen('genero_id', 0); ?>
									<button class="btn light-green darken-2 waves-effect waves-light" type="submit" name="acao" id="acao" value="InsertGenero">
										<i class="material-icons left">send</i>
										Adicionar
									</button>
								</div>

							<?php else : ?>

								<i class="yellow-text text-darken-2">Gêneros só podem ser adicionados a uma obra após seu cadastro.</i>

							<?php endif; ?>

						</div>
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

							<button class="blue-grey btn" type="submit" name="acao" value="<?= $acao; ?>">
								<i class="material-icons left"><?= $acao_ico; ?></i>
								<?= $acao_txt; ?>
							</button>
						</div>

						<?php if ($acao == 'Update') : ?>
							<div class="class input-field col s6">
								<button class="btn waves-effect waves-light red darken-2" type="submit" name="acao" id="acao" value="Delete">
									<i class="material-icons left">delete</i>
									Excluir
								</button>
							</div>
						<?php endif; ?>
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