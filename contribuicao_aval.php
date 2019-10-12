<!DOCTYPE html>
<?php
include('valida_secao.php');
if ($_SESSION['usuario_tipo'] != 1) {
	header("location:index.php");
}

require_once('autoload.php');
$id = isset($_GET['id']) ? $_GET['id'] : '';
$con = ContribuicaoDao::SelectPorId($id);

$title = 'Avaliar contribuição';
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
	<header><?php Funcoes::PrintHeader(); ?></header>

	<main>
		<div class="container">
			<a href="contribuicao.php?id=<?php echo $id; ?>" class="btn-flat teal-text waves-effect">
				<i class="material-icons left">keyboard_return</i>
				Voltar
			</a>
			<div class="card-panel hoverable">

				<div class="row">
					<div class="col s12 center-align">
						<h4><b class="blue-grey-text text-darken-2">
							<?php echo $title; ?>
						</b></h4>
					</div>
				</div>

				<div class="row">
					<div class="col s12">
						<form action="contribuicao_acao.php" method="post">
							<input type="hidden" name="adm_id" value="<?php echo $_SESSION['usuario_id']; ?>">
							<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
							<div class="row">
								<div class="input-field col s12">
									<?php Funcoes::GerarSelect('estado', 'estado_con', 'id_estado', 'descricao', 0); ?>
									<span class="helper-text">Estado</span>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<label for="comentario">Comentário</label>
									<textarea name="comentario" id="comentario" class="materialize-textarea"></textarea>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12 center-align">
									<button class="btn waves-effect waves-light blue-grey darken-2"
									name="acao" value="UpdateAval">
										<i class="material-icons left">gavel</i>
										Avaliar
									</button>
								</div>
							</div>
						</form>
					</div>
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