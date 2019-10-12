<?php
require_once("autoload.php");

class ContribuicaoDao {

  // ////// //
  // SELECT //
  // ////// //

  /**
   * Popula objeto com linha de um resultado de um SELECT 
   * @param mixed[] $row registro/linha da tabela 'contribuicao'
   * @return Contribuicao instância de Contribuicao populada pelo registro recebido
   */
  public static function Popula ($row) {
    $tipo_con = ContribuicaoTipoDao::SelectPorId($row['tipo_con_id']);
    $estado_con = ContribuicaoEstadoDao::SelectPorId($row['estado_con_id']);
    $obj = self::SelectObj($row);
    
    $con = new Contribuicao;
    $con->setId($row['id_contribuicao']);
    $con->setInformacao($row['informacao']);
    $con->setFontes($row['fontes']);
    $con->setComentario($row['adm_comentario']);
    $con->setTipo($tipo_con);
    $con->setEstado($estado_con);
    $con->setObj($obj);

    return $con;
  }

  public static function Select ($criterio, $pesquisa) {
    switch ($criterio) {
      case 'informacao':
      case 'fontes':
        $sql = "SELECT * FROM contribuicao WHERE $criterio like '%$pesquisa%'";
        break;

      case 'todos':
        $sql = "SELECT * FROM contribuicao";
        break;

      default:
        $sql = "SELECT * FROM contribuicao WHERE $criterio = '$pesquisa'";
        break;
    }
    try {
      $bd = Conexao::getInstance();
      $query = $bd->query($sql);
      $cons = array();
      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        array_push($cons, self::Popula($row));
      }
    } catch (PDOException $e) {
      echo "<b>Erro (ContribuicaoDao::Select): </b>".$e->getMessage();
    }
    return $cons;
  }

  /**
   * Consulta um registro da tabela 'informacao' por seu id
   * @param int $id ID do registro que se deseja consultar
   * @return Contribuicao objeto populado em InformacaoDao::Popula a partir do registro consultado
   */
  public static function SelectPorId(int $id) {
    $sql = "SELECT * FROM contribuicao WHERE id_contribuicao = $id";
    try {
      $bd = Conexao::getInstance();
      $query = $bd->query($sql);
      $row = $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo "<b>Erro (InformacaoDao::SelectPorId): </b>".$e->getMessage();
    }
    return self::Popula($row);
  }

  /**
   * Cria e popula objeto de uma informação (Obra, Artista etc.) pelo registro do BD da informação.
   * @param mixed[] $row linha de resultado de PDOStatement::fetch(PDO::FETCH_ASSOC) (um registro da tabela 'informacao')
   * @return Obra|Artista|Genero|LingArte objeto instanciado da informação, que será parâmetro de Informacao::setObj()
   */
  // Recebe a linha de uma informação e retorna o objeto dela (obra, artista etc)
  private static function SelectObj ($row) {
    if ($row['artista_id'] !== null) {
      $obj = new Artista;
      $obj->setId($row['artista_id']);
    } else if ($row['obra_id'] !== null) {
      $obj = new Obra;
      $obj->setId($row['obra_id']);
    } else if ($row['genero_id'] !== null) {
      $obj = new Genero;
      $obj->setId($row['genero_id']);
    } else if ($row['linguagensart_id'] !== null) {
      $obj = new LingArte;
      $obj->setId($row['linguagensart_id']);
    } else {
      return null;
    }
    return $obj;
  }


  // ////// //
  // INSERT //
  // ////// //

  /**
   * Cadastra uma informação no BD pelo seu objeto instanciado e pelo ID do usuário que a fez
   */
  public static function Insert (Contribuicao $contribuicao, $usuario_id) {
    if ($contribuicao->getObj() !== null) {
      $col_obj = self::ColObj($contribuicao->getObj()). " , ";
    } else {
      $col_obj = "";
    }

    $sql = "INSERT INTO contribuicao (informacao, fontes, ".$col_obj." tipo_con_id, usuario_id)
    VALUES (:info, :fontes, ";
    if ($contribuicao->getObj() !== null) {
      $sql .= " :obj, ";
    }
    $sql .= " :tipo, :usuario)";
    
    try {
      $bd = Conexao::getInstance();
      $stmt = $bd->prepare($sql);

      $info = $contribuicao->getInformacao();
      $fontes = $contribuicao->getFontes();
      if ($contribuicao->getObj() !== null) {  
        $obj = $contribuicao->getObj()->getId();
      }
      $tipo = $contribuicao->getTipo()->getId();
      $stmt->bindParam(":info", $info);
      $stmt->bindParam(":fontes", $fontes);
      if (isset($obj)) {
        $stmt->bindParam(":obj", $obj);
      }
      $stmt->bindParam(":tipo", $tipo);
      $stmt->bindParam(":usuario", $usuario_id);

      $stmt->execute();
      echo $stmt->rowCount();
    } catch (PDOException $e) {
      echo "<b>Erro (ContribuicaoDao::Insert): </b>".$e->getMessage();
    }
  }
  /**
   * Determina a qual coluna da tabela contribuicao o código de um objeto deve ir. Método usado no Insert.
   * @param Obra|Artista|Genero|LingArte $obj 
   * @return string nome da coluna a qual o código do objeto deve ir
   */
  public static function ColObj ($obj) {
    if ($obj instanceof Obra) {
      return 'obra_id';
    } else if ($obj instanceof Artista) {
      return 'artista_id';
    } else if ($obj instanceof Genero) {
      return 'genero_id';
    } else if ($obj instanceof LingArte) {
      return 'linguagensart_id';
    }
  }

  /**
   * Retorna se o usuário informado é o autor da contribucao informada
   * @return bool se o usuário é ou não o autor da contribucao
   */
  public static function UsuarioAutor(int $usuario_id, int $con_id) {
    $sql = "SELECT usuario_id FROM contribuicao WHERE id_contribuicao = $con_id AND usuario_id = $usuario_id";
    try {
      $query = Conexao::getInstance()->query($sql);
      $row = $query->fetch(PDO::FETCH_ASSOC);
      return $row['usuario_id'] == $usuario_id;
    } catch (PDOException $e) {
      echo "Erro: " . $e->getMessage();
    }
  }

  /**
   * Retorna verdadeiro se a contribuição informada foi avaliada por um administrador, e falso se não foi
   * @param int $con_id id da contribuição a ser verificada
   * @return bool se foi avaliada (true) ou não (false)
   */
  public static function ConAvaliada(int $con_id) {
    $sql = "SELECT adm_usuario_id FROM contribuicao WHERE id_contribuicao = $con_id";
    try {
      $bd = Conexao::getInstance();
      $query = $bd->query($sql);
      $row = $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo "<b>Erro (ContribuicaoDao::ConAvaliada): </b>".$e->getMessage();
    }
    return $row['adm_usuario_id'] !== null;
  }


  // ////// //
  // UPDATE //
  // ////// //

  /**
   * Atualiza uma contribuição alterando apenas as colunas relacionadas à sua avaliação (comentario, adm_usuario_id etc.)
   */
  public static function UpdateAval (Usuario $adm) {
    $con = $adm->getContribuicoesAval()[0];
    $sql = "UPDATE contribuicao SET adm_comentario = :comentario,
    adm_usuario_id = :adm_id, estado_con_id = :estado
    WHERE id_contribuicao = :id";
    try {
      $bd = Conexao::getInstance();
      $stmt = $bd->prepare($sql);
      $comentario = $con->getComentario();
      $adm_id = $adm->getId();
      $estado = $con->getEstado()->getId();
      $id = $con->getId();
      $stmt->bindParam(":comentario", $comentario);
      $stmt->bindParam(":adm_id", $adm_id);
      $stmt->bindParam(":estado", $estado);
      $stmt->bindParam(":id", $id);
      return $stmt->execute();
    } catch (PDOException $e) {
      echo "<b>Erro (ContribuicaoDao::UpdateAval): </b>".$e->getMessage();
    }
  }
  
  
  // ////// //
  // DELETE //
  // ////// //

  public static function Delete ($con_id) {
    $sql = "DELETE FROM contribuicao WHERE id_contribuicao = :id";
    try {
      $bd = Conexao::getInstance();
      $stmt = $bd->prepare($sql);
      $stmt->bindParam(":id", $con_id);
    } catch (PDOException $e) {
      echo "<b>Erro (ContribuicaoDao::Delete): </b>".$e->getMessage();
    }
    return $stmt->execute();
  }
}
?>