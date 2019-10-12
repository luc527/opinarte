<!DOCTYPE html>

<?php


require_once "autoload.php";

if (isset($_POST['erro'])) $erro = $_POST['erro'];
else if (isset($_GET['erro'])) $erro = $_GET['erro'];

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
		<?php Funcoes::PrintHeader(); ?>
	</header>

	<main>
		<div class="container">
			<div class="row">
				<div class="hide-on-small-only col m1"></div>

				<div class="col s12 m10">

					<form action="cadastre-se_acao.php" method="post" class="card-panel">
						<div class="row">
							<div class="col s12 m6">
								<div class="input-field">
									<i class="material-icons prefix">person</i>
									<input type="text" name="nome" id="nome" required>
									<label for="nome">Nome de usuário</label>
								</div>
							</div>

							<div class="col s12 m6">
								<div class="input-field">
									<i class="material-icons prefix">lock</i>
									<input type="password" name="senha" id="senha" required>
									<label for="senha">Senha</label>
								</div>
							</div>

							<div class="col s12 m6">
								<div class="input-field">
									<i class="material-icons prefix">calendar_today</i>
									<input type="date" name="data_nasc" id="data_nasc" required>
									<span class="helper-text">Data de nascimento</label>
								</div>
							</div>

							<div class="col s12 m6">
								<div class="input-field">
									<i class="material-icons prefix">email</i>
									<input type="email" name="email" id="email" required>
									<label for="email">E-mail</label>
								</div>
							</div>

							<div class="col s12">
								<div class="input-field">
									<i class="material-icons prefix">sentiment_very_satisfied</i>
									<textarea name="sobre_mim" id="sobre_mim" class="materialize-textarea" placeholder="Escreva um pouco sobre você!"></textarea>
									<label for="sobre_mim">Sobre mim (Opcional)</label>
								</div>
							</div>


						</div>

						<div class="center-align">
							<?php
							if(isset($erro)) {
								echo "<div id='erro' class='card-panel z-depth-3 red white-text'>";
								echo "<b>Erro:</b> ";
								if ($erro == 'nome_em_uso') {
									echo "o nome digitado já está em uso.";
								}
								echo "</div>";
							}
						?>

							<button type="submit" name="acao" value="Inserir" class="btn blue-grey darken-2 waves-effect waves-light">Cadastrar</button>
							<p>Já se cadastrou? <a class="link" href="entrar.php">Entre em sua conta</a>.</p>
						</div>
					</form>

				</div>

				<div class="hide-on-small-only col m1"></div>
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
