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

    // Arquivos virtuais. // * NÃO IMPLEMENTADO OS ARQUIVOS VIRTUAIS
    // Variável receberá a estrutura serialize do banco de dados.
    $estruturaVirtual = [
      'html' => '<div id="html"><div id="head"><title>Banco de dados</title>{% block head %}{% endblock %}</div><div id="body">{% block body %}{% endblock %}</div></div>',
      'head' => '{% block head %}<div value="teste">array head</div>{% endblock %}',
    ];
    $vurlv = new \Twig\Loader\ArrayLoader($estruturaVirtual);

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
    $loader = new \Twig\Loader\ChainLoader([$vurll, $vurlv, $html_base]);
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
      if(isset($params['status'])){
        http_response_code($params['status']);
      }else{
        http_response_code(200);
      }

      // Verifica se a saída é json.
      if ($params['render']['content_type'] == 'application/json') {
        // Acrescenta retorno padrão.
        $params['response']['ENV'] = BASE_ENV;
        $params['response']['DATE'] = date('Y-m-d H:i:s');
        $params['response']['IP'] = BASE_IP;
        // Converte a saída array para json com utf-8.
        return json_encode($params['response'], JSON_UNESCAPED_UNICODE);
      } else {
        // Caso a saída seja personalizada, é necessário enviar de acordo com a saída.
        return $params['response'];
      }
    } else {
      // Retorno de erro.
      return '{error:"true",msg:"Não foi definido valor de resposta. Preenche o $params[\'response\']"}';
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
    $cache = self::getCache('app/cache/obj/' . self::path_file_cache($obj_path, $flag), $cacheTime);

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
  public static function obj($obj_path, $params = null, $cacheTime = null, $flag = null)
  {
    // Retorno padrão.
    $result = false;

    // Tenta obter cache.
    $cache = self::getCache('app/cache/obj/' . self::path_file_cache($obj_path, $flag), $cacheTime);

    // Verifica se teve retorno cache.
    if ($cache) {
      // Retorna o cache.
      return $cache;
    }

    // Inicia o processamento do objeto.
    $result = self::twig('template/obj_render/', $obj_path, $params);

    // Salva resultado do processamento em cache.
    self::saveCache('app/cache/obj/' . self::path_file_cache($obj_path, $flag), $result, $cacheTime);

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
   * @param  mixed $flag // Nome do arquivo cache.
   * @return string
   */
  public static function htmlCache($cacheTime = null, $flag)
  {
    // Retorno padrão.
    $result = false;

    // Tenta obter cache.
    $cache = self::getCache('app/cache/obj/' . self::path_file_cache($flag), $cacheTime);

    // Verifica se teve retorno cache.
    if ($cache) {
      // Retorna o cache.
      return $cache;
    }

    return $result;
  }


  /**
   * html
   * 
   * Renderiza um texto html com os parâmetros personalizados.
   * É possível criar um cache para não precisar renderizar esse texto html.
   * É possível criar uma flag para tornar esse cache único.
   *
   * @param  mixed $html
   * @param  mixed $params
   * @param  mixed $cacheTime
   * @param  mixed $flag // Nome do arquivo cache.
   * @return string
   */
  public static function html($html, $params = null, $cacheTime = null, $flag)
  {
    // Retorno padrão.
    $result = false;

    // Tenta obter cache.
    $cache = self::getCache('app/cache/html/' . self::path_file_cache($flag), $cacheTime);

    // Verifica se teve retorno cache.
    if ($cache) {
      // Retorna o cache.
      return $cache;
    }

    // Inicia a construção do HTML
    $loader = new \Twig\Loader\ArrayLoader([
      'index' => $html,
    ]);
    $twig = new \Twig\Environment($loader);
    $twig->addExtension(new IntlExtension());

    // Inicia o processamento do objeto.
    $result = $twig->render('index', $params);

    // Salva resultado do processamento em cache.
    self::saveCache('app/cache/obj/' . self::path_file_cache($flag), $result, $cacheTime);

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
   * @param  mixed $path_file
   * @param  mixed $cacheTime
   * @param  mixed $flag
   * @return string
   */
  public static function getCache($path_file, $cacheTime = null)
  {
    // Verifica se o arquivo não existe e finaliza.
    if (!is_file($path_file)) {
      return false;
    }

    // Verifica se não é necessário obter cache.
    if (!$cacheTime) {
      return false;
    }

    // Verifica se cache está vencido e finaliza.
    if ((time() - filemtime($path_file)) > $cacheTime) {
      return false;
    }

    // Retorna conteúdo do cache.
    return file_get_contents($path_file);
  }


  /**
   * saveCache
   * 
   * Salva cache se possível.
   * É possível criar uma flag para tornar esse cache único.
   *
   * @param  mixed $path_file
   * @param  mixed $cacheTime Em segundos
   * @param  mixed $flag
   * @return bool
   */
  public static function saveCache($path_file, $content = null, $cacheTime = null)
  {
    // Verifica se não tem vencimento ou se não ten conteúdo a ser salvo e finaliza.
    if (!$cacheTime || !$content) {
      return false;
    }

    // Verifica se o arquivo não existe, Verifica se cache não está vencido e finaliza.
    if (is_file($path_file) && time() - filemtime($path_file) < $cacheTime) {
      return false;
    }

    // Retorna conteúdo do cache.
    return file_put_contents($path_file, $content);
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

      // Obtém tipo do retorno.
      $extension = explode('/', $paramsRender['content_type']);
      // Obtém o path do arquivo cache do endpoint.
      $path_file = self::path_file_endpoint(end($extension), $paramsRender['cacheParams']);

      // Verifica se é um arquivo.
      if (is_file($path_file)) {

        // Tempo corrido desde a última atualização do arquivo até hj em segundos.
        $update = time() - filectime($path_file);

        // Verifica se o chache está dentro do tempo.
        if ($update < $paramsRender['cacheTime']) {
          // Carrega o arquivo cache.
          $cache = file_get_contents($path_file);
        }
      }
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
    // Retorno padrão.
    $cache = false;

    // Verifica se o cache está ativo.
    if ($paramsRender['cache']) {

      // Obtém tipo do retorno.
      $extension = explode('/', $paramsRender['content_type']);
      // Obtém o path do arquivo cache do endpoint.
      $path_file = self::path_file_endpoint(end($extension), $paramsRender['cacheParams']);

      // Verifica se é um arquivo.
      if (is_file($path_file)) {
        // Tempo corrido desde a última atualização do arquivo até hj em segundos.
        $update = time() - filectime($path_file);
      } else {
        $update = $paramsRender['cacheTime'];
      }

      // Verifica se o chache está dentro do tempo.
      if ($update >= $paramsRender['cacheTime']) {
        // salva o arquivo cache.
        $cache = file_put_contents($path_file, $content);
      }
    }

    // Finaliza informando que não tem cache.
    return $cache;
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
    $dir = 'app/cache/endpoint/';

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
    return str_replace(['/', '.php', '.html'], ['-', '', ''], $path_file) . '-' . $flag . '.txt';
  }
}
