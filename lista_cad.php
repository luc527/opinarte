<!DOCTYPE html>
<?php
include('valida_secao.php');
require_once('autoload.php');

$title = "Cadastro de lista";
$acao = "Insert";
$acao_txt = "Cadastrar";
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
      <div class="row"><div class="col s12">
        <center><h4><b class="<?php echo $cor; ?>-text text-darken-2">
          <?php echo $title; ?>
        </b></h4></center>
      </div></div>

      <form action="lista_acao.php" method="post">
        <input type="hidden" name="autor" value="<?php echo $_SESSION['usuario_id']; ?>"/>
        <div class="row">
          <div class="input-field col s12 m8 l9">
            <label for="nome">Título</label>
            <input type="text" name="nome" id="nome">
          </div>

          <div class="col s12 m4 l3">
            <label for="ordem">Ordem</label>
            <p><label>
              <input type="radio" name="ordem" value=0>
              <span>Não ordenada</span>
            </label></p>
            <p><label>
              <input type="radio" name="ordem" value=1>
              <span>Ordenada</span>
            </label></p>

          </div>
        </div>

        <div class="row"> <div class="col s12">
          <label for="descricao">Descrição</label>
          <textarea class="materialize-textarea"
           name="descricao" id="descricao"></textarea>
        </div> </div>

        <div class="row"> <div class="col s12 center">
          <button type="submit" name="acao" class="btn <?php echo $cor; ?> darken-2"
          value="<?php echo $acao; ?>">
            <i class="material-icons right">send</i>
            <?php echo $acao_txt; ?>
          </button>
        </div> </div>
      </form>
      <center>
        <p class="<?php echo $cor; ?>-text"><b>OBS: </b>Os itens poderão ser adicionados apenas depois do cadastro da lista</p>
      </center>
    </div> </div> </main>


    <footer><?php Funcoes::PrintFooter(); ?></footer>

  	<!-- Scripts -->
  	<script type="text/javascript" src="js/jquery-3.4.1.js"></script> <!-- OBS: jQuery deve estar sempre acima -->
  	<script type="text/javascript" src="js/materialize.min.js"></script>
  	<!-- Materialize auto init -->
  	<script type="text/javascript"> M.AutoInit(); </script>
  </body>
</html>
