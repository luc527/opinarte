<!DOCTYPE html>
<?php

include 'valida_secao.php';
if ($_SESSION['usuario_tipo'] != 1) { // Se o usuário não é adm (0=normal, 1=adm)
	header("genero_list.php");
}
require_once 'autoload.php';

$acao = 'Insert';

if (isset($_POST['id'])) $id = $_POST['id'];
else if (isset($_GET['id'])) $id = $_GET['id'];

if (isset($id)) $acao = 'Update';
else $id = 'ID preenchido automaticamente.';

$nome = '';
$descricao = '';
$linguagem = '0';

if ($acao == 'Update') {
	$genero = GeneroDao::SelectPorId($id);
	$ling = LingArteDao::SelectPorGenero($genero);

	$nome = $genero->getNome();
	$descricao = $genero->getDescricao();
	$linguagem = $ling->getId();
}

$title = 'Cadastro de gênero';

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

	<header><?php Funcoes::PrintHeader(); ?></header>

	<main>
		<div class="container">
			<?php if ($acao == 'Update'): ?>
				<a class="link" href="genero.php?id=<?= $id; ?>">Voltar para página do gênero</a>
			<?php endif; ?>
			<div class="card-panel hoverable">
				<form action="genero_acao.php" method="POST">
					<div class="row">
						<div class="input-field col s6">
							<label for="nome">Nome</label>
							<input type="text" name="nome" id="nome" value="<?= $nome; ?>" required />
						</div>
						<div class="input-field col s6">
							<label for="id">ID</label>
							<input type="text" value="<?php echo $id; ?>" disabled>
							<input type="hidden" name="id" id="id" value="<?= $id; ?>">
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<label for="descricao">Descrição</label>
							<textarea name="descricao" id="descricao" class="materialize-textarea"
							><?= $descricao; ?></textarea>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<?php Funcoes::GerarSelect('lingArte', 'linguagensArt', 'id', 'nome', $linguagem); ?>
							<span class="helper-text">Linguagem</span>
						</div>
					</div>
					<div class="row">
						<?php
							if ($acao == 'Insert') {
								$acao_txt = "Cadastrar";
								$acao_ico = 'add';
							} else if ($acao == 'Update') {
								$acao_txt = 'Editar';
								$acao_ico = 'edit';
							}
						?>
						<div class="input-field col s6">
							<button
								class="btn waves-effect waves-light light-green darken-2"
								type="submit" name="acao" value="<?php echo $acao; ?>"
							>
								<i class="material-icons left"><?= $acao_ico; ?></i>
								<?= $acao_txt; ?>
							</button>
						</div>
						<div class="input-field col s6">
							<button
								class="btn waves-effect waves-light red darken-2"
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