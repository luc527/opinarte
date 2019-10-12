<!DOCTYPE html>
<?php
  $id = isset($_GET['id']) ? $_GET['id'] : '';
  include('valida_secao.php');
  if ($_SESSION['usuario_id'] != $id) {
    header("location:perfil.php?id=$id");
  }

  require_once('autoload.php');
  if ($id != '') {
    $usuario = UsuarioDao::SelectPorId($id);
  }
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Editar perfil</title>
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
      <a href="perfil.php?id=<?php echo $id; ?>" class="btn-flat waves-effect teal-text">
        <i class="material-icons left">keyboard_return</i>Voltar
      </a>

      <div class="card-panel hoverable">
        <form action="usuario_acao.php" method="post">

          <input type="hidden" name="id" value="<?php echo $usuario->getId(); ?>"/>

          <div class="row">
            <div class="col s12 input-field">
              <i class="material-icons prefix">photo</i>
              <label for="img_perfil">Imagem de perfil (URL)</label>
              <input value="<?php echo $usuario->getImgPerfil(); ?>"
              type="url" name="img_perfil" id="img_perfil"/>
            </div>
          </div>

          <div class="row">
            <div class="col s12 m6 input-field">
              <i class="material-icons prefix">mail</i>
              <label for="email">E-mail</label>
              <input value="<?php echo $usuario->getEmail(); ?>"
              type="email" name="email" id="email"/>
            </div>

            <div class="col s12 m6 input-field">
              <i class="material-icons prefix">calendar_today</i>
              <label for="data_nasc">Data de nascimento</label>
              <input value="<?php echo $usuario->getData_nasc(); ?>"
              type="date" name="data_nasc" id="data_nasc"/>
            </div>
          </div>

          <div class="row">
            <div class="col s12 input-field">
              <i class="material-icons prefix">face</i>
              <label for="sobre_mim">Sobre mim</label>
              <textarea class="materialize-textarea" name="sobre_mim" id="sobre_mim"><?php echo $usuario->getSobre_mim(); ?></textarea>
            </div>
          </div>

          <div class="row"> <div class="col s12"> <center>
            <button type="submit" name="acao" value="Update"
            class="btn waves-effect waves-light green">
              <i class="material-icons left">edit</i>Editar
            </button>
          </center> </div></div>
        </form>
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
