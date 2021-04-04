<?php

class BdCreate extends Bd
{
  /**
   * Chama a criação de cada tabela.
   *
   * @return void
   */
  public static function create()
  {
    Self::createStatus();
  }


  /**
   * Cria tabela STATUS
   *
   * @return void
   */
  private static function createStatus()
  {
    $table_name = DB1_PREFIX_TABLE . 'status';
    if (Self::$conn1->exec('SHOW TABLES LIKE ' . $table_name) != $table_name) {
      $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id INT NOT NULL AUTO_INCREMENT primary key,
        nome VARCHAR(45) NULL,
        help VARCHAR(128) NULL,
        descricao VARCHAR(255) NULL,
        tabela VARCHAR(90) NULL)
        engine=InnoDB default charset " . DB1_CHARSET . ";";
      Self::$conn1->exec($sql) or die(print_r(Self::$conn1->errorInfo(), true));
    }
  }
}
