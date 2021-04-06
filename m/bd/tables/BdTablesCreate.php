<?php

/**
 * Classe que cuida da criação das tabelas.
 * Ao final um modelo de como criar uma tabela.
 */
class BdTablesCreate extends Bd
{
  /**
   * Chama a criação de cada tabela.
   *
   * @return void
   */
  public static function start()
  {
    Self::createlogin();
    Self::createStatus();
    Self::createUsuarios();
    Self::createPageInfo();
    Self::createPageContent();


    // BD RAFA
    Self::createAreas();
    Self::createBanners();
    Self::createEventos();
    Self::createGaleriaFotos();
    Self::createInnerNoticiasAreas();
    Self::createNoticias();
    Self::createUsuario();

    
  }


  /**
   * Cria tabela LOGIN
   *
   * @return void
   */
  private static function createlogin()
  {
    $tabela_name = 'login';
    $fields = [
      "id INT NOT NULL AUTO_INCREMENT primary key",
      "full_name     VARCHAR(160) NULL",
      "first_name    VARCHAR(40) NULL",
      "last_name     VARCHAR(40) NULL",
      "email         VARCHAR(160) NOT NULL",
      "user_name     VARCHAR(32) NOT NULL",
      "senha         VARCHAR(32) NOT NULL",
      "cpf           VARCHAR(11) NULL",
      "telefone      INT(11) NULL",
      "active        BOOLEAN NULL",
      "id_status     INT NULL",
      "obs           VARCHAR(255) NULL",
      "dt_create     DATETIME NULL",
    ];
    return Self::createTable($tabela_name, $fields);
  }


  /**
   * Cria tabela status
   *
   * @return void
   */
  private static function createStatus()
  {
    $tabela_name = 'status';
    $fields = [
      "id INT NOT NULL AUTO_INCREMENT primary key",
      "nome VARCHAR(45) NULL",
      "help VARCHAR(128) NULL",
      "descricao VARCHAR(255) NULL",
      "tabela VARCHAR(90) NULL",
    ];
    return Self::createTable($tabela_name, $fields);
  }


  /**
   * Cria tabela users
   *
   * @return void
   */
  private static function createUsuarios()
  {
    $tabela_name = 'users';
    $fields = [

      // Controle
      "id INT NOT NULL AUTO_INCREMENT primary key",
      "idLogin INT NOT NULL",
      "idStatus INT NULL",
      "idStatusGrupo INT NULL",
      "obsGeral VARCHAR(512) NULL",

      // Pessoal
      "nome VARCHAR(128) NULL",
      "dataNascimento DATE NULL",
      "sexo VARCHAR(1) NULL",
      "estadoCivil VARCHAR(11) NULL",
      "nomeConjuge VARCHAR(128) NULL",
      "idConjuge INT NULL",
      "naturalidade VARCHAR(45) NULL",
      "naturalidade_uf VARCHAR(3) NULL",
      "nacionalidade VARCHAR(45) NULL",
      "urlFoto VARCHAR(255) NULL",
      "idFoto INT NULL",

      // Profissional
      "escolaridade VARCHAR(45) NULL",

      // Endereço
      "cep VARCHAR(9) NULL",
      "endereco VARCHAR(45) NULL",
      "numero VARCHAR(45) NULL",
      "complemento VARCHAR(45) NULL",
      "bairro VARCHAR(45) NULL",
      "cidade VARCHAR(45) NULL",
      "estadoUf VARCHAR(3) NULL",
      "pais VARCHAR(45) NULL",

      // Contato
      "telefone1 VARCHAR(11) NULL",
      "whatsapp1 BOOLEAN NULL",
      "telefone2 VARCHAR(11) NULL",
      "whatsapp2 BOOLEAN NULL",
      "emailProfissional VARCHAR(128) NULL",
      "emailPessoal VARCHAR(128) NULL",

      // Documentos
      "rg VARCHAR(13) NULL",
      "dataEmissao DATE NULL",
      "emissor VARCHAR(5) NULL",
      "cpf VARCHAR(11) NULL",
      "categoriaCnh VARCHAR(3) NULL",

      // Familiar
      "nomePai VARCHAR(128) NULL",
      "nomeMae VARCHAR(128) NULL",
      "idPai INT NULL",
      "idMae INT NULL",

      // Redes
      "instagram VARCHAR(45) NULL",
      "facebook VARCHAR(45) NULL",
      "linkedin VARCHAR(45) NULL",
      "twitter VARCHAR(45) NULL",
      "lattes VARCHAR(45) NULL",
    ];
    return Self::createTable($tabela_name, $fields);
  }




  /**
   * Cria tabela pageInfo
   *
   * @return void
   */
  private static function createPageInfo()
  {
    $tabela_name = 'pageInfo';
    $fields = [
      "id INT NOT NULL AUTO_INCREMENT primary key",
      "nome VARCHAR(128) NULL",
      "paramsSecurity VARCHAR(1024) NULL",
      "paramsController VARCHAR(1024) NULL",
      "paramsTemplate VARCHAR(1024) NULL",
      "paramsTemplateObjs VARCHAR(1024) NULL",
      "paramsView VARCHAR(1024) NULL",
      "paramsPage VARCHAR(1024) NULL",
      "paramsBd VARCHAR(1024) NULL",
      "url VARCHAR(256) NULL",
      "controller VARCHAR(128) NULL",
      "idPagePai INT NULL",
    ];
    return Self::createTable($tabela_name, $fields);
  }




  /**
   * Cria tabela pageContent
   *
   * @return void
   */
  private static function createPageContent()
  {
    $tabela_name = 'pageContent';
    $fields = [
      "id INT NOT NULL AUTO_INCREMENT primary key",
      "idPage INT NULL",
      "idRest INT NULL",
      "content MEDIUMTEXT NULL",
    ];
    return Self::createTable($tabela_name, $fields);
  }























  // TODO: **********************************************************************************************
  // TODO: BD RAFAEL

  /**
   * Cria tabela areas
   * 
   *
   * @return void
   */
  private static function createAreas()
  {
    $tabela_name = 'areas';
    $fields = [
      "id INT NOT NULL AUTO_INCREMENT primary key",
      "codArea int NOT NULL",
      "descricao varchar(50) NOT NULL",
    ];
    return Self::createTable($tabela_name, $fields);
  }




  /**
   * Cria tabela banners
   *
   * @return void
   */
  private static function createBanners()
  {
    $tabela_name = 'banners';
    $fields = [
      "id INT NOT NULL AUTO_INCREMENT primary key",
      "idDestaque int NOT NULL",
      "titulo varchar(250) NOT NULL",
      "imagem varchar(250) NOT NULL",
      "link varchar(250) NOT NULL",
      "ativo int NOT NULL",
      "dataPostagem timestamp NOT NULL",
    ];
    return Self::createTable($tabela_name, $fields);
  }




  /**
   * Cria tabela eventos
   *
   * @return void
   */
  private static function createEventos()
  {
    $tabela_name = 'eventos';
    $fields = [
      "id INT NOT NULL AUTO_INCREMENT primary key",
      "idEvento int NOT NULL",
      "codEvento int NOT NULL COMMENT 'Tipo de evento que é(feiras, ago etc..)'",
      "titulo varchar(200) NOT NULL",
      "dataEvento date NOT NULL",
      "infoEvento text NOT NULL COMMENT 'Info/descrição do evento'",
      "imagemEvento varchar(200) NOT NULL COMMENT 'Imagem que vai anexada no evento'",
      "statusEvento int NOT NULL",
    ];
    return Self::createTable($tabela_name, $fields);
  }




  /**
   * Cria tabela galeriaFotos
   *
   * @return void
   */
  private static function createGaleriaFotos()
  {
    $tabela_name = 'galeriaFotos';
    $fields = [
      "id INT NOT NULL AUTO_INCREMENT primary key",
      "idFoto int NOT NULL",
      "idGaleria char(45) NOT NULL",
      "nomeFoto varchar(50) DEFAULT NULL",
      "ordem int DEFAULT NULL",
      "texto varchar(300) DEFAULT NULL",
    ];
    return Self::createTable($tabela_name, $fields);
  }




  /**
   * Cria tabela innerNoticiasAreas
   *
   * @return void
   */
  private static function createInnerNoticiasAreas()
  {
    $tabela_name = 'innerNoticiasAreas';
    $fields = [
      "id INT NOT NULL AUTO_INCREMENT primary key",
      "codNoticia int NOT NULL",
      "codArea int NOT NULL"
    ];
    return Self::createTable($tabela_name, $fields);
  }




  /**
   * Cria tabela noticias
   *
   * @return void
   */
  private static function createNoticias()
  {
    $tabela_name = 'noticias';
    $fields = [
      "id INT NOT NULL AUTO_INCREMENT primary key",
      "codNoticia int NOT NULL",
      "titulo varchar(120) NOT NULL",
      "previa varchar(280) DEFAULT NULL",
      "texto longtext NULL",
      "imagemDestaque varchar(280) NOT NULL",
      "dataPostagem timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP",
      "status varchar(30) NOT NULL",
      "fixaTopo char(1) NOT NULL",
    ];
    return Self::createTable($tabela_name, $fields);
  }




  /**
   * Cria tabela usuarios
   *
   * @return void
   */
  private static function createUsuario()
  {
    $tabela_name = 'usuarios';
    $fields = [
      "id INT NOT NULL AUTO_INCREMENT primary key",
      "matricula int NOT NULL",
      "senha varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL",
      "nome varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL",
      "tipoCadastro char(1) NOT NULL COMMENT 'M->Master, A->Administradores\r\n'",
      "ativo char(1) NOT NULL",
    ];
    return Self::createTable($tabela_name, $fields);
  }




  /**
   * Cria tabela NOME_TABELA
   *
   * @return void
   */
  // private static function createTabela()
  // {
  //   $tabela_name = 'nome_tabela';
  //   $fields = [
  //     "id INT NOT NULL AUTO_INCREMENT primary key",
  //     "",
  //   ];
  //   return Self::createTable($tabela_name, $fields);
  // }







}
