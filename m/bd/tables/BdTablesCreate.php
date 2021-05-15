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
    Self::Status();
    Self::login();
    Self::Users();
    Self::PageInfo();
    Self::pageContent();
    Self::areas();
    Self::innerAreaUser();
    Self::Banners();
    Self::Eventos();
    Self::Noticias();
    Self::InnerNoticiasAreas();
    Self::permissions();
    Self::options();
    Self::midia();
    Self::Galeria();
    Self::innerGaleriaMidia();


    return true;
  }


  /**
   * Cria tabela status
   *
   * @return void
   */
  private static function Status()
  {
    $tabela_name = 'status';
    $fields = [
      // Identificador
      "id               INT NOT NULL AUTO_INCREMENT primary key",

      // Informações básicas
      "nome             VARCHAR(45) NULL",
      "obs             VARCHAR(255) NULL",
      "statusGrupo      VARCHAR(90) NULL",    // Nome de um grupo de status para um determinado campo de tabela.
      "idStatusPai      INT NULL",

      // Controle
      "dtCreate         DATETIME NULL",
    ];
    return Self::createTable($tabela_name, $fields);
  }


  /**
   * Cria tabela LOGIN
   *
   * @return void
   */
  private static function login()
  {
    $tabela_name = 'login';
    $fields = [
      // Identificador
      "id                     INT NOT NULL AUTO_INCREMENT primary key",
      "matricula              INT NOT NULL",
      "idUser                 INT NULL",          // Id do usuário

      // Chaves externas  
      "idStatus               INT NULL",          // Status geral
      "idGrupo                INT NULL",          // Status para um grupo.

      // Informações básicas
      "fullName         VARCHAR(160) NULL",
      "firstName        VARCHAR(40) NULL",
      "lastName         VARCHAR(40) NULL",

      // Login
      "userName         VARCHAR(32) NOT NULL",
      "email            VARCHAR(160) NOT NULL",
      "cpf              VARCHAR(11) NULL",
      "telefone         VARCHAR(11) NULL",

      // Senha
      "senha            VARCHAR(32) NOT NULL", // MD5
      "expirationDays   INT(11) NULL",
      "strongPass       BOOLEAN NULL",
      "dateChangePass   DATETIME NULL",

      // Controle
      "initialUrl       VARCHAR(255) NOT NULL",
      "active           BOOLEAN NULL",
      "dtCreate         DATETIME NULL",
      "obs              VARCHAR(255) NULL",
    ];
    return Self::createTable($tabela_name, $fields);
  }


  /**
   * Cria tabela users
   *
   * @return void
   */
  private static function Users()
  {
    $tabela_name = 'users';
    $fields = [

      // Identificador
      "id                 INT NOT NULL AUTO_INCREMENT primary key",

      // Chaves externas  
      "idLogin                INT NOT NULL",
      "idStatusRh             INT NULL",          // Status controle RH.
      "idStatusMarketing      INT NULL",          // Status controle Marketing.
      "idStatusTi             INT NULL",          // Status controle Ti.
      "idStatusContabilidade  INT NULL",          // Status contabilidade.
      "idStatusPontuacao      INT NULL",          // Status para pontuação.
      "idArea                 INT NULL",          // Status Area.

      // Pessoal  
      "nome               VARCHAR(128) NULL",
      "dataNascimento     DATE NULL",
      "sexo               VARCHAR(1) NULL",
      "estadoCivil        VARCHAR(11) NULL",
      "nomeConjuge        VARCHAR(128) NULL",
      "idConjuge          INT NULL",
      "naturalidade       VARCHAR(45) NULL",
      "naturalidade_uf    VARCHAR(3) NULL",
      "nacionalidade      VARCHAR(45) NULL",
      "urlFoto            VARCHAR(255) NULL",
      "idFoto             INT NULL",

      // Profissional 
      "escolaridade       VARCHAR(45) NULL",

      // Endereço 
      "cep                VARCHAR(9) NULL",
      "endereco           VARCHAR(45) NULL",
      "numero             VARCHAR(45) NULL",
      "complemento        VARCHAR(45) NULL",
      "bairro             VARCHAR(45) NULL",
      "cidade             VARCHAR(45) NULL",
      "estadoUf           VARCHAR(3) NULL",
      "pais               VARCHAR(45) NULL",

      // Contato  
      "telefone1          VARCHAR(11) NULL",
      "whatsapp1          BOOLEAN NULL",
      "telefone2          VARCHAR(11) NULL",
      "whatsapp2          BOOLEAN NULL",
      "emailProfissional  VARCHAR(128) NULL",
      "emailPessoal       VARCHAR(128) NULL",

      // Documentos
      "rg                 VARCHAR(13) NULL",
      "dataEmissao        DATE NULL",
      "emissor            VARCHAR(5) NULL",
      "cpf                VARCHAR(11) NULL",
      "categoriaCnh       VARCHAR(3) NULL",

      // Familiar
      "nomePai            VARCHAR(128) NULL",
      "nomeMae            VARCHAR(128) NULL",
      "idPai              INT NULL",
      "idMae              INT NULL",

      // Redes
      "instagram          VARCHAR(45) NULL",
      "facebook           VARCHAR(45) NULL",
      "linkedin           VARCHAR(45) NULL",
      "twitter            VARCHAR(45) NULL",
      "lattes             VARCHAR(45) NULL",

      // Outro
      "obsGeral           VARCHAR(512) NULL",

      // Controle
      "pontuacao          INT NULL",
      "dtCreate           DATETIME NULL",

    ];
    return Self::createTable($tabela_name, $fields);
  }




  /**
   * Cria tabela pageInfo
   *
   * @return void
   */
  private static function PageInfo()
  {
    $tabela_name = 'pageInfo';
    $fields = [
      // Identificador
      "id                 INT NOT NULL AUTO_INCREMENT primary key",

      // Informações básicas
      "nome               VARCHAR(128) NULL",
      "url                VARCHAR(256) NULL",
      "controller         VARCHAR(128) NULL",
      "idPagePai          INT NULL",

      // Parâmetros
      "paramsSecurity     VARCHAR(1024) NULL",
      "paramsController   VARCHAR(1024) NULL",
      "paramsTemplate     VARCHAR(1024) NULL",
      "paramsTemplateObjs VARCHAR(1024) NULL",
      "paramsView         VARCHAR(1024) NULL",
      "paramsPage         VARCHAR(1024) NULL",
      "paramsBd           VARCHAR(1024) NULL",

      // Controle
      "dtCreate           DATETIME NULL",
      "idStatus           INT NULL",                // Status pageinfo
    ];
    return Self::createTable($tabela_name, $fields);
  }




  /**
   * Cria tabela pageContent
   * Conteúdo de uma página ou bloco.
   *
   * @return void
   */
  private static function pageContent()
  {
    $tabela_name = 'pageContent';
    $fields = [
      // Identificador
      "id                 INT NOT NULL AUTO_INCREMENT primary key",

      // Informações básicas
      "idPage             INT NULL",
      "idRest             INT NULL",
      "content            MEDIUMTEXT NULL",

      // Controle
      "dtCreate           DATETIME NULL",
      "idStatus           INT NULL",                // Status pagecontent

    ];
    return Self::createTable($tabela_name, $fields);
  }




  /**
   * Cria tabela Permissions
   * Caso usuário não tenha um registro de permissão a uma página. a segurança vem da página.
   *
   * @return void
   */
  private static function Permissions()
  {
    $tabela_name = 'permissions';
    $fields = [
      // Identificador
      "id                 INT NOT NULL AUTO_INCREMENT primary key",

      // Chaves externas  
      "idLogin            INT NULL",
      "idPagina           INT NULL",  
      "idGrupo            INT NULL",  // grupoStatus: users/idGrupo

      // Informações básicas
      "nome               VARCHAR(128) NULL",
      "urlPagina          VARCHAR(128) NULL",
      "obs                VARCHAR(512) NULL",
      "permissions        VARCHAR(5) NULL",        // [1,0,0,0,0] Visualização básica, visualização total, Criação, Edição, Exclusão.

      // Controle
      "dtCreate           DATETIME NULL",
      "idStatus           INT NULL",                // Status permissão
    ];
    return Self::createTable($tabela_name, $fields);
  }




  /**
   * Cria tabela Options
   * Opções de configurações etc.
   *
   * @return void
   */
  private static function Options()
  {
    $tabela_name = 'options';
    $fields = [
      // Identificador
      "id                 INT NOT NULL AUTO_INCREMENT primary key",

      // Informações básicas
      "option             VARCHAR(128) NULL UNIQUE",
      "value              VARCHAR(1024) NULL",

      // Controle
      "dtCreate           DATETIME NULL",
      "idStatus           INT NULL",                // Status option
    ];
    return Self::createTable($tabela_name, $fields);
  }




  /**
   * Cria tabela áreas
   * Área das notícias. coopama store, LOJAS AGROPECUÁRIAS, CAFÉ E CEREAIS, NUTRIÇÃO ANIMAL
   *
   * @return void
   */
  private static function areas()
  {
    $tabela_name = 'areas';
    $fields = [
      // Identificador
      "id                 INT NOT NULL AUTO_INCREMENT primary key",

      // Informações básicas
      "nome               VARCHAR(128) NULL",
      "obs                VARCHAR(512) NOT NULL",
      "telefone           VARCHAR(11) NULL",
      "whatsapp           BOOLEAN NULL",
      "plantao            VARCHAR(11) NULL",

      // Controle
      "dtCreate           DATETIME NULL",
      "idStatus           INT NULL",                // Status areas
    ];
    return Self::createTable($tabela_name, $fields);
  }



  /**
   * Cria tabela innerAreaUser
   *
   * @return void
   */
  private static function innerAreaUser()
  {
    $tabela_name = 'innerAreaUser';
    $fields = [
      // Identificador
      "id             INT NOT NULL AUTO_INCREMENT primary key",
      
      // Informações básicas
      "idArea         INT NOT NULL",                // Tabela de Área.
      "idUser         INT NOT NULL",                // Tabela de Usuários (users).
      "telefone       VARCHAR(11) NULL",            // Ramal
      "idFuncao           INT NULL",                // Status função

    ];
    return Self::createTable($tabela_name, $fields);
  }




/**
   * Cria tabela banners
   *
   * @return void
   */
  private static function Banners()
  {
    $tabela_name = 'banners';
    $fields = [
      // Identificador
      "id                 INT NOT NULL AUTO_INCREMENT primary key",

      // Informações básicas
      "idDestaque         INT NULL",              // banner que aparece em ordem de destaque
      "titulo             VARCHAR(250) NULL",
      "idFoto             INT NULL",
      "idVideo            INT NULL",
      "link               VARCHAR(250) NULL",
      "ordem              INT NULL",              // Se o banner vai ser exibido ou não

      // Controle
      "dtExibicaoIni      DATETIME NULL",         // Quando o banner vai aparecer. no dia e hora aparece.
      "dtExibicaoFim      DATETIME NULL",         // Quando o banner vai desaparecer. no dia e hora desaparece.
      "dtExclusao         DATETIME NULL",         // Quando o banner vai ser excluido automaticamente.
      "dtCreate           DATETIME NULL",
      "idStatus           INT NULL",              // Status banners

    ];
    return Self::createTable($tabela_name, $fields);
  }



  /**
   * Cria tabela eventos
   *
   * @return void
   */
  private static function Eventos()
  {
    $tabela_name = 'eventos';
    $fields = [
      // Identificador
      "id                 INT NOT NULL AUTO_INCREMENT primary key",
      
      // Informações básicas
      "idArea             INT NULL",
      "titulo             VARCHAR(128) NOT NULL",
      "dtIni              DATETIME NULL",
      "dtFim              DATETIME NULL",
      "infoEvento         MEDIUMTEXT NULL",       // A página. texto.
      "idFoto             VARCHAR(512) NULL",
      "color              VARCHAR(10) NULL",

      // Controle
      "dtExibicaoIni      DATETIME NULL",         // Quando o evento vai aparecer. no dia e hora aparece.
      "dtExibicaoFim      DATETIME NULL",         // Quando o evento vai desaparecer. no dia e hora desaparece.
      "dtExclusao         DATETIME NULL",         // Quando o evento vai ser excluido automaticamente.
      "dtCreate           DATETIME NULL",
      "idStatus           INT NULL",              // Status eventos
    ];
    return Self::createTable($tabela_name, $fields);
  }



  /**
   * Cria tabela de registro de mídia
   *
   * @return void
   */
  private static function Midia()
  {
    $tabela_name = 'midia';
    $fields = [
      // Identificador
      "id             INT NOT NULL AUTO_INCREMENT primary key",
      
      // Informações básicas
      "nome           VARCHAR(128) NULL",
      "obs            VARCHAR(1024) NULL",          // descrição.
      "dir            VARCHAR(1024) NULL",          // diretório que se encontra.
      "extension      VARCHAR(5) NULL",             // Extensão da mídia.
      
      // Informações tratadas
      "urlMidia       VARCHAR(1024) NOT NULL",      // url completa da mídia.
      "dirMidia       VARCHAR(1024) NOT NULL",      // diretório completo da mídia.

      // Controle
      "dtCreate       DATETIME NULL",
      "idGrupo        INT NULL",                    // Status grupo mídia
      "idStatus       INT NULL",                    // Status midia
    ];
    return Self::createTable($tabela_name, $fields);
  }



  /**
   * Cria tabela galeria
   *
   * @return void
   */
  private static function Galeria()
  {
    $tabela_name = 'galeria';
    $fields = [
      // Identificador
      "id             INT NOT NULL AUTO_INCREMENT primary key",

      // Chaves externas 
      "idArea       INT NULL",
      
      // Informações básicas
      "nome           VARCHAR(128) NOT NULL",
      "obs            VARCHAR(1024) DEFAULT NULL",  // descrição da galeria.

      // Controle
      "dtCreate       DATETIME NULL",
      "idStatus       INT NULL",                    // Status eventos
    ];
    return Self::createTable($tabela_name, $fields);
  }



  /**
   * Cria tabela innerGaleriaMidia
   *
   * @return void
   */
  private static function innerGaleriaMidia()
  {
    $tabela_name = 'innerGaleriaMidia';
    $fields = [
      // Identificador
      "id             INT NOT NULL AUTO_INCREMENT primary key",
      
      // Informações básicas
      "idGaleria      INT NOT NULL",                // Tabela de Galeria.
      "idFoto         INT NOT NULL",                // Tabela de Mídia.
    ];
    return Self::createTable($tabela_name, $fields);
  }




  /**
   * Cria tabela innerNoticiasAreas
   * Fas a associação de noticia e áreas.
   *
   * @return void
   */
  private static function InnerNoticiasAreas()  // Tem que verificar se muda para catogira
  {
    $tabela_name = 'innerNoticiasAreas';
    $fields = [
      // Identificador
      "id           INT NOT NULL AUTO_INCREMENT primary key",
      
      // Informações básicas
      "idNoticia    INT NOT NULL",
      "idArea       INT NOT NULL",
    ];
    return Self::createTable($tabela_name, $fields);
  }



  /**
   * Cria tabela noticias
   *
   * @return void
   */
  private static function Noticias()
  {
    $tabela_name = 'noticias';
    $fields = [
      // Identificador
      "id             INT NOT NULL AUTO_INCREMENT primary key",
      
      // Informações básicas
      "titulo         VARCHAR(128) NULL",
      "previa         VARCHAR(256) NULL",   // exibição do resumo.
      "tags           VARCHAR(256) NULL",   // exibição do resumo.
      "texto          MEDIUMTEXT NULL",     // pode ser html.
      "idFoto         INT NULL",            // Tabela de midia.
      "dataPostagem   DATETIME NULL",
      "ordem          INT NULL",            // ordem de exibição.
      "idCategoria    INT NULL",            // Status grupo categoria
      "fixaTopo       VARCHAR(1) NULL",
      "color          VARCHAR(10) NULL",

      // Controle
      "dtExibicaoIni      DATETIME NULL",         // Quando a noticia vai aparecer. no dia e hora aparece.
      "dtExibicaoFim      DATETIME NULL",         // Quando a noticia vai desaparecer. no dia e hora desaparece.
      "dtExclusao         DATETIME NULL",         // Quando a noticia vai ser excluido automaticamente.
      "dtCreate           DATETIME NULL",
      "idStatus           INT NULL",              // Status eventos
    ];
    return Self::createTable($tabela_name, $fields);
  }




  /**
   * Cria tabela NOME_TABELA
   *
   * @return void
   */
  // private static function Tabela()
  // {
  //   $tabela_name = 'nome_tabela';
  //   $fields = [
  //     "id INT NOT NULL AUTO_INCREMENT primary key",
  //     "",
  //   ];
  //   return Self::createTable($tabela_name, $fields);
  // }







}
