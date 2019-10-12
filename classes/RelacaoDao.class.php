<?php
require_once("autoload.php");

class RelacaoDao {


	/**
	 * SELECT
	 */
	public static function Popula($row) {
		$relacao = new Relacao;
		$relacao->setId($row['id_relacao']);
		$relacao->setDescricao($row['descricao']);
		$relacao->setFontes($row['fontes']);
		$relacao->setVotos($row['votos']);

		$objs = array();
		for($i = 1; $i <= 2; $i++) {
			if(isset($row['obra'.$i.'_id'])) {
				$objs[$i] = ObraDao::SelectPorId( $row['obra'.$i.'_id'] );
			} else if (isset($row['artista'.$i.'_id'])) {
				$objs[$i] = ArtistaDao::SelectPorId( $row['artista'.$i.'_id'] );
			} else if (isset($row['genero'.$i.'_id'])) {
				$objs[$i] = GeneroDao::SelectPorId( $row['genero'.$i.'_id'] );
			}
		}

		$relacao->setObj1( $objs[1] );
		$relacao->setObj2( $objs[2] );

		return $relacao;
	}

	public static function Select($criterio, $pesquisa) {
		switch ($criterio) {
			case 'descricao':
				$sql = "SELECT * FROM relacao WHERE descricao like '%$pesquisa%'";
				break;
			case 'todos':
				$sql = "SELECT * FROM relacao";
				break;
		}
		try {
			$bd = Conexao::getInstance();
			$query = $bd->query($sql);
			$relacoes = array();
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				array_push($relacoes, self::Popula($row));
			}
		} catch (PDOException $e) {
			echo "<b>Erro (RelacaoDao::Select): </b>".$e->getMessage();
		}
		return $relacoes;
	}
	
	public static function SelectPorId($id) {
		$sql = "SELECT * FROM relacao WHERE id_relacao = $id";
		try {
			$bd = Conexao::getInstance();
			$query = $bd->query($sql);
			$row = $query->fetch(PDO::FETCH_ASSOC);
			return self::Popula($row);
		} catch (PDOException $e) {
			echo "<b>Erro (RelacaoDao::SelectPorId):</b>".$e->getMessage();
		}
	}

	public static function SelectPorObj($obj_id, $tipo) {
		$sql = "SELECT id_relacao FROM relacao
		WHERE ".$tipo."1_id = ".$obj_id." OR ".$tipo."2_id = ".$obj_id;
		try {
			$bd = Conexao::getInstance();
			$query = $bd->query($sql);
			
			$relacoes = array();
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				array_push($relacoes, self::SelectPorId($row['id_relacao']) );
			}
		} catch (PDOException $e) {
			echo "<b>Erro (RelacaoDao::SelectPorObj): </b>".$e->getMessage();
		}
		return $relacoes;
	}


	/**
	 * INSERT
	 */
	public static function Insert(Relacao $relacao, $usuario_id){
		$obj1 = $relacao->getObj1();
		$obj2 = $relacao->getObj2();

		// Determina campos no $sql relativos aos objetos da relação
		if ($obj1 instanceof Obra) {
			$item1 = 'obra1_id';
		} else if ($obj1 instanceof Artista) {
			$item1 = 'artista1_id';
		} else if ($obj1 instanceof Genero) {
			$item1 = 'genero1_id';
		}
		if ($obj2 instanceof Obra) {
			$item2 = 'obra2_id';
		} else if ($obj2 instanceof Artista) {
			$item2 = 'artista2_id';
		} else if ($obj2 instanceof Genero) {
			$item2 = 'genero2_id';
		}

		$sql = "INSERT INTO relacao (descricao, ".$item1.", ".$item2.", fontes, usuario_id) VALUES
		(:descricao, :obj1, :obj2, :fontes, :usuario_id)";

		try {
			$bd = Conexao::getInstance();
			$stmt = $bd->prepare($sql);
		} catch (PDOException $e) {
			echo "<b>Erro no preparo (RelacaoDao::Insert): </b>".$e->getMessage();
		}

		$stmt->bindParam(":obj1", $obj1_id);
		$obj1_id = $obj1->getId();
		$stmt->bindParam(":obj2", $obj2_id);
		$obj2_id = $obj2->getId();

		$stmt->bindParam(":descricao", $descricao);
		$descricao = $relacao->getDescricao();
		$stmt->bindParam(":fontes", $fontes);
		$fontes = $relacao->getFontes();
		$stmt->bindParam(":usuario_id", $usuario_id);

		return $stmt->execute();
	}

	// ////// //
	// UPDATE //
	// ////// //
	/**
	 * Atualiza um registro da tabela relação, substituindo todos os campos pelos atribuídos no objeto enviado como parâmetro
	 */
	public static function Update (Relacao $relacao) {
		self::SetTodosObjsNull($relacao->getId());
		
		$obj[1] = $relacao->getObj1();
		$obj[2] = $relacao->getObj2();
		for ($i=1; $i <= 2; $i++) { 
			if ($obj[$i] instanceof Obra) {
				$col_obj[$i] = 'obra '. $i . "_id";
			} else if ($obj[$i] instanceof Artista) {
				$col_obj[$i] = 'artista' . $i . "_id";
			} else if ($obj[$i] instanceof Genero) {
				$col_obj[$i] = 'genero' . $i . "_id";
			} 
		}

		$sql = "UPDATE relacao SET " . $col_obj[1] . " = :obj1, " . $col_obj[2] . " = :obj2,
		descricao = :descricao, fontes = :fontes WHERE id_relacao = :id";
		try {
			$pdo = Conexao::getInstance();
			$stmt = $pdo->prepare($sql);

			$obj1 = $obj[1]->getId();
			$obj2 = $obj[2]->getId();
			$descricao = $relacao->getDescricao();
			$fontes = $relacao->getFontes();
			$id = $relacao->getId();
			$stmt->bindParam(":obj1", $obj1);
			$stmt->bindParam(":obj2", $obj2);
			$stmt->bindParam(":descricao", $descricao);
			$stmt->bindParam(":fontes", $fontes);
			$stmt->bindParam(":id", $id);

			return $stmt->execute();

		} catch (PDOException $e) {
			echo("<b>Erro (RelacaoDao::Update)</b>" . $e->getMessage());
		}

	}

	/**
	 * Faz com que todos os campos obra1_id, obra2_id, artista1_id etc. fiquem vazios. Isto é feito antes do update para que, caso sejam mudados os tipos de objetos da relação, os tipos anteriores não continuem registrados
	 */
	public static function SetTodosObjsNull ($id_relacao) {
		$sql = "UPDATE relacao SET obra1_id = null, obra2_id = null, artista1_id = null, artista2_id = null, genero1_id = null, genero2_id = null
		WHERE id_relacao = :id";
		try {
			$bd = Conexao::getInstance();
			$stmt = $bd->prepare($sql);
			$stmt->bindParam(":id", $id_relacao);
			
			return $stmt->execute();
		} catch (PDOException $e) {
			echo "<b>Erro (RelacaoDao::SetTodosObjsNull): </b>".$e->getMessage();
		}
	}
}
?>
