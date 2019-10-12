<?php
require_once("autoload.php");

class ContribuicaoEstadoDao {
  /**
   * SELECT
   */
  public static function Popula ($row) {
    $estado_con = new ContribuicaoEstado;
    $estado_con->setId($row['id_estado']);
    $estado_con->setNome($row['descricao']);
    return $estado_con;
  }

  public static function SelectPorId ($id) {
    $sql = "SELECT * FROM estado_con WHERE id_estado = $id";
    try {
      $query = Conexao::getInstance()->query($sql);
      $row = $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo "<b>Erro (ContribuicaoEstadoDao::SelectPorId): </b>".$e->getMessage();
    }
    return self::Popula($row);
  }

  public static function Select () {
    $sql = "SELECT * FROM estado_con";
    $estados = array();
    try {
      $query = Conexao::getInstance()->query($sql);
      while($row = $query->fetch(PDO::FETCH_ASSOC)) {
        array_push($estados, self::Popula($row));
      }  
    } catch (PDOException $e) {
      echo "<b>Erro (ContribuicaoEstadoDao::Select): </b>" . $e->getMessage();
    }
    return $estados;
  }
}
?>