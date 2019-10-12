<?php

class Funcoes
{


	/////////////////////
	// Funções PHP/SQL //

	public static function Data_BD_para_user($data)
	{
		return date("d/m/Y", strtotime($data));
	}

	public static function Data_user_para_BD($data)
	{
		$data = str_replace('/', '-', $data);
		return date("Y-m-d", strtotime($data));
	}

	public static function ProximoId($tabela)
	{
		$sql = "SELECT Auto_Increment FROM Information_schema.Tables WHERE Table_name = '$tabela'";
		$query = Conexao::getInstance()->query($sql);
		$row = $query->fetch(PDO::FETCH_ASSOC);

		return $row['Auto_Increment'];
	}

	public static function GerarSelect($nome, $tabela, $value, $innerHTML, $selected)
	{
		if ($tabela == 'genero') {
			self::GerarSelect_gen($nome, $selected);
		} else {
			$sql = "SELECT $value, $innerHTML FROM $tabela";
			$stmt = Conexao::getInstance()->prepare($sql);

			$stmt->execute();

			$res = $stmt->fetchAll();

			echo "<select name='$nome' id='$nome'>";
			echo "<option disabled>Selecione</option>";

			for ($i = 0; $i < count($res); $i++) {
				if ($res[$i]["$value"] == $selected) {
					$slctd = ' selected ';
				} else {
					$slctd = '';
				}

				echo "<option $slctd value=" . $res[$i]["$value"] . ">" . $res[$i]["$innerHTML"] . "</option>";
			}

			echo "</select>";
		}
	}

	public static function GerarSelect_gen($nome, $selected)
	{
		$sql = "SELECT `g`.`id` as 'id_genero', `g`.`nome` as 'nome',
	   `l`.`nome` as 'linguagem'
		FROM `genero` `g`, `linguagensart` `l`
		WHERE `g`.`lingArte` = `l`.`id`
		ORDER BY `l`.`nome`";

		$stmt = Conexao::getInstance()->prepare($sql);

		$stmt->execute();

		$res = $stmt->fetchAll();

		echo "<select name='$nome' id='$nome'>";
		echo "<option disabled>Selecione um gênereo</option>";

		for ($i = 0; $i < count($res); $i++) {

			if ($res[$i]['id_genero'] == $selected) {
				$sel = " selected ";
			} else {
				$sel = "";
			}

			echo "<option $sel
			value=" . $res[$i]['id_genero'] . ">" . $res[$i]['linguagem'] . " - " . $res[$i]['nome'] . "</option>";
		}

		echo "</select>";
	}

	public function VerifNomeEmUso($nome)
	{
		$sql = "SELECT nome FROM usuario WHERE nome = '" . $nome . "'";
		$query = Conexao::getInstance()->query($sql);
		$row = $query->fetch(PDO::FETCH_ASSOC);

		if ($row['nome'] == $nome) {
			return true;
		} else {
			return false;
		}
	}



	//////////////////
	// Funções HTML //

	/**
	 * Gera todo o HTML para cadastrar comentários e mostrar os comentários de uma página
	 * 
	 * @param string $componente 'artista', 'obra', 'resenha' etc.
	 * @param mixed $id o id do componente
	 * 
	 * = echo o código html a ser mostrado
	 */
	public function GerarComentariosHTML(string $componente, $id)
	{
		// Formulário para cadastrar comentário
		echo ('
			<div class="row">
				<div class="col s12">
					<form action="comentario_acao.php" class="row card-panel" method="POST">

						<input type="hidden" name="componente_id" id="componente_id" value="' . $id . '">
						<input type="hidden" name="componente" id="componente" value="' . $componente . '">

						<div class="input-field col s12">
							<label for="texto">Novo comentário</label>
							<input type="text" name="texto" id="texto"/>
						</div>

						<div class="input-field col s12 center-align">
							<button
								type="submit" name="acao" id="acao" value="Cadastrar"
								class="btn blue-grey waves-effect waves-light"
							> <i class="material-icons left">send</i>
								Enviar
							</button>
						</div>

					</form>
				</div>
			</div>
		');
		// Mostrar comentários do componente

		// Instancia o objeto do componente
		$dao = ucwords($componente) . "Dao"; // 'artista' -> 'ArtistaDao', 'lista' -> 'ListaDao'
		$objeto = $dao::SelectPorId($id);

		$objeto = $componente == 'resenha' ?
			$objeto->getResenhas()[0]
			: $objeto;
		/* SelectPorId da resenha retorna um usuário com a resenha
		Preferiu-se, em vez de mudar como esse método funciona, contornar o problema
		O motivo disso é que o funcionamento do sistema em outras páginas seria afetado */

		// Popula objeto com comentários
		$objeto = ComentarioDao::SelectComentarios($objeto);

		// Seleciona comentários do objeto
		if ($objeto instanceof Usuario) {
			// o usuário tanto cria comentários quanto tem comentários em seu perfil
			// há, pois, dois atributos diferentes para cada tipo de comentário
			$comentarios = $objeto->comentarios_recebidos();
		} else {
			$comentarios = $objeto->comentarios();
		}

		// Gera HTML para mostrar comentários
		if (count($comentarios) > 0) :
			echo ('
				<div class="row">
					<div class="col s12">

						<ul class="collection">
			');

			foreach ($comentarios as $comentario) :
				// Determina avatar do usuário
				$autor = UsuarioDao::SelectPorComentario($comentario->getId(), $componente);
				if (null !== $autor->getImgPerfil()) {
					$avatar = "<img class='materialboxed circle' src='" . $autor->getImgPerfil() . "' />";
				} else {
					$avatar = "<i class='material-icons circle brown'>person</i>";
				}

				// Cria HTML do comentário
				echo ('
					<li class="collection-item avatar">
						' . $avatar . '
						
						<span class="title">
							<b class="brown-text"> ' . $autor->getNome() . ' </b>
						</span>

						<a class="secondary-content" href="perfil.php?id=' . $autor->getId() . '">
							<i class="material-icons tooltipped" data-tooltip="Ver perfil">send</i>
						</a>	
						
						<i class="grey-text center">
							' . date("d/m/Y H:i:s", strtotime($comentario->data_hora())) . '
						</i>

						<a 
							style="margin-left: 2rem;"
							href="comentario_acao.php?acao=Like&id=' . $comentario->getId() . '&componente=' . $componente . '&componente_id=' . $id . '"
							class="tooltipped" data-tooltip="Curti"
						>
							<i class="material-icons">thumb_up</i>
						</a>

						<i style="position: relative; bottom: .5rem; left: 1rem">
							(' . $comentario->noLikes() . ' likes)
						</i>

						<p>' . $comentario->texto() . '</p>
					</li>
				');

			endforeach;

			// Fecha HTML em que os comentários estao contidos
			echo ('</ul>

					</div>
				</div>
			');
		endif;
	}









	public static function BotaoContribuir($id, $tipo)
	{ ?>
		<a class="btn-flat teal-text waves-effect" href="contribuicao_cad.php?id=<?php echo $id ?>&tipo=<?php echo $tipo; ?>">
			<i class="material-icons left">edit</i>
			Contribuir com informações
		</a>
	<?php }

		public static function PrintHeader($pag = '')
		{
			// $pag = página em que a pessoa está, para que se possa ser usado o class='active' corretamente
			?>

		<nav class="blue-grey darken-2">
			<div class="nav-wrapper container">
				<b><a href="index.php" class="brand-logo">Opinarte</a></b>
				<a href="#" data-target="sidenavHeader" class="sidenav-trigger">
					<i class="material-icons">menu</i>
				</a>

				<ul class="right hide-on-med-and-down">

					<?php if (isset($_SESSION['usuario_tipo'])) : ?>
						<?php if ($_SESSION['usuario_tipo'] == 1) : ?>
							<li>
								<a href="" class="dropdown-trigger" data-target="dropdownAdm">
									<i class="material-icons left">add</i>
									Cadastrar
									<i class="material-icons right">arrow_drop_down</i>
								</a>
							</li>
						<?php endif; ?>
					<?php endif; ?>

					<li>
						<a class="dropdown-trigger" data-target="dropdownList">
							<i class="material-icons left">list</i>
							Listagem
							<i class="material-icons right">arrow_drop_down</i>
						</a>
					</li>

					<li>
						<a class="dropdown-trigger" data-target="dropdownNew">
							<i class="material-icons left">add</i>
							Criar
							<i class="material-icons right">arrow_drop_down</i>
						</a>
					</li>

					<?php if (isset($_SESSION['usuario_nome'])) { ?>

						<li> <a class="dropdown-trigger" data-target="dropdownUser">
								<i class="material-icons left">person</i>
								<?php echo $_SESSION['usuario_nome'] ?>
								<i class="material-icons right">arrow_drop_down</i>
							</a> </li>

					<?php } else { ?>

						<li <?php if ($pag == 'entrar') {
											echo "class='active'";
										} ?>> <a href="entrar.php">
								<i class="material-icons left">person</i> Entrar </a> </li>

					<?php } ?>

					</li>
				</ul>
			</div>
		</nav>

		<ul class="sidenav" id="sidenavHeader">
			<?php if (isset($_SESSION['usuario_nome'])) { ?>
				<li> <a href="perfil.php?id=<?php echo $_SESSION['usuario_id']; ?>"><i class="material-icons left">person</i> Ver perfil (<?php echo $_SESSION['usuario_nome']; ?>)</a> </li>
				<li><a href="mpt_list.php"><i class="material-icons left">mail</i>MPs</a></li>
				<li><a href="pedidos_amizade.php"><i class="material-icons left">person</i> Pedidos de amizade</a></li>
				<li> <a href="entrar_acao.php?acao=Logoff"><i class="material-icons left">close</i> Sair </a> </li>
			<?php } else { ?>
				<li> <a href="entrar.php"><i class="material-icons left">person</i> Entrar </a> </li>
			<?php } ?>

			<?php if (isset($_SESSION['usuario_tipo'])) : ?>
				<?php if ($_SESSION['usuario_tipo'] == 1) : ?>
					<li class="divider"></li>
					<li> <a href="lingArte_cad.php"> <i class='material-icons'>add</i> Linguagem</a> </li>
					<li> <a href="genero_cad.php"> <i class='material-icons'>add</i> Gênero</a> </li>
					<li> <a href="artista_cad.php"> <i class='material-icons'>add</i> Artista</a> </li>
					<li> <a href="obra_cad.php"> <i class='material-icons'>add</i> Obra</a> </li>
				<?php endif; ?>
			<?php endif; ?>

			<li class="divider"></li>

			<li> <a href="lingArte_list.php"> <i class='material-icons'>list</i> Linguagens</a> </li>
			<li> <a href="genero_list.php"> <i class='material-icons'>list</i> Gêneros</a> </li>
			<li> <a href="artista_list.php"> <i class='material-icons'>list</i> Artistas</a> </li>
			<li> <a href="obra_list.php"> <i class='material-icons'>list</i> Obras</a> </li>
			<li> <a href="lista_list.php"> <i class='material-icons'>list</i> Listas</a> </li>
			<li> <a href="relacao_list.php"> <i class='material-icons'>list</i> Relações</a> </li>
			<li> <a href="contribuicao_list.php"> <i class='material-icons'>list</i> Contribuições</a> </li>

			<li class="divider"></li>

			<li> <a href="lista_cad.php"> <i class='material-icons'>add</i> Lista</a> </li>
			<li> <a href="relacao_cad.php"> <i class='material-icons'>add</i> Relação</a> </li>
			<li> <a href="contribuicao_cad.php"> <i class='material-icons'>add</i> Contribuição</a> </li>
			<li> <a href="mpt_cad.php"> <i class='material-icons'>add</i> Mensagem privada</a> </li>
		</ul>

		<ul class="dropdown-content" id="dropdownUser">
			<li><a href="perfil.php?id=<?php echo $_SESSION['usuario_id']; ?>"><i class="material-icons left">person</i> Ver perfil</a></li>
			<li><a href="mpt_list.php"><i class="material-icons left">mail</i>MPs</a></li>
			<li><a href="pedidos_amizade.php"><i class="material-icons left">person</i> Pedidos de amizade</a></li>
			<li><a href="entrar_acao.php?acao=Logoff"><i class="material-icons left">close</i>Sair</a></li>
		</ul>

		<ul class="dropdown-content" id="dropdownList">
			<li> <a href="lingArte_list.php">Linguagens</a> </li>
			<li> <a href="genero_list.php">Gêneros</a> </li>
			<li> <a href="artista_list.php">Artistas</a> </li>
			<li> <a href="obra_list.php">Obras</a> </li>
			<li> <a href="lista_list.php">Listas</a> </li>
			<li> <a href="relacao_list.php">Relação</a> </li>
			<li> <a href="contribuicao_list.php">Contribuições</a> </li>
			<li> <a href="usuario_list.php">Usuário</a> </li>
		</ul>

		<ul class="dropdown-content" id="dropdownNew">
			<li> <a href="lista_cad.php">Lista</a> </li>
			<li> <a href="relacao_cad.php">Relação</a> </li>
			<li> <a href="contribuicao_cad.php">Contribuição</a> </li>
			<li> <a href="mpt_cad.php">Mensagem privada</a> </li>
		</ul>

		<ul class="dropdown-content" id="dropdownAdm">
			<li> <a href="lingArte_cad.php">Linguagem</a> </li>
			<li> <a href="genero_cad.php">Gênero</a> </li>
			<li> <a href="artista_cad.php">Artista</a> </li>
			<li> <a href="obra_cad.php">Obra</a> </li>
		</ul>



	<?php
		}



		public static function PrintFooter()
		{ }

		public static function GerarRelacao($id, $tipo)
		{
			if ($tipo != 'usuario') {
				$relacoes = RelacaoDao::SelectPorObj($id, $tipo);
			} else {
				$usuario = new Usuario;
				$usuario->setId($id);
				$usuario = UsuarioDao::SelectRelacoes($usuario);
				$relacoes = $usuario->getRelacoes();
			} ?>

		<div class="row">
			<div class="col s12">
				<?php foreach ($relacoes as $rel) : ?>
					<ul class="collection">
						<li class='collection-item teal lighten-5'>
							<?php $obj[1] = $rel->getObj1();
										$obj[2] = $rel->getObj2(); ?>

							<div class="row">
								<div class="col s12 right-align">
									<a href="relacao.php?id=<?php echo $rel->getId() ?>" class="btn-flat waves-effect teal-text">
										<i class="material-icons left">send</i>
										Ver relação
									</a>
								</div>
							</div>

							<div class="row">
								<?php for ($i = 1; $i <= 2; $i++) :
												if ($obj[$i] instanceof Obra) {
													$color = 'blue';
													$link = 'obra.php';
												} else if ($obj[$i] instanceof Artista) {
													$color = 'cyan';
													$link = 'artista.php';
												} else if ($obj[$i] instanceof Genero) {
													$color = 'light-green';
													$link = 'genero.php';
												} ?>
									<div class="col s12 m6">
										<ul class="collection">
											<li class="collection-item">
												<span class="title">
													<b class="<?php echo $color; ?>-text text-darken-2">
														<?php echo $obj[$i]->getNome(); ?>
													</b>
													<a href="<?php echo $link; ?>?id=<?php echo $obj[$i]->getId() ?>" class="secondary-content">
														<i class="material-icons">send</i>
													</a>
													<i class="truncate <?php echo $color ?>-text text-darken-4">
														<?php echo $obj[$i]->getDescricao(); ?>
													</i>
												</span>
											</li>
										</ul>
									</div>
								<?php endfor; ?>
							</div>

							<div class="row">
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

						</li>
					</ul>
				<?php endforeach; ?>
			</div>
		</div>
<?php }
}

?>