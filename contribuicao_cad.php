<!DOCTYPE html>
<?php
include('valida_secao.php');
require_once('autoload.php');

$obj_tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
$obj_id = isset($_GET['id']) ? $_GET['id'] : '';
if ($obj_tipo == 'artista') {
  $obj = ArtistaDao::SelectPorId($obj_id);
  $cor_obj = 'cyan';
  $link_obj = 'artista.php';
} else if ($obj_tipo == 'obra') {
  $obj = ObraDao::SelectPorId($obj_id);
  $cor_obj = 'blue';
  $link_obj = 'obra.php';
} else if ($obj_tipo == 'genero') {
  $obj = GeneroDao::SelectPorId($obj_id);
  $cor_obj = 'light-green';
  $link_obj = 'genero.php';
} else if ($obj_tipo == 'lingarte') {
  $obj = LingArteDao::SelectPorId($obj_id);
  $cor_obj = 'lime';
  $link_obj = 'lingArte.php';
}

$acao = "Insert";
$acao_txt = "Cadastrar";
$acao_ico = "add";

$title = "Cadastro de contribuição";

$cor = 'blue-grey';

$tipos_con = ContribuicaoTipoDao::Select();
?>

<html>

<head>
  <title><?php echo $title; ?></title>
  <meta charset="utf-8">

  <!-- Materialize -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
  <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
  <!-- Custom CSS -->
  <link type="text/css" rel="stylesheet" href="css/custom.css" />
  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body class="<?php echo $cor; ?> lighten-5">
  <header>
    <?php Funcoes::PrintHeader(); ?>
  </header>

  <main>
    <div class="container">
      <div class="card-panel hoverable">

        <div class="row">
          <div class="col s12">
            <center>
              <h3><b class="<?php echo $cor; ?>-text text-darken-2">
                  <?php echo $title; ?>
                </b></h3>
            </center>
          </div>
        </div>

        <div class="row">
          <div class="col s12">
            <p class="<?php echo $cor; ?>-text text-darken-4 center-align">
              Com este recurso você pode contribuir para o banco de dados do sistema. <br />
              Insira alguma informação sobre determinada obra, artista, gênero ou linguagem da arte, existente ou não no site. <br />
              <IMPORTANT style="font-weight: bold;">Caso você queira adicionar uma contribuição sobre um registro que já existe no site, vá para a página desse registro, vá na aba de contribuições e clique em "cadastrar". <br />
                Caso você queira adicionar um registro novo, clique em "publicar" na barra de navegação e, em seguida, em "informação". </IMPORTANT><br />
              Não se esqueça de fornecer, além disso, a(s) fonte(s) dessa informação.
            </p>
            <form action="contribuicao_acao.php" method="post">

              <!-- Mostra a entidade à qual a informação se refere -->
              <?php if ($obj_id != '') : ?>
                <input type="hidden" name="obj" id="obj" value="<?php echo $obj_id; ?>">
                <input type="hidden" name="tipo_obj" id="tipo_obj" value="<?php echo $obj_tipo; ?>">
                <ul class="collection">
                  <li class="collection-item">
                    <span class="title"><b class="<?php echo $cor_obj; ?>-text text-darken-2">
                        <?php echo $obj->getNome(); ?>
                      </b></span>
                    <a href="<?php echo $link_obj; ?>?id=<?php echo $obj->getId(); ?>" class="secondary-content">
                      <i class="material-icons">send</i>
                    </a>
                    <i class="truncate <?php echo $cor_obj ?>-text text-darken-4">
                      <?php echo $obj->getDescricao(); ?>
                    </i>
                  </li>
                </ul>
              <?php endif; ?>

              <!-- Informação -->
              <div class="row">
                <div class="input-field col s12">
                  <label for="informacao">Informação</label>
                  <textarea name="informacao" id="informacao" class="materialize-textarea"></textarea>
                </div>
              </div>

              <!-- Fontes -->
              <div class="row">
                <div class="input-field col s12">
                  <label for="fontes">Fontes</label>
                  <textarea name="fontes" id="fontes" class="materialize-textarea"></textarea>
                </div>
              </div>

              <!-- Select de tipos -->
              <div class="row">
                <div class="input-field col s12">
                  <select name="tipo" id="tipo" class="disabled">

                    <?php foreach ($tipos_con as $tipo) :
                      if ($obj_id == '') {
                        if ($tipo->getId() == 1 || $tipo->getId() == 2) {
                          $disabled = " disabled ";
                          $selected = "";
                        } else {
                          $disabled = "";
                          $selected = " selected ";
                        }
                      } else {
                        if ($tipo->getId() == 3) {
                          $disabled = " disabled ";
                          $selected = "";
                        } else {
                          $disabled = "";
                          $selected = " selected ";
                        }
                      }
                      ?>
                      <option value="<?php echo $tipo->getId() ?>" <?php echo $selected;
                                                                      echo $disabled; ?>><?php echo $tipo->getNome(); ?>
                      </option>
                    <?php endforeach; ?>

                  </select>
                  <span class="helper-text">Tipo</span>
                </div>
              </div>

              <!-- Botão - submissão do formulário -->
              <div class="row">
                <div class="input-field col s12">
                  <button type="submit" class="btn <?php echo $cor; ?> darken-2 waves-effect waves-light" name="acao" id="acao" value="<?php echo $acao; ?>">
                    <i class="material-icons left">
                      <?php echo $acao_ico; ?>
                    </i>
                    <?php echo $acao_txt; ?>
                  </button>
                </div>
              </div>

            </form>
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