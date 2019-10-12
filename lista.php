<!DOCTYPE html>
<?php
include('valida_secao.php');
require_once('autoload.php');

if (isset($_POST['id'])) $id = $_POST['id'];
else if (isset($_GET['id'])) $id = $_GET['id'];
else $id = '';
// se o usuário logado é ou não o autor dessa lista -- p/ mostra ou não o "editar lista"
$usuario_dono = ListaDao::UsuarioAutor($_SESSION['usuario_id'], $id);
$title = 'Lista';

$lista = ListaDao::SelectPorId($id);
$lista = ListaDao::SelectItens($lista);
$itens = $lista->itens();

$autor = UsuarioDao::SelectPorLista($lista->getId());
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

<body class="purple lighten-5">
  <header><?php Funcoes::PrintHeader(); ?></header>

  <main>
    <div class="container">
      <?php if ($usuario_dono) : ?>
        <a href="lista_edit.php?id=<?php echo $id; ?>" class="btn-flat teal-text waves-effect">
          <i class="material-icons left">edit</i>
          Editar lista
        </a>
      <?php endif; ?>
      <div class="card-panel hoverable">
        <div class="row">
          <div class="col s12">
            <center>
              <h4><b class="purple-text text-darken-2">
                  <?php echo $lista->getNome(); ?>
                </b></h4>
            </center>
          </div>
        </div>

        <?php if ($autor->getImgPerfil() !== null) :
          $autor_avatar = "<img class='circle materialboxed' src='" . $autor->getImgPerfil() . "' />";
        else :
          $autor_avatar = "<i class='material-icons circle brown darken-2'>person</i>";
        endif; ?>
        <div class="row">
          <div class="col s12">
            <ul class="collection">
              <li class="collection-item avatar">
                <?php echo $autor_avatar; ?>
                <span class="title">
                  <i class="brown-text text-darken-4">Autor: </i>
                  <b class="brown-text text-darken-2"><?php echo $autor->getNome(); ?></b>
                </span>
                <a class="secondary-content" href="perfil.php?id=<?php echo $autor->getId(); ?>">
                  <i class="material-icons">send</i>
                </a>
                <i class="truncate brown-text text-darken-2"><?php echo $autor->getSobre_mim(); ?></i>
              </li>
              <li class="collection-item">
                <i class="blue-grey-text text-darken-2">Data de publicação/edição:</i>
                <b class="blue-grey-text"><?php echo $lista->datahr(); ?></b>
              </li>
              <li class="collection-item">
                <i class="blue-grey-text text-darken-2">Descrição: </i>
                <b class="blue-grey-text"><?php echo $lista->getDescricao(); ?></b>
              </li>
            </ul>
          </div>
        </div>

        <div class="card-panel hoverable">
          <div class="row">
            <div class="col s12">
              <center>
                <h4><b class="purple-text text-darken-2">
                    Itens
                  </b></h4>
              </center>
            </div>
          </div>

          <div class="row">
            <div class="col s12">
              <ul class="collection">
                <?php foreach ($itens as $lista_item) :
                  $item = $lista_item->item(); //$lista_item =instanceof ListaItem, item() =instanceof Artista ou Obra
                  if ($item instanceof Obra) :
                    $cor = 'blue';
                    $ico = 'photo';
                    $link = 'obra.php';
                  elseif ($item instanceof Artista) :
                    $cor = 'cyan';
                    $ico = 'person';
                    $link = 'artista.php';
                  endif;

                  if ($item->getImagemUrl() !== null) :
                    $avatar_item = "<img class='circle materialboxed' src='" . $item->getImagemUrl() . "'/>";
                  else :
                    $avatar_item = "<i class='material-icons circle " . $cor . "'>" . $ico . "</i>";
                  endif; ?>

                  <li class="collection-item avatar">
                    <?php echo $avatar_item; ?>
                    <span class='title'>
                      <b class="blue-grey-text text-darken-2" style="font-size: 1.5em;">
                        <?php echo $lista_item->posicao(); ?>º
                      </b>
                      <b class="<?php echo $cor ?>-text text-darken-2">
                        <?php echo $item->getNome(); ?>
                      </b>
                    </span>

                    <a class="secondary-content" href="<?php echo $link ?>?id=<?php echo $item->getId(); ?>">
                      <i class="material-icons">send</i>
                    </a>

                    <i class="truncate <?php echo $cor ?>-text text-darken-4">
                      <?php echo $item->getDescricao(); ?>
                    </i>

                    <?php if ($lista_item->getDescricao() != '') : ?>
                      <ul class="collection">
                        <li class="collection-item">
                          <?php echo $lista_item->getDescricao(); ?>
                        </li>
                      </ul>
                    <?php endif; ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>

        <div class="divider" style="margin: 2rem 0 2rem 0;"></div>

        <div class="row">
          <div class="col s12">
            <h5 class="center-align">
              <b class="purple-text text-darken-2">Comentários</b>
            </h5>

            <?php Funcoes::GerarComentariosHTML('lista', $id); ?>

          </div>
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