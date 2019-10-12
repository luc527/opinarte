<?php

require_once "autoload.php";

class ArtistaDao
{
	public static $instance;

	public static function getInstance()
	{
		if (!isset(self::$instance)) {
			self::$instance = new ArtistaDao;
		}
		return self::$instance;
	}


	///////////////////////
	// FUNÇÕES DE SELECT //

	public static function Popula($row)
	{
		$artista = new Artista;
		$artista->setId($row['id_artista']);
		$artista->setNome($row['nome']);
		$artista->setDescricao($row['descricao']);
		$artista->setImagemUrl($row['imagemUrl']);

		return $artista;
	}

	public static function Select($criterio, $pesquisa = false)
	{
		try {
			switch ($criterio) {
				case 'nome':
				case 'descricao':
					$sql = "SELECT * FROM artista WHERE $criterio like '%$pesquisa%'";
					break;
				case 'id_artista':
					$sql = "SELECT * FROM artista WHERE $criterio = '$pesquisa'";
					break;
				case 'todos':
					$sql = "SELECT * FROM artista";
					break;
			}
			$query = Conexao::getInstance()->query($sql);
			$artistas = array();
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				array_push($artistas, self::Popula($row));
			}
			return $artistas;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public static function SelectPorId($id)
	{
		try {
			$sql = "SELECT * FROM artista WHERE id_artista = $id";
			$query = Conexao::getInstance()->query($sql);
			$row = $query->fetch(PDO::FETCH_ASSOC);
			return self::Popula($row);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public static function SelectGeneros(Artista $artista)
	{
		// Recebe um objeto artista sem gêneros (só com nome, descricao e imagemUrl)
		// E adiciona os gêneros a ele

		try {
			$id = $artista->getId();
			$sql = "SELECT * FROM artista_has_genero WHERE artista_id = $id";
			$query = Conexao::getInstance()->query($sql);

			$generos_id = array();
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				array_push($generos_id, $row['genero_id']);
			}

			for ($i = 0; $i < count($generos_id); $i++) {
				$genero = GeneroDao::SelectPorId($generos_id[$i]);
				$artista->setGenero($genero);
			}

			return $artista;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public static function SelectPorGenero(Genero $genero)
	{
		try {
			$genero_id = $genero->getId();

			$sql = "SELECT * FROM artista_has_genero WHERE genero_id = $genero_id";
			$query = Conexao::getInstance()->query($sql);

			$artistas_id = array();
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				array_push($artistas_id, $row['artista_id']);
			}

			$artistas = array();
			for ($i = 0; $i < count($artistas_id); $i++) {
				array_push($artistas, self::SelectPorId($artistas_id[$i]));
			}

			return $artistas;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public static function SelectObras(Artista $artista)
	{
		try {
			$id = $artista->getId();
			$sql = "SELECT * FROM artista_has_obra WHERE artista_id = $id";
			$query = Conexao::getInstance()->query($sql);

			$obras_id = array();
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				array_push($obras_id, $row['obra_id']);
			}

			for ($i = 0; $i < count($obras_id); $i++) {
				$obra = ObraDao::SelectPorId($obras_id[$i]);
				$artista->setObra($obra);
			}

			return $artista;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public static function SelectPorObra(Obra $obra)
	{
		try {
			$obra_id = $obra->getId();
			$sql = "SELECT * FROM artista_has_obra WHERE obra_id = $obra_id";
			$query = Conexao::getInstance()->query($sql);

			$arts_id = array();
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				array_push($arts_id, $row['artista_id']);
			}

			$artistas = array();
			for ($i = 0; $i < count($arts_id); $i++) {
				array_push($artistas, self::SelectPorId($arts_id[$i]));
			}

			return $artistas;
		} catch (Exception $e) { }
	}

	/**
	 * Popula um objeto Artista com seus comentários
	 * 
	 * @param Artista $artista
	 * @return Artista
	 */
	public static function SelectComentarios(Artista $artista)
	{
		$artista_id = $artista->getId();
		$sql = "SELECT * FROM cmt_artista WHERE artista_id = $artista_id ORDER BY dtHr DESC";
		try {
			$query = Conexao::getInstance()->query($sql);
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$artista->setComentario(ComentarioDao::Popula($row));
			}
		} catch (PDOException $e) {
			echo "<b>Erro (ArtistaDao::SelectComentarios): </b>" . $e->getMessage();
		}
		return $artista;
	}


	///////////////////////
	// FUNÇÕES DE INSERT //

	public static function Insert(Artista $artista)
	{
		try {
			$sql = "INSERT INTO artista (nome, descricao, imagemUrl) VALUES (:nome, :descricao, :imagemUrl)";
			$stmt = Conexao::getInstance()->prepare($sql);

			$stmt->bindParam(":nome", $nome);
			$stmt->bindParam(":descricao", $descricao);
			$stmt->bindParam(":imagemUrl", $imagemUrl);

			$nome = $artista->getNome();
			$descricao = $artista->getDescricao();
			$imagemUrl = $artista->getImagemUrl();

			return $stmt->execute();
		} catch (Exception $e) {
			echo "<b>Erro: </b>" . $e->getMessage();
		}
	}

	public static function InsertGeneros(Artista $artista)
	{
		$generos = $artista->getGeneros();

		try {
			for ($i = 0; $i < count($generos); $i++) {
				$sql = "INSERT INTO artista_has_genero (artista_id, genero_id) VALUES (:artista_id, :genero_id)";
				$stmt = Conexao::getInstance()->prepare($sql);

				$stmt->bindParam(":artista_id", $art_id);
				$stmt->bindParam(":genero_id", $gen_id);

				$art_id = $artista->getId();
				$gen_id = $generos[$i]->getId();

				$stmt->execute();
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public static function InsertObras(Artista $artista)
	{
		$obras = $artista->getObras();

		try {
			for ($i = 0; $i < count($obras); $i++) {
				$sql = "INSERT INTO artista_has_obra (artista_id, obra_id) VALUES (:artista_id, :obra_id)";
				$stmt = Conexao::getInstance()->prepare($sql);

				$stmt->bindParam(":artista_id", $art_id);
				$stmt->bindParam(":obra_id", $obra_id);

				$art_id = $artista->getId();
				$obra_id = $obras[$i]->getId();

				$stmt->execute();
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}


	///////////////////////
	// FUNÇÕES DE UPDATE //

	public static function Update(Artista $artista)
	{
		try {
			$sql = "UPDATE artista SET nome = :nome, descricao = :descricao, imagemUrl = :imagemUrl WHERE id_artista = :id";
			$stmt = Conexao::getInstance()->prepare($sql);

			$stmt->bindParam(":nome", $nome);
			$stmt->bindParam(":descricao", $descricao);
			$stmt->bindParam(":imagemUrl", $imagemUrl);
			$stmt->bindParam(":id", $id);

			$nome = $artista->getNome();
			$descricao = $artista->getDescricao();
			$imagemUrl = $artista->getImagemUrl();
			$id = $artista->getId();

			return $stmt->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}


	////////////////////////
	// FUNÇÕES DE DELETE //

	public static function Delete($id)
	{
		try {
			$sql = "DELETE FROM artista WHERE id_artista = :id";
			$stmt = Conexao::getInstance()->prepare($sql);
			$stmt->bindParam(":id", $id);
			return $stmt->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public static function DeleteGeneros(Artista $artista)
	{
		try {
			$generos = $artista->getGeneros();

			for ($i = 0; $i < count($generos); $i++) {
				$sql = "DELETE FROM artista_has_genero WHERE artista_id = :artista AND genero_id = :genero";
				$stmt = Conexao::getInstance()->prepare($sql);

				$stmt->bindParam(":artista", $art_id);
				$stmt->bindParam(":genero", $gen_id);

				$art_id = $artista->getId();
				$gen_id = $generos[$i]->getId();

				$stmt->execute();
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public static function DeleteObras(Artista $artista)
	{
		$obras = $artista->getObras();

		try {
			for ($i = 0; $i < count($obras); $i++) {
				$sql = "DELETE FROM artista_has_obra WHERE obra_id = :obra_id AND artista_id = :artista_id";
				$stmt = Conexao::getInstance()->prepare($sql);

				$stmt->bindParam(":obra_id", $id_obra);
				$stmt->bindParam(":artista_id", $id_artista);

				$id_obra = $obras[$i]->getId();
				$id_artista = $artista->getId();

				$stmt->execute();
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}
