<?php

class BdUsuarios extends Bd
{
  /**
   * Retorna todos os usuários
   *
   * @return array
   */
  public static function getUsuarios()
  {
    return Bd::getAll('teste');
  }
}