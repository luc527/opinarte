<?php
require_once('autoload.php');
class ListaItemDao {

  /**
   * INSERT
   */

  public static function Insert (ListaItem $item, $lista_id) {
    $sql = "INSERT INTO item (lista, descricao, posicao, obra, artista)
    VALUES (:lis, :des, :pos, :obr, :art)";
    try {
      $bd = Conexao::getInstance();
      $stmt = $bd->prepare($sql);

      $stmt->bindParam(":lis", $lista_id);
      $stmt->bindParam(":des", $des);
      $des = $item->getDescricao();
      $stmt->bindParam(":pos", $pos);
      $pos = $item->posicao();

      $stmt->bindParam(":obr", $obr);
      $stmt->bindParam(":art", $art);
      if ($item->item() instanceof Obra) {
        $obr = $item->item()->getId();
        $art = null;
      } else if ($item->item() instanceof Artista) {
        $obr = null;
        $art = $item->item()->getId();
      }

      return $stmt->execute();
    } catch (PDOException $e) {
      echo "<b>Erro (PDOException): </b>".$e->getMessage();
    }
  }


  /**
   * SELECT
   */

  public static function Popula($row) {
    $item = new ListaItem;
    $item->setId($row['id_item']);
    $item->setDescricao($row['descricao']);
    $item->setPosicao($row['posicao']);

    if(isset($row['obra'])) {
      $item->setItem( ObraDao::SelectPorId($row['obra']) );
    } else if (isset($row['artista'])) {
      $item->setItem( ArtistaDao::SelectPorId($row['artista']) );
    } else return null;

    return $item;
  }

  public static function SelectPorId($id) {
    $sql = "SELECT * FROM item WHERE id_item = $id";
    try {
      $query = Conexao::getInstance()->query($sql);
      return self::Popula($query->fetch(PDO::FETCH_ASSOC));
    } catch (PDOException $e) {
      echo "<b>Erro (PDOException): </b>".$e->getMessage();
    }
  }


  /**
   * DELETE
   */

  public static function Delete($id) {
    $sql = "DELETE FROM item WHERE id_item = :id";
    try {
      $stmt = Conexao::getInstance()->prepare($sql);
      $stmt->bindParam(":id", $id);
      return $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}
?>
