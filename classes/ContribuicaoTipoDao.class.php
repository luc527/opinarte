<?php
require_once("autoload.php");

class ContribuicaoTipoDao
{
  /**
   * SELECT
   */
  public static function Popula($row)
  {
    $tipo_con = new ContribuicaoTipo;
    $tipo_con->setId($row['id_tipo']);
    $tipo_con->setNome($row['descricao']);
    return $tipo_con;
  }

  public static function SelectPorId($id)
  {
    $sql = "SELECT * FROM tipo_con WHERE id_tipo = $id";
    try {
      $query = Conexao::getInstance()->query($sql);
      $row = $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo "<b>Erro (ContribuicaoTipoDao::SelectPorId): </b>" . $e->getMessage();
    }
    return self::Popula($row);
  }

  public static function Select()
  {
    $sql = "SELECT * FROM tipo_con";
    $tipos = array();
    try {
      $query = Conexao::getInstance()->query($sql);
      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        array_push($tipos, self::Popula($row));
      }
    } catch (PDOException $e) {
      echo "<b>Erro (ContribuicaoTipoDao::Select): </b>" . $e->getMessage();
    }
    return $tipos;
  }
}
