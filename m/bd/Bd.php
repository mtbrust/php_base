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
  protected static $conn1;

  /**
   * Conexão secundária do banco de dados.
   *
   * @var PDO
   */
  protected static $conn2;

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
  private static function getConn1()
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
  private static function getConn2()
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
   * @param int $conn
   * @return void
   */
  public static function getAll($table, $limit = "9 OFFSET 0", $conn = 1)
  {
    if ($conn == 2)
      $conn = Self::$conn2;
    else
      $conn = Self::$conn1;

    $result = $conn->query("SELECT * FROM $table WHERE 1 LIMIT $limit", PDO::FETCH_ASSOC);

    return $result->fetchAll();
  }
}
