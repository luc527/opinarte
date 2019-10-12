<?php

require_once "autoload.php";

class UsuarioDao
{

	/**
	 * FUNÇÕES DE SELEÇÃO
	 */

	public static function Popula($row)
	{
		$usuario = new Usuario;

		$usuario->setId($row['id_usuario']);
		$usuario->setNome($row['nome']);
		$usuario->setImgPerfil($row['img_perfil']);
		$usuario->setData_nasc($row['data_nasc']);
		$usuario->setEmail($row['email']);
		$usuario->setUltimoLogin($row['ultimoLogin']);
		$usuario->setSobre_mim($row['sobre_mim']);
		$usuario->setPontuacao($row['pontuacao']);
		$usuario->setAdm($row['adm']);
		$usuario->setData_criaConta($row['data_criacaoConta']);

		return $usuario;
	}

	public static function PopulaResenha($row)
	{
		$obra = ObraDao::SelectPorId($row['obra_id']);

		$resenha = new Resenha;
		$resenha->setId($row['id_resenha']);
		$resenha->setObra($obra);
		$resenha->setTexto($row['texto']);
		$resenha->setDataHora($row['dtHr']);

		return $resenha;
	}

	public static function Select($criterio, $pesquisa)
	{
		switch ($criterio) {
			case 'nome':
			case 'sobre_mim':
				$sql = "SELECT * FROM usuario WHERE $criterio like '%$pesquisa%'";
				break;
			case 'todos':
				$sql = "SELECT * FROM usuario";
				break;
			case 'nome-exato':
				$sql = "SELECT * FROM usuario WHERE nome = '$pesquisa'";
				break;
			default:
				$sql = "SELECT * FROM usuario WHERE $criterio = '$pesquisa'";
				break;
		}
		$query = Conexao::getInstance()->query($sql);
		$usuarios = array();
		for ($i = 0; $row = $query->fetch(PDO::FETCH_ASSOC); $i++) {
			array_push($usuarios, self::Popula($row));
		}
		return $usuarios;
	}

	public static function SelectPorId($id)
	{
		$sql = "SELECT * FROM usuario WHERE id_usuario = {$id}";
		try {
			$query = Conexao::getInstance()->query($sql);
			$row = $query->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			echo "<b>Erro (UsuarioDao::SelectPorId): </b>" . $e->getMessage();
		}
		return self::Popula($row);
	}

	public static function SelectPorNome($nome)
	{
		$usuario = self::Select('nome', $nome);
		return $usuario[0];
	}

	public static function SelectObrasRel_porObra(int $usuario_id, int $obra_id)
	{
		try {
			$sql = "SELECT * FROM usuario_relacao_obra WHERE usuario_id = $usuario_id AND obra_id = $obra_id";
			//var_dump($sql);
			$query = Conexao::getInstance()->query($sql);
			$row = $query->fetch(PDO::FETCH_ASSOC);

			return $row['relacao'];
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public static function SelectObrasRel_porTipo(int $usuario_id, string $tipo)
	{
		try {
			$sql = "SELECT * FROM usuario_relacao_obra WHERE usuario_id = $usuario_id AND relacao = '$tipo'";
			//var_dump($sql);
			$query = Conexao::getInstance()->query($sql);
			$obras = array();
			for ($i = 0; $row = $query->fetch(PDO::FETCH_ASSOC); $i++) {
				array_push($obras, ObraDao::SelectPorId($row['obra_id']));
			}
			return $obras;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public static function Obra_favoritada($id_obra, $id_usuario)
	{
		try {
			$sql = "SELECT * FROM obras_favoritas WHERE usuario_id = $id_usuario AND obra_id = $id_obra";
			$query = Conexao::getInstance()->query($sql);
			$row = $query->fetch(PDO::FETCH_ASSOC);

			if ($row['obra_id'] == $id_obra)
				return true;
			else
				return false;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public static function Artista_favoritado($id_artista, $id_usuario)
	{
		try {
			$sql = "SELECT * FROM artistas_favoritos WHERE usuario_id = $id_usuario AND artista_id = $id_artista";
			$query = Conexao::getInstance()->query($sql);
			$row = $query->fetch(PDO::FETCH_ASSOC);

			if ($row['artista_id'] == $id_artista)
				return true;
			else
				return false;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public static function Obra_relacionada($id_usuario, $id_obra)
	{
		try {
			$sql = "SELECT * FROM usuario_relacao_obra WHERE obra_id = $id_obra AND usuario_id = $id_usuario";
			$query = Conexao::getInstance()->query($sql);
			$row = $query->fetch(PDO::FETCH_ASSOC);

			if ($row['obra_id'] == $id_obra)
				return true;
			else
				return false;
		} catch (Exception $e) {
			echo $e - getMessage();
		}
	}

	public static function Obra_avaliada($id_usuario, $id_obra)
	{
		try {
			$sql = "SELECT * FROM usuario_nota_obra WHERE obra_id = $id_obra AND usuario_id = $id_usuario";
			$query = Conexao::getInstance()->query($sql);
			$row = $query->fetch(PDO::FETCH_ASSOC);

			if ($row['obra_id'] == $id_obra)
				return true;
			else
				return false;
		} catch (Exception $e) {
			echo $e - getMessage();
		}
	}

	public static function SelectNotas_porNota($usuario_id, $nota)
	{
		$sql = "SELECT * FROM usuario_nota_obra WHERE usuario_id = $usuario_id AND nota = $nota";
		try {
			$query = Conexao::getInstance()->query($sql);
			$notas = array();
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$obra = new Obra;
				$obra->setId($row['obra_id']);

				$nota = new UsuarioNotaObra;
				$nota->setObra($obra);
				$nota->setNota($row['nota']);

				array_push($notas, $nota);
			}
		} catch (PDOException $e) {
			echo "<b>Erro: </b>" . $e->getMessage();
		}
		return $notas;
	}

	public static function SelectNotas_count($usuario_id)
	{
		//echo $usuario_id;
		$sql = "SELECT nota, count(*) as qtd FROM usuario_nota_obra
		WHERE usuario_id = :usuario_id
		GROUP BY nota";
		try {
			$stmt = Conexao::getInstance()->prepare($sql);
			$stmt->bindParam(":usuario_id", $usuario_id);
			$stmt->execute();

			return $stmt->fetchAll();
		} catch (PDOException $e) {
			echo "Erro: " . $e->getMessage();
		}
	}

	public static function SelectNotaObra($usuario_id, $obra_id)
	{
		// seleciona a nota de uma obra
		try {
			$sql = "SELECT * FROM usuario_nota_obra WHERE usuario_id = $usuario_id AND obra_id = $obra_id";
			$query = Conexao::getInstance()->query($sql);
			$row = $query->fetch(PDO::FETCH_ASSOC);
			return $row['nota'];
		} catch (Exception $e) { }
	}

	public static function SelectObrasFav(Usuario $usuario)
	{
		$usuario_id = $usuario->getId();
		$sql = "SELECT * FROM obras_favoritas WHERE usuario_id = $usuario_id";
		try {
			$query = Conexao::getInstance()->query($sql);
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$usuario->setObra_fav(ObraDao::SelectPorId($row['obra_id']));
			}
			return $usuario;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	public static function SelectArtistasFav(Usuario $usuario)
	{
		$usuario_id = $usuario->getId();
		$sql = "SELECT * FROM artistas_favoritos WHERE usuario_id = $usuario_id";
		try {
			$query = Conexao::getInstance()->query($sql);
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$usuario->setArtista_fav(ArtistaDao::SelectPorId($row['artista_id']));
			}
			return $usuario;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public static function SelectResenhas(Usuario $usuario)
	{
		$usuario_id = $usuario->getId();
		$sql = "SELECT * FROM resenha WHERE usuario_id = $usuario_id";
		try {
			$query = Conexao::getInstance()->query($sql);
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$usuario->setResenha(self::PopulaResenha($row));
			}
			return $usuario;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public static function SelectListas(Usuario $usuario)
	{
		$id = $usuario->getId();
		$sql = "SELECT id_lista FROM lista WHERE autor = $id";
		try {
			$query = Conexao::getInstance()->query($sql);
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$usuario->setLista(ListaDao::SelectPorId($row['id_lista']));
			}
			return $usuario;
		} catch (PDOException $e) {
			echo "<b>Erro (SelectListas): </b>" . $e->getMessage();
		}
	}

	public static function SelectPorLista($lista_id)
	{
		$sql = "SELECT autor FROM lista WHERE id_lista = $lista_id";
		try {
			$query = Conexao::getInstance()->query($sql);
			$row = $query->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			echo "<b>Erro (PDOException, UsuarioDao::SelectPorLista): " . $e->getMessage();
		}
		return self::SelectPorId($row['autor']);
	}

	public static function SelectRelacoes(Usuario $usuario)
	{
		$usuario_id = $usuario->getId();
		$sql = "SELECT * FROM relacao WHERE usuario_id = $usuario_id";
		try {
			$bd = Conexao::getInstance();
			$query = $bd->query($sql);
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$usuario->setRelacao(RelacaoDao::Popula($row));
			}
		} catch (PDOException $e) {
			echo "<b>Erro (UsuarioDao::SelectRelacoes): </b>" . $e->getMessage();
		}
		return $usuario;
	}

	public static function SelectPorRelacao($rel_id)
	{
		$sql = "SELECT * FROM relacao WHERE id_relacao = '$rel_id'";
		try {
			$bd = Conexao::getInstance();
			$query = $bd->query($sql);
			$row = $query->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			echo "<b>Erro (UsuarioDao::SelectPorRelacao): </b>" . $e->getMessage();
		}
		return self::SelectPorId($row['usuario_id']);
	}

	/**
	 * Retorna certo usuário a partir de uma contribuição (método usado em contribuicao.php para mostrar o autor)
	 * @param int $con_id id da contribuição
	 * @return Usuario usuário instanciado a partir de UsuarioDao::SelectPorId -> UsuarioDao::Popula
	 */
	public static function SelectPorContribuicao(int $con_id)
	{
		$sql = "SELECT usuario_id FROM contribuicao WHERE id_contribuicao = $con_id";
		try {
			$bd = Conexao::getInstance();
			$query = $bd->query($sql);
			$row = $query->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			echo "<b>Erro (UsuarioDao::SelectPorContribuicao)</b> :" . $e->getMessage();
		}
		return self::SelectPorId($row['usuario_id']);
	}

	public static function SelectContribuicoes(Usuario $us)
	{
		$cons = ContribuicaoDao::Select('usuario_id', $us->getId());
		foreach ($cons as $con) {
			$us->setContribuicao($con);
		}
		return $us;
	}

	/**
	 * Retorna o administrador que avaliou certa contribuição
	 * @param int $con_id id da contribuição
	 * @return Usuario usuário ADMINISTRADOR instanciado a partir de UsuarioDao::SelectPorId -> UsuarioDao::Popula
	 */
	public static function SelectADMPorContribuicao(int $con_id)
	{
		$sql = "SELECT adm_usuario_id FROM contribuicao WHERE id_contribuicao = $con_id";
		try {
			$bd = Conexao::getInstance();
			$query = $bd->query($sql);
			$row = $query->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			echo "<b>Erro (UsuarioDao::SelectPorContribuicao)</b> :" . $e->getMessage();
		}
		return self::SelectPorId($row['adm_usuario_id']);
	}

	/**
	 * Retorna true se existe um usuário com o nome informado, false se não
	 * @param string $nome nome a ser verificado
	 * @return bool
	 */
	public static function Usuario_existe($nome)
	{
		$sql = "SELECT * FROM usuario WHERE nome = '$nome'";
		try {
			$query = Conexao::getInstance()->query($sql);
			$row = $query->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			echo "<b>Erro (UsuarioDao::Usuario_existe)</b> :" . $e->getMessage();
		}
		if ($row == false) return false; // $row = FALSE quando não há registros
		else return true;
	}

	public static function SelectPorComentario($id, $componente)
	{
		$sql = "SELECT usuario_id FROM cmt_{$componente} WHERE id_cmt_{$componente} = $id";
		try {
			$query = Conexao::getInstance()->query($sql);
			$row = $query->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			echo "<b>Erro (UsuarioDao::SelectPorComentario): </b>" . $e->getMessage();
		}
		return UsuarioDao::SelectPorId($row['usuario_id']);
	}

	/**
	 * Busca pedidos de amizade pendentes (recebidos) de determinado usuário
	 * 
	 * @param Usuario $usuario instância de Usuario sem pedidos de amizade pendentes
	 * 
	 * @return Usuario instância de Usuario com pedidos de amizade pendentes
	 */
	public static function SelectPedidosAmizade(Usuario $usuario)
	{
		$sql = "SELECT * FROM amizade_pedido WHERE user2_id = '{$usuario->getId()}'";
		try {
			$query = Conexao::getInstance()->query($sql);
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$usuario->setPedidoAmizadeRecebido(self::SelectPorId($row['user1_id']));
			}
		} catch (PDOException $e) {
			die("<b>Could not fetch friend requests (UsuarioDao@SelectPedidosAmizade): </b>" . $e->getMessage());
		}
		return $usuario;
	}

	/**
	 * Busca pedidos de amizade que um usuário fez
	 * 
	* @param Usuario $usuario instância de Usuario sem pedidos de amizade feitos
	 * 
	 * @return Usuario instância de Usuario com pedidos de amizade feitos 
	 */
	public static function SelectPedidosFeitos(Usuario $usuario)
	{
		$sql = "SELECT * FROM amizade_pedido WHERE user1_id = '{$usuario->getId()}'";
		try {
			$query = Conexao::getInstance()->query($sql);
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$usuario->setPedidoAmizadeFeito(self::SelectPorId($row['user2_id']));
			}
		} catch (PDOException $e) {
			die("<b>Could not fetch friend requests made by user (UsuarioDao@SelectPedidosFeitos): </b>" . $e->getMessage());
		}
		return $usuario;
	}
	
	/**
	 * Busca amigos de determinado usuário
	 * 
	 * @param Usuario $usuario instância de Usuario sem amigos
	 * 
	 * @return Usuario instância de Usuario com amigos
	 */
	public static function SelectAmigos(Usuario $usuario)
	{
		$user1_id = $usuario->getId();
		$sql = "SELECT user2_id FROM amizade WHERE user1_id = {$user1_id}";
		try {
			$query = Conexao::getInstance()->query($sql);
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$usuario->setAmigo(self::SelectPorId($row['user2_id']));
			}
		} catch (Exception $e) {
			die("<b>Could not fetch friend list: </b>" . $e->getMessage());
		}
		return $usuario;
	}

	public static function isFriend($id1, $id2)
	{
		$sql = "SELECT * FROM amizade WHERE user1_id = $id1 AND user2_id = $id2";
		try {
			$query = Conexao::getInstance()->query($sql);
			$row = $query->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			die("<b>Could not verify friendship (UsuarioDao@isFriend): </b>" . $e->getMessage());
		}

		return $row == false ? false : true;
	}

	/**
	 * Verifica se há um pedido de amizade pendente do usuário 1 (o que está pedindo) com o usuário 2
	 * 
	 * @param mixed $id1 id do usuário que está pedindo
	 * @param mixed $id2 id do usuário pedido
	 * 
	 * @return bool se há um pedido pendente (true) ou não (false)
	 */
	public static function pedidoPendente ($id1, $id2)
	{
		$sql = "SELECT * FROM amizade_pedido WHERE user1_id = {$id1} AND user2_id = {$id2}";
		try {
			$query = Conexao::getInstance()->query($sql);
			$row = $query->fetch(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			die("<b>Could not verify if user has a pending friend request (UsuarioDao@pedidoPendente): </b>".$e->getMessage());
		}

		return $row == false ? false : true;
	}

	/**
	 * FUNÇÕES DE INSERÇÃO
	 */

	public static function Insert(Usuario $usuario)
	{
		try {
			$sql = "INSERT INTO usuario (nome, senha, data_nasc, email, data_criacaoConta, sobre_mim)
			VALUES (:nome, :senha, :data_nasc, :email, :data_criaConta, :sobre_mim)";

			$stmt = Conexao::getInstance()->prepare($sql);

			$stmt->bindParam(":nome", $nome);
			$stmt->bindParam(":senha", $senha);
			$stmt->bindParam(":data_nasc", $data_nasc);
			$stmt->bindParam(":email", $email);
			$stmt->bindParam(":data_criaConta", $data_criaConta);
			$stmt->bindParam(":sobre_mim", $sobre_mim);

			$nome = $usuario->getNome();
			$senha = $usuario->getSenha();
			$data_nasc = $usuario->getData_nasc();
			$email = $usuario->getEmail();
			$data_criaConta = $usuario->getData_criaConta();
			$sobre_mim = $usuario->getSobre_mim();

			return $stmt->execute();
		} catch (Exception $e) {
			echo "Erro: " . $e->getMessage();
		}
	}

	public static function InsertObrasFav(Usuario $usuario)
	{
		$obras = $usuario->getObras_fav();
		for ($i = 0; $i < count($obras); $i++) {
			try {
				$sql = "INSERT INTO obras_favoritas (usuario_id, obra_id) VALUES (:us, :ob)";
				$stmt = Conexao::getInstance()->prepare($sql);

				$stmt->bindParam(":us", $us);
				$stmt->bindParam(":ob", $ob);
				$us = $usuario->getId();
				$ob = $obras[$i]->getId();

				$stmt->execute();
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
	}

	public static function InsertArtistasFav(Usuario $usuario)
	{
		$artistas = $usuario->getArtistas_fav();
		for ($i = 0; $i < count($artistas); $i++) {
			try {
				$sql = "INSERT INTO artistas_favoritos (usuario_id, artista_id) VALUES (:us, :art)";
				$stmt = Conexao::getInstance()->prepare($sql);

				$stmt->bindParam(":us", $us);
				$stmt->bindParam(":art", $art);
				$us = $usuario->getId();
				$art = $artistas[$i]->getId();

				$stmt->execute();
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
	}

	public static function InsertObrasRel(Usuario $usuario)
	{
		$relacoes = $usuario->getObras_rel();

		for ($i = 0; $i < count($relacoes); $i++) {

			$obra = $relacoes[$i]->getObra();

			try {
				if (self::Obra_relacionada($usuario->getId(), $obra->getId())) {
					self::DeleteObraRel($usuario->getId(), $obra->getId());
				}

				$sql = "INSERT INTO usuario_relacao_obra (obra_id, usuario_id, relacao) VALUES (:obra, :usuario, :relacao)";
				$stmt = Conexao::getInstance()->prepare($sql);

				$stmt->bindParam(":obra", $obra_id);
				$stmt->bindParam(":usuario", $usuario_id);
				$stmt->bindParam(":relacao", $relacao);

				$obra_id = $obra->getId();
				$usuario_id = $usuario->getId();
				$relacao = $relacoes[$i]->getRelacao();

				$stmt->execute();
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
	}

	public static function InsertObrasNota(Usuario $usuario)
	{
		$notas = $usuario->getObras_nota();
		for ($i = 0; $i < count($notas); $i++) {
			$obra = $notas[$i]->getObra();
			try {
				if (self::Obra_avaliada($usuario->getId(), $obra->getId())) {
					self::DeleteObraNota($usuario->getId(), $obra->getId());
				}

				$sql = "INSERT INTO usuario_nota_obra (usuario_id, obra_id, nota) VALUES (:usuario, :obra, :nota)";
				$stmt = Conexao::getInstance()->prepare($sql);

				$stmt->bindParam(":usuario", $us);
				$stmt->bindParam(":obra", $ob);
				$stmt->bindParam(":nota", $no);
				$us = $usuario->getId();
				$ob = $obra->getId();
				$no = $notas[$i]->getNota();

				$stmt->execute();
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
	}

	/**
	 * Insere os pedidos que um usuário fez no banco de dados (Usuario->pedidos_feitos)
	 * 
	 * @param Usuario $usuario instância de Usuario com pedidos feitos
	 */
	public static function InsertPedidosAmizade(Usuario $usuario)
	{
		$pedidos = $usuario->getPedidosAmizadeFeitos();
		foreach($pedidos as $pedido) {
			$sql = "INSERT INTO amizade_pedido (user1_id, user2_id) VALUES (:usuario_que_pediu, :usuario_pedido)";
			try {
				$stmt = Conexao::getInstance()->prepare($sql);
				$usuario_pediu = $usuario->getId();
				$usuario_pedido = $pedido->getId();
				$stmt->bindParam(":usuario_que_pediu", $usuario_pediu);
				$stmt->bindParam(":usuario_pedido", $usuario_pedido);
				$stmt->execute();
			} catch (Exception $e) {
				die("<b>Could not send friend request (UsuarioDao@InsertPedidosAmizade): </b>".$e->getMessage());
			}
		}
	}
	
	/**
	 * Insere os amigos de um usuário no banco de dados (Usuario->amigos)
	 * 
	 * @param Usuario $usuario instancia de Usuario com outros usuarios instanciados no atributo "amigos"
	 */
	public static function InsertAmigos(Usuario $usuario)
	{
		$amigos = $usuario->getAmigos();
		foreach ($amigos as $amigo) {

			$u1 = $usuario->getId();
			$u2 = $amigo->getId();
			
			self::DeletePedidoAmizade($u1, $u2);

			try {
				$sql = "INSERT INTO amizade (user1_id, user2_id) VALUES (:u1, :u2)";
				
				$stmt = Conexao::getInstance()->prepare($sql);
				$stmt->bindParam(':u1', $u1);
				$stmt->bindParam(':u2', $u2);
				$stmt->execute();

				$sql = "INSERT INTO amizade (user1_id, user2_id) VALUES (:u2, :u1)";
				$stmt = Conexao::getInstance()->prepare($sql);
				$stmt->bindParam(':u1', $u1);
				$stmt->bindParam(':u2', $u2);
				$stmt->execute();
			} catch (PDOException $e) {
				die("<b>Não pôde adicinar à lista de amigos (UsuarioDao@InsertAmigos): </b>" . $e->getMessage());
			}
		}
	}

	/**
	 * LOGIN
	 */

	public static function Login(Usuario $usuario)
	{
		// Verifica se o nome e a senha estão corretos e retorna, caso contrário, qual está errado
		$login = array();
		$login[0] = ''; // Ação a ser tomada ou erro a ser retornado
		$login[1] = ''; // ID do usuário a ser logado
		$login[2] = ''; // Tipo do usuário (adm ou não)


		$sql = "SELECT nome FROM usuario WHERE nome = '" . $usuario->getNome() . "'";
		$query = Conexao::getInstance()->query($sql);
		$row = $query->fetch(PDO::FETCH_ASSOC);

		if (isset($row['nome'])) {
			$nome = $row['nome'];

			$sql = "SELECT id_usuario, senha, adm FROM usuario WHERE nome = '" . $nome . "'";
			$query = Conexao::getInstance()->query($sql);
			$row = $query->fetch(PDO::FETCH_ASSOC);

			$senhaBD = $row['senha'];

			if ($senhaBD == $usuario->getSenha()) {
				$login[0] = 'fazer_login';
				$login[1] = $row['id_usuario'];
				$login[2] = $row['adm'];
				self::UpdateUltimoLogin($row['id_usuario']);
			} else {
				$login[0] = 'senha_incorreta';
			}
		} else {
			$login[0] = 'usuario_inexistente';
		}

		return $login;
	}

	/**
	 * FUNÇÕES DE EDIÇÃO
	 */

	public static function UpdateUltimoLogin($usuario_id)
	{
		try {
			$sql = "UPDATE usuario SET ultimoLogin = :ultimo WHERE id_usuario = :usuario";

			$stmt = Conexao::getInstance()->prepare($sql);

			$stmt->bindParam(":ultimo", $ultimo);
			$stmt->bindParam(":usuario", $usuario_id);
			$ultimo = date("Y-m-d H:i:s");

			return $stmt->execute();
		} catch (PDOException $e) {
			echo "Erro (PDOException): " . $e->getMessage();
		}
	}

	public static function Update(Usuario $usuario)
	{
		$sql = "UPDATE usuario SET
		img_perfil = :img,
		data_nasc = :data,
		email = :email,
		sobre_mim = :sobre
		WHERE id_usuario = :id";

		try {
			$stmt = Conexao::getInstance()->prepare($sql);

			$stmt->bindParam(":img", $img);
			$stmt->bindParam(":data", $data);
			$stmt->bindParam(":email", $email);
			$stmt->bindParam(":sobre", $sobre);
			$stmt->bindParam(":id", $id);
			$img = $usuario->getImgPerfil();
			$data = $usuario->getData_nasc();
			$email = $usuario->getEmail();
			$sobre = $usuario->getSobre_mim();
			$id = $usuario->getId();

			return $stmt->execute();
		} catch (PDOException $e) {
			echo "Erro (PDOException): " . $e->getMessage();
		}
	}

	/**
	 * FUNÇÕES DE REMOÇÃO
	 */

	public static function DeleteObrasFav(Usuario $usuario)
	{
		$obras = $usuario->getObras_fav();
		for ($i = 0; $i < count($obras); $i++) {
			try {
				$sql = "DELETE FROM obras_favoritas WHERE usuario_id = :us AND obra_id = :ob";
				$stmt = Conexao::getInstance()->prepare($sql);

				$stmt->bindParam(":us", $us);
				$stmt->bindParam(":ob", $ob);
				$us = $usuario->getId();
				$ob = $obras[$i]->getId();

				$stmt->execute();
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
	}

	public static function DeleteArtistasFav(Usuario $usuario)
	{
		$artistas = $usuario->getArtistas_fav();
		for ($i = 0; $i < count($artistas); $i++) {
			try {
				$sql = "DELETE FROM artistas_favoritos WHERE usuario_id = :us AND artista_id = :art";
				$stmt = Conexao::getInstance()->prepare($sql);

				$stmt->bindParam(":us", $us);
				$stmt->bindParam(":art", $art);
				$us = $usuario->getId();
				$art = $artistas[$i]->getId();

				$stmt->execute();
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
	}

	public static function DeleteObrasRel(Usuario $usuario)
	{
		$relacoes = $usuario->getObras_rel();
		for ($i = 0; $i < count($relacoes); $i++) {
			self::DeleteObraRel($usuario->getId(), $relacoes[$i]->getObra()->getId());
		}
	}

	public static function DeleteObraRel($usuario_id, $obra_id)
	{
		try {
			$sql = "DELETE FROM usuario_relacao_obra WHERE usuario_id = :usuario AND obra_id = :obra";
			$stmt = Conexao::getInstance()->prepare($sql);

			$stmt->bindParam(":usuario", $usuario_id);
			$stmt->bindParam(":obra", $obra_id);

			return $stmt->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public static function DeleteObrasNota(Usuario $usuario)
	{
		$notas = $usuario->getObras_nota();
		for ($i = 0; $i < count($notas); $i++) {
			self::DeleteObraNota($usuario->getId(), $notas[$i]->getObra()->getId());
		}
	}

	public static function DeleteObraNota($usuario_id, $obra_id)
	{
		try {
			$sql = "DELETE FROM usuario_nota_obra WHERE usuario_id = :usuario AND obra_id = :obra";
			$stmt = Conexao::getInstance()->prepare($sql);

			$stmt->bindParam(":usuario", $usuario_id);
			$stmt->bindParam(":obra", $obra_id);

			return $stmt->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	/**
	 * Remove um amigo ($id2) da lista de amigos de um usuário ($id1)
	 * 
	 * @param mixed $id1 ID do usuário com a lista de amigos
	 * @param mixed $id2 ID a ser removido da lista de amigos do usuário $id1
	 */
	public static function DeleteAmizade($id1, $id2)
	{
		try {
			$sql = "DELETE FROM amizade WHERE user1_id = :u1 AND user2_id = :u2";
			$stmt = Conexao::getInstance()->prepare($sql);
			$stmt->bindParam(":u1", $id1);
			$stmt->bindParam(":u2", $id2);
			$stmt->execute();

			$sql = "DELETE FROM amizade WHERE user1_id = :u2 AND user2_id = :u1";
			$stmt = Conexao::getInstance()->prepare($sql);
			$stmt->bindParam(":u1", $id1);
			$stmt->bindParam(":u2", $id2);
			$stmt->execute();
		} catch (PDOException $e) {
			die("<b>Could not remove friend from friend list (UsuarioDao@DeleteAmizade): </b>" . $e->getMessage());
		}
	}

	/**
	 * Delete um pedido de amizade entre dois usuários, não importa a ordem dos parâmetros
	 * 
	 * @param mixed $id1 id de um usuário
	 * @param mixed $id2 id de outro usuário
	 */
	public static function DeletePedidoAmizade($id1, $id2) 
	{
		$sql = "DELETE FROM amizade_pedido WHERE user1_id = :id1 AND user2_id = :id2";
		try {
			$stmt = Conexao::getInstance()->prepare($sql);
			$stmt->bindParam(":id1", $id1);
			$stmt->bindParam(":id2", $id2);
			$stmt->execute();

			$stmt = Conexao::getInstance()->prepare($sql);
			$stmt->bindParam(":id1", $id2);
			$stmt->bindParam(":id2", $id1);
			$stmt->execute();
		} catch (PDOException $e) {
			die("<b>Could not delete friend request (UsuarioDao@DeletePedidoAmizade): </b>" . $e->getMessage());
		}
	}
}
