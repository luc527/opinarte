<!DOCTYPE html>

<?php
include 'valida_secao.php';

require_once('autoload.php');

$acao = 'Insert';

if (isset($_POST['id'])) $id = $_POST['id'];
else if (isset($_GET['id'])) $id = $_GET['id'];

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
	<title>Cadastro de obra</title>
	<meta charset="utf-8">
</head>

<body>
	<main>
		<div class="container" style="width:70%; margin:auto;">
			<?php if ($acao == 'Update') : ?>
				<a href="obra.php?id=<?php echo $id; ?>">
					Voltar para página da obra
				</a>
			<?php endif; ?>
			<form action="obra_acao.php" method="post">
				<fieldset>
					<legend>Cadastro de obra</legend>

					<label for="nome">Nome: </label> <br />
					<input type="text" name="nome" id="nome" value="<?php echo $nome; ?>" required> <br /><br />

					<label for="id">ID: </label> <br />
					<input type="text" value="<?php echo $id; ?>" disabled> <br /><br />
					<input type="hidden" value="<?php echo $id; ?>" name="id" id="id">


					<label for="descricao">Descrição: </label> <br />
					<textarea name="descricao" id="descricao"><?php echo $descricao; ?></textarea> <br /><br />

					<label for="dtLancamento">Data de lançamento: </label> <br />
					<input type="date" name="dtLancamento" id="dtLancamento" value="<?php echo $dtLancamento; ?>"> <br /><br />

					<label for="imagemUrl">Imagem (URL): </label> <br />
					<input type="url" name="imagemUrl" id="imagemUrl" value="<?php echo $imgUrl; ?>"> <br /><br />
					<?php
					if ($acao == 'Update') {
						echo "<img src='" . $imgUrl . "' style='width: 150px; max-height: 250px'>";
					}
					?>

					<?php if ($acao == 'Insert') { ?>
						<label for="artista_id">Artista: </label> <br />
						<?php Funcoes::GerarSelect("artista_id", "artista", "id_artista", "nome", 0); ?> <br /><br />
					<?php } else if ($acao == 'Update') {
						echo "<i>Para editar os artistas de uma obra, vá para a página do artista e adicione ou remova artistas.</i> <br/><br/>";
					} ?>

					<fieldset>
						<?php
						if ($acao == 'Update') {
							$obra = ObraDao::SelectGeneros($obra);
							$generos = $obra->getGeneros();

							echo "<b>Gêneros</b>";
							echo "<ul>";
							for ($i = 0; $i < count($generos); $i++) {
								echo "<li>" . $generos[$i]->getNome()
									. " [<a href='obra_acao.php
						?acao=DeleteGenero&obra_id=" . $obra->getId() . "&gen_id=" . $generos[$i]->getId() . "'>Remover</a>]</li>";
							}
							echo "</ul>";
							?>

							<label for="genero_id">Adicionar gênero: </label> <br />
							<?php Funcoes::GerarSelect_gen('genero_id', 0); ?>
							<button type="submit" name="acao" value="InsertGenero">Adicionar</button> <br /><br />
						<?php
						} else {
							echo "<i>Gêneros só podem ser adicionados a uma obra após seu cadastro.</i><br/><br/>";
						}
						?>
					</fieldset> <br />

					<?php
					if ($acao == 'Insert') $acao_txt = 'Cadastrar';
					else if ($acao == 'Update') $acao_txt = 'Editar';
					?>
					<button type="submit" name="acao" value="<?php echo $acao; ?>"><?php echo $acao_txt; ?></button>

					<br /><br /><br /> <button type="submit" name="acao" value="Delete" style="background-color:darkred; color:white;">Excluir</button>
				</fieldset>
			</form>

		</div>
	</main>
</body>

</html>