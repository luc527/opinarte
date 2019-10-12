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
  $title .= " de " . $usuario->getNome();
} else {
  $erro = "Código não informado";
}

$isFriend = UsuarioDao::isFriend($_SESSION['usuario_id'], $id);
$pedidoPendente = UsuarioDao::pedidoPendente($_SESSION['usuario_id'], $id);
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
      <?php if ($usuario_dono) {
        echo '<a class="teal-text btn-flat waves-effect" href="perfil_edit.php?id=' . $id . '">
            <i class="material-icons left">edit</i> Editar perfil
          </a>';
      } ?>
      <div class="card-panel hoverable">
        <div class="row">

          <div class="col s12 center-align">
            <h3 class="brown-text text-darken-2"><b>
                <?php echo $usuario->getNome(); ?>
              </b></h3>
          </div>

        </div>

        <div class="row">

          <div class="col s12 m5 l4">

            <ul class="collection">

              <!-- Botão de adicionar ou remover da lista de amigos -->
              <?php if (!$usuario_dono) : ?>

                <li class="collection-item center-align">
                  <?php if ($isFriend) : ?>

                    <div class="row">
                      <div class="col s12">
                        <a href="usuario_acao.php?acao=deleteAmigo&user2_id=<?= $id; ?>" class="btn red darken-2 waves-effect waves-light">
                          <i class="material-icons left">close</i>
                          <i class="material-icons right">person</i>
                        </a>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col s12 red-text text-darken-2">
                        Remover da lista de amigos
                      </div>
                    </div>

                  <?php else : ?>

                    <?php if ($pedidoPendente): ?>

                      <div class="row">
                        <div class="col s12">
                          <a class="btn waves-effect waves-light green darken-3 disabled">
                            <i class="material-icons left">add</i>
                            <i class="material-icons right">person</i>
                          </a>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col s12 grey-text">
                          Pedido pendente
                        </div>
                      </div>

                    <?php else: ?>

                      <div class="row">
                        <div class="col s12">
                          <a href="usuario_acao.php?acao=pedidoAmizade&user2_id=<?= $id; ?>" class="btn waves-effect waves-light green darken-3">
                            <i class="material-icons left">add</i>
                            <i class="material-icons right">person</i>
                          </a>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col s12 green-text text-darken-2">
                          Enviar pedido de amizade
                        </div>
                      </div>

                    <?php endif; ?>

                  <?php endif; ?>

                </li>

              <?php endif; ?>


              <li class="collection-item">
                <img style='width:100%;' class='materialboxed' src="<?php echo $usuario->getImgPerfil() ?>">
              </li>
              <?php
              $infos = array(
                'Data de Nascimento' => $usuario->getData_nasc(),
                'E-mail' => $usuario->getEmail(),
                'Conta criada em' => $usuario->getData_criaConta(),
                'Último login' => $usuario->getUltimoLogin(),
                'Pontuação' => $usuario->getPontuacao(),
                'ADM' => $usuario->getAdm()
              );
              if ($usuario->getNivel() !== null) {
                $infos['Nivel'] = $usuario->getNivel()->getDescricao();
              }

              foreach ($infos as $info => $value) {
                if ($info == 'ADM' && $value == 0) $value = null;
                else if ($info == 'ADM') $value = 'Este usuário é um administrador';

                if ($value !== null) {
                  echo "<li class='collection-item'>
                    <b class='blue-grey-text'>" . $info . ": </b>
                    <i class='blue-grey-text text-darken-2'>" . $value . "</i>
                    </li>";
                }
              }
              ?>
            </ul>

          </div>


          <div class="col s12 m7 l8">
            <p align="justify" class="brown-text text-darken-4">
              <?php echo $usuario->getSobre_mim(); ?>
            </p>
          </div>
        </div>

        <div class="row center-align">
          <div class="col s12">
            <a href="perfil_favoritos.php?id=<?php echo $id; ?>" class="btn yellow darken-3 waves-effect waves-light">
              <i class="material-icons left">star</i>
              Favoritos
              <i class="material-icons right">send</i>
            </a>

            <a href="perfil_relacoes.php?id=<?php echo $id; ?>" class="btn red lighten-1 waves-effect waves-light">
              Relações com obras <i class="material-icons right">send</i>
            </a>

            <a href="perfil_notas.php?id=<?php echo $id; ?>" class="btn blue-grey waves-effect waves-light">
              Notas <i class="material-icons right">send</i>
            </a>
          </div>
        </div>

        <div class="row center-align">
          <div class="col s12">
            <a href="perfil_resenhas.php?id=<?php echo $id; ?>" class="btn indigo waves-effect waves-light">
              Resenhas <i class="material-icons right">send</i>
            </a>

            <a href="perfil_listas.php?id=<?php echo $id; ?>" class="btn purple waves-effect waves-light">
              Listas <i class="material-icons right">send</i>
            </a>

            <a href="perfil_relacoes_entreobjs.php?id=<?php echo $id; ?>" class="btn teal waves-effect waves-light">
              Relações <i class="material-icons right">send</i>
            </a>

            <a href="perfil_contribuicoes.php?id=<?php echo $id; ?>" class="btn blue-grey darken-2 waves-effect waves-light">
              Contribuições <i class="material-icons right">send</i>
            </a>
          </div>
        </div>

        <div class="row center-align">
          <div class="col s12">
            <a href="perfil_listaAmigos.php?id=<?= $id; ?>" class="btn green darken-2">
              <i class="material-icons left">person</i>
              Lista de amigos
              <i class="material-icons right">send</i>
            </a>
          </div>
        </div>

        <div class="divider" style="margin: 2rem 0 2rem 0;"></div>

        <div class="row">
          <div class="col s12">
            <h5 class="center-align">
              <b class="purple-text text-darken-2">Comentários</b>
            </h5>

            <?php Funcoes::GerarComentariosHTML('usuario', $id); ?>
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