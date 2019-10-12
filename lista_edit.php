<!DOCTYPE html>
<?php
include('valida_secao.php');
require_once('autoload.php');

$id = isset($_GET['id']) ? $_GET['id'] : '';

$usuario_autor = ListaDao::UsuarioAutor($_SESSION['usuario_id'], $id);
if(!$usuario_autor) {
  header("location:index.php");
}

$lista = ListaDao::SelectPorId($id);
$lista = ListaDao::SelectItens($lista);
$itens = $lista->itens();
$ordem = $lista->ordem();

$acao_edit = "Update";
$acao_del = "Delete";
$acao_item_add = "InsertItem";
$acao_item_del = "DeleteItem";

$title1 = 'Edição de lista';
$title2 = 'Itens';
$title = $title1." - ".$title2;

$cor = 'purple';
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

  <body class="<?php echo $cor; ?> lighten-5">
    <header><?php Funcoes::PrintHeader(); ?></header>

    <main> <div class="container"> <div class="card-panel hoverable">
      <div class="row"> <div class="col s12">
        <center> <h4> <b class="<?php echo $cor ?>-text text-darken-2">
          <?php echo $title1; ?>
        </b> </h4> </center>
      </div> </div>


      <form action="lista_acao.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
        <div class="row">
          <div class="input-field col s12 m8 l9">
            <label for="nome">Título</label>
            <input type="text" name="nome" id="nome" value="<?php echo $lista->getNome(); ?>">
          </div>

          <div class="col s12 m4 l3">
            <label for="ordem">Ordem</label>
            <p><label>
              <input type="radio" name="ordem" value=0 <?php if($lista->ordem()==0) echo 'checked'; ?>>
              <span>Não ordenada</span>
            </label></p>
            <p><label>
              <input type="radio" name="ordem" value=1 <?php if($lista->ordem()==1) echo 'checked'; ?>>
              <span>Ordenada</span>
            </label></p>

          </div>
        </div>

        <div class="row"> <div class="col s12">
          <label for="descricao">Descrição</label>
          <textarea class="materialize-textarea"
           name="descricao" id="descricao"><?php echo $lista->getDescricao(); ?></textarea>
        </div> </div>

        <div class="row">
          <div class="col s12 center-align">
            <button type="submit" name="acao" class="btn waves-effect waves-light <?php echo $cor; ?> darken-2"
            value="<?php echo $acao_edit; ?>">
              <i class="material-icons right">edit</i>
              Editar
            </button>
          </div>
          <div class="col s12 right-align">
            <button type="submit" name="acao" class="btn waves-effect waves-light red darken-2"
            value="<?php echo $acao_del; ?>">
              <i class="material-icons right">delete</i>
              Excluir
            </button>
          </div>
        </div>
      </form>

      <br/>

      <div class="card-panel hoverable">
        <div class="row"> <div class="col s12">
          <center> <h4> <b class="<?php echo $cor; ?>-text text-darken-2">
            <?php echo $title2; ?>
          </b> </h4> </center>
        </div> </div>

        <div class="row">
          <div class="col s12 l6">
            <div class="row">
              <ul class="tabs">
                <li class="tab col s6"> <a href="#item_obra">Add obra</a> </li>
                <li class="tab col s6"> <a href="#item_artista">Add artista</a> </li>
              </ul>

              <?php
                $tipos_item = array('item_obra', 'item_artista');
                foreach ($tipos_item as $tipo):
                  if($tipo == 'item_obra') $tb = 'obra';
                  else $tb = 'artista'; ?>
                  <form action="lista_acao.php" method="post">
                    <input type="hidden" name="lista" value="<?php echo $id; ?>"/>
                    <div id="<?php echo $tipo; ?>">
                      <div class="row"> <div class="col s12">
                        <?php $value = 'id_'.$tb;
                        Funcoes::GerarSelect($tipo, $tb, $value, 'nome', 0); ?>
                      </div> </div>

                      <div class="row"> <div class="col s12">
                          <label for="descricao">Descrição (por que esse item está na lista?)</label>
                          <textarea class="materialize-textarea" name="descricao" id="descricao"></textarea>
                      </div> </div>

                      <?php if ($ordem == 1): ?>
                        <div class="row"> <div class="col s12">
                            <label for="posicao">Posição (lista ordenada)</label>
                            <input type="number" name="posicao" id="posicao" min="1" required>
                        </div> </div>
                      <?php endif; ?>

                      <div class="row"> <div class="col s12">
                        <button type="submit" name="acao" value="<?php echo $acao_item_add; ?>"
                        class="btn <?php echo $cor; ?> darken-2 waves-effect waves-light ">
                          <i class="material-icons left">add</i>
                          Add item
                        </button>
                      </div> </div>

                    </div>
                  </form>
                <?php endforeach; ?>
            </div>
          </div>

          <div class="col s12 l6">
            <ul class="collection">
              <?php foreach($itens as $lista_item) {
                $item = $lista_item->item(); // $item é ListaItem, item() é um obj Obra ou Artista
                if($item instanceof Artista) {
                  $cor_item = 'cyan';
                  $link = 'artista.php';
                  $ico_item = 'person';
                } else if ($item instanceof Obra) {
                  $cor_item = 'blue';
                  $link = 'obra.php';
                  $ico_item = 'photo';
                }

                if( $item->getImagemUrl() !== null ) {
                  $avatar = "<img src='".$item->getImagemUrl()."' class='circle materialboxed'>";
                } else {
                  $avatar = "<i class='material-icons circle ".$cor_item."'>
                  ".$ico_item."
                  </i>";
                }

                $posicao = "";
                if( $lista_item->posicao() !== null ) {
                  $posicao = "<b class='blue-grey-text text-darken-2'
                  style='font-size:1.5em;'>".$lista_item->posicao()."º</b>";
                }

                echo "<li class='collection-item avatar'>
                  ".$avatar."
                  <span class='title'> ".$posicao."
                  <b class='".$cor_item."-text text-darken-2'>
                    ". $item->getNome() ."
                  </b> </span>

                  <a class='secondary-content' href='".$link."?id=".$item->getId()."'>
                    <i class='material-icons'>send</i>
                  </a>

                  <i class='truncate'> ".$item->getDescricao()." </i>
                  <ul class='collection'><li class='collection-item'>
                    <p>".$lista_item->getDescricao()."</p>
                  </li></ul>
                  <a href='lista_acao.php?acao=".$acao_item_del."&id_item=".$lista_item->getId()."&lista=".$id."'
                  type='submit' class='btn-flat red-text text-darken-2 waves-effect waves-light'>
                    <i class='material-icons tooltipped'
                    data-tooltip='Remover da lista'>close</i>
                  </a>
                </li>";
              } ?>
            </ul>
          </div>
        </div>
      </div>

    </div> </div></main>

    <footer><?php Funcoes::PrintFooter(); ?></footer>

  	<!-- Scripts -->
  	<script type="text/javascript" src="js/jquery-3.4.1.js"></script> <!-- OBS: jQuery deve estar sempre acima -->
  	<script type="text/javascript" src="js/materialize.min.js"></script>
  	<!-- Materialize auto init -->
  	<script type="text/javascript"> M.AutoInit(); </script>
  </body>
</html>
