<!DOCTYPE html>
<?php
include('valida_secao.php');
require_once('autoload.php');

$id = isset($_GET['id']) ? $_GET['id'] : '';
$title = 'Resenhas';
if ($id != '') {
  $usuario = UsuarioDao::SelectPorId($id);
  $usuario = UsuarioDao::SelectResenhas($usuario);
  $resenhas = $usuario->getResenhas();

  $title = $usuario->getNome()." - ".$title;
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
            <center><h3 class='brown-text'><b>Resenhas de <?php echo $usuario->getNome(); ?></b></h3></center>
          </div>
        </div>

        <ul class="collection">
          <?php foreach ($resenhas as $resenha) {
            $obra = $resenha->getObra();
            $artistas = ArtistaDao::SelectPorObra($obra);
            echo "<li class='collection-item'>

              <ul class='collection'>
                <li class='collection-item avatar'>";
                if ($obra->getImagemUrl() !== null) {
                  echo "<img class='circle materialboxed' src='".$obra->getImagemUrl()."'>";
                } else {
                  echo "<i class='material-icons circle blue darken-2'>photo</i>";
                }
                echo "<span class='title'>
                    <b class='cyan-text text-darken-2'>";
                    for ($i=0; $i < count($artistas); $i++) {
                      echo $artistas[$i]->getNome();
                      if ($i != count($artistas)-1) echo ", ";
                    }
                    echo "</b>

                    <b class='blue-text text-darken-2'>
                       - ".$obra->getNome()."
                    </b>
                  </span>
                  <a class='secondary-content' href='obra.php?id=".$obra->getId()."'>
                    <i class='material-icons'>send</i>
                  </a>
                </li>
              </ul>

              <div class='container'>
                <span class='title'>
                  <h6 class='indigo-text'><b>Resenha - ".$resenha->getDataHora()."</b>
                    <a class='secondary-content right' href='resenha.php?id=".$resenha->getId()."'>
                      <i class='material-icons'>send</i>
                    </a>
                  </h6>
                </span>

                <p class='indigo-text text-darken-2' align='justify'>
                  ".$resenha->getTexto()."
                </p>
              </div>

            </li>";
          } ?>
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
