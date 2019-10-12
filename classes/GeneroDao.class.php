<?php

require_once "autoload.php";

class GeneroDao {
	public static $instance;

	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new GeneroDao;
		}
		return self::$instance;
	}


	///////////////////////
	// FUNÇÕES DE SELECT //

	public static function Popula($row) {
		$genero = new Genero;
		$genero->setId($row['id']);
		$genero->setNome($row['nome']);
		$genero->setDescricao($row['descricao']);

		return $genero;
	}

	public static function Select($criterio, $pesquisa) {
		switch ($criterio) {
			case 'nome':
			case 'descricao':
				$sql = "SELECT * FROM genero WHERE $criterio like '%$pesquisa%'";
				break;

			case 'id':
				$sql = "SELECT * FROM genero WHERE $criterio = '$pesquisa'";
				break;				

			case 'lingArte':
				// O usuário digita o nome da linguagem, mas a pesquisa deve ser feita pelo ID
				$lingArte = LingArteDao::Select('nome', $pesquisa)[0];
				$lingArte_id = $lingArte->getId();
				$sql = "SELECT * FROM genero WHERE $criterio = '$lingArte_id'";
				break;

			case 'todos':
				$sql = "SELECT * FROM genero";
				break;
		}

		$query = Conexao::getInstance()->query($sql);

		$generos = array();
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			array_push($generos, self::Popula($row));
		}
		return $generos;
	}

	public static function SelectPorId($id) {
		$genero = self::Select('id', $id);
		return $genero[0];
	}

	/*public static function SelectPorArtista($artista_id) {
		try {	
			$sql = "SELECT * FROM artista_has_genero WHERE artista_id = $artista_id";
			$query = Conexao::getInstance()->query($sql);
			
			$generos_id = array();
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				array_push($generos_id, $row['genero_id']);
			}

			$generos = array();
			for ($i=0; $i < count($generos_id); $i++) { 
				array_push($generos, self::SelectPorId($generos_id[$i]));
			}

			return $generos;		
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	*/

	////////////////////////
	// FUNÇÕES DE INSERIR //

	public static function Insert(Genero $genero, $lingArte_id) {
		try {
			$sql = "INSERT INTO genero (nome, descricao, lingArte) VALUES (:nome, :descricao, :lingArte)";
			$stmt = Conexao::getInstance()->prepare($sql);

			$stmt->bindParam(":nome", $nome);
			$stmt->bindParam(":descricao", $descricao);
			$stmt->bindParam(":lingArte", $lingArte_id);

			$nome = $genero->getNome();
			$descricao = $genero->getDescricao();

			return $stmt->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}


	///////////////////////
	// FUNÇÕES DE UPDATE //

	public static function Update(Genero $genero, $lingArte_id) {
		try {
			$sql = "UPDATE genero SET nome = :nome, descricao = :descricao, lingArte = :lingArte WHERE id = :id";
			$stmt = Conexao::getInstance()->prepare($sql);

			$stmt->bindParam(":nome", $nome);
			$stmt->bindParam(":descricao", $descricao);
			$stmt->bindParam(":lingArte", $lingArte_id);
			$stmt->bindParam(":id", $id);

			$nome = $genero->getNome();
			$descricao = $genero->getDescricao();
			$id = $genero->getId();

			return $stmt->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}


	///////////////////////
	// FUNÇÕES DE DELETE //

	public static function Delete($id) {
		try {
			$sql = "DELETE FROM genero WHERE id = :id";
			$stmt = Conexao::getInstance()->prepare($sql);
			$stmt->bindParam(":id", $id);
			return $stmt->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public static function DeleteObra($id_obra) {
		try {
			$sql = "DELETE FROM obra_has_genero WHERE obra_id = :id";
			$stmt = Conexao::getInstance()->prepare($sql);
			$stmt->bindParam(":id", $id_obra);
			return $stmt->execute();
			//echo "<br/>".$stmt->rowCount();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}

?>