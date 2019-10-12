<?php
require_once('autoload.php');
class ResenhaDao {

	/**
	 * FUNÇÕES SELECT
	 */

	public static function Popula($row) {
		/**
		 * OBS: Retorna um objeto Usuario com o obj Resenha dentro, não
		 * um objeto resenha. Só assim é possível identificar a autoria
		 * de uma resenha
		 */

		$usuario = new Usuario;
		$usuario->setId($row['usuario_id']);

		$obra = new Obra;
		$obra->setId($row['obra_id']);

		$resenha = new Resenha;
		$resenha->setId($row['id_resenha']);
		$resenha->setTexto($row['texto']);
		$resenha->setObra($obra);
		$resenha->setDataHora($row['dtHr']);

		$usuario->setResenha($resenha);

		return $usuario;
	}

	public static function SelectPorId($id) {
		$sql = "SELECT * FROM resenha WHERE id_resenha = $id";
		try {
			$query = Conexao::getInstance()->query($sql);
			return self::Popula($query->fetch(PDO::FETCH_ASSOC));
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public static function SelectPorObra($obra_id) {
		try {
			$sql = "SELECT * FROM resenha WHERE obra_id = $obra_id";
			$query = Conexao::getInstance()->query($sql);

			$usuarios = array(); // porque as resenhas precisam estar dentro de um usuário p/ terem autoria
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				array_push($usuarios, self::Popula($row));
			}

			return $usuarios;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	/**
	 * FUNÇÕES INSERT
	 */

	public static function InsertResenhas(Usuario $usuario) {
		$resenhas = $usuario->getResenhas();
		for ($i=0; $i < count($resenhas); $i++) {
			try {
				$sql = "INSERT INTO resenha (usuario_id, obra_id, texto, dtHr) VALUES (:us, :ob, :tx, :dt)";
				$stmt = Conexao::getInstance()->prepare($sql);

				$stmt->bindParam(":us", $us);
				$stmt->bindParam(":ob", $ob);
				$stmt->bindParam(":tx", $tx);
				$stmt->bindParam(":dt", $dt);
				$us = $usuario->getId();
				$ob = $resenhas[$i]->getObra()->getId();
				$tx = $resenhas[$i]->getTexto();
				$dt = $resenhas[$i]->getDataHora();

				$stmt->execute();
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
	}

	public static function UpdateResenha($resenha) {
		$sql = "UPDATE resenha SET texto = :texto , dtHr = :data  WHERE id_resenha = :id";
		try {
			$stmt = Conexao::getInstance()->prepare($sql);

			$stmt->bindParam(":texto", $texto);
			$stmt->bindParam(":data", $data);
			$stmt->bindParam(":id", $id);
			$texto = $resenha->getTexto();
			$data = $resenha->getDataHora();
			$id = $resenha->getId();

			return $stmt->execute();
		} catch (PDOExcpetion $e) {
			echo $e->getMessage();
		}
	}

	public static function DeleteResenha($res_id) {
		$sql = "DELETE FROM resenha WHERE id_resenha = :res_id";
		try {
			$stmt = Conexao::getInstance()->prepare($sql);
			$stmt->bindParam(":res_id", $res_id);
			return $stmt->execute();
		} catch (PDOExcpetion $e) {
			echo $e->getMessage();
		}
	}
}
?>
