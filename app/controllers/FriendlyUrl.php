<?php

namespace controllers;
use Respect\Validation\Rules\Lowercase;


/**
 * FriendlyUrl
 * Classe responsável por encontrar o endpoint.
 * Gera o caminho completo do endpoint.
 * Gera o caminho completo da controller.
 * Gera todas as informações que pode ser passado pela URL.
 */
class FriendlyUrl
{
  /**
   * Guarda o processamento default da url para não ter que processar novamente
   */
  private static $infoUrl = [];

  /**
   * start
   *
   * @return array
   */
  public static function start()
  {
    // Pega as informações da URL.
    self::$infoUrl = self::getFrendlyURL();

    // Retorna as informações da URL.
    return self::$infoUrl;
  }


  /**
   * getFrendlyURL
   * Retorna o resultado do processamento das informações da url.
   *
   * @return array
   */
  private static function getFrendlyURL()
  {

    // Verifica se não processou informações da url.
    if (!self::$infoUrl) {
      self::$infoUrl = self::processEndPoint();
    }

    // Retorna as informações da url.
    return self::$infoUrl;
  }


  /**
   * processFrendlyURL
   * Função que processa informações da url.
   * Busca os endpoints.
   * 
   * @author Mateus Brust
   * 
   *  Array
   *  (
   *      [url] => https://localhost/cetrus/sp-vindi-api/api/testes/param1        // Url completa.
   *      [namespace] => api                                                      // Namespace (API ou PAGES).
   *      [path_dir] => template/api/testes/                                      // Caminho para diretório do endpoint.
   *      [path_endpoint] => template/api/testes/index.php                        // Caminho relativo para o endpoint.
   *      [dir] => testes/                                                        // Diretório do endpoint.
   *      [file_name] => index.php                                                // Nome do arquivo do endpoint.
   *      [file_endpoint] => index                                                // Nome do arquivo do endpoint sem extensão.
   *      [controller_name] => index                                              // Nome da controller do endpoint (No caso uma página.).
   *      [controller_path] => template/api/testes/index.php                      // Caminho relativo da controller do endpoint.
   *      [url_endpoint] => https://localhost/cetrus/sp-vindi-api/api/testes/     // Url do endpoint.
   *      [url_relative] => testes/                                               // Url relativa do endpoint.
   *      [attr] => Array                                                         // Parâmetros enviados após o endpoint.
   *          (
   *              [0] => param1
   *          )
   *  )
   *
   * @return array
   */
  private static function processEndPoint()
  {

    // Guarda os parâmetros da URL atual conforme htacces.
    if (isset($_GET['url'])) {
      // Explode a url em parâmetros.
      $url = explode('/', strtolower($_GET['url']));
      // Guarda a url completa.
      $infoUrl['url'] = BASE_URL . $_GET['url'];
    } else {
      // Seta url vazio para não dar erro.
      $url = [''];
      // Guarda a url completa.
      $infoUrl['url'] = BASE_URL;
    }

    // Verifica se não tem posição vazia no final.
    if (!empty(end($url))) {
      // Acrescenta uma posição vazia no final para não dar erro.
      array_push($url, '');
    }

    // Verifica se é API e monta o path das páginas.
    if ($url[0] == 'api') {
      $infoUrl['namespace'] = 'api';
      unset($url[0]);
      $path = BASE_PATH_API;
      $extension = '.php';
      $api = true;
    } else {
      $infoUrl['namespace'] = 'pages';
      $path = BASE_PATH_PAGES_VIEWS;
      $extension = '.html';
      $api = false;
    }

    // Inicializa informações default do endpoint
    $infoUrl['path_dir']        = $path;
    $infoUrl['path_endpoint']   = '';
    $infoUrl['dir']             = '';
    $infoUrl['file_name']       = '';
    $infoUrl['file_endpoint']   = '';
    $infoUrl['controller_name'] = '';
    $infoUrl['controller_path'] = BASE_PATH_PAGES_CONTROLLERS;

    // Acrescenta caso seja api.
    if ($api) {
      $infoUrl['url_endpoint']    = BASE_URL . 'api/';
    } else {
      $infoUrl['url_endpoint']    = BASE_URL;
    }

    $infoUrl['url_relative']    = '';
    $infoUrl['attr']            = [];

    // Variáveis de apoio.
    $is_file = 1;      // [0] não é arquivo, [1] endpoint, [2] index do endpoint.
    $is_dir  = false;  // Guarda se posição atual é diretório.
    $is_end  = false;  // Guarda se é para finalizar processo de endpoint.
    $title   = '';     // Guarda o nome do endpoint.

    // Percorre cada posição da url em busca de um endpoint.
    foreach ($url as $key => $value) {

      $title = $value;
      $value = str_replace('-', '', $value);

      // Verifica se nome do arquivo atual é um arquivo.
      if (is_file($path . $value . $extension)) {

        // Guarda o endpoint atual.
        $infoUrl['path_endpoint'] = $path . $value . $extension;

        // Ajusta o nome do arquivo atual.
        $infoUrl['file_name'] = $value . $extension;

        // Ajusta o endpoint atual.
        $infoUrl['file_endpoint'] = str_replace('-', '', $value);

        // Ajusta o endpoint atual.
        $infoUrl['title_endpoint'] = ucfirst(str_replace('-', ' ', $title));

        // É um endpoint.
        $is_file = 1;
      } else if (is_file($path . 'index' . $extension)) {

        // Guarda o endpoint atual.
        $infoUrl['path_endpoint'] = $path . 'index' . $extension;

        // Ajusta o nome do arquivo atual.
        $infoUrl['file_name'] = 'index' . $extension;

        // Ajusta o endpoint atual.
        $infoUrl['file_endpoint'] = 'index';

        // É um endpoint index.
        $is_file = 2;
      } else {
        // Endereço atual não é um endpoint.
        $is_file = 0;
      }

      // Verifica se é pasta e prossegue.
      if (is_dir($path . $value . '/')) {
        // Guarda para finalizar.
        $is_dir = true;

        // Guarda path diretório pai.
        $infoUrl['path_dir'] = $path . $value;
        // Guarda diretório pai.
        $infoUrl['dir'] = $title;

        // Ajusta caminho.
        if ($value . '/' != '/') {
          // Ajusta path diretório pai.
          $infoUrl['path_dir'] .= '/';
          // Ajusta diretório pai.
          $infoUrl['dir'] .= '/';
        }
      } else {

        // Encontrou o endpoint.
        $is_end = true;
      }

      // Verifica se é para finalizar.
      if ($is_end) {

        // Limpa se último parâmetro é vazio.
        if (empty(end($url))) {
          unset($url[array_key_last($url)]);
        }

        // Verifica se é endpoint e retira dos parâmetros [attr].
        if (($is_dir || $is_file == 0) && $is_file != 2 || $infoUrl['file_endpoint'] == $url[$key]) {
          unset($url[$key]);
        }

        // Guarda os parâmetros passados pela url.
        $infoUrl['attr'] = array_values($url);

        // Finaliza a procura por endpoint.
        break;
      } else {
        // Caso não seja endpoint.
        $path .= $value . '/';

        // Guarda url do endpoint.
        $infoUrl['url_endpoint'] .= $value;
        $infoUrl['url_relative'] .= $value;

        // Ajusta caminho.
        if ($value . '/' != '/') {
          // Ajusta caminho.
          $infoUrl['url_endpoint'] .= '/';
          $infoUrl['url_relative'] .= '/';
        }

        // Tira valor da url o resto é parâmetros [attr].
        unset($url[$key]);
      }
    }

    // Ajustes finais.
    // Se não for api.
    if (!$api) {
      // Acrescenta informações da controller da página.
      $infoUrl['controller_name'] = $infoUrl['file_endpoint'];
      $infoUrl['controller_path'] = str_replace($infoUrl['file_name'], $infoUrl['controller_name'], $infoUrl['path_endpoint']) . '.php';
      $infoUrl['controller_path'][15] = 'c';
      // Verifica se não existe controller.
      if (!is_file($infoUrl['controller_path'])) {
        // Seta controller default
        $infoUrl['controller_name'] = 'standart';
        $infoUrl['controller_path'] = BASE_PATH_PAGES_CONTROLLERS . $infoUrl['controller_name'] . '.php';
      }
    } else {
      // $infoUrl['controller_name'] = $infoUrl['file_name'];
      $infoUrl['controller_name'] = $infoUrl['file_endpoint'];
      $infoUrl['controller_path'] = $infoUrl['path_endpoint'];
    }

    // Verifica se arquivo não é index.
    if ($infoUrl['file_endpoint'] != 'index') {
      // Ajusta url do endpoint.
      $infoUrl['url_endpoint'] .= $infoUrl['file_endpoint'] . '/';
      $infoUrl['url_relative'] .= $infoUrl['file_endpoint'] . '/';
    } else {
      // Ajusta o endpoint atual.
      $infoUrl['title_endpoint'] = ucfirst(str_replace(['/', '-'], ['', ' '], $infoUrl['dir']));
    }

    // Retorna as informações do processamento da URL.
    return $infoUrl;
  }

  /**
   * getParameter
   * Retorna valor das informações da url.
   *
   * @param  string $parameter
   * @return mixed
   */
  public static function getParameters($parameter = null)
  {
    // Verifica se não processou informações da url.
    if ($parameter) {
      return self::$infoUrl[$parameter];
    }

    // Finaliza função.
    return self::$infoUrl;
  }


  /**
   * setParameters
   * 
   * Cadastra um parâmetro nas informações de url.
   *
   * @param  mixed $parameter
   * @param  mixed $value
   * @return bool
   */
  public static function setParameters($parameter, $value)
  {
    self::$infoUrl[$parameter] = $value;

    return true;
  }
}
