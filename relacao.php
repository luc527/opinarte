<!DOCTYPE html>
<?php
include('valida_secao.php');
require_once('autoload.php');
$title = 'Relação';

$id = isset($_GET['id']) ? $_GET['id'] : '';
$rel = RelacaoDao::SelectPorId($id);
$obj[1] = $rel->getObj1();
$obj[2] = $rel->getObj2();

for ($i = 1; $i <= 2; $i++) {
  if ($obj[$i] instanceof Obra) {
    $icon[$i] = 'photo';
    $color[$i] = 'blue';
    $link[$i] = 'obra.php';
    $hasAvatar[$i] = ' avatar ';
  } else if ($obj[$i] instanceof Artista) {
    $icon[$i] = 'person';
    $color[$i] = 'cyan';
    $link[$i] = 'artista.php';
    $hasAvatar[$i] = ' avatar ';
  } else if ($obj[$i] instanceof Genero) {
    $color[$i] = 'light-green';
    $link[$i] = 'genero.php';
    $hasAvatar[$i] = '  ';
  }

  if (isset($icon[$i])) {
    if ($obj[$i]->getImagemUrl() !== null) {
      $avatar[$i] = "<img class='materialboxed circle' src='" . $obj[$i]->getImagemUrl() . "' />";
    } else {
      $avatar[$i] = "<i class='material-icons circle 
      " . $color[$i] . " darken-2'>" . $icon[$i] . "</i>";
    }
  } else {
    $avatar[$i] = "";
  }
}

function usuario_dono($rel_id, $user_logado)
{
  $query = Conexao::getInstance()->query("SELECT usuario_id FROM relacao WHERE id_relacao = $rel_id");
  $row = $query->fetch(PDO::FETCH_ASSOC);
  return $user_logado == $row['usuario_id'];
}
$usuario_dono = usuario_dono($id, $_SESSION['usuario_id']);

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

<body class="teal lighten-5">
  <header><?php Funcoes::PrintHeader(); ?></header>


  <main>
    <div class="container">

      <?php if ($usuario_dono) : ?>
        <a class="btn-flat teal-text waves-effect" href="relacao_edit.php?id=<?php echo $id; ?>">
          <i class="material-icons left">edit</i>
          Editar relação
        </a>
      <?php endif; ?>

      <div class="card-panel hoverable">

        <div class="row">
          <div class="col s12">
            <center>
              <h4><b class="teal-text">
                  Relação
                </b></h4>
            </center>
          </div>
        </div>

        <div class="row">
          <div class="col s12">
            <ul class="collection">
              <li class="collection-item teal lighten-5">

                <div class="row">
                  <?php for ($i = 1; $i <= 2; $i++) : ?>
                    <div class="col s12 m6">
                      <ul class="collection">
                        <li class="collection-item <?php echo $hasAvatar[$i]; ?>">
                          <?php echo $avatar[$i]; ?>
                          <span class="title">
                            <b class="<?php echo $color[$i]; ?>-text text-darken-2">
                              <?php echo $obj[$i]->getNome(); ?>
                            </b>
                          </span>
                          <a class="secondary-content" href="<?php echo $link[$i] ?>?id=<?php echo $obj[$i]->getId(); ?>">
                            <i class="material-icons">send</i>
                          </a>
                          <i class="truncate <?php echo $color[$i] ?>-text text-darken-4">
                            <?php echo $obj[$i]->getDescricao(); ?>
                          </i>
                        </li>
                      </ul>
                    </div>
                  <?php endfor; ?>
                </div>

                <div class="row">
                  <div class="col s12">
                    <ul class="collection">
                      <li class="collection-item center-align">
                        <b class="blue-grey-text text-darken-2">
                          <?php echo $rel->getDescricao(); ?>
                        </b>
                      </li>
                      <li class="collection-item">
                        <b class="blue-grey-text">Fontes: </b>
                        <i class="blue-grey-text text-darken-2">
                          <?php echo $rel->getFontes(); ?>
                        </i>
                      </li>
                    </ul>
                  </div>
                </div>

              </li>
            </ul>
          </div>
        </div>

      </div>

      <!-- Comentários -->

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