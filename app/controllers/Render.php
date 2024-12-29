<?php

namespace controllers;

use Twig\Extra\Intl\IntlExtension;

/**
 * Render
 * Classe de renderização de conteúdo usando a biblioteca Twig.
 * Renderização com função de cache.
 */
class Render
{
  /**
   * endPoint
   * 
   * Inicia o motor da classe.
   * Renderiza todos os parâmetros passados e devolve o conteúdo.
   *
   * @param  mixed $params
   * @return string
   */
  public static function endPoint($params)
  {
    // Verifica qual render utilizar. (página ou api)
    if ($params['infoUrl']['namespace'] == 'pages' && $params['infoUrl']['func'] != 'api') {
      $content = self::page($params);
    } else {
      $content = self::api($params);
    }

    // Verifica as condições e salva em cache.
    self::saveCacheEndpoint($params['render'], $content);

    // Retorna resultado da renderização.
    return $content;
  }


  /**
   * page
   * 
   * Renderia os parâmetros específicos para páginas HTML.
   *
   * @param  mixed $params
   * @return mixed
   */
  public static function page($params)
  {
    // Arquivos locais.
    $vurll = new \Twig\Loader\ArrayLoader(
      $params['structure']
    );

    // Monta quais são as partes (pastas) que se usa no template da página atual.
    $base = '';
    foreach (array_keys($params['structure']) as $key => $value) {
      if (!$key == 0)
        $base .= '{% use "' . $value . '" %}';
    }

    // Base html. Aqui controla quais arquivos o TWIG irá renderizar.
    $html_base = new \Twig\Loader\ArrayLoader([
      'base' => '{% extends "html" %}' . $base
    ]);

    // Sequência de prioridade. Arquivos físicos depois Virtuais.
    $loader = new \Twig\Loader\ChainLoader([$vurll, $html_base]);
    $twig   = new \Twig\Environment($loader);
    $twig->addExtension(new IntlExtension());

    // Limpa valores de estrutura para não sujar view.
    unset($params['structure']);

    // Após carregar os templates HTML, e passar os parmâmetros, desenha página na tela.
    return $twig->render('base', $params);
  }


  /**
   * api
   * 
   * Renderiza os parâmetros de acordo com a saída desejada.
   *
   * @param  mixed $params
   * @return string
   */
  public static function api($params)
  {
    if (isset($params['response'])) {

      // Verifica se foi passado o código do status da requisição.
      if (isset($params['status'])) {
        http_response_code($params['status']);
      } else {
        http_response_code(200);
      }

      // Verifica se a saída é json.
      if ($params['render']['content_type'] == 'application/json') {

        // Padronização da response.
        $response['error'] = false;
        $response['status'] = $params['status'];
        $response['date'] = date('Y-m-d H:i:s');
        $response['ip'] = BASE_IP;
        $response['msg'] = $params['msg'];
        $response['body'] = $params['response'];

        // Exibe todos os parametros no retorno da API.
        if ($params['render']['showParams']) {
          $response['params'] = $params;
        }

        // Converte a saída array para json com utf-8.
        return json_encode($response, JSON_UNESCAPED_UNICODE);
      } else {
        // Caso a saída seja personalizada, é necessário enviar de acordo com a saída.
        return $params['response'];
      }
    } else {
      // Retorno de erro.
      return '{"error":"true","msg":"Não foi definido valor de resposta. Preencha o $params[\'response\']"}';
    }
  }


  /**
   * objCache
   * 
   * Verifica se tem cache.
   *
   * @param  mixed $obj_path Preencher com pasta/nome_arquivo.extensão.
   * @param  mixed $params
   * @param  mixed $cacheTime
   * @param  mixed $flag
   * @return string
   */
  public static function objCache($obj_path, $cacheTime = null, $flag = null)
  {
    // Retorno padrão.
    $result = false;

    // Tenta obter cache.
    $cache = self::getCache('obj/' . self::path_file_cache($obj_path, $flag), $cacheTime);

    // Verifica se teve retorno cache.
    if ($cache) {
      // Retorna o cache.
      return $cache;
    }

    // Retorna o resultado do processamento.
    return $result;
  }


  /**
   * obj
   * 
   * Renderiza um objeto com os parâmetros personalizados.
   * É possível criar um cache para não precisar renderizar esse objeto.
   * É possível criar uma flag para tornar esse cache único.
   * Objeto não precisa ser necessariamente um html. Pode ser um PDF, TXT, etc.
   * Cache irá salvar como txt.
   *
   * @param  mixed $obj_path Preencher com pasta/nome_arquivo.extensão.
   * @param  mixed $params Array para substituir marcações.
   * @param  mixed $cacheTime Tempo para renovar cache em segundos.
   * @param  mixed $flag Flag para diferenciar cache.
   * @return string
   */
  public static function obj($obj_path, $params = null, $cacheTime = false, $flag = null)
  {
    // Retorno padrão.
    $result = false;

    // Tenta obter cache.
    $cache = self::getCache('obj/' . self::path_file_cache($obj_path, $flag), $cacheTime);

    // Verifica se teve retorno cache.
    if ($cache) {
      // Retorna o cache.
      return $cache;
    }

    // Inicia o processamento do objeto.
    $result = self::twig('template/render/', $obj_path, $params);

    // Salva resultado do processamento em cache.
    self::saveCache('obj/' . self::path_file_cache($obj_path, $flag), $result, $cacheTime);

    // Retorna o resultado do processamento.
    return $result;
  }


  /**
   * htmlCache
   * 
   * Verifica se tem cache.
   *
   * @param  mixed $html
   * @param  mixed $cacheTime
   * @param  string $flag // Nome do arquivo cache.
   * @return string
   */
  public static function htmlCache($cacheTime = null, $flag = '')
  {
    // Retorno padrão.
    $result = false;

    // Tenta obter cache.
    $cache = self::getCache('obj/' . self::path_file_cache($flag), $cacheTime);

    // Verifica se teve retorno cache.
    if ($cache) {
      // Retorna o cache.
      return $cache;
    }

    return $result;
  }


  /**
   * doc
   * 
   * Renderiza um documento de texto com os parâmetros personalizados.
   * É possível criar um cache para não precisar renderizar esse texto html.
   * É possível criar uma flag para tornar esse cache único.
   *
   * @param  mixed $text
   * @param  mixed $params
   * @param  mixed $cacheTime // Em segundos
   * @param  string $flag // Nome do arquivo cache.
   * @return string
   */
  public static function doc($text, $params = null, $cacheTime = false, $flag = '')
  {
    // Retorno padrão.
    $result = false;

    // Tenta obter cache.
    $cache = self::getCache('text/' . self::path_file_cache($flag), $cacheTime);

    // Verifica se teve retorno cache.
    if ($cache) {
      // Retorna o cache.
      return $cache;
    }

    // Inicia a construção do HTML
    $loader = new \Twig\Loader\ArrayLoader([
      'index' => $text,
    ]);
    $twig = new \Twig\Environment($loader);
    $twig->addExtension(new IntlExtension());

    // Inicia o processamento do objeto.
    $result = $twig->render('index', $params);

    // Salva resultado do processamento em cache.
    self::saveCache('text/' . self::path_file_cache($flag), $result, $cacheTime);

    return $result;
  }


  /**
   * Renderiza objetos.
   * Renderiza um objeto html com os parâmetros passados.
   * Retorna uma string HTML.
   *
   * @param string $path
   * @param string $objName
   * @param array $params
   * @return string
   */
  public static function twig($path, $objName, $params = [])
  {
    // Verifica se arquivo NÃO existe e retorna.
    if (!file_exists($path . $objName)) {
      return 'Não foi possível renderizar. Arquivo não encontrado: ' . $path . $objName;
    }

    // Inicia a construção do objeto HTML
    $loader   = new \Twig\Loader\FilesystemLoader($path);   // Verifica a pasta objs.
    $twig     = new \Twig\Environment($loader);             // Instancia objeto twig.
    $twig->addExtension(new IntlExtension());
    $template = $twig->load($objName);            // Retorna template html.
    return $template->render($params);                      // Junta parametros com template. (array associativo)
  }


  /**
   * getCache
   * 
   * Carrega cache se possível.
   * É possível criar uma flag para tornar esse cache único.
   *
   * @param  mixed $pathFile
   * @param  mixed $cacheTime
   * @param  mixed $flag
   * @return string
   */
  public static function getCache($pathFile, $cacheTime = false)
  {
    // Verifica se não tem vencimento ou se não ten conteúdo a ser salvo e finaliza.
    if (!$cacheTime) {
      return false;
    }

    return Cache::get($pathFile, $cacheTime);
  }


  /**
   * saveCache
   * 
   * Salva cache se possível.
   *
   * @param  string $pathFile
   * @param  string $content
   * @param  int $cacheTime Em segundos
   * @return void
   */
  public static function saveCache($pathFile, $content = false, $cacheTime = false)
  {
    // Verifica se não tem vencimento ou se não ten conteúdo a ser salvo e finaliza.
    if (!$cacheTime || !$content) {
      return false;
    }
    
    Cache::set($pathFile, $content);
  }


  /**
   * getCacheEndpoint
   * 
   * FUNÇÃO DE APOIO
   * Verifica cache do endpoint atual e devolve o conteúdo do arquivo.
   *
   * @param  mixed $params
   * @return mixed
   */
  public static function getCacheEndpoint($paramsRender)
  {
    // Retorno padrão.
    $cache = false;

    // Verifica se o cache está ativo.
    if ($paramsRender['cache']) {

      // Caso seja necessário cachear por parametros.
      $path_endpoint = '';
      if ($paramsRender['cacheParams']) {
        $path_endpoint = '-' . implode('-', \controllers\FriendlyUrl::getParameters('attr'));
      }
      // Monta o domínio do endpoint
      $pathFile = 'endpoint/' . str_replace(['.php', '.html'], ['', ''], \controllers\FriendlyUrl::getParameters('path_endpoint')) . $path_endpoint;
      
      $cache = self::getCache($pathFile, $paramsRender['cacheTime']);
    }

    // Retorna se tem cache.
    return $cache;
  }


  /**
   * saveCacheEndpoint
   * 
   * FUNÇÃO DE APOIO
   * Verifica cache do endpoint atual e salva se necessário.
   *
   * @param  mixed $paramsRender
   * @param  mixed $content
   * @return mixed
   */
  public static function saveCacheEndpoint($paramsRender, $content)
  {
    // Verifica se o cache está ativo.
    if ($paramsRender['cache']) {

      // Caso seja necessário cachear por parametros.
      $path_endpoint = '';
      if ($paramsRender['cacheParams']) {
        $path_endpoint = '-' . implode('-', \controllers\FriendlyUrl::getParameters('attr'));
      }
      // Monta o domínio do endpoint
      $pathFile = 'endpoint/' . str_replace(['.php', '.html'], ['', ''], \controllers\FriendlyUrl::getParameters('path_endpoint')) . $path_endpoint;

      self::saveCache($pathFile, $content, $paramsRender['cacheTime']);
    }
  }


  /**
   * path_file_endpoint
   * 
   * FUNÇÃO DE APOIO
   * Devolve o path do arquivo cache do endpoint.
   *
   * @param  string $extension
   * @param  bool $use_url_params
   * @return string
   */
  private static function path_file_endpoint($extension, $use_url_params = false)
  {
    // Guarda caminho do diretório.
    $dir = 'endpoint/';

    // Obtém caminho do arquivo cache.
    $path_file = $dir . str_replace(['/', '.php', '.html'], ['-', '', ''], \controllers\FriendlyUrl::getParameters('path_endpoint'));

    // Parmâmetros (attr) da url do endpoint fazem parte do cache?
    if ($use_url_params) {
      $path_file .= '-' . implode('-', \controllers\FriendlyUrl::getParameters('attr'));
    }

    // Acrescenta a extensão txt no arquivo (pode ser um html, json, imagem, etc.).
    $path_file .= '.' . $extension;

    // Caso não seja um arquivo retorna false.
    return $path_file;
  }


  /**
   * path_file_cache
   * 
   * Retorna o nome do arquivo cache.
   *
   * @param  mixed $path_file
   * @return string
   */
  private static function path_file_cache($path_file, $flag = 'flag')
  {
    return str_replace(['.php', '.html'], ['', ''], $path_file) . '-' . $flag;
  }
}
