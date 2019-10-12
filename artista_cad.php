<!DOCTYPE html>

<?php
include 'valida_secao.php';

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
	<title><?php echo $title; ?></title>
	<meta charset="utf-8">
</head>
<body>

	<main>
		<div style="width: 70%; margin: auto;">
			<?php if ($acao == 'Update'): ?>
				<a href="artista.php?id=<?php echo $id;?>">
					Voltar para página do artista
				</a>
			<?php endif; ?>
			<form action="artista_acao.php" method="post">
				<fieldset> <legend><b><?php echo $title; ?></b></legend>
					<label for="nome">Nome: </label> <br/>
					<input type="text" name="nome" id="nome" required value="<?php echo $nome; ?>"> <br/><br/>

					<?php if($acao == 'Update') { ?>	
						<label for="id">ID: </label> <br/>
						<input type="text" value="<?php echo $id; ?>" disabled> <br/><br/>
						<input type="hidden" name="id" value="<?php echo $id; ?>">
					<?php } ?>

					<label for="imgUrl">Imagem (url): </label> <br/>
					<input type="url" name="imgUrl" id="imgUrl" value="<?php echo $imgUrl; ?>"> <br/><br/>

					<?php
					if ($acao == 'Update' && $imgUrl != '') {
						echo "<img style='width:250px' src='".$imgUrl."'>";
					}
					?> <br/><br/>

					<label for="descricao">Descrição: </label> <br/>
					<textarea name="descricao" id="descricao"><?php echo $descricao; ?></textarea> <br/><br/>

					<fieldset>
						<?php
						if ($acao == 'Update') {
							$artista = ArtistaDao::SelectObras($artista);
							$obras = $artista->getObras();

							echo "<b>Obras</b>";
							echo "<ul>";
							for ($i=0; $i < count($obras); $i++) { 
								echo "<li>".$obras[$i]->getNome()
								." [<a href='artista_acao.php
								?acao=DeleteObra&art_id=".$artista->getId()."&obra_id=".$obras[$i]->getId()."'>Remover</a>]</li>";
							}
							echo "</ul>";
						?>

						<label for="obra_id">Adicionar obra: </label> <br/>
						<?php Funcoes::GerarSelect('obra_id', 'obra', 'id_obra', 'nome', 0); ?>
						<button type="submit" name="acao" value="InsertObra">Adicionar</button> <br/><br/>
							
						<?php 
							} else { echo "<i>Obras só podem ser adicionados a um artista após seu cadastro.</i><br/><br/>"; }
						?>
					</fieldset> <br/>

					<fieldset>
						<?php
						if ($acao == 'Update') {
							$artista = ArtistaDao::SelectGeneros($artista);
							$generos = $artista->getGeneros();

							echo "<b>Gêneros</b>";
							echo "<ul>";
							for ($i=0; $i < count($generos); $i++) { 
								echo "<li>".$generos[$i]->getNome()
								." [<a href='artista_acao.php
								?acao=DeleteGenero&art_id=".$id."&gen_id=".$generos[$i]->getId()."'>Remover</a>]</li>";
							}
							echo "</ul>";
						?>

						<label for="genero_id">Adicionar gênero: </label> <br/>
						<?php Funcoes::GerarSelect_gen('genero_id', 0); ?>
						<button type="submit" name="acao" value="InsertGenero">Adicionar</button> <br/><br/>
						<?php 
							} else { echo "<i>Gêneros só podem ser adicionados a uma obra após seu cadastro.</i><br/><br/>"; }
						?>
					</fieldset> <br/>

					<?php
						if ($acao == 'Insert') $acao_txt = "Cadastrar";
						else if ($acao == 'Update') $acao_txt = "Editar";
					?>
					<button type="submit" name="acao" value="<?php echo $acao; ?>"> <?php echo $acao_txt; ?> </button>

					<br/><br/><br/> <button type="submit" name="acao" value="Delete" style="background-color:darkred;color:white;">Excluir</button>
				</fieldset>
			</form>

		</div>
	</main>

</body>
</html>