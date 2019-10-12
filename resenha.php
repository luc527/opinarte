<!DOCTYPE html>
<?php
include('valida_secao.php');
require_once('autoload.php');

$id = isset($_GET['id']) ? $_GET['id'] : '';
if ($id != '') {
  $autor = ResenhaDao::SelectPorId($id); // a resenha vem atribuida ao usuario que a fez
  $resenha = $autor->getResenhas()[0]; // [0] porque é a única resenha que vem atribuida ao user
  $obra = $resenha->getObra();

  $autor = UsuarioDao::SelectPorId($autor->getId());
  $obra = ObraDao::SelectPorId($obra->getId());
}

function usuario_autor()
{
  return $_SESSION['usuario_id'] == $GLOBALS['autor']->getId();
}
?>
<html>

<head>
  <title>Resenha</title>
  <meta charset="utf=8">

  <!-- Materialize -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
  <!-- Custom CSS -->
  <link type="text/css" rel="stylesheet" href="css/custom.css" />
  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body class="indigo lighten-5">
  <header>
    <?php Funcoes::PrintHeader(); ?>
  </header>

  <main>
    <div class="container">
      <?php
      if (usuario_autor()) {
        echo "<a class='btn-flat teal-text waves-effect' href='resenha_cad.php?acao=Update&res_id=" . $id . "'>
          <i class='material-icons left'>edit</i>Editar
          </a>";
      } ?>
      <div class="card-panel hoverable">
        <div class="row">
          <div class="col s12">
            <center>
              <h4><b class='indigo-text'>Resenha</b></h4>
              <i class="indigo-text text-lighten-2">Publicada em <?php echo $resenha->getDataHora(); ?></i>
            </center>
          </div>
        </div>

        <div class="row">
          <div class="col s12 m6">
            <ul class="collection">
              <li class="collection-item avatar">
                <?php if ($autor->getImgPerfil() != null) {
                  echo "<img src='" . $autor->getImgPerfil() . "' class='circle'>";
                } else {
                  echo "<i class='circle brown material-icons'>person</i>";
                } ?>
                <span class="title">
                  <i class="brown-text text-darken-2">Autor: </i>
                  <b class="brown-text"><?php echo $autor->getNome(); ?></b>
                </span>
                <a class="secondary-content" href="perfil.php?id=<?php echo $autor->getId(); ?>">
                  <i class="material-icons">send</i>
                </a>
                <i class="truncate brown-text text-darken-2"><?php echo $autor->getSobre_mim(); ?></i>
              </li>
            </ul>
          </div>

          <div class="col s12 m6">
            <ul class="collection">
              <li class="collection-item avatar">
                <?php $artistas = ArtistaDao::SelectPorObra($obra);
                if ($obra->getImagemUrl() != null) {
                  echo "<img src='" . $obra->getImagemUrl() . "' class='circle materialboxed'>";
                } else {
                  echo "<i class='circle blue darken-2 material-icons'>photo</i>";
                } ?>
                <span class="title">
                  <i class="blue-text text-darken-4">Obra: </i>
                  <b class="cyan-text text-darken-2">
                    <?php for ($i = 0; $i < count($artistas); $i++) {
                      echo $artistas[$i]->getNome();
                      if ($i != count($artistas) - 1) echo ", ";
                    } ?>
                  </b>
                  <b class="blue-text darken-2"> - <?php echo $obra->getNome(); ?></b>
                </span>
                <a class="secondary-content" href="obra.php?id=<?php echo $obra->getId(); ?>">
                  <i class="material-icons">send</i>
                </a>
                <i class="truncate blue-text text-darken-2"><?php echo $obra->getDescricao(); ?></i>
              </li>
            </ul>
          </div>
        </div>

        <div class="row">
          <div class="col s12">
            <p class="container indigo-text text-darken-4">
              <?php echo $resenha->getTexto(); ?>
            </p>
          </div>
        </div>

        <div class="divider" style="margin: 2rem 0 2rem 0;"></div>

        <div class="row">
          <div class="col s12">
            <h5 class="indigo-text text-darken-2 center-align">
              <b>Comentários</b>
            </h5>

            <?php Funcoes::GerarComentariosHTML('resenha', $id); ?>
          </div>
        </div>
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
  <script type="text/javascript">
    M.AutoInit();
  </script>
</body>

</html>