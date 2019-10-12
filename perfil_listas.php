<!DOCTYPE html>
<?php
include('valida_secao.php');
require_once('autoload.php');

$id = isset($_GET['id']) ? $_GET['id'] : '';
$title = 'Listas';
if ($id != '') {
  $usuario = UsuarioDao::SelectPorId($id);
  $usuario = UsuarioDao::SelectListas($usuario);
  $listas = $usuario->listas();

  $title = $title." de ".$usuario->getNome();
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

  <body class="brown lighten-5">
    <header><?php Funcoes::PrintHeader(); ?></header>

    <main> <div class="container">
      <a class="teal-text btn-flat waves-effect" href="perfil.php?id=<?php echo $id; ?>">
        <i class="material-icons left">keyboard_return</i> Voltar
      </a>

      <div class="card-panel hoverable">
        <div class="row">
          <div class="col s12">
            <center><h3 class='brown-text'><b><?php echo $title; ?></b></h3></center>
          </div>
        </div>

        <ul class="collection">
          <?php foreach ($listas as $lista): ?>
            <li class="collection-item">
              <span class="title"><b class="purple-text">
                <?php echo $lista->getNome(); ?>
              </b></span>

              <a href="lista.php?id=<?php echo $lista->getId(); ?>" class="secondary-content">
                <i class="material-icons">send</i>
              </a>

              <i class="truncate purple-text text-darken-2">
                <?php echo $lista->getDescricao(); ?>
              </i>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div> </main>

    <footer><?php Funcoes::PrintFooter(); ?></footer>

  	<!-- Scripts -->
  	<script type="text/javascript" src="js/jquery-3.4.1.js"></script> <!-- OBS: jQuery deve estar sempre acima -->
  	<script type="text/javascript" src="js/materialize.min.js"></script>
  	<!-- Materialize auto init -->
  	<script type="text/javascript"> M.AutoInit(); </script>
  </body>
</html>
