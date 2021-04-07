<?php

class BdPagesInsert extends Bd
{

  public static function start()
  {
    // Popular páginas para teste;
    Self::insertTest();

    return true;
  }

  /**
   * Insere páginas para teste.
   *
   * @return bool
   */
  public static function insertTest()
  {
    // Campos e valores.
    $fields = [
      'nome' => 'serviços',
      'url' => URL_RAIZ . 'servicos'
    ];
    // Execução do insert.
    return Self::Insert('pageInfo', $fields);
  }


  

}