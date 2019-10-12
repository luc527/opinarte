<!DOCTYPE html>

<?php require_once('autoload.php');
include 'valida_secao.php';

if (isset($_POST['obra_id'])) $obra_id = $_POST['obra_id'];
else if (isset($_GET['obra_id'])) $obra_id = $_GET['obra_id'];
else $obra_id = '';

$acao = 'Insert';
$acao_ico = 'add';
$acao_txt = 'Publicar';

if (isset($_POST['acao'])) $acao = $_POST['acao'];
else if (isset($_GET['acao'])) $acao = $_GET['acao'];

$texto = '';
if ($acao == 'Update') {
	$acao_ico = 'edit';
	$acao_txt = 'Editar';

	$res_id = $_GET['res_id'];
	$autor = ResenhaDao::SelectPorId($res_id);
	$resenha = $autor->getResenhas()[0];
	$obra_id = $resenha->getObra()->getId();
	$texto = $resenha->getTexto();
}

$title = "Resenha";
if ($obra_id != '') {
	$obra = new Obra;
	$obra = ObraDao::SelectPorId($obra_id);
	$title .= ": ".$obra->getNome();

	$artistas = ArtistaDao::SelectPorObra($obra);

	$fav = UsuarioDao::Obra_favoritada($obra_id, $_SESSION['usuario_id']);

	$rel = UsuarioDao::SelectObrasRel_porObra($_SESSION['usuario_id'], $obra_id);

	$nota = UsuarioDao::SelectNotaObra($_SESSION['usuario_id'], $obra_id);
}
?>

<html>
<head>
	<title><?php echo $title; ?></title>
	<meta charset="utf-8">
	<!-- Materialize -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
	<!-- Custom CSS -->
	<link type="text/css" rel="stylesheet" href="css/custom.css"/>
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

</head>
<body class="indigo lighten-5">
	<header><?php Funcoes::PrintHeader(); ?></header>

	<main>
		<div class="container"> <div class="card-panel hoverable">
			<div class="row"> <div class="col s12">
				<center><h4><b class="indigo-text">Resenha</b></h4></center>
			</div> </div>

			<?php if ($obra_id != '' || !isset($res_id)) { ?>
			<div class="row"> <div class="col s12">
				<ul class="collection"><li class="collection-item avatar">

					<?php if($obra->getImagemUrl() != '') {
						echo "<img src='".$obra->getImagemUrl()."' class='circle materialboxed'>";
					} else { echo "<i class='material-icons blue circle darken-2'>photo</i>"; } ?>

					<div class="row"> <div class="col s6 m9">
						<span class="title">
							<b class="cyan-text text-darken-2">
								<?php for($i=0; $i < count($artistas); $i++) {
									echo $artistas[$i]->getNome();
									if($i != (count($artistas)-1)) echo ", ";
								} ?> </b>
							<b class="blue-text text-darken-2"> -
								<?php echo $obra->getNome(); ?>
							</b>
						</span>

						<a class="secondary-content" href="obra.php?id=<?php echo $obra_id; ?>">
							<i class="material-icons">send</i>
						</a>

						<p><i class="truncate blue-text text-darken-4"><?php echo $obra->getDescricao(); ?></i></p>
					</div>
					<div class="col s6 m3">
						<?php if(isset($nota)) { $corn='blue-grey-text text-darken-2'; }
						else { $nota='0'; $corn='grey-text'; } ?>
						<b style='font-size:1.5em; vertical-align:super;' class='<?php echo $corn; ?> tooltipped' data-tooltip="Nota"><?php echo $nota; ?> </b>

						<?php if($fav) { $corf='yellow-text text-darken-3'; $ico='star'; }
						else { $corf='grey-text'; $ico='star_border'; } ?>
						<i data-tooltip="Favoritada" class="small tooltipped material-icons <?php echo $corf ?>"><?php echo $ico ?></i>

						<?php $tooltip="Relação (".$rel.")";
						if($rel=='Atual') { $corr='green-text'; }
						else if ($rel=='Desejo') { $corr='orange-text'; }
						else if ($rel=='Completa') { $corr='blue-text'; }
						else { $corr='grey-text'; $rel='Sem relação'; } ?>
						<i class="<?php echo $corr ?> small material-icons tooltipped" data-tooltip="<?php echo $tooltip; ?>">room</i>
					</div> </div>
				</li></ul>
			</div></div>


			<form action="resenha_acao.php" method="post">
				<?php if($acao=='Update') echo "<input type='hidden' name='res_id' value='".$res_id."'/>"; ?>
				<input type="hidden" name="obra_id" value="<?php echo $obra_id; ?>">
				<div class="row container"><div class="input-field col s12">
					<label for="texto">Texto da resenha</label>
					<textarea class="materialize-textarea" name="texto"><?php echo $texto; ?></textarea>
				</div></div>
				<div class="row">
					<div class="input-field col s12"> <center>
						<button type="submit" name="acao" value="<?php echo $acao; ?>"
						class="waves-effect waves-light btn indigo">
							<i class="material-icons left"><?php echo $acao_ico; ?></i>
							<?php echo $acao_txt; ?>
						</button>
					</center> </div>

					<?php if($acao == 'Update') { ?>
						<div class="input-field col s12">
							<button type="submit" name="acao" value="Delete"
							class="waves-effect waves-light btn red darken-2">
								<i class="material-icons left">delete</i>
								Deletar
							</button></div>
					<?php } ?>
				</div>
			</form>
		<?php } else {
			if ($acao != 'Update') {
				echo "<center><div class='container card-panel red darken-1 z-depth-3 white-text'><b>Erro: </b> não foi informada uma obra (<code>resenha_cad.php?obra_id=n</code>)</div></center>";
				}
		} ?>

		</div> </div>
	</main>

	<footer><?php Funcoes::PrintFooter(); ?></footer>
	<!-- Scripts -->
	<script type="text/javascript" src="js/jquery-3.4.1.js"></script> <!-- OBS: jQuery deve estar sempre acima -->
	<script type="text/javascript" src="js/materialize.min.js"></script>
	<!-- Materialize auto init -->
	<script type="text/javascript"> M.AutoInit(); </script>
</body>
</html>
