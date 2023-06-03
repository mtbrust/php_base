<?php

namespace controllers;

class Security
{
  private static $paramsSecurity = [];

  /**
   * start
   * Inicia o motor da classe.
   *
   * @param  mixed $params
   * @return mixed
   */
  public static function start($params = [], $menus = [])
  {
    // Salva os parâmetros de segurança.
    self::$paramsSecurity = $params;

    // Guarda namespace (api ou page)
    $namespace = \controllers\FriendlyUrl::getParameters('namespace');

    // Guarda a função atual (menu).
    $menu = FriendlyUrl::getParameters('func');

    // Verifica se segurança NÃO está ativa para endpoint atual e finaliza.
    if (!$params['ativo']) {
      return [];
    }

    // Permite as origens informadas do endpoint.
    self::allowOrigins($params);

    // Verifica se necessita de sessão.
    self::checkSession($params);

    // Verifica se foi solicitada altenticação por headers.
    self::checkAuthorizationHeaders($params, $namespace);
    
    // Verifica se é obrigatório uso de token na transação e se tem transação.
    self::checkToken($params, $namespace, $menu);
    
    // Verifica se necessita de sessão. E analisa permissões do usuário logado.
    self::checkPermissions($params, $menu, $menus);

    // Retorna resultado da segurança.
    return self::$paramsSecurity;
  }

  
  /**
   * allowOrigins
   * 
   * Permite as origens informadas do endpoint.
   *
   * @param  mixed $params
   * @return void
   */
  private static function allowOrigins($params){

    // Verifica as origens permitidas do endpoint.
    foreach ($params['origin'] as $key => $value) {
      // Permite as origens.
      header("Access-Control-Allow-Origin: " . $value);
    }
  }


  /**
   * checkSession
   * 
   * Verifica se necessita de sessão.
   *
   * @param  mixed $params
   * @return void
   */
  private static function checkSession($params)
  {
    // Verifica se necessita de sessão.
    if ($params['session']) {

      // Inicia a sessão.
      \classes\Session::start();

      // Verifica se existe sessão aberta.
      if (!\classes\Session::check($params['sessionTimeOut'])) {
        // Monta url de redirecionamento para login e passa a url atual.
        $url = BASE_URL . $params['loginPage'] . '?redirect_url=' . FriendlyUrl::getParameters('url');
        // Redireciona para url.
        header('location: ' . $url);
      }
    }
  }
  
  /**
   * checkAuthorizationHeaders
   * 
   * Verifica se foi solicitada altenticação por headers.
   *
   * @param  mixed $params
   * @param  mixed $namespace
   * @return void
   */
  private static function checkAuthorizationHeaders($params, $namespace)
  {
    // Verifica se foi solicitada altenticação por headers.
    if (!empty($params['headers']) && !empty($params['headers']['key']) && !empty($params['headers']['value'])) {
      // Verifica se tem valores no cabeçalho. Se não tiver, finaliza.
      if (isset(getallheaders()[$params['headers']['key']]) && !empty(getallheaders()[$params['headers']['key']])) {
        // Guarda o valor da key.
        $authorization = getallheaders()[$params['headers']['key']];
        // Verifica se o valor da key recebida é diferente da solicitada e finaliza.
        if ($authorization != $params['headers']['value']) {

          // Verifica se é api.
          if ($namespace == 'api') {
            header('Content-Type: application/json; charset=utf-8');
            // Imprime na tela mensagem de erro e finaliza.
            echo '{"msg":"Autenticação falhou."}';
          } else {
            echo 'Autenticação falhou.';
          }
          exit;
        }
      } else {
        // Verifica se é api.
        if ($namespace == 'api') {
          header('Content-Type: application/json; charset=utf-8');
          // Imprime na tela mensagem de erro e finaliza.
          echo '{"msg":"Autenticação falhou."}';
        } else {
          echo 'Autenticação falhou.';
        }
        exit;
      }
    }
  }

  
  /**
   * checkToken
   * 
   * Verifica se é obrigatório uso de token na transação e se tem transação.
   *
   * @param  mixed $params
   * @param  mixed $namespace
   * @param  mixed $menu
   * @return void
   */
  private static function checkToken($params, $namespace, $menu)
  {
    // Verifica se é obrigatório uso de token na transação e se tem transação.
    if ($params['token'] && $menu != 'get') {

      // Acrescenta o token nos parâmetros da security. para ser usado nas transações.
      self::$paramsSecurity['token'] = BASE_AUTH['token'];

      // Verifica se token não é válido.
      if (empty($_POST) || !isset($_POST['token']) || $_POST['token'] != BASE_AUTH['token']) {

        // Verifica se é API.
        if ($namespace == 'api') {
          header('Content-Type: application/json; charset=utf-8');
          // Imprime na tela mensagem de erro e finaliza.
          echo '{"msg":"É necessário um token válido para terminar a requisição."}';
          exit;
        }

        // Feedback para usuário.
        \classes\FeedBackMessagens::add('danger', 'Erro.', 'Transação de dados interrompido. É necessário um token válido para terminar a requisição.');
        // Apaga os dados do post.
        $_POST = [];
      }
    }
  }
    

  /**
   * todo - FAZER A PARTE DE PERMISSÕES POR USUÁRIO LOGADO E GRUPOS.
   * checkPermissions
   * 
   * Verifica se necessita de sessão. E analisa permissões do usuário logado.
   *
   * @param  mixed $params
   * @param  mixed $menu
   * @return void
   */
  private static function checkPermissions($params, $menu, $menus)
  {
    // Verifica se necessita de sessão. E analisa permissões do usuário logado.
    if ($params['session']) {

      // todo - FAZER A PARTE DE PERMISSÕES POR USUÁRIO LOGADO E GRUPOS.
      echo '{TEM QUE FAZER ESSA PARTE DE VERIFICAR PERMISSÕES DO ENDPOINT.} ' . __FILE__;
      // Verifica se tem permissões específicas para acessar a função (menu) do endpoint.
      if (isset($menus[$menu])) {
        // Permissões específicas para menu do endpoint.
        $permissionEndpoint = $menus[$menu]['permission'];
      } else {
        // Permissões gerais do endpoint.
        $permissionEndpoint = $params['permission'];
      }

      $permissionUser = \classes\Session::get('permissions');
      print_r($permissionUser[\controllers\FriendlyUrl::getParameters('controller_path')]);

      echo '
    Finalizar aqui.
    ';
      print_r($params);
      exit;
    }
  }











  // todo - ANTIGO - VERIFICAR POIS ACHO QUE NÃO PRECISA MAIS.


  /**
   * createSession
   * Cria sessão com as informações passadas por parâmetro.
   * Ao final redireciona para página restrita.
   *
   * @param  mixed $infoSession
   * @return void
   */

   /*
  public static function createSession($infoSession, $redirect_url = null)
  {
    // Inicia o serviço de sessão.
    session_start();

    // Informações default de usuário. Garante que terá no mínimo esses campos.
    $infoSessionDefault = [
      'id'         => '0',       // Identificador único do usuário.
      'nome'       => 'guest',   // Nome para ser exibido.
      'login'      => 'guest',   // Identificação de usuário (user, matricula, email, id).
      'senha'      => '',        // Senha usada para logar. Depois é retirada da sessão.
      'menus'      => [],        // Menu do usuário e do grupo do usuário.
      'permission' => [
        'url/'          => '000000000',
        'url/endpoint/' => '000000000',
      ],   // Permissões personalizadas do usuário logado em cada url. [9] Menu, Início, Adicionar, Editar, Listar (Básico), Listar Completo, Deletar, API, Testes.
      'groups'        => [],       // Grupos que usuário pertence.
      'sessionTimeIn' => time(),   // Guarda o time de login.
    ];

    // Mescla informações default com as informações recebidas.
    $infoSession = array_replace_recursive($infoSessionDefault, $infoSession);

    // Guarda informações de sessão do usuário logado.
    $_SESSION[BASE_ENV] = $infoSession;

    // Caso não seja passado nenhuma url por parâmetro, segue o padrão.
    if (!$redirect_url) {
      // Obtém a url padrão para endpoint restrito.
      $redirect_url = self::$paramsSecurity['restrictPage'];
      if (isset($_GET['redirect_url'])) {
        // Sobreescreve endpoint restrito, para onde o usuário estava.
        $redirect_url = $_GET['redirect_url'];
      }
    }

    // Redireciona usuário para login.
    header("location: " . $redirect_url);
    // Garante que vai redirecionar.
    exit;
  }
  */

  /**
   * getSession
   * Obtém uma informação específica da sessão de segurança atual.
   * Caso não passe parâmetro, devolve toda a sessão.
   *
   * @param  mixed $param
   * @return mixed
   */
  
  public static function getSession($param = null)
  {

    // Inicia o serviço de sessão.
    session_start();

    // Verifica se não inicializou sessão e finaliza.
    if (!isset($_SESSION[BASE_ENV])) {
      return false;
    }

    // Verifica se tem o parâmetro na sessão e retorna.
    if (isset($_SESSION[BASE_ENV][$param])) {
      return $_SESSION[BASE_ENV][$param];
    }

    // Retorna toda a session.
    return $_SESSION[BASE_ENV];
  }

  public static function getUserId($param = null)
  {
    return true;

    // Inicia o serviço de sessão.
    session_start();

    // Verifica se não inicializou sessão e finaliza.
    if (!isset($_SESSION[BASE_ENV])) {
      return false;
    }

    // Verifica se tem o parâmetro na sessão e retorna.
    if (isset($_SESSION[BASE_ENV][$param])) {
      return $_SESSION[BASE_ENV][$param];
    }

    // Retorna toda a session.
    return $_SESSION[BASE_ENV];
  }
  

  /**
   * delSession
   * Finaliza a sessão aberta para segurança do sistema atual.
   * Permite deixar outras informações na sessão.
   *
   * @return bool
   */
  /*
  public static function delSession()
  {
    // Apaga apenas a sessão aberta para o sistema.
    unset($_SESSION[BASE_ENV]);

    // Finaliza.
    return true;
  }
  */
}
