<?php

/**
 * Classe pai para as conexões com o banco de dados.
 */
class Bd
{

  /**
   * Conexão principal do banco de dados.
   *
   * @var PDO
   */
  private static $conn1;

  /**
   * Conexão secundária do banco de dados.
   *
   * @var PDO
   */
  private static $conn2;


  /**
   * Inicia as conexões.
   */
  public static function start()
  {
    // Chama a conexão.
    if (DB1)
      Self::getConn1();
    if (DB2)
      Self::getConn2();
  }

  /**
   * Solicita a conexão com o banco de dados 1. Padrão singleton.
   *
   * @return $conn
   */
  public static function getConn1()
  {

    if (empty(Self::$conn1)) {
      try {
        Self::$conn1 = new PDO(DB1_DBMANAGER . ":host=" . DB1_HOST . ';port=' . DB1_PORT . ';dbname=' . DB1_DBNAME . ';charset=' . DB1_CHARSET, DB1_USER, DB1_PASSWORD);
        Self::$conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
      } catch (PDOException $error) {
        echo $error->getMessage();
      }
    }
    return Self::$conn1;
  }




  /**
   * Solicita a conexão com o banco de dados 2. Padrão singleton.
   *
   * @return $conn
   */
  public static function getConn2()
  {

    if (empty(Self::$conn2)) {
      try {
        Self::$conn2 = new PDO(DB2_DBMANAGER . ":host=" . DB2_HOST . ';port=' . DB2_PORT . ';dbname=' . DB2_DBNAME . ';charset=' . DB2_CHARSET, DB2_USER, DB2_PASSWORD);
        Self::$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
      } catch (PDOException $error) {
        echo $error->getMessage();
      }
    }
    return Self::$conn2;
  }




  /**
   * Executa função padrão de retornar 10 valores da tabela selecionada.
   *
   * @param string $table
   * @param string $limit
   * @param PDO $conn
   * @return void
   */
  public static function getAll($table, $limit = "9 OFFSET 0", $conn = null)
  {
    // Verifica qual conexão utilizar.
    if (!$conn)
      $conn = Self::$conn1;

    $result = $conn->query("SELECT * FROM $table WHERE 1 LIMIT $limit", PDO::FETCH_ASSOC);

    return $result->fetchAll();
  }



  /**
   * Retorna todas as tabelas ou a solicitada.
   * [$table_name] já acrescenta o prefixo. Basta colocar o nome final da tabela.
   *
   * @param string $table_name
   * @param PDO $conn
   * @return void
   */
  public static function getTables($table_name = '', $conn = null)
  {
    // Verifica qual conexão utilizar.
    if (!$conn)
      $conn = Self::$conn1;

    // Caso passe o nome da tabela, cria o wherer para filtrar.
    if ($table_name)
      $table_name =  "WHERE Tables_in_" . DB1_DBNAME . " LIKE '" . DB1_PREFIX_TABLE . "$table_name'";

    // Monta a Sql com filtro ou sem nada.
    $sql = "SHOW TABLES $table_name";
    // Executa a query e retorna um PDO Object.
    $result = $conn->query($sql, PDO::FETCH_ASSOC);
    // Retorna um array associativo dos valores.
    return $result->fetchAll();
  }



  /**
   * Função genérica para criação de tabelas conforme os parâmetros passados.
   * Preencha o nome da tabela.
   * Preencha o array com "nome_campo tipo_campo" (sem chave, apenas valores).
   *
   * @param string $table_name
   * @param array $fields
   * @param PDO $conn
   * @return bool
   */
  public static function createTable($table_name, $fields, $conn = null)
  {

    // Verifica qual conexão utilizar.
    if (!$conn)
      $conn = Self::$conn1;

    // Verifica se tabela existe.
    if (Self::getTables($table_name, $conn))
      return true;

    // Constroi SQL.
    $sql = "CREATE TABLE IF NOT EXISTS " . DB1_PREFIX_TABLE . "$table_name (";
    $sql .= implode(',', $fields);
    $sql .= ") engine=InnoDB default charset " . DB1_CHARSET . ";";

    // Executa query de criação.
    if (!$conn->query($sql, PDO::FETCH_ASSOC)) {
      die(print_r($conn->errorInfo(), true));
      return false;
    }

    return true;
  }



  /**
   * Função genérica para deletar tabela.
   *
   * @param string $table_name
   * @param PDO $conn
   * @return bool
   */
  public static function deleteTable($table_name, $conn = null)
  {

    // Verifica qual conexão utilizar.
    if (!$conn)
      $conn = Self::$conn1;

    // Verifica se tabela existe.
    if (!Self::getTables($table_name, $conn))
      return true;

    // Constroi sql.
    $sql = "DROP TABLE IF EXISTS " . DB1_PREFIX_TABLE . "$table_name";
    $sth = $conn->prepare($sql);

    // Executa query de criação.
    if (!$sth->execute()) {
      die(print_r($conn->errorInfo(), true));
      return false;
    }

    // Caso ocorra tudo corretamente.
    return true;
  }



  /**
   * Função genérica para inserts.
   * Preencha o nome da tabela.
   * Preencha o array com nome_campo => valor_campo.
   *
   * @param string $table_name
   * @param array $fields
   * @param PDO $conn
   * @return bool
   */
  public static function insert($table_name, $fields, $conn = null)
  {

    // Verifica qual conexão utilizar.
    if (!$conn)
      $conn = Self::$conn1;

    // Verifica se tabela existe.
    if (!Self::getTables($table_name, $conn))
      return false;

    // Obtém as chaves (nome dos campos).
    $cols = implode(', ', array_keys($fields));
    // Obtém as chaves como parâmetro (incluido em values), para depois trocar pelos valores.
    $params = implode(', :', array_keys($fields));

    // Constrói sql.
    $sql = "INSERT INTO " . DB1_PREFIX_TABLE . "$table_name ($cols) VALUES(:$params)";
    $sth = $conn->prepare($sql);

    // Percorre os valores e adiciona ao bind.
    foreach ($fields as $key => $value) {
      $sth->bindValue(":$key", $value);
    }

    // Executa query de criação.
    if (!$sth->execute()) {
      die(print_r($conn->errorInfo(), true));
      return false;
    }

    // Caso ocorra tudo corretamente.
    return true;
  }




  public static function selectIdWhereAnd($table_name, $where, $conn = null)
  {
    // Verifica qual conexão utilizar.
    if (!$conn)
      $conn = Self::$conn1;

    // Verifica se tabela existe.
    if (!Self::getTables($table_name, $conn))
      return false;

    $select_where = '';
    // Percorre os valores e adiciona ao bind.
    foreach ($where as $key => $value) {
      $select_where .= "$key = :$key and ";
    }
    $select_where .= '1';

    // Constrói sql.
    $sql = "SELECT id FROM " . DB1_PREFIX_TABLE . "$table_name WHERE $select_where";
    $sth = $conn->prepare($sql);

    // Percorre os valores e adiciona ao bind.
    foreach ($where as $key => $value) {
      $sth->bindValue(":$key", $value);
    }

    // Executa query de criação.
    if (!$sth->execute()) {
      die(print_r($conn->errorInfo(), true));
      return false;
    }

    // Caso ocorra tudo corretamente.
    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }
}
