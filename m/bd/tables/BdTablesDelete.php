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
    Self::deleteLogin();
    Self::deleteStatus();
    Self::deleteUsers();
    Self::deletePageInfo();
    Self::deletePageContent();
  }


  /**
   * Deleta tabela login
   *
   * @return void
   */
  private static function deleteLogin()
  {
    $tabela_name = 'login';
    return Self::deleteTable($tabela_name);
  }


  /**
   * Deleta tabela status
   *
   * @return void
   */
  private static function deleteStatus()
  {
    $tabela_name = 'status';
    return Self::deleteTable($tabela_name);
  }


  /**
   * Deleta tabela users
   *
   * @return void
   */
  private static function deleteUsers()
  {
    $tabela_name = 'users';
    return Self::deleteTable($tabela_name);
  }


  /**
   * Deleta tabela pageInfo
   *
   * @return void
   */
  private static function deletePageInfo()
  {
    $tabela_name = 'pageInfo';
    return Self::deleteTable($tabela_name);
  }


  /**
   * Deleta tabela pageContent
   *
   * @return void
   */
  private static function deletePageContent()
  {
    $tabela_name = 'pageContent';
    return Self::deleteTable($tabela_name);
  }





}