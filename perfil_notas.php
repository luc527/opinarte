<!DOCTYPE html>
<?php
require_once('autoload.php');
include('valida_secao.php');
include('perfil_notas_grafico.php');

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
            <b> Notas de <?php echo $usuario->getNome(); ?> </b>
          </h3> </center>
        </div> </div>

        <div class="row"> <div class="col s12">
          <?php
            $notas_cnt = UsuarioDao::SelectNotas_count($usuario->getId());
            gerarGrafico($notas_cnt, $usuario->getNome()); // funcao em perfil_notas_grafico.php
          ?>
        </div> </div>

        <div class="row ">
          <ul class="tabs center-align">
            <?php for ($i=1; $i <= 10; $i++) {
              echo "<li class='tab'><a href='#nota".$i."'>".$i."</a></li>";
            } ?>
          </ul>

          <?php
            for ($i=1; $i <= 10; $i++) {
              echo "<div id='nota".$i."'>";
                $notas[$i] = UsuarioDao::SelectNotas_porNota($id, $i);
                echo "<ul class='collection'>";
                  for ($j=0; $j < count($notas[$i]); $j++) {
                    $obra = ObraDao::SelectPorId( $notas[$i][$j]->getObra()->getId() );
                    $img = $obra->getImagemUrl();
                    $artistas = ArtistaDao::SelectPorObra($obra);

                    echo "<li class='collection-item avatar'> <div class='row'>
                      <div class='col s8'>";
                        if(isset($img)) {
                          echo "<img class='circle' src='".$obra->getImagemUrl()."'>";
                        } else {
                          echo "<i class='materialboxed circle blue material-icons'>photo</i>";
                        }

                        // TÍTULO
                        echo "<span class='title'> <b class='cyan-text text-darken-2'>";
                        for ($k=0; $k < count($artistas); $k++) {
                          echo $artistas[$k]->getNome();
                          if ($k != count($artistas)-1) echo ", ";
                        }
                        echo " - </b> <b class='blue-text text-darken-2'>
                        ".$obra->getNome()."</b>";
                        echo "</span>


                      </div>";

                      echo "<a class='secondary-content' href='obra.php?id=".$obra->getId()."'>
                        <i class='material-icons'>send</i>
                      </a>";

                      echo "<div class='col s4'>
                        <b style='font-size:1.5em'
                        class='large blue-grey-text text-darken-2'>
                        ".$notas[$i][$j]->getNota()."</b>
                      </div>";

                    echo "</div> </li>";
                  }
                echo "</ul>";
              echo "</div>";
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
