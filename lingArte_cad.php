<!DOCTYPE html>

<?php
include 'valida_secao.php';

require_once('autoload.php');

$title = "Cadastro de linguagem";

$acao = 'Insert';

if (isset($_POST['id'])) $id = $_POST['id'];
else if (isset($_GET['id'])) $id = $_GET['id'];

if (isset($id)) $acao = 'Update';
else $id = 'ID preenchido automaticamente.';

$nome = '';
$descricao = '';

if ($acao == 'Update') {
	$lingArte = LingArteDao::SelectPorId($id);
	$nome = $lingArte->getNome();

	$descricao = $lingArte->getDescricao();
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

<body class="blue-grey lighten-5">

	<header>
		<?php Funcoes::PrintHeader(); ?>
	</header>

	<main>
		<div class="container">
			<?php if ($acao == 'Update') : ?>
				<a href="lingArte.php?id=<?php echo $id; ?>" class="link">
					Voltar para página da linguagem
				</a>
			<?php endif; ?>
			<form action="lingArte_acao.php" method="post" class="card-panel hoverable">
				<p class="blue-grey-text"><b><?php echo $title; ?></b></p>

				<div class="row">
					<div class="input-field col s12 m6">
						<label for="nome">Nome</label>
						<input type="text" name="nome" id="nome" value="<?php echo $nome; ?>" required>
					</div>

					<div class="input-field col s12 m6">
						<label for="id">ID</label>
						<input type="text" value="<?php echo $id; ?>" class="disabled" disabled>
						<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
					</div>
				</div>

				<div class="row">
					<div class="input-field col s12">
						<label for="descricao">Descrição</label>
						<textarea class="materialize-textarea" name="descricao" id="descricao"><?php echo $descricao; ?></textarea>
					</div>
				</div>

				<?php
				if ($acao == 'Insert') {
					$acao_txt = 'Cadastrar';
					$acao_ico = "add";
				} else if ($acao == 'Update') {
					$acao_txt = 'Editar';
					$acao_ico = "edit";
				}
				?>

				<div class="row">
					<div class="input-field col s12">
						<center> <button class="waves-effect waves-light btn green" type="submit" name="acao" value="<?php echo $acao; ?>">
								<?php echo $acao_txt; ?>
								<i class="material-icons right"><?php echo $acao_ico; ?></i>
							</button> </center>
					</div>
				</div>

				<?php if ($acao == 'Update') { ?>
					<div class="row">
						<div class="input-field col s12">
							<center> <button class="waves-effect waves-light btn red darken-3 white-text" type="submit" name="acao" value="Delete" style="background-color: darkred; color:white;">
									Excluir
									<i class="material-icons right">delete</i>
								</button> </center>
						</div>
					</div>
				<?php } ?>

			</form>
		</div>
	</main>

	<footer>
		<?php Funcoes::PrintFooter(); ?>
	</footer>

	<!-- Scripts -->
	<script type="text/javascript" src="js/jquery-3.4.1.js"></script> <!-- OBS: jQuery deve estar sempre acima -->
	<script type="text/javascript" src="js/materialize.min.js"></script>
	<!-- Materialize auto init -->
	<script type="text/javascript">
		M.AutoInit();
	</script>

</body>

</html>