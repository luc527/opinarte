<!DOCTYPE html>
<?php
require_once('autoload.php');
include('valida_secao.php');
include('perfil_notas_grafico.php');

$id = isset($_GET['id']) ? $_GET['id'] : '';

$usuario = '';
$erro = '';
$title = 'Relações';

if ($id != '') {
  if ($_SESSION['usuario_id'] == $id) $usuario_dono = true;
  else $usuario_dono = false;

  $usuario = UsuarioDao::SelectPorId($id);
  $title .= " de " . $usuario->getNome();

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
  <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
  <!-- Custom CSS -->
  <link type="text/css" rel="stylesheet" href="css/custom.css" />
  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body class="brown lighten-5">
  <header><?php Funcoes::PrintHeader(); ?></header>

  <main>
    <div class="container">

      <a href="perfil.php?id=<?php echo $id; ?>" class="btn-flat teal-text waves-effect">
        <i class="material-icons left">keyboard_return</i>
        Voltar
      </a>

      <div class="card-panel hoverable">
        
        <div class="row">
          <div class="col s12">
            <center><h4><b class="brown-text">
              Relações de <?php echo $usuario->getNome(); ?>
            </b></h4></center>
          </div>
        </div>

        <div class="row">
          <div class="col s12">
            <?php Funcoes::GerarRelacao($id, 'usuario'); ?>
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