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

    // Guarda informações da url
    self::$infoUrl = $infoUrl;

    // Guarda a função atual (menu).
    $menu = self::$infoUrl['func'];

    // Verifica se segurança NÃO está ativa para endpoint atual e finaliza.
    if (!self::$paramsSecurity['ativo']) {
      return self::$paramsSecurity;
    }

    // Permite as origens informadas do endpoint.
    self::allowOrigins();

    // Verifica se necessita de sessão.
    self::checkSession();

    // Verifica se foi solicitada altenticação por headers.
    self::checkAuthorizationHeaders();

    // Verifica se é obrigatório uso de token na transação e se tem transação.
    self::checkToken();

    // Verifica se necessita de sessão. E analisa permissões do usuário logado.
    self::checkPermissions($menus);

    // Retorna resultado da segurança.
    return self::$paramsSecurity;
  }


  /**
   * allowOrigins
   * 
   * Permite as origens informadas do endpoint.
   *
   * @return void
   */
  private static function allowOrigins()
  {

    // Verifica as origens permitidas do endpoint.
    foreach (self::$paramsSecurity['origin'] as $key => $value) {
      // Permite as origens.
      header("Access-Control-Allow-Origin: " . $value);
    }
  }


  /**
   * checkSession
   * 
   * Verifica se necessita de sessão.
   *
   * @return void
   */
  private static function checkSession()
  {
    // Verifica se necessita de sessão.
    if (self::$paramsSecurity['session']) {

      // Verifica se não existe sessão aberta.
      if (!\classes\Session::check(self::$paramsSecurity['sessionTimeOut'])) {
        self::redirect('A página que tentou acessar é restrita.');
      }
    }
  }

  /**
   * checkAuthorizationHeaders
   * 
   * Verifica se foi solicitada altenticação por headers.
   *
   * @return void
   */
  private static function checkAuthorizationHeaders()
  {
    // Verifica se foi solicitada altenticação por headers.
    if (!empty(self::$paramsSecurity['headers']) && !empty(self::$paramsSecurity['headers']['key']) && !empty(self::$paramsSecurity['headers']['value'])) {
      // Verifica se tem valores no cabeçalho. Se não tiver, finaliza.
      if (isset(getallheaders()[self::$paramsSecurity['headers']['key']]) && !empty(getallheaders()[self::$paramsSecurity['headers']['key']])) {
        // Guarda o valor da key.
        $authorization = getallheaders()[self::$paramsSecurity['headers']['key']];
        // Verifica se o valor da key recebida é diferente da solicitada e finaliza.
        if ($authorization != self::$paramsSecurity['headers']['value']) {

          // Verifica se é api.
          if (self::$infoUrl['namespace'] == 'api') {
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
        if (self::$infoUrl['namespace'] == 'api') {
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
   * @return void
   */
  private static function checkToken()
  {
    // Verifica se é obrigatório uso de token na transação e se tem transação.
    if (self::$paramsSecurity['token'] && self::$infoUrl['func'] != 'get') {

      // Acrescenta o token nos parâmetros da security. para ser usado nas transações.
      self::$paramsSecurity['token'] = BASE_AUTH['token'];

      // Verifica se token não é válido.
      if (empty($_POST) || !isset($_POST['token']) || $_POST['token'] != BASE_AUTH['token']) {

        // Verifica se é API.
        if (self::$infoUrl['namespace'] == 'api') {
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
   * checkPermissions
   * 
   * Verifica se necessita de sessão. E analisa permissões do usuário logado.
   *
   * @param  array $menus
   * @return void
   */
  private static function checkPermissions($menus)
  {
    // Verifica se necessita de sessão. E analisa permissões do usuário logado.
    if (self::$paramsSecurity['session']) {

      // Verifica se tem permissões específicas (funão menu) ou geral do endpoint.
      if (isset($menus[self::$infoUrl['func']])) {
        // Permissões específicas para menu do endpoint.
        $permissionEndpoint = $menus[self::$infoUrl['func']]['permission'];
      } else {
        // Permissões gerais do endpoint.
        $permissionEndpoint = self::$paramsSecurity['permission'];
      }

      // Permissões que usuário tem na página atual.
      $permissionUser = self::getPermissionUrlRelative(Session::get('permissions'), self::$infoUrl['url_relative']);

      // Guarda as permissões que usuário tem.
      self::$paramsSecurity['permissionUser'] = $permissionUser;

      // Caso não tenha permissões, finaliza.
      if (!self::comparaPermissao($permissionEndpoint, $permissionUser)) {
        // Verifica se é api.
        if (self::$infoUrl['namespace'] == 'api') {
          header('Content-Type: application/json; charset=utf-8');
          // Imprime na tela mensagem de erro e finaliza.
          echo '{"msg":"Sem permissões"}';
        } else {
          self::redirect('Usuário não tem permissões para acessar a página.');
        }
        exit;
      }
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

  /**
   * Redireciona para o login e passa uma mensagem.
   *
   * @param string $msg
   * 
   * @return void
   * 
   */
  private static function redirect($msg = 'Redirecionado.')
  {
    // Monta url de redirecionamento para login e passa a url atual.
    $url = BASE_URL . self::$paramsSecurity['loginPage'] . '?redirect_url=' . self::$infoUrl['url'] . '&redirect_msg=' . $msg;
    // Redireciona para url.
    header('location: ' . $url);
  }

  /**
   * Compara as permissões exigidas com as concedidas ao uauário.
   *
   * @param array $exigidas
   * @param array $concedidas
   * 
   * @return bool
   * 
   */
  private static function comparaPermissao($exigidas, $concedidas)
  {
    if ($exigidas['session'] > $concedidas['session']) {
      return false;
    };
    if ($exigidas['get'] > $concedidas['get']) {
      return false;
    };
    if ($exigidas['getFull'] > $concedidas['getFull']) {
      return false;
    };
    if ($exigidas['post'] > $concedidas['post']) {
      return false;
    };
    if ($exigidas['put'] > $concedidas['put']) {
      return false;
    };
    if ($exigidas['patch'] > $concedidas['patch']) {
      return false;
    };
    if ($exigidas['del'] > $concedidas['del']) {
      return false;
    };
    if ($exigidas['api'] > $concedidas['api']) {
      return false;
    };

    return true;
  }
}
