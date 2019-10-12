<!DOCTYPE html>
<?php
	require_once('autoload.php');
	include('valida_secao.php');
	
	$title = 'Criar thread de mensagem privada';
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

<body class="orange lighten-5">
  <header><?php Funcoes::PrintHeader(); ?></header>

  <main>
		<div class="container">
			<div class="card-panel hoverable">

				<!-- Título (heading) da página -->
				<div class="row">
					<div class="col s12 center-align">
						<h4>
							<b class="orange-text text-darken-3">
								Criar <i>thread</i> de mensagem privada
							</b>
						</h4>
					</div>
				</div>

				<!-- Formulário para criar thread de MP (titulo e usuários) -->
				<form action="mpt_acao.php" method="post" class="row">
					<div class="input-field col s12">
						<i class="material-icons prefix">person</i>
						<label for="usuarios">Usuários (separar por ";" - exemplo: dude123; person66; max99; testman123)</label>
						<input type="text" name="usuarios" id="usuarios">
					</div>
					<div class="input-field col s12">
					<i class="material-icons prefix">title</i>
						<label for="titulo">Título</label>
						<input type="text" name="titulo" id="titulo">
					</div>
					<div class="input-field col s12 center-align">
						<button class="btn waves-effect waves-light orange darken-3"
						type="submit" name="acao" id="acao" value="CriarMPT">
							<i class="material-icons left">send</i>
							Criar
						</button>
					</div>
					<input type="hidden" name="autor" id="autor" value="<?php echo $_SESSION['usuario_id']; ?>">
				</form>

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