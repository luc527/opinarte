<!DOCTYPE html>
<?php
require_once('autoload.php');
include('valida_secao.php');

$id = isset($_GET['id']) ? $_GET['id'] : '';

$usuario = '';
$erro = '';
$title = 'Perfil';

if ($id != '') {
  if ($_SESSION['usuario_id'] == $id) $usuario_dono = true;
  else $usuario_dono = false;

  $usuario = UsuarioDao::SelectPorId($id);
  $title .= " de ".$usuario->getNome();

  $notas = array();
} else {
  $erro = "Código não informado";
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

    <main>
      <div class="container">
      <a class="teal-text btn-flat waves-effect" href="perfil.php?id=<?php echo $id; ?>">
        <i class="material-icons left">keyboard_return</i> Voltar
      </a>

      <div class="card-panel hoverable">
        <div class="row"> <div class="col s12">
          <center> <h3 class="brown-text">
            <b> Relações com obras de <?php echo $usuario->getNome(); ?> </b>
          </h3> </center>
        </div> </div>

        <div class="row ">
          <ul class="tabs center-align">
            <?php

              $relacoes = array('Desejo','Atual','Completa');
              $cor = array('orange-text','green-text','blue-text');

              for ($i=0; $i < count($relacoes); $i++) {
                echo "<li class='tab col s4'> <a href='#".$relacoes[$i]."'>".$relacoes[$i]."</a> </li>";
              }

            ?>
          </ul>

          <?php
            for ($i=0; $i < count($relacoes); $i++) {
              $obras = UsuarioDao::SelectObrasRel_porTipo($usuario->getId(), $relacoes[$i]);

              echo "<div id='".$relacoes[$i]."'>
              <ul class='collection'>";

                for ($j=0; $j < count($obras); $j++) {
                  $artistas = ArtistaDao::SelectPorObra($obras[$j]);
                  $img = $obras[$j]->getImagemUrl();

                  echo "<li class='collection-item avatar'>";
                  echo "<div class='row'>";
                    echo "<div class='col s8'>";
                      if ($img != '') {
                        echo "<img class='circle materialboxed' src='".$obras[$j]->getImagemUrl()."'>";
                      } else {
                        echo "<i class='material-icons blue circle'>photo</i>";
                      }
                      echo "<span class='title'> <b class='cyan-text text-darken-2'>";
                      for ($k=0; $k < count($artistas); $k++) {
                        echo $artistas[$k]->getNome();
                        if ($k != count($artistas)-1) echo ", ";
                      }
                      echo " - </b> <b class='blue-text text-darken-2'>
                      ".$obras[$j]->getNome()."</b>";
                      echo "</span>";
                    echo "</div>

                    <a class='secondary-content' href='obra.php?id=".$obras[$j]->getId()."'>
                      <i class='material-icons'>send</i>
                    </a>

                    <div class='col s4'>
                      <i class='material-icons ".$cor[$i]." small'>
                      link person</i>";

                    echo "</div>";
                  echo "</div>";
                }

              echo "</ul>
              </div>";
            }
          ?>


        </div>
      </div> </div>
    </main>

    <footer><?php Funcoes::PrintFooter(); ?></footer>
  	<!-- Scripts -->
  	<script type="text/javascript" src="js/jquery-3.4.1.js"></script> <!-- OBS: jQuery deve estar sempre acima -->
  	<script type="text/javascript" src="js/materialize.min.js"></script>
  	<!-- Materialize auto init -->
  	<script type="text/javascript"> M.AutoInit(); </script>
  </body>
</html>
