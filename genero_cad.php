<!DOCTYPE html>

<?php
include 'valida_secao.php';

require_once('autoload.php');

$title = "Cadastro de gênero";

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


?>

<html>

<head>
	<title><?php echo $title; ?></title>
	<meta charset="utf-8">
</head>

<body>

	<main>
		<div style="width: 70%; margin: auto;">
			<?php if ($acao == 'Update') : ?>
				<a href="genero.php?id=<?php echo $id; ?>">
					Voltar para página do gênero
				</a>
			<?php endif; ?> <br/>
			<form action="genero_acao.php" method="post">
				<fieldset>
					<legend><b><?php echo $title; ?></b></legend>
					<label for="nome">Nome: </label> <br />
					<input type="text" name="nome" id="nome" value="<?php echo $nome; ?>" required> <br /><br />

					<label for="id">ID: </label> <br />
					<input type="text" value="<?php echo $id; ?>" disabled> <br /><br />
					<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">

					<label for="descricao">Descrição: </label> <br />
					<textarea name="descricao" id="descricao"><?php echo $descricao; ?></textarea> <br /><br />

					<label for="lingArte">Linguagem: </label> <br />
					<?php Funcoes::GerarSelect('lingArte', 'linguagensArt', 'id', 'nome', $linguagem); ?> <br /><br />

					<?php
					if ($acao == 'Insert') $acao_txt = "Cadastrar";
					else if ($acao == 'Update') $acao_txt = 'Editar'
					?>
					<button type="submit" name="acao" value="<?php echo $acao; ?>"><?php echo $acao_txt; ?></button>

					<br /><br /><br /> <button type="submit" name="acao" value="Delete" style="background-color: darkred; color:white;">Excluir</button>
				</fieldset>
			</form>

		</div>
	</main>

	<div id="teste">
		<?php

		?>
	</div>

</body>

</html>