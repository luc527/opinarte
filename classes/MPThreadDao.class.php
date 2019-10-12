<?php
require_once('autoload.php');

class MPThreadDao {
	// ////// //
	// INSERT //
	// ////// //

	/**
	 * Cria uma thread de mensagens privadas no BD e, em seguida, adiciona os usuários dela (se o autor não tiver selecionado nenhum, irá inserir apenas ele)
	 * @param MPThread $mpt a instância da thread
	 */
	public static function Insert(MPThread $mpt) {
		$sql = "INSERT INTO msgPrivadaThread (titulo) VALUES (:titulo)";
		try {
			$stmt = Conexao::getInstance()->prepare($sql);
			$titulo = $mpt->titulo();
			$stmt->bindParam(":titulo", $titulo);
		} catch (PDOException $e) { echo "<b>Erro (MPThreadDao::Insert): </b>".$e->getMessage(); }
		$stmt->execute();

		self::InsertUsuarios($mpt);
	}

	/**
	 * Insere usuários de uma instância MPThread no banco de dados
	 * @param MPThread $mpt instância de que deve ter objetos Usuario em ->usuarios;
	 */
	public static function InsertUsuarios(MPThread $mpt) {
		$usuarios = $mpt->usuarios();

		foreach ($usuarios as $usuario) {
			$sql = "INSERT INTO msgUsuariosThread (thread_id, usuario_id) VALUES (:thread, :usuario_id)";
			try {
				$stmt = Conexao::getInstance()->prepare($sql);
				$thread = $mpt->getId();
				$usuario_id = $usuario->getId();
				$stmt->bindParam(":thread", $thread);
				$stmt->bindParam(":usuario_id", $usuario_id);
			} catch (PDOException $e) { echo "<b>Erro (MPThreadDao::InsertUsuarios): </b>".$e->getMessage(); }
			$stmt->execute();
		}
	}

	/**
	 * Insere mensagems de uma instância MPThread no banco de dados
	 * @param MPThread $mpt instância de que deve ter objetos MP em ->mensagens;
	 */
	public static function InsertMensagens(MPThread $mpt) {
		$mensagens = $mpt->mensagens();
		foreach ($mensagens as $msg) {
			MPDao::Insert($msg, $mpt->getId());
		}
	}

	
	// ////// //
	// SELECT //
	// ////// //

	/**
	 * Recebe um registro de consulta do BD e instancia um objeto com os valores do registro
	 * @param array $row deve ser um array com o nome das colunas como índices
	 * ($row['id_thread'], $row['titulo']). Resultado de fetch(PDO::FETCH_ASSOC)
	 */
	public static function Popula($row) {
		$mpt = new MPThread;
		$mpt->setId($row['id_thread']);
		$mpt->setTitulo($row['titulo']);
		return $mpt;
	}
	
	/**
	 * Seleciona uma MPThread do BD por critério e pesquisa
	 */
	public static function Select($criterio = 'titulo', $pesquisa = '') {
		switch ($criterio) {
			case 'titulo':
				$sql = "SELECT * FROM msgPrivadaThread WHERE $criterio like '%$pesquisa%'";
				break;			
			default:
				$sql = "SELECT * FROM msgPrivadaThread WHERE $criterio = '$pesquisa'";
				break;
		}
		$threads = [];
		try {
			$query = Conexao::getInstance()->query($sql);
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$threads[] = self::Popula($row);
			}
		} catch (PDOException $e) { echo "<b>Erro (MPThreadDao::Select): </b>".$e->getMessage(); }
		return $threads;
	}

	/**
	 * Seleciona uma MPThread por ID e
	 * usa a função Select e retorna apenas um objeto em vez de
	 * um array com um objeto (wrapper function?)
	 */
	public static function SelectPorId($id) {
		return self::Select('id_thread', $id)[0];
	}

	/**
	 * Consulta o BD e popula uma MPThread com os usuários
	 * @param MPThread $mpt sem usuários
	 * @return MPThread com usuários
	 */
	public static function SelectUsuarios(MPThread $mpt) {
		$id = $mpt->getId();
		$sql = "SELECT usuario_id FROM msgUsuariosThread WHERE thread_id = $id";
		try {
			$query = Conexao::getInstance()->query($sql);
			while($row = $query->fetch(PDO::FETCH_ASSOC)) {
				// Seleciona e popula usuário pelo id da coluna 
				// e popula a MPThread com esse usuário
				$mpt->setUsuario(UsuarioDao::SelectPorId($row['usuario_id']));
			}
		} catch (PDOException $e) { echo "<b>Erro (MPThreadDao::SelectUsuarios): </b>".$e->getMessage(); }
		return $mpt;
	}

	/**
	 * Consulta o BD e retorna as threads em que um usuário está
	 * @param mixed $usuario_id 
	 * @return array objetos MPThread dos quais o usuário faz parte
	 */
	public static function SelectPorUsuario($usuario_id) {
		$sql = "SELECT * FROM msgUsuariosThread WHERE usuario_id = $usuario_id";
		try {
			$threads = [];
			$query = Conexao::getInstance()->query($sql);
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$threads[] = self::SelectPorId($row['thread_id']);
			}
		} catch (PDOException $e) { echo "<b>Erro (MPThreadDao::SelectPorUsuario): </b>".$e->getMessage(); }
		return $threads;
	}

	/**
	 * Consulta o BD e popula uma MPThread com as mensagens
	 * @param MPThread $mpt sem mensagens
	 * @param string $quantas OPCIONAL quantas mensagens selecionar ('todas' [padrão] ou 'apenas_ultima')
	 * @return MPThread com mensagem
	 */
	public static function SelectMensagens(MPThread $mpt, $quantas = 'todas') {
		$id = $mpt->getId();
		$sql = "SELECT * FROM msgPrivada WHERE thread_id = $id ORDER BY dtHr DESC";
		if ($quantas == 'apenas_ultima') $sql .= " LIMIT 1";
		try {
			$query = Conexao::getInstance()->query($sql);
			while($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$mpt->setMensagem(MPDao::Popula($row));
			}
		} catch (PDOException $e) { echo "<b>Erro (MPThreadDao::SelectMensagens): </b>".$e->getMessage(); }
		return $mpt;
	}

	/**
	 * Verifica se um usuário faz parte da MP Thread
	 */
	public static function Usuario_na_MPT($usuario_id, $thread_id) {
		$sql = "SELECT * FROM msgUsuariosThread WHERE usuario_id = $usuario_id AND thread_id = $thread_id";
		try {
			$query = Conexao::getInstance()->query($sql);
			$row = $query->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) { echo "<b>Erro (MPThreadDao::Usuario_na_MPT): </b>".$e->getMessage(); }
		return $row != false;
	}


	// ////// //
	// DELETE //
	// ////// //

	/**
	 * Deleta um usuário de uma thread de MPs
	 */
	public static function DeleteUsuario($thread_id, $usuario_id) {
		$sql = "DELETE FROM msgUsuariosThread WHERE thread_id = :thread_id AND usuario_id = :usuario_id";
		try {
			$stmt = Conexao::getInstance()->prepare($sql);
			$stmt->bindParam(":thread_id", $thread_id);
			$stmt->bindParam(":usuario_id", $usuario_id);
			return $stmt->execute();
		} catch (PDOException $e) { echo "<b>Erro (MPThreadDao::DeleteUsuario): </b>".$e->getMessage(); }
	}
}
