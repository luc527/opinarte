<!DOCTYPE html>
<?php
include('valida_secao.php');
require_once('autoload.php');

$id = $_SESSION['usuario_id'];
$mpts = MPThreadDao::SelectPorUsuario($id);

$title = 'Suas mensagens privadas';
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
			<div class="card-panel hoverable">

				<!-- Título da página -->
				<div class="row">
					<div class="col s12 center-align">
						<h4><b class="blue-grey-text"><?= $title ?></b></h4>
					</div>
				</div>

				<!-- Listagem de threads de mensagens privadas -->
				<div class="row">
					<div class="col s12">

						<?php if (count($mpts) == 0) : ?>
							<div class="card-panel yellow darken-4 white-text">
								<h4 class="header">Aviso</h4>
								<p>Você não está em nenhum grupo de mensagem privada.</p>
							</div>
						<?php else : ?>
							<ul class="collection">
								<?php foreach ($mpts as $mpt) :
										$mpt = MPThreadDao::SelectMensagens($mpt, 'apenas_ultima'); ?>
									<li class="collection-item">

										<!-- Título da thread -->
										<span class="title orange-text text-darken-2">
											<b style="font-size: 1.5em;"><?= $mpt->titulo() ?></b>
										</span>

										<!-- Link para a thread -->
										<a href="mpt.php?id=<?= $mpt->getId() ?>" class="secondary-content">
											<i class="material-icons">send</i>
										</a>

										<!-- Última mensagem da thread -->
										<?php if (count($mpt->mensagens()) > 0) : ?>
											<p>
												<i class="orange-text text-darken-3">Última mensagem: </i>
												<b class="brown-text"><?= $mpt->mensagens()[0]->usuario()->getNome() ?>: </b>
												<i class="black-text"><?= $mpt->mensagens()[0]->texto() ?></i>
												<i class="grey-text right-align"> às
													<?= date("d/m/Y H:i:s", strtotime($mpt->mensagens()[0]->data_hora())) ?>
												</i>
											</p>
										<?php endif; ?>


									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>

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