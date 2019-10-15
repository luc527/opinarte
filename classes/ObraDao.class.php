<?php

require_once "autoload.php";

class ObraDao
{


	///////////////////////
	// FUNÇÕES DE SELECT //

	public static function Popula($row)
	{
		$obra = new Obra;
		$obra->setId($row['id_obra']);
		$obra->setNome($row['nome']);
		$obra->setDescricao($row['descricao']);
		$obra->setData_lancamento($row['dtLancamento']);
		$obra->setImagemUrl($row['imagemUrl']);

		return $obra;
	}

	public static function Select($criterio, $pesquisa = false)
	{
		try {

			switch ($criterio) {
				case 'nome':
				case 'descricao':
					$sql = "SELECT * FROM obra WHERE $criterio like '%$pesquisa%'";
					break;

				case 'id_obra':
				case 'dtLancamento':
					$sql = "SELECT * FROM obra WHERE $criterio = '$pesquisa'";
					break;

				case 'todos':
					$sql = "SELECT * FROM obra ";
					break;
			}

			$query = Conexao::getInstance()->query($sql);

			$obras = array();

			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				array_push($obras, self::Popula($row));
			}

			return $obras;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public static function SelectPorId($id)
	{
		try {
			$sql = "SELECT * FROM obra WHERE id_obra = $id";
			$query = Conexao::getInstance()->query($sql);
			$row = $query->fetch(PDO::FETCH_ASSOC);
			return self::Popula($row);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public static function SelectGeneros(Obra $obra)
	{
		try {
			$obra_id = $obra->getId();

			$sql = "SELECT * FROM obra_has_genero WHERE obra_id = $obra_id";
			$query = Conexao::getInstance()->query($sql);

			$generos_id = array();
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				array_push($generos_id, $row['genero_id']);
			}

			for ($i = 0; $i < count($generos_id); $i++) {
				$obra->setGenero(GeneroDao::SelectPorId($generos_id[$i]));
			}

			return $obra;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public static function SelectPorGenero(Genero $genero)
	{
		try {
			$genero_id = $genero->getId();

			$sql = "SELECT * FROM obra_has_genero WHERE genero_id = $genero_id";
			$query = Conexao::getInstance()->query($sql);

			$obras_id = array();
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				array_push($obras_id, $row['obra_id']);
			}

			$obras = array();
			for ($i = 0; $i < count($obras_id); $i++) {
				array_push($obras, ObraDao::SelectPorId($obras_id[$i]));
			}

			return $obras;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	/**
	 * Popula um objeto Obra com seus comentários
	 */
	public static function SelectComentarios(Obra $obra)
	{
		$obra_id = $obra->getId();
		$sql = "SELECT * FROM cmt_obra WHERE obra_id = $obra_id ORDER BY dtHr DESC";
		try {
			$query = Conexao::getInstance()->query($sql);
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$obra->setComentario(ComentarioDao::Popula($row));
			}
		} catch (PDOException $e) {
			echo "<b>Erro (ObraDao::SelectComentarios): </b>" . $e->getMessage();
		}
		return $obra;
	}

	/**
	 * Consulta o BD e calcula a nota média de uma obra
	 * 
	 * @param Obra $obra obra sem nota média
	 * 
	 * @return Obra obra com nota média
	 */
	public static function SelectNotaMedia(Obra $obra)
	{
		$obra_id = $obra->getId();
		$sql = "SELECT AVG(nota) as 'notaMedia' FROM usuario_nota_obra WHERE obra_id = {$obra_id}";
		try {
			$query = Conexao::getInstance()->query($sql);
			$row = $query->fetch(PDO::FETCH_ASSOC);
			$obra->setNotaMedia($row['notaMedia']);
		} catch (PDOException $e) {
			die("<b>Could not get average rating of artwork (ObraDao@SelectNotaMedia): </b>" . $e->getMessage());
		}
		return $obra;
	}

	///////////////////////
	// FUNÇÕES DE INSERT //

	public static function Insert(Obra $obra)
	{
		try {
			$sql = "INSERT INTO Obra (nome, descricao, dtLancamento, imagemUrl) VALUES (:nome, :descricao, :dtLancamento, :imagemUrl)";
			$stmt = Conexao::getInstance()->prepare($sql);

			$stmt->bindParam(":nome", $nome);
			$stmt->bindParam(":descricao", $descricao);
			$stmt->bindParam(":dtLancamento", $dtLancamento);
			$stmt->bindParam(":imagemUrl", $imagemUrl);

			$nome = $obra->getNome();
			$descricao = $obra->getDescricao();
			$dtLancamento = $obra->getData_lancamento();
			$imagemUrl = $obra->getImagemUrl();

			return $stmt->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public static function InsertGeneros(Obra $obra)
	{
		try {
			$generos = $obra->getGeneros();

			for ($i = 0; $i < count($generos); $i++) {
				$sql = "INSERT INTO obra_has_genero (obra_id, genero_id) VALUES (:obra, :genero)";
				$stmt = Conexao::getInstance()->prepare($sql);

				$stmt->bindParam(":obra", $obra_id);
				$stmt->bindParam(":genero", $genero_id);

				$obra_id = $obra->getId();
				$genero_id = $generos[$i]->getId();

				$stmt->execute();
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}


	///////////////////////
	// FUNÇÕES DE UPDATE //

	public static function Update(Obra $obra)
	{
		try {
			$sql = "UPDATE obra SET nome = :nome, descricao = :descricao, dtLancamento = :data, imagemUrl = :imagemUrl WHERE id_obra = :id";
			$stmt = Conexao::getInstance()->prepare($sql);

			$stmt->bindParam(":nome", $nome);
			$stmt->bindParam(":descricao", $descricao);
			$stmt->bindParam(":data", $data);
			$stmt->bindParam(":imagemUrl", $imagemUrl);
			$stmt->bindParam(":id", $id);

			$nome = $obra->getNome();
			$descricao = $obra->getDescricao();
			$data = $obra->getData_lancamento();
			$imagemUrl = $obra->getImagemUrl();
			$id = $obra->getId();

			return $stmt->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}


	///////////////////////
	// FUNÇÕES DE DELETE //

	public static function Delete($id)
	{
		try {
			// Deleta as relações da obra com os gêneros
			GeneroDao::DeleteObra($id);

			// Deleta as relações da obra com artistas
			ArtistaDao::DeleteObrasPorId($id);

			$sql = "DELETE FROM obra WHERE id_obra = :id";
			$stmt = Conexao::getInstance()->prepare($sql);
			$stmt->bindParam(":id", $id);
			return $stmt->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public static function DeleteGeneros(Obra $obra)
	{
		try {
			$generos = $obra->getGeneros();

			for ($i = 0; $i < count($generos); $i++) {
				$sql = "DELETE FROM obra_has_genero WHERE obra_id = :obra_id AND genero_id = :genero_id";
				$stmt = Conexao::getInstance()->prepare($sql);

				$stmt->bindParam(":obra_id", $obra_id);
				$stmt->bindParam(":genero_id", $genero_id);

				$obra_id = $obra->getId();
				$genero_id = $generos[$i]->getId();

				$stmt->execute();
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}
