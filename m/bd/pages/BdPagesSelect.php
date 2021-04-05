<?php

class BdPagesSelect extends Bd
{

  public static function start()
  {
  }

  /**
   * Busca uma página no banco de dados.
   *
   * @return int
   */
  public static function selectIdPage($path)
  {
    // Campos e valores.
    $where = [
      'url' => URL_RAIZ . $path,
    ];
    // Execução do insert. Retorna Id.
    $r = Self::selectIdWhereAnd('pageInfo', $where);
    if ($r)
      return $r[0]['id'];
    else
      return 0;
  }

  /**
   * Busca uma página no banco de dados.
   *
   * @return bool
   */
  public static function selectPage()
  {
    // Select campos de retorno.
    $fields = [
      '*',
    ];
    // Campos e valores.
    $where = [
      'id' => 1,
    ];
    // Execução do insert.
    //return Self::select('pageInfo', $fields);
  }
}
