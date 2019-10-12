<!DOCTYPE html>
<html>

<head>
	<title>Opinarte</title>
	<meta charset="utf-8">

	<!-- Materialize -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
	<link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
	<!-- Custom CSS -->
	<link type="text/css" rel="stylesheet" href="css/custom.css" />
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
	<header class="navbar-fixed">
		<nav class="blue-grey darken-2">
			<div class="nav-wrapper container">
				<b class="brand-logo">Opinarte</b>
				<a href="#" data-target="mobile-nav" class="sidenav-trigger"><i class="material-icons">menu</i></a>
				<ul class="right hide-on-med-and-down">
					<li><a href="cadastre-se.php"><i class="material-icons left">add</i>Cadastre-se</a></li>
					<li><a href="entrar.php"><i class="material-icons left">person</i>Entrar</a></li>
				</ul>
			</div>
		</nav>
		<ul class="sidenav" id="mobile-nav">
			<li><a href="cadastre-se.php"><i class="material-icons left">add</i>Cadastre-se</a></li>
			<li><a href="entrar.php"><i class="material-icons left">person</i>Entrar</a></li>
		</ul>
	</header>

	<main>

		<div class="parallax-container">
			<div class="parallax"><img src="img/vinyl.jpg" alt="Disco de vinil"></div>
		</div>
		<div class="section white">
			<div class="row container">
				<h2 class="header blue-grey-text">Opinarte</h2>
				<p class="flow-text grey-text text-darken-3">
					Opinarte é uma plataforma para discussão e compartilhamento de opiniões sobre arte. Juntamos no nome, inclusive, opinar e arte. Nela você encontrará uma forma especial de se relacionar com o mundo da arte.
				</p>
			</div>
		</div>
		<div class="parallax-container">
			<div class="parallax"><img src="img/books.jpg" alt="Book collection"></div>
		</div>
		<div class="section white">
			<div class="row container">
				<h2 class="header blue-grey-text">Todas as linguagens</h2>
				<p class="flow-text grey-text text-darken-3">
					Opinarte não tem foco em apenas uma linguagem, mas mantém informações sobre quaisquer linguagens; música, literatura, cinema, pintura...
				</p>
			</div>
		</div>
		<div class="parallax-container">
			<div class="parallax"><img src="img/handwriting.jpg" alt="Manuscrito"></div>
		</div>
		<div class="section white">
			<div class="row container">
				<h2 class="header blue-grey-text">Escreva sobre arte</h2>
				<p class="flow-text grey-text text-darken-3">
					No Opinarte, é possível escrever resenhas sobre obras e montar listas (top 10s e afins), fornecendo a você, assim, um meio de se expressar sobre suas experências com a arte. Você pode, ainda, ler o que outros usuários escreveram como meio de obter informações adicionais e pessoais sobre certas obras.
				</p>
			</div>
		</div>
		<div class="parallax-container">
			<div class="parallax"><img src="img/vinyl-collection.jpg" alt="Coleção de vinil"></div>
		</div>
		<div class="section white">
			<div class="row container">
				<h2 class="header blue-grey-text">Catálogo pessoal</h2>
				<p class="flow-text grey-text text-darken-3">
					Você pode, ainda, manter um catálogo e um histórico pessoal. Marque quais livros deseja ler, que álbuns está ouvindo e que filmes já assistiu. Avalie-os com notas de 1 a 10. Adicione obras e artistas a seus favoritos.
				</p>
			</div>
		</div>
		<div class="parallax-container">
			<div class="parallax"><img src="img/conversation.png" alt="Pessoas conversando"></div>
		</div>
		<div class="section white">
			<div class="row container">
				<h2 class="header blue-grey-text">Interaja com outros usuários</h2>
				<p class="flow-text grey-text text-darken-3">
					Por fim, você pode interagir com outros usuários. Comente nas páginas de obras, artistas, gêneros, resenhas etc. Crie e participe de grupos de mensagens privadas. Adicione outros usuários como amigos.
				</p>
			</div>
			<div class="row container center-align">
				<a class="btn blue-grey btn-large waves-effect waves-light" href="cadastre-se.php">
					<i class="material-icons left">person</i>
					Cadastre-se
				</a>
			</div>
			<div class="row center-align">
				Já possui uma conta? <a class="link" href="entrar.php">entre</a>.
			</div>
		</div>

	</main>

	<footer class="page-footer blue-grey darken-2">
		<div class="container">
			<div class="row">
				<div id="foooter" class="col s12 grey-text text-lighten-4">
					<h5 class="header">Fontes das imagens</h5>
					<li><a class="white-text link" href="https://www.virginmegastore.ae/lp/edit/start-vinyl-collection">Virginmegastore</a></li>
					<li><a class="white-text link" href="https://en.wikipedia.org/wiki/Great_Books_of_the_Western_World">Wikipedia</a></li>
					<li><a class="white-text link" href="https://www.noticebard.com/world-handwriting-competition/">Noticebard</a></li>
					<li><a class="white-text link" href="http://www.collectorsroom.com.br/2011/03/minha-colecao-conheca-o-acervo-de.html">Collectorsroom</a></li>
					<li><a class="white-text link" href="https://wrightoncomm.com/rediscover-the-lost-art-of-conversation/">Wrightoncomm</a></li>
				</div>
			</div>
		</div>
		<div class="footer-copyright blue-grey darken-4">

		</div>
	</footer>

	<!-- Scripts -->
	<script type="text/javascript" src="js/jquery-3.4.1.js"></script> <!-- OBS: jQuery deve estar sempre acima -->
	<script type="text/javascript" src="js/materialize.min.js"></script>
	<!-- Materialize auto init -->
	<script type="text/javascript">
		M.AutoInit();
	</script>
</body>

</html>