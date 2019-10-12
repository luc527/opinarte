<?php

require_once "autoload.php";

class LingArteDao {
	
	
	///////////////////////
	// FUNÇÕES DE SELECT //

	public static function Popula($row) {
		$lingArte = new LingArte;
		$lingArte->setId($row['id']);
		$lingArte->setNome($row['nome']);
		$lingArte->setDescricao($row['descricao']);

		return $lingArte;
	}

	public static function Select($criterio, $pesquisa = false) {
		try {

			switch ($criterio) {
				case 'nome':
				case 'descricao':
					$sql = "SELECT * FROM linguagensArt WHERE $criterio like '%$pesquisa%'";
					break;
				
				case 'id':
					$sql = "SELECT * FROM linguagensArt WHERE $criterio = '$pesquisa'";
					break;

				case 'todos':
					$sql = "SELECT * FROM linguagensArt";
					break;
			}

			$query = Conexao::getInstance()->query($sql);
			
			$lingArtes = array();

			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				array_push($lingArtes, self::Popula($row));
			}

			return $lingArtes;
				
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public static function SelectPorId($id) {
		$ling = self::Select('id', $id);
		return $ling[0];
	}

	public static function SelectPorGenero(Genero $genero) {
		try {
			$id = $genero->getId();

			$sql = "SELECT lingArte FROM genero WHERE id = $id";
			$query = Conexao::getInstance()->query($sql);
			$row = $query->fetch(PDO::FETCH_ASSOC);

			$lingArte = LingArteDao::SelectPorId( $row['lingArte'] );
			$lingArte->setGenero($genero);
			
			return $lingArte;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public static function SelectGeneros(LingArte $lingArte) {
		try {
			$id = $lingArte->getId();
			$sql = "SELECT * FROM genero WHERE lingArte = $id";
			$query = Conexao::getInstance()->query($sql);
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$lingArte->setGenero( GeneroDao::Popula($row) );
			}

			return $lingArte;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	///////////////////////
	// FUNÇÕES DE INSERT //

	public static function Insert(LingArte $lingArte) {
		try {
			$sql = "INSERT INTO linguagensArt (nome, descricao) VALUES (:nome, :descricao)";
			$stmt = Conexao::getInstance()->prepare($sql);

			$stmt->bindParam(":nome", $nome);
			$stmt->bindParam(":descricao", $descricao);

			$nome = $lingArte->getNome();
			$descricao = $lingArte->getDescricao();

			return $stmt->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public static function InsertGeneros(LingArte $lingArte) {
		$generos = $lingArte->getGeneros();
		for ($i=0; $i < count($generos); $i++) { 
			GeneroDao::Insert($generos[$i], $lingArte->getId());
		}
	}


	///////////////////////
	// FUNÇÕES DE UPDATE //

	public static function Update(LingArte $lingArte) {
		try {
			$sql = "UPDATE linguagensArt SET nome = :nome, descricao = :descricao WHERE id = :id";
			$stmt = Conexao::getInstance()->prepare($sql);

			$stmt->bindParam(":nome", $nome);
			$stmt->bindParam(":descricao", $descricao);
			$stmt->bindParam(":id", $id);

			$nome = $lingArte->getNome();
			$descricao = $lingArte->getDescricao();
			$id = $lingArte->getId();

			return $stmt->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public static function UpdateGeneros(LingArte $lingArte) {
		$lingArte_id = $lingArte->getId();
		$generos = $lingArte->getGeneros();
		for ($i=0; $i < count($generos); $i++) { 
			GeneroDao::Update($generos[$i], $lingArte_id);
		}
	}


	////////////////////////
	// FUNÇÕES DE DELETAR //

	public static function Delete( $id ) {
		try {
			$sql = "DELETE FROM linguagensArt WHERE id = :id";
			$stmt = Conexao::getInstance()->prepare($sql);
			$stmt->bindParam(":id", $id);
			return $stmt->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}


?>