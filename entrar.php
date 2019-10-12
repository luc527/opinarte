<!DOCTYPE html>

<?php

require_once "autoload.php";

if (isset($_GET['erro'])) $erro = $_GET['erro'];
else if (isset($_POST['erro'])) $erro = $_POST['erro'];

if (isset($_GET['success'])) $success = $_GET['success'];
else if (isset($_POST['success'])) $success = $_POST['success'];

?>

<html>

<head>
	<title>Entrar</title>
	<meta charset="utf-8">
	
	<!-- Materialize -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
	<!-- Custom CSS -->
	<link type="text/css" rel="stylesheet" href="css/custom.css"/>
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

</head>

<body class="blue-grey lighten-5">
	<header>
		<?php Funcoes::PrintHeader('entrar'); ?>
	</header>

	<main>
		<div class="container">
			<div class="row">
				<div class="hide-on-small-only col m2"></div>

				<div class="col s12 m8">
					
					<form action="entrar_acao.php" method="post" class="card-panel hoverable">
						<div class="input-field">
							<i class="material-icons prefix">person</i>
							<input type="text" name="nome" id="nome">
							<label for="nome">Nome de usuário</label>
						</div>

						<div class="input-field">
							<i class="material-icons prefix">lock</i>
							<input type="password" name="senha" id="senha">
							<label for="senha">Senha</label>
						</div>

						<div class="center-align">
							<button type="submit" name="acao" value="Login" class="btn blue-grey darken-2 waves-effect waves-light">Entrar</button>
							<p>Ainda não se cadastrou? <a class="link" href="cadastre-se.php">Cadastre-se</a>.</p>
						</div>

						<?php
							if(isset($erro)) {
								echo "<div id='erro' class='card-panel z-depth-3 white-text red'>";
								echo "<b>Erro:</b> ";
								if ($erro == 'usuario_inexistente') {
									echo "o usuário informado não existe.";
								}
								else if ($erro == 'senha_incorreta') {
									echo "a senha informada está incorreta.";
								}
								echo "</div>";
							}

							if (isset($success)) {
								echo "<div id='success' class='card-panel z-depth-3 white-text green darken-3'>";
								echo "<b>Sucesso:</b> ";
								if ($success == 'cadastro_sucesso') {
									echo "o usuário foi cadastrado com sucesso.";
								}
								else if ($success == 'logoff') {
									echo "o logoff foi realizado com sucesso.";
								}
								echo "</div>";
							}
						?>
						
					</form>
				</div>
				
				<div class="hide-on-small-only col m2"></div>
			</div>
		</div>
	</main>

	<footer>
		<?php Funcoes::PrintFooter(); ?>
	</footer>

	<!-- Scripts -->
	<script type="text/javascript" src="js/jquery-3.4.1.js"></script> <!-- OBS: jQuery deve estar sempre acima -->
	<script type="text/javascript" src="js/materialize.min.js"></script>
	<!-- Materialize auto init -->
	<script type="text/javascript"> M.AutoInit(); </script>
</body>

</html>