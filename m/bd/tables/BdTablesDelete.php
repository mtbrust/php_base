<?php

/**
 * Classe que cuida da criação das tabelas.
 * Ao final um modelo de como criar uma tabela.
 */
class BdTablesDelete extends Bd
{
  /**
   * Chama a criação de cada tabela.
   *
   * @return void
   */
  public static function start()
  {

    // Deleta as tabelas
    Self::deleteTable('login');
    Self::deleteTable('status');
    Self::deleteTable('users');
    Self::deleteTable('pageInfo');
    Self::deleteTable('pageContent');
    Self::deleteTable('areas');
    Self::deleteTable('innerAreaUser');
    Self::deleteTable('banners');
    Self::deleteTable('eventos');
    Self::deleteTable('noticias');
    Self::deleteTable('innerNoticiasAreas');
    Self::deleteTable('permissions');
    Self::deleteTable('options');
    Self::deleteTable('midia');
    Self::deleteTable('galeria');
    Self::deleteTable('innerGaleriaMidia');

    return true;
  }

}