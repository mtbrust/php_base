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
   * Inicia as conexões.
   */
  public static function close()
  {
    // Chama a conexão.
    if (Self::$conn1) {
      Self::$conn1->query('KILL CONNECTION_ID()');
      Self::$conn1 = null;
    }
    if (Self::$conn2) {
      Self::$conn2->query('KILL CONNECTION_ID()');
      Self::$conn2 = null;
    }
  }

  /**
   * Solicita a conexão com o banco de dados 1 (DB1). Padrão singleton.
   * Configurado no arquivo config.php.
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
   * Solicita a conexão com o banco de dados 2 (DB2). Padrão singleton.
   * Configurado no arquivo config.php.
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
   * Retorna o nome completo da tabela.
   *
   * @param string $tableName
   * @return string
   */
  public static function fullTableName($tableName)
  {
    return DB1_PREFIX_TABLE . $tableName;
  }




  /**
   * Executa função padrão de retornar 10 linhas da tabela selecionada.
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
   * [$tableName] já acrescenta o prefixo. Basta colocar o nome final da tabela.
   *
   * @param string $tableName
   * @param PDO $conn
   * @return void
   */
  public static function getTables($tableName = '', $conn = null)
  {
    // Verifica qual conexão utilizar.
    if (!$conn)
      $conn = Self::$conn1;

    // Caso passe o nome da tabela, cria o wherer para filtrar.
    if ($tableName)
      $tableName =  "WHERE Tables_in_" . DB1_DBNAME . " LIKE '" . DB1_PREFIX_TABLE . "$tableName'";

    // Monta a Sql com filtro ou sem nada.
    $sql = "SHOW TABLES $tableName";
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
   * @param string $tableName
   * @param array $fields
   * @param PDO $conn
   * @return bool
   */
  public static function createTable($tableName, $fields, $conn = null)
  {

    // Verifica qual conexão utilizar.
    if (!$conn)
      $conn = Self::$conn1;

    // Verifica se tabela existe.
    if (Self::getTables($tableName, $conn))
      return true;

    // Constroi SQL.
    $sql = "CREATE TABLE IF NOT EXISTS " . DB1_PREFIX_TABLE . "$tableName (";
    $sql .= implode(',', $fields);
    $sql .= ") engine=InnoDB default charset " . DB1_CHARSET . ";";


    // Executa query de criação.
    if (!$conn->query($sql, PDO::FETCH_ASSOC)) {
      die("\n\nNão foi possível criar tabela.\n\n" . print_r($conn->errorInfo(), true));
      return false;
    }

    return true;
  }



  /**
   * Função genérica para deletar tabela.
   *
   * @param string $tableName
   * @param PDO $conn
   * @return bool
   */
  public static function deleteTable($tableName, $conn = null)
  {

    // Verifica qual conexão utilizar.
    if (!$conn)
      $conn = Self::$conn1;

    // Verifica se tabela existe.
    if (!Self::getTables($tableName, $conn))
      return true;

    // Constroi sql.
    $sql = "DROP TABLE IF EXISTS " . DB1_PREFIX_TABLE . "$tableName";
    $sth = $conn->prepare($sql);

    // Executa query de criação.
    if (!$sth->execute()) {
      die("\n\nNão foi possível deletar tabela.\n\n" . print_r($conn->errorInfo(), true));
      return false;
    }

    // Caso ocorra tudo corretamente.
    return true;
  }



  /**
   * Função genérica para deletar tabela.
   *
   * @param string $query
   * @param PDO $conn
   * @return array
   */
  public static function executeQuery($query, $conn = null)
  {

    // Verifica qual conexão utilizar.
    if (!$conn)
      $conn = Self::$conn1;

    // Constroi sql.
    $sql = $query;
    $sth = $conn->prepare($sql);

    // Executa query de criação.
    if (!$sth->execute()) {
      die("\n\nNão foi possível executar query.\n\n" . print_r($conn->errorInfo(), true));
      return false;
    }

    // Caso ocorra tudo corretamente.
    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }



  /**
   * Função genérica para inserts.
   * Preencha o nome da tabela.
   * Preencha o array com nome_campo => valor_campo.
   *
   * @param string $tableName
   * @param array $fields
   * @param PDO $conn
   * @return bool
   */
  public static function insert($tableName, $fields, $conn = null)
  {

    // Verifica qual conexão utilizar.
    if (!$conn)
      $conn = Self::$conn1;

    // Verifica se tabela existe.
    if (!Self::getTables($tableName, $conn))
      return false;

    // Obtém as chaves (nome dos campos).
    $cols = implode(', ', array_keys($fields));
    // Obtém as chaves como parâmetro (incluido em values), para depois trocar pelos valores.
    $params = implode(', :', array_keys($fields));

    // Constrói sql.
    $sql = "INSERT INTO " . DB1_PREFIX_TABLE . "$tableName ($cols) VALUES(:$params)";
    $sth = $conn->prepare($sql);

    // Para verificação do sql.
    //echo $sql;


    // Percorre os valores e adiciona ao bind.
    foreach ($fields as $key => $value) {
      $sth->bindValue(":$key", $value);
    }


    // Executa query de criação.
    if (!$sth->execute()) {
      die("\n\nNão foi possível inserir os dados.\n\n" . print_r($conn->errorInfo(), true));
      return false;
    }


    // Caso ocorra tudo corretamente.
    return $id = $conn->lastInsertId();
  }


  /**
   * Função genérica para update.
   * Preencha o nome da tabela.
   * Preencha o array com nome_campo => valor_campo.
   *
   * @param string $tableName
   * @param array $fields
   * @param PDO $conn
   * @return bool
   */
  public static function update($tableName, $id, $fields, $conn = null)
  {

    // Verifica qual conexão utilizar.
    if (!$conn)
      $conn = Self::$conn1;

    // Verifica se tabela existe.
    if (!Self::getTables($tableName, $conn))
      return false;

    // Prepara o SET (key, values)
    $set = '';
    // Percorre os valores e adiciona ao bind.
    foreach ($fields as $key => $value) {
      $set .= ", $key=:$key";
    }
    $set[0] = ' '; // Tia a virgual inicial.

    // Constrói sql.
    $sql = "UPDATE " . DB1_PREFIX_TABLE . "$tableName SET$set  WHERE id = $id";
    $sth = $conn->prepare($sql);

    // echo $sql;
    // exit;

    // Percorre os valores e adiciona ao bind.
    foreach ($fields as $key => $value) {
      $sth->bindValue(":$key", $value);
    }
    //echo $sql;
    //exit();
    // Executa query de criação.
    if (!$sth->execute()) {
      die("\n\nNão foi possível atualizar registro.\n\n" . print_r($conn->errorInfo(), true));
      return false;
    }

    // Caso ocorra tudo corretamente.
    return true;
  }



  /**
   * Função selectById que busca registro por id.
   * Retorna um array da linha.
   *
   * @param string $tableName
   * @param int $id
   * @param PDO $conn
   * @return array
   */
  public static function selectById($tableName, $id, $conn = null)
  {
    // Verifica qual conexão utilizar.
    if (!$conn)
      $conn = Self::$conn1;

    // Verifica se tabela existe.
    if (!Self::getTables($tableName, $conn))
      return false;

    // Constrói sql.
    $sql = "SELECT * FROM " . DB1_PREFIX_TABLE . "$tableName WHERE id = $id";
    $sth = $conn->prepare($sql);

    // Executa query de criação.
    if (!$sth->execute()) {
      die("\n\nNão foi possível selecionar por id.\n\n" . print_r($conn->errorInfo(), true));
      return false;
    }

    $r = $sth->fetchAll(PDO::FETCH_ASSOC);

    if (!isset($r[0]))
      return false;

    // Caso ocorra tudo corretamente.

      return $r[0];
  }




  /**
   * Função delete passando id e iniciando a conexão.
   * Deleta registro pela tabela e id informado.
   *
   * @param string $tableName
   * @param int $id
   * @param PDO $conn
   * @return bool
   */
  public static function delete($tableName, $id, $conn = null)
  {

    // Verifica qual conexão utilizar.
    if (!$conn)
      $conn = Self::$conn1;

    // Verifica se tabela existe.
    if (!Self::getTables($tableName, $conn))
      return false;

    // Constrói sql.
    $sql = "DELETE FROM " . DB1_PREFIX_TABLE . "$tableName WHERE id = $id";
    $sth = $conn->prepare($sql);

    // Executa query de criação.
    if (!$sth->execute()) {
      die("\n\nNão foi possível deletar os dados.\n\n" . print_r($conn->errorInfo(), true));
      return false;
    }

    // Caso ocorra tudo corretamente.
    return true;
  }




  public static function selectIdWhereAnd($tableName, $where, $conn = null)
  {
    // Verifica qual conexão utilizar.
    if (!$conn)
      $conn = Self::$conn1;

    // Verifica se tabela existe.
    if (!Self::getTables($tableName, $conn))
      return false;

    $select_where = '';
    // Percorre os valores e adiciona ao bind.
    foreach ($where as $key => $value) {
      $select_where .= "$key = :$key and ";
    }
    $select_where .= '1';

    // Constrói sql.
    $sql = "SELECT id FROM " . DB1_PREFIX_TABLE . "$tableName WHERE $select_where";
    $sth = $conn->prepare($sql);

    // Percorre os valores e adiciona ao bind.
    foreach ($where as $key => $value) {
      $sth->bindValue(":$key", $value);
    }

    // Executa query de criação.
    if (!$sth->execute()) {
      die("\n\nNão foi possível selecionar com where.\n\n" . print_r($conn->errorInfo(), true));
      return false;
    }

    // Caso ocorra tudo corretamente.
    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }


  /**
   * Função genérica para selecionar por id.
   * Retorna um vetor da linha selecionada.
   *
   * @param string $tableName
   * @param int $id
   * @param PDO $conn
   * @return array
   */
  protected static function selectAll($tableName, $posicao = null, $qtd = 10, $conn = null)
  {
    // Verifica qual conexão utilizar.
    if (!$conn)
      $conn = Self::$conn1;

    // Verifica se tabela existe.
    if (!Self::getTables($tableName, $conn))
      return false;

    $limit = '';
    if ($posicao)
      $limit = "LIMIT $qtd, $posicao";

    // Constrói sql.
    $sql = "SELECT * FROM " . DB1_PREFIX_TABLE . "$tableName $limit";
    $sth = $conn->prepare($sql);

    // Executa query de criação.
    if (!$sth->execute()) {
      die("\n\nNão foi possível selecionar todos os dados.\n\n" . print_r($conn->errorInfo(), true));
      return false;
    }

    // Caso ocorra tudo corretamente.
    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }


  /**
   * Função genérica para retornar a quantidade de registros da tabela.
   * Retorna um vetor da linha selecionada.
   *
   * @param string $tableName
   * @param PDO $conn
   * @return int
   */
  protected static function count($tableName, $conn = null)
  {
    // Verifica qual conexão utilizar.
    if (!$conn)
      $conn = Self::$conn1;

    // Verifica se tabela existe.
    if (!Self::getTables($tableName, $conn))
      return false;

    // Constrói sql.
    $sql = "SELECT count(*) as qtd FROM " . DB1_PREFIX_TABLE . "$tableName";
    $sth = $conn->prepare($sql);

    // Executa query de criação.
    if (!$sth->execute()) {
      die("\n\nNão foi possível contar os dados.\n\n" . print_r($conn->errorInfo(), true));
      return false;
    }

    // Caso ocorra tudo corretamente.
    return $sth->fetchAll(PDO::FETCH_ASSOC)[0]['qtd'];
  }
}
