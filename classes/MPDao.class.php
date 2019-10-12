<?php
require_once('autoload.php');

class MPDao {
	// ////// //
	// INSERT //
	// ////// //

	/**
	 * Insere uma MP no banco de dados
	 * @param MP $mp a mensagem a ser inserida
	 * @param mixed $thread_id o id da thread de que a mp faz parte
	 */
	public static function Insert(MP $mp, $thread_id) {
		$sql = "INSERT INTO msgPrivada (texto, usuario_id, thread_id, dtHr) VALUES
			(:texto, :usuario_id, :thread_id, :data_hora)";
			try {
				$stmt = Conexao::getInstance()->prepare($sql);

				$texto = $mp->texto();
				$usuario_id = $mp->usuario()->getId();
				$data_hora = $mp->data_hora();

				$stmt->bindParam(":texto", $texto);
				$stmt->bindParam(":usuario_id", $usuario_id);
				$stmt->bindParam(":thread_id", $thread_id);
				$stmt->bindParam(":data_hora", $data_hora);

				return $stmt->execute();
			} catch (PDOException $e) { echo "<b>Erro (MPDao::Insert): </b>".$e->getMessage(); }
	}

	// ////// //
	// SELECT //
	// ////// //

	/**
	 * Popula um objeto MP a partir de um registro da tabela 'msgPrivada'
	 * @param array $row registro cujos índices são os nomes das colunas ($row['id_msg'], $row['texto']) etc.,
	 * proveniente de ->fetch(PDO::FETCH_ASSOC)
	 * @return MP
	 */
	public static function Popula($row) {
		$usuario = UsuarioDao::SelectPorId($row['usuario_id']);
		
		$mp = new MP;
		$mp->setId($row['id_msg']);
		$mp->setTexto($row['texto']);
		$mp->setData_hora($row['dtHr']);
		$mp->setUsuario($usuario);
		return $mp;
	}

	/**
	 * Consulta o BD por registros da tabela 'msgPrivada' a partir de
	 * critério e pesquisa (WHERE $criterio = $pesquisa)
	 * @param string $criterio coluna da tabela
	 * @param string $pesquisa valor nessa coluna
	 * @return array de objetos MP encontrados pela consulta
	 */
	public static function Select($criterio = 'texto', $pesquisa = '') {
		switch ($criterio) {
			case 'texto':
				$sql = "SELECT * FROM msgPrivada WHERE $criterio like '%$pesquisa%'";
				break;
			default:
				$sql = "SELECT * FROM msgPrivada WHERE $criterio = '$pesquisa'";
				break;
		}
		try {
			$query = Conexao::getInstance()->query($sql);
			while($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$msgs[] = self::Popula($row);
			}
		} catch (PDOException $e) { echo "<b>Erro (MPDao::Select): </b>".$e->getMessage(); }
		return $msgs;
	}
}
?>