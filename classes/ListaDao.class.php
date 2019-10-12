<?php
require_once('autoload.php');
class ListaDao {

  /**
   * INSERT
   */

  public static function Insert(Lista $lista, $autor_id) {
    $sql = "INSERT INTO lista (id_lista, autor, dtHr, nome, descricao, ordenacao)
    VALUES (:id, :autor, :datahr, :nome, :descricao, :ordem)";
    try {
      $stmt = Conexao::getInstance()->prepare($sql);

      $stmt->bindParam(":id", $id);
      $stmt->bindParam(":autor", $autor_id);
      $stmt->bindParam(":datahr", $datahr);
      $stmt->bindParam(":nome", $nome);
      $stmt->bindParam(":descricao", $descricao);
      $stmt->bindParam(":ordem", $ordem);
      $id = $lista->getId();
      $datahr = $lista->datahr();
      $nome = $lista->getNome();
      $descricao = $lista->getDescricao();
      $ordem = $lista->ordem();

      return $stmt->execute();
    } catch (PDOException $e) {
      echo "<b>Erro (PDOException): </b>".$e->getMessage();
    }
  }


  /**
   * SELECT
   */

  public static function Popula($row) {
    $lista = new Lista;
    $lista->setId($row['id_lista']);
    $lista->setNome($row['nome']);
    $lista->setDescricao($row['descricao']);
    $lista->setOrdem($row['ordenacao']);
    $lista->setDatahr($row['dtHr']);

    return $lista;
  }

  public static function Select($criterio, $pesquisa) {
    switch ($criterio) {
      case 'nome':
      case 'descricao':
        $sql = "SELECT * FROM lista WHERE $criterio like '%$pesquisa%'";
        break;

      case 'todos':
        $sql = "SELECT * FROM lista";
        break;

      default:
        $sql = "SELECT * FROM lista WHERE $criterio = '$pesquisa'";
        break;
    }
    try {
      $query = Conexao::getInstance()->query($sql);
      $listas = array();
      while($row = $query->fetch(PDO::FETCH_ASSOC)) {
        array_push($listas, self::Popula($row));
      }
      return $listas;
    } catch (PDOException $e) {
      echo "Erro: ".$e->getMessage();
    }
  }

  public static function SelectPorId($id) {
    return self::Select('id_lista', $id)[0];
  }

  public static function SelectItens(Lista $lista) {
    $lista_id = $lista->getId();
    $sql = "SELECT * FROM item WHERE lista = $lista_id ORDER BY posicao";
    try {
      $query = Conexao::getInstance()->query($sql);
      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $lista->setItem( ListaItemDao::SelectPorId($row['id_item']) );
      }
      return $lista;
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public static function SelectPorItem($id, $tipo) {
    if ($tipo == 'obra') $sql = "SELECT * FROM item WHERE obra = $id";
    else if ($tipo == 'artista') $sql = "SELECT * FROM item WHERE artista = $id";

    $listas = array();
    try {
      $bd = Conexao::getInstance();
      $query = $bd->query($sql);
      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        array_push($listas, self::SelectPorId($row['lista']) );
      }
    } catch (PDOException $e) {
      echo "<b>Erro (PDOException): </b>".$e->getMessage();
    }

    return $listas;
  }

  public static function UsuarioAutor($usuario_id, $lista_id) {
    // Retorna valor booleano (esse usuário é autor dessa lista?)
    $sql = "SELECT autor FROM lista WHERE id_lista = $lista_id AND autor = $usuario_id";
    try {
      $query = Conexao::getInstance()->query($sql);
      $row = $query->fetch(PDO::FETCH_ASSOC);
      return $row['autor'] == $usuario_id;
    } catch (PDOException $e) {
      echo "Erro: ".$e->getMessage();
    }
  }


  /**
   * UPDATE
   */

  public static function Update (Lista $lista) {
    $sql = "UPDATE lista SET nome = :nome, descricao = :descricao,
    ordenacao = :ordenacao, dtHr = :dthr WHERE id_lista = :id_lista";
    try {
      $bd = Conexao::getInstance();
      $stmt = $bd->prepare($sql);

      $stmt->bindParam(":nome", $nome);
      $nome = $lista->getNome();
      $stmt->bindParam(":descricao", $descricao);
      $descricao = $lista->getDescricao();
      $stmt->bindParam(":ordenacao", $ordenacao);
      $ordenacao = $lista->ordem();
      $stmt->bindParam(":dthr", $dthr);
      $dthr = $lista->datahr();
      $stmt->bindParam(":id_lista", $id_lista);
      $id_lista = $lista->getId();

      return $stmt->execute();
    } catch (PDOException $e) {
      echo "<b>Erro (PDOException): </b>".$e->getMessage();
    }
  }


  /**
   * DELETE
   */

  public static function Delete($id) {
    $sql = "DELETE FROM lista WHERE id_lista = :id";
    try {
      $stmt = Conexao::getInstance()->prepare($sql);
      $stmt->bindParam(":id", $id);
      return $stmt->execute();
    } catch (PDOExcpetion $e) {
      echo "<b>Erro (PDOException): </b>".$e->getMessage();
    }
  }
}
?>
