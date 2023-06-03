<?php

namespace controllers;

/**
 * EndPoint
 * 
 * Classe que controla o processamento dos endpoints.
 * Tanto páginas como apis.
 */
abstract class EndPoint
{
  public static $params = [];

  /**
   * start
   * Inicia o motor da classe.
   *
   * @param  mixed $endPoint
   * @return array
   */
  public function start()
  {
    // // Acrescenta as demais informações para uso no endpoint.
    // self::$params['session'] = \controllers\Security::getSession();

    // Carrega banco de dados.
    $this->carregaBDs();

    // Carrega classes .
    $this->carregaClasses();

    // Carrega controllers.
    $this->carregaControllers();

    // Obtém dinamicamente a função personalizada.
    $menu = \controllers\FriendlyUrl::getParameters('func');

    // Caso seja endpoint de página. Carrega apenas funções de página.
    if (self::$params['infoUrl']['namespace'] == 'pages' && $menu != 'api') {
      // Carrega e monta toda a estrutura
      $this->carregaEstrutura();

      // todo - Carrega informações da página como scripts, styles, etc
    }

    // Chama a função personalizada e envia todos os parâmetros tratados.
    $this->$menu(self::$params);

    // Retorna os parâmetros
    return self::$params;
  }

  /**
   * loadParams
   * Carrega os parâmetros de personalização do endpoint.
   *
   * @return void
   */
  abstract function loadParams();


  /**
   * get
   * Função primária do endpoint.
   *
   * @return void
   */
  abstract function get($params);


  /**
   * getParameters
   * 
   * Mescla os parâmetros default com os personalizados do endpoint.
   * Retorna resultado dos parâmetros.
   *
   * @return array
   */
  public function getParameters()
  {
    // Carrega os parâmetros personalizados.
    $this->loadParams();

    // Valores default
    $params_default['render']      = BASE_PARAMS_RENDER;       // Opções de renderização.
    $params_default['config']      = BASE_PARAMS_CONFIG;       // Configuração personalizada do endpoins.
    $params_default['security']    = BASE_PARAMS_SECURITY;     // Opções de segurança.
    $params_default['info']        = BASE_PARAMS_INFO;         // Informações extras.
    $params_default['controllers'] = BASE_PARAMS_CONTROLLERS;  // Carrega controllers para reutilizar funções.
    $params_default['menus']       = BASE_PARAMS_MENUS;        // Monta estrutura de parâmetros passados na url.
    $params_default['structure']   = BASE_PARAMS_STRUCTURE;    // Carrega estrutura html. Somente pages.
    $params_default['scripts']     = BASE_PARAMS_SCRIPTS;      // Carrega na página scripts (template/assets/js/) Somente pages.
    $params_default['styles']      = BASE_PARAMS_STYLES;       // Carrega na página estilos (template/assets/css/) Somente pages.
    $params_default['plugins']     = BASE_PARAMS_PLUGINS;      // Carrega na página plugins (template/assets/css/) Somente pages.

    // Mescla valores default com os valores definidos no endpoint.
    self::$params = array_replace_recursive($params_default, self::$params);

    // Acrescenta.
    $params_default_merge['bds']         = BASE_PARAMS_BDS;          // Carrega controllers de bancos de dados.
    $params_default_merge['classes']     = BASE_PARAMS_CLASSES;      // Carrega classes de apoio.
    self::$params = array_merge_recursive($params_default_merge, self::$params);

    // Acrescenta as demais informações para uso no endpoint.
    self::$params['infoUrl'] = \controllers\FriendlyUrl::getParameters();

    // Acrescenta informações das constantes da base.
    self::$params['base'] = [
      'name'                   => BASE_NAME,
      'domain'                 => BASE_DOMAIN,
      'url'                    => BASE_URL,
      'dir'                    => BASE_DIR,
      'dir_relative'           => BASE_DIR_RELATIVE,
      'ip'                     => BASE_IP,
      'path_pages_controllers' => BASE_PATH_PAGES_CONTROLLERS,
      'path_pages_views'       => BASE_PATH_PAGES_VIEWS,
      'path_api'               => BASE_PATH_API,
      'env'                    => BASE_ENV,
      'auth'                   => BASE_AUTH,
      'config'                 => BASE_CONFIG,
    ];

    // Obtém dinamicamente a função personalizada.
    $menu = \controllers\FriendlyUrl::getParameters('func');
    
    // Acrescenta nos parâmetros gerais do endpoint o conteúdo header.
    self::$params[$menu] = $this->parse_raw_http_request();

    // Retorna
    return self::$params;
  }


  /**
   * setParameters
   * 
   * Cadastra um parâmetro no endpoint.
   *
   * @param  mixed $parameter
   * @param  mixed $value
   * @return bool
   */
  public function setParameters($parameters)
  {

    // Mescla valores default com os valores definidos no endpoint.
    self::$params = array_replace_recursive(self::$params, $parameters);

    return true;
  }


  /**
   * carregaBDs
   * 
   * Carrega os arquivos de banco de dados.
   * As classes de BDs após carregadas ficam disponíveis na controller para uso.
   * Caso o arquivo exista, ele é carregado.
   *
   * @return void
   */
  protected function carregaBDs()
  {

    // Carrega os BDs passados nos parâmetros da controler. 
    foreach (self::$params['bds'] as $key => $bdTable) {

      // Monta caminho do arquivo.
      $path_arquivo = BASE_DIR . 'template/bds/' . $bdTable . '.php';

      // Carrega arquivo.
      if (file_exists($path_arquivo)) {
        require_once $path_arquivo;
      } else {
        // Avisa que não foi possível carregar tabela específica.
        \classes\FeedBackMessagens::addWarning('Tabela não incluida.', "A banco de dados $bdTable não foi encontrato. Verifique o nome.");
      }
    }
  }


  /**
   * carregaClasses
   * 
   * Carrega as classes para funções específicas.
   * As classes após carregadas ficam disponíveis na controller para uso.
   * Caso o arquivo exista, ele é carregado.
   *
   * @return void
   */
  protected function carregaClasses()
  {
    // Carrega as Classes passados nos parâmetros da controler. 
    foreach (self::$params['classes'] as $key => $class) {

      // Monta caminho do arquivo.
      $path_arquivo = BASE_DIR . 'template/classes/' . $class . '.php';

      // Carrega arquivo.
      if (file_exists($path_arquivo)) {
        require_once $path_arquivo;
      } else {
        // Avisa que não foi possível carregar Classe de tabela.
        \classes\FeedBackMessagens::addWarning('Classe não incluida.', "A classe $class não existe. Verifique o nome.");
      }
    }
  }


  /**
   * Carrega as controllers para uso das funções staticas.
   * As classes após carregadas ficam disponíveis na controller para uso.
   * Caso o arquivo exista, ele é carregado.
   *
   * @return void
   */
  protected function carregaControllers()
  {
    // Carrega as controllers passados nos parâmetros da controler. 
    foreach (self::$params['controllers'] as $key => $origem) {

      // Classes do módulo
      foreach ($origem as $item) {

        // Inicia a base.
        $path_arquivo = '';

        // Verifica se é módulo ou api.
        switch ($key) {
          case 'pages':
            // $modulo = $modulos[0]; // Guarda o módulo de Page.
            // unset($modulos[0]); // Elimina o módulo para juntar apenas a page.
            // $path_arquivo .= VC_PATHS['PATH_CONTROL'] . 'modulos/' . $modulo . '/pages/c/' . implode('/', $modulos) . '.php';
            $path_arquivo .= BASE_DIR . 'template/pages/c/' . $item . '.php';
            break;

          case 'api':
            // $modulo = $modulos[0]; // Guarda o módulo de API.
            // unset($modulos[0]); // Elimina o módulo de api para juntar apenas a função.
            // $path_arquivo .= VC_PATHS['PATH_CONTROL'] . 'api/' . $modulo . '/functions/' . implode('/', $modulos) . '.php';
            $path_arquivo .= BASE_DIR . 'template/api/' . $item . '.php';
            break;
        }

        // Caso não tenha o módulo.
        if (empty($path_arquivo)) {
          // Avisa que não foi possível carregar Classe de tabela.
          \classes\FeedBackMessagens::addWarning('Módulo.', "O módulo [$key] não existe. Verifique o nome.");
        } else {

          // Carrega arquivo.
          if (file_exists($path_arquivo)) {
            require_once $path_arquivo;
          } else {
            // Avisa que não foi possível carregar Classe de tabela.
            \classes\FeedBackMessagens::addWarning('Controller.', "A controller [$key] não existe. Verifique o nome.");
          }
        }
      }
    }
  }


  /**
   * carregaEstrutura
   * 
   * Carrega conteúdo html dos arquivos de estrutura do módulo.
   *
   * @return bool
   */
  private function carregaEstrutura()
  {
    // Garante que o conteúdo será preenchido pela controller.
    unset(self::$params['structure']['content_page']);

    // Carrega os arquivos do parâmetro page template.
    foreach (self::$params['structure'] as $key => $value) {
      // Parâmetro recebe o conteúdo HTML do arquivo na posição.
      self::$params['structure'][$key] = file_get_contents('template//structure//' . $key . '/' . $value . '.html');
    }

    // Acrescenta novamente o html após as permissões.
    self::$params['structure']['html'] = str_replace("block content_page", "block " . self::$params['infoUrl']['func'], self::$params['structure']['html']);

    // Carrega conteúdo da página.
    self::$params['structure']['content_page'] = file_get_contents(self::$params['infoUrl']['path_endpoint']);

    // Finaliza.
    return true;
  }



  /**
   * parse_raw_http_request
   * 
   * Função de apoio para resolver tradução de requisições diferentes de get.
   * Tenta traduzir tudo para array.
   * Preenche $_POST com as informações recebidas.
   *
   * @return mixed
   */
  function parse_raw_http_request()
  {
    // Lê informações do request POST.
    $input = file_get_contents('php://input');

    // Verifica se tem valor em POST e finaliza.
    if (!empty($_POST)) {
      return $_POST;
    }

    // Verifica se conteúdo da requisição é vazio.
    if (empty($input)) {
      // Retorna um array vazio.
      return $_POST = $a_data = [];
    }

    // Decodifica em multipartes o conteúdo da requisição.
    preg_match('/boundary=(.*)$/', $_SERVER['CONTENT_TYPE'], $matches);

    // Verifica se foi possível decodificar as combinações.
    if (!isset($matches[1])) {

      // Tenta transformar conteúdo (json) em array.
      $json = json_decode($input, true);
      // Verifica se foi possível decodificar json.
      if ($json) {
        // Salva o json em array e passa pra frente.
        $input = $json;
      }

      // Sava array no $_POST e devolve o array ou texto.
      return $_POST = $a_data = $input;
    }

    // Continua verificação sem eu entender.
    $boundary = $matches[1];

    // split content by boundary and get rid of last -- element
    $a_blocks = preg_split("/-+$boundary/", $input);
    array_pop($a_blocks);

    // loop data blocks
    foreach ($a_blocks as $id => $block) {
      if (empty($block))
        continue;

      // you'll have to var_dump $block to understand this and maybe replace \n or \r with a visibile char

      // parse uploaded files
      if (strpos($block, 'application/octet-stream') !== FALSE) {
        // match "name", then everything after "stream" (optional) except for prepending newlines 
        preg_match('/name=\"([^\"]*)\".*stream[\n|\r]+([^\n\r].*)?$/s', $block, $matches);
      }
      // parse all other fields
      else {
        // match "name" and optional value in between newline sequences
        preg_match('/name=\"([^\"]*)\"[\n|\r]+([^\n\r].*)?\r$/s', $block, $matches);
      }
      $a_data[$matches[1]] = $matches[2];
    }

    // Sava array no $_POST e devolve o array ou texto.
    return $_POST = $a_data;
  }
}
