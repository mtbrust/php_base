<?php

namespace controllers;

use classes\DevHelper;
use classes\Session;

class Security
{
  private static $paramsSecurity = [];

  private static $infoUrl = [];

  /**
   * start
   * Inicia o motor da classe.
   *
   * @param  mixed $params
   * @return mixed
   */
  public static function start($params = [], $menus = [], $infoUrl = [])
  {
    // Inicia a sessão independente se tiver sessão a página (para garantir que vai disponibilizar informações caso usuário estiver logado).
    Session::start();

    // Salva os parâmetros de segurança.
    self::$paramsSecurity = $params;

    self::$infoUrl = $infoUrl;

    // Mesmo não precisando de sessão, caso tenha, manda para a controller.
    self::$paramsSecurity['session'] = Session::get();

    // Guarda namespace (api ou page)
    $namespace = self::$infoUrl['namespace'];

    // Guarda a função atual (menu).
    $menu = self::$infoUrl['func'];

    // Verifica se segurança NÃO está ativa para endpoint atual e finaliza.
    if (!$params['ativo']) {
      return self::$paramsSecurity;
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
  private static function allowOrigins($params)
  {

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

      // Verifica se existe sessão aberta.
      if (!\classes\Session::check($params['sessionTimeOut'])) {
        // Monta url de redirecionamento para login e passa a url atual.
        $url = BASE_URL . $params['loginPage'] . '?redirect_url=' . self::$infoUrl['url'];
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

      // Verifica se tem permissões específicas (funão menu) ou geral do endpoint.
      if (isset($menus[$menu])) {
        // Permissões específicas para menu do endpoint.
        $permissionEndpoint = $menus[$menu]['permission'];
      } else {
        // Permissões gerais do endpoint.
        $permissionEndpoint = $params['permission'];
      }

      // Permissões que usuário tem na página atual.
      $permissionUser = self::getPermissionUrlRelative(Session::get('permissions'), self::$infoUrl['url_relative']);

      // todo - verificar como está sendo gravado as permissões específicas. (tem que conseguir transformar em array de novo.)
      // DevHelper::printr($params['permission']);
      $tmp = $permissionUser;
      $tmp = $tmp['especific'];
      $tmp = '[' . $tmp . ']';
      // $tmp = json_decode($tmp);
      DevHelper::printr($tmp);

      echo '<hr>PERMISSÕES QUE A PÁGINA(MENU) ATUAL EXIGE: <pre>';
      print_r($permissionEndpoint);
      echo '<hr>PÁGINA(MENU) ATUAL: <pre>';
      print_r($controller_path);

      echo '<Hr>
    Finalizar aqui.
    ';
      print_r($params);
      exit;
    }
  }

  private static function getPermissionUrlRelative($permissionsUser, $urlRelative)
  {
    foreach ($permissionsUser as $key => $value) {
      if ($value['urlPagina'] == $urlRelative)
      return $value;
    }
    return false;
  }
}
