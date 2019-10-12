<!DOCTYPE HTML>
<?php
include('valida_secao.php');
require_once('autoload.php');

$title = 'Favoritos';
$id = isset($_GET['id']) ? $_GET['id'] : '';
if ($id != '') {
  $usuario = UsuarioDao::SelectPorId($id);

  $usuario = UsuarioDao::SelectObrasFav($usuario);
  $usuario = UsuarioDao::SelectArtistasFav($usuario);
  $obras_fav = $usuario->getObras_fav();
  $artistas_fav = $usuario->getArtistas_fav();

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
      <a class="btn-flat waves-effect teal-text" href="perfil.php?id=<?php echo $id; ?>">
        <i class="material-icons left">keyboard_return</i> Voltar
      </a>
      <div class="card-panel hoverable">
        <div class="row"> <div class="col s12">
          <center> <h3> <b class="brown-text">Favoritos de <?php echo $usuario->getNome(); ?> </b> </h3> </center>
        </div> </div>

        <div class="row">
          <div class="col s12">
            <ul class="tabs">
              <li class='tab col s6'><a href="#obras">Obras</a></li>
              <li class='tab col s6'><a href="#artistas">Artistas</a></li>
            </ul>
          </div>

          <div id="obras" class="col s12">
            <ul class="collection">
              <?php for ($i=0; $i < count($obras_fav); $i++) {
                $artistas = ArtistaDao::SelectPorObra($obras_fav[$i]);

                echo "<li class='collection-item avatar'>";
                  if ($obras_fav[$i]->getImagemUrl() !== null) {
                    echo "<img class='circle materialboxed' src='".$obras_fav[$i]->getImagemUrl()."'>";
                  } else {
                    echo "<i class='material-icons circle blue darken-2'>photo</i>";
                  }
                  echo "<div class='row'>
                    <div class='col s8'>
                      <span class='title'>
                        <b class='cyan-text text-darken-2'>";
                        for ($j=0; $j < count($artistas); $j++) {
                          echo $artistas[$j]->getNome();
                          if ($j != count($artistas)-1) echo ", ";
                        }
                        echo "</b>

                        <b class='blue-text text-darken-2'> - ".$obras_fav[$i]->getNome()."</b>
                      </span>
                    </div>

                    <a class='secondary-content' href='obra.php?id=".$obras_fav[$i]->getId()."'>
                      <i class='material-icons'>send</i>
                    </a>

                    <div class='col s4'>
                      <i class='material-icons small yellow-text text-darken-3'>star</i>
                    </div>
                  </div>
                </li>";
              } ?>
            </ul>
          </div>



          <div id="artistas" class="col s12">
            <ul class="collection">
              <?php for ($i=0; $i < count($artistas_fav); $i++) {
                echo "<li class='collection-item avatar'>";
                  if ($artistas_fav[$i]->getImagemUrl() !== null) {
                    echo "<img class='circle materialboxed' src='".$artistas_fav[$i]->getImagemUrl()."'>";
                  } else {
                    echo "<i class='material-icons circle cyan darken-2'>person</i>";
                  }
                  echo "<div class='row'>
                    <div class='col s8'>
                      <span class='title'>
                        <b class='cyan-text text-darken-2'>".$artistas_fav[$i]->getNome()."</b>
                      </span>
                    </div>

                    <a class='secondary-content' href='artista.php?id=".$artistas_fav[$i]->getId()."'>
                      <i class='material-icons'>send</i>
                    </a>

                    <div class='col s4'>
                      <i class='material-icons small yellow-text text-darken-3'>star</i>
                    </div>
                  </div>
                </li>";
              } ?>
            </ul>
          </div>
        </div>


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
