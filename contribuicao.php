<!DOCTYPE html>
<?php
include('valida_secao.php');
require_once('autoload.php');

if (isset($_POST['id'])) $id = $_POST['id'];
else if (isset($_GET['id'])) $id = $_GET['id'];
else $id = '';
// se o usuário logado é ou não o autor dessa contribuição -- p/ mostra ou não o "editar lista"
$usuario_autor = ContribuicaoDao::UsuarioAutor($_SESSION['usuario_id'], $id);

$con = ContribuicaoDao::SelectPorId($id);

$title = 'Contribuição';

$autor = UsuarioDao::SelectPorContribuicao($con->getId());
if ($autor->getImgPerfil() !== null) {
  $avatar_autor = "<img class='materialboxed circle' src='" . $autor->getImgPerfil() . "' />";
} else {
  $avatar_autor = "<i class='material-icons circle brown'>person</i>";
}

$con_avaliada = ContribuicaoDao::ConAvaliada($con->getId());
if ($con_avaliada) {
  $adm_avaliador = UsuarioDao::SelectADMPorContribuicao($con->getId());
  if ($adm_avaliador->getImgPerfil() !== null) {
    $avatar_adm = "<img class='materialboxed circle' src='" . $adm_avaliador->getImgPerfil() . "' />";
  } else {
    $avatar_adm = "<i class='material-icons circle brown'>person</i>";
  }
}

if ($con->getObj() !== null) {
  $obj = $con->getObj();
  if ($obj instanceof Obra) {
    $obj = ObraDao::SelectPorId($obj->getId());
    $link_obj = "obra.php";
    $cor_obj = "blue";
    $ico_obj = "photo";
  } else if ($obj instanceof Artista) {
    $obj = ArtistaDao::SelectPorId($obj->getId());
    $link_obj = "artista.php";
    $cor_obj = "cyan";
    $ico_obj = "person";
  } else if ($obj instanceof Genero) {
    $obj = GeneroDao::SelectPorId($obj->getId());
    $link_obj = "genero.php";
    $cor_obj = "light-green";
  } else if ($obj instanceof LingArte) {
    $obj = LingArteDao::SelectPorId($obj->getId());
    $link_obj = "lingArte.php";
    $cor_obj = "lime";
  }

  if ($obj instanceof Obra || $obj instanceof Artista) {
    $hasAvatar = " avatar ";
    if ($obj->getImagemUrl() !== null) {
      $avatar_obj = "<img class='materialboxed circle' src='" . $obj->getImagemUrl() . "' />";
    } else {
      $avatar_obj = "<i class='material-icons circle " . $cor_obj . " darken-2'>" . $ico_obj . "</i>";
    }
  } else {
    $hasAvatar = "";
  }
}
?>
<html>

<head>
  <title><?php echo $title; ?></title>
  <meta charset="utf-8">
  <!-- Materialize -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
  <!-- Custom CSS -->
  <link type="text/css" rel="stylesheet" href="css/custom.css" />
  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body class="blue-grey lighten-5">
  <header><?php Funcoes::PrintHeader(); ?></header>

  <main>
    <div class="container">
      <?php if ($_SESSION['usuario_tipo'] == 1) : ?>
        <a href="contribuicao_aval.php?id=<?php echo $id; ?>" class="btn-flat teal-text waves-effect">
          <i class="material-icons left">gavel</i>
          Avaliar
        </a>
      <?php endif; ?>
      <div class="card-panel hoverable">

        <div class="row">
          <div class="col s12 center-align">
            <h3>
              <b class="blue-grey-text text-darken-2">
                <?php echo $title; ?>
              </b>
            </h3>
          </div>
        </div>

        <div class="row">
          <div class="col s12">

            <ul class="collection">
              <!-- Autor da contribuição -->
              <li class="collection-item avatar">
                <?php echo $avatar_autor; ?>
                <span class="title brown-text">
                  <b class="brown-text text-darken-2">Autor: </b>
                  <i class="brown-text text-darken-4">
                    <?php echo $autor->getNome(); ?>
                  </i>
                </span>
                <a href="perfil.php?id=<?php echo $autor->getId(); ?>" class="secondary-content">
                  <i class="material-icons">send</i>
                </a>
                <i class="truncate brown-text text-darken-4">
                  <?php echo $autor->getSobre_mim(); ?>
                </i>
              </li>
              <!-- Tipo de contribuição -->
              <li class="collection-item">
                <b class="blue-grey-text text-darken-2">Tipo de contribuição: </b>
                <i class="blue-grey-text text-darken-4">
                  <?php echo $con->getTipo()->getNome(); ?>
                </i>
              </li>
              <!-- Objeto da contribuição -->
              <?php if ($con->getObj() !== null) : ?>
                <li class="collection-item <?php echo $hasAvatar; ?>">
                  <?php echo $avatar_obj; ?>
                  <span class="title">
                    <b class="blue-grey-text text-darken-2">Objeto da contribuição: </b>
                    <i class="<?php echo $cor_obj; ?>-text text-darken-4">
                      <?php echo $obj->getNome(); ?>
                    </i>
                  </span>
                  <a class="secondary-content" href="<?php echo $link_obj; ?>?id=<?php echo $obj->getId(); ?>">
                    <i class="material-icons">send</i>
                  </a>
                  <i class="truncate <?php echo $cor_obj; ?>-text text-darken-4">
                    <?php echo $obj->getDescricao(); ?>
                  </i>
                </li>
              <?php endif; ?>
              <li class="collection-item">
                <b class="blue-grey-text text-darken-2">Informação contribuída: </b>
                <i class="blue-grey-text text-darken-4">
                  <?php echo $con->getInformacao(); ?>
                </i>
              </li>
              <li class="collection-item">
                <b class="blue-grey-text text-darken-2">Fonte(s) da informação: </b>
                <i class="blue-grey-text text-darken-4">
                  <?php echo $con->getFontes(); ?>
                </i>
              </li>
            </ul>

            <ul class="collection with-header">
              <li class="collection-item header">
                <h5><b class="blue-grey-text text-darken-2">Avaliação</b></h5>
              </li>
              <!-- Estado da informação -->
              <li class="collection-item">
                <b class="blue-grey-text text-darken-2">Estado: </b>
                <i class="blue-grey-text text-darken-4">
                  <?php echo $con->getEstado()->getNome(); ?>
                </i>
              </li>
              <!-- Avaliação da contribuição -->
              <?php if ($con_avaliada) : ?>
                <!-- Administrador que avaliou -->
                <li class="collection-item avatar">
                  <?php echo $avatar_adm; ?>
                  <span class="title brown-text">
                    <b class="brown-text text-darken-2">Avaliador: </b>
                    <i class="brown-text text-darken-4">
                      <?php echo $adm_avaliador->getNome(); ?>
                    </i>
                  </span>
                  <a href="perfil.php?id=<?php echo $adm_avaliador->getId(); ?>" class="secondary-content">
                    <i class="material-icons">send</i>
                  </a>
                  <i class="truncate brown-text text-darken-4">
                    <?php echo $adm_avaliador->getSobre_mim(); ?>
                  </i>
                </li>
                <!-- Comentário do administrador -->
                <li class="collection-item">
                  <b class="blue-grey-text text-darken-2">Comentário do avaliador: </b>
                  <i class="blue-grey-text text-darken-4">
                    <?php echo $con->getComentario(); ?>
                  </i>
                </li>
              <?php endif; ?>
            </ul>
          </div>
          <?php if ($usuario_autor) : ?>
            <div class="col s12 right-align">
              <a class="btn red waves-effect waves-light"
              href="contribuicao_acao.php?acao=Delete&id=<?php echo $id; ?>">
                <i class="material-icons left">delete</i>
                Deletar
              </a>
            </div>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </main>

  <footer><?php Funcoes::PrintFooter(); ?></footer>

  <!-- Scripts -->
  <script type="text/javascript" src="js/jquery-3.4.1.js"></script> <!-- OBS: jQuery deve estar sempre acima -->
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <!-- Materialize auto init -->
  <script type="text/javascript">
    M.AutoInit();
  </script>
</body>

</html>