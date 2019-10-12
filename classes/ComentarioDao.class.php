<?php
require_once('autoload.php');

class ComentarioDao
{

  /**
   * SelectComentarios : Seleciona do BD e popula um objeto com seus comentários
   * 
   * @param Artista|Obra|Resenha|Lista|Usuario $objeto objeto sem comentários
   * 
   * @return Artista|Obra|Resenha|Lista|Usuario objeto populado com comentários
   */
  public static function SelectComentarios($objeto)
  {
    $objeto_id = $objeto->getId();

    $entidade = strtolower(get_class($objeto)); // 'Artista' -> 'artista'
    $sql = "SELECT * FROM cmt_{$entidade}
    WHERE {$entidade}_id = {$objeto_id}
    ORDER BY noLikes DESC, dtHr DESC";

    $metodo = $objeto instanceof Usuario ?
      'setComentario_recebido'
      : 'setComentario'; // $usuario->setComentario_recebido($...); | $obra->setComentario($...);

    try {
      $query = Conexao::getInstance()->query($sql);
      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $objeto->$metodo(self::Popula($row));
      }
    } catch (PDOException $e) {
      echo "<b>Erro (ComentarioDao::SelectComentarios): </b>" . $e->getMessage();
    }
    return $objeto;
  }

  /**
   * Popula : Instancia um objeto Comentario por um registro do BD
   * 
   * @param array $row linha do registro no BD
   * @return Comentario
   */
  public static function Popula($row)
  {
    if (isset($row['id_cmt_artista'])) $row_id = $row['id_cmt_artista'];
    else if (isset($row['id_cmt_obra'])) $row_id = $row['id_cmt_obra'];
    else if (isset($row['id_cmt_resenha'])) $row_id = $row['id_cmt_resenha'];
    else if (isset($row['id_cmt_lista'])) $row_id = $row['id_cmt_lista'];
    else if (isset($row['id_cmt_usuario'])) $row_id = $row['id_cmt_usuario'];

    $cmt = new Comentario;
    $cmt->setId($row_id);
    $cmt->setTexto($row['texto']);
    $cmt->setNoLikes($row['noLikes']);
    $cmt->setData_hora($row['dtHr']);
    return $cmt;
  }

  /**
   * InsertComentario : Insere um comentário no banco de dados
   *
   * @param Comentario $comentario 
   * @param mixed $usuario_id usuário que fez o comentário
   * @param array 'componente' => 'obra|artista|resenha|etc' e 'componente_id' => 1|10|etc
   */
  public static function InsertComentario($comentario, $usuario_id, $componente)
  {
    switch ($componente['componente']) {
      case 'usuario':
        $sql = "INSERT INTO cmt_usuario (texto, dtHr, usuario_id, usuario_comentado_id)
        VALUES (:texto, :data_hora, :usuario_id, :componente_id)";
        break;
      default:
        $sql = "INSERT INTO cmt_{$componente['componente']}
        (texto, dtHr, usuario_id, {$componente['componente']}_id)
        VALUES (:texto, :data_hora, :usuario_id, :componente_id)";
        break;
    }

    try {
      $stmt = Conexao::getInstance()->prepare($sql);

      $texto = $comentario->texto();
      $data_hora = $comentario->data_hora();

      $stmt->bindParam(":texto", $texto);
      $stmt->bindParam(":data_hora", $data_hora);
      $stmt->bindParam(":usuario_id", $usuario_id);
      $stmt->bindParam(":componente_id", $componente['componente_id']);
    } catch (PDOException $e) {
      echo "<b>Erro (ComentarioDao::InsertComentarios): </b>" . $e->getMessage();
    }

    return $stmt->execute();
  }

  /**
   * AddLike : Incrementa em 1 o número de likes de um comentário
   * 
   * @param mixed $comentario_id id do comentário recebendo like
   * @param string $componente 'artista'|'obra' etc. -- determina que tabela alterar (cmt_artista, cmt_obra...) 
   */
  public static function AddLike($comentario_id, $componente)
  {
    $sql = "UPDATE cmt_{$componente} SET noLikes = noLikes + 1 WHERE id_cmt_{$componente} = :comentario_id";
    try {
      $stmt = Conexao::getInstance()->prepare($sql);
      $stmt->bindParam(":comentario_id", $comentario_id);
    } catch (PDOException $e) {
      echo "<b>Erro (ComentarioDao::AddLike): </b>" . $e->getMessage();
    }
    return $stmt->execute();
  }
}
