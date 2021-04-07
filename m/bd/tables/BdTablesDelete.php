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
    
    // todo: Rafael
    Self::deleteUsuarios();
    Self::deleteNoticias();
    Self::deleteInnerNoticiasAreas();
    Self::deleteGaleriaFotos();
    Self::deleteEventos();
    Self::deleteBanners();
    Self::deleteAreas();
    Self::deleteAreas();



    return true;
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



  // todo: ************************************************************************
  // todo: Rafael


  /**
   * Deleta tabela areas
   *
   * @return void
   */
  private static function deleteAreas()
  {
    $tabela_name = 'areas';
    return Self::deleteTable($tabela_name);
  }


  /**
   * Deleta tabela banners
   *
   * @return void
   */
  private static function deleteBanners()
  {
    $tabela_name = 'banners';
    return Self::deleteTable($tabela_name);
  }


  /**
   * Deleta tabela eventos
   *
   * @return void
   */
  private static function deleteEventos()
  {
    $tabela_name = 'eventos';
    return Self::deleteTable($tabela_name);
  }


  /**
   * Deleta tabela galeriaFotos
   *
   * @return void
   */
  private static function deleteGaleriaFotos()
  {
    $tabela_name = 'galeriaFotos';
    return Self::deleteTable($tabela_name);
  }


  /**
   * Deleta tabela innerNoticiasAreas
   *
   * @return void
   */
  private static function deleteInnerNoticiasAreas()
  {
    $tabela_name = 'innerNoticiasAreas';
    return Self::deleteTable($tabela_name);
  }


  /**
   * Deleta tabela noticias
   *
   * @return void
   */
  private static function deleteNoticias()
  {
    $tabela_name = 'noticias';
    return Self::deleteTable($tabela_name);
  }


  /**
   * Deleta tabela usuarios
   *
   * @return void
   */
  private static function deleteUsuarios()
  {
    $tabela_name = 'usuarios';
    return Self::deleteTable($tabela_name);
  }





}