<?php

namespace controllers;

/**
 * Cache
 */
class Cache
{

  /**
   * get
   * 
   * Obtém o conteúdo do cache ou false.
   *
   * @param  mixed $hash
   * @param  mixed $domain
   * @param  mixed $time
   * @return string|bool
   */
  public static function get($domain, $hash, $time)
  {
    // Obtém o path do arquivo ou false.
    $pathFile = self::check($domain, $hash);

    // Verifica se cache está vencido e finaliza.
    if ((time() - filemtime($pathFile)) > $time) {
      return false;
    }

    // Verifica se existe o caminho.
    if (!$pathFile) {
      return false;
    }

    // Retorna conteúdo do cache.
    return file_get_contents($pathFile);
  }


  /**
   * set
   * 
   * Grava o conteúdo do cache ou false.
   *
   * @param  mixed $hash
   * @param  mixed $domain
   * @param  mixed $content
   * @return bool
   */
  public static function set($domain, $hash, $content)
  {
    // Obtém o path do arquivo ou false.
    $pathFile = self::pathHash($domain, $hash);

    // Grava conteúdo em TXT.
    return file_put_contents($pathFile, $content);
  }


  /**
   * check
   * 
   * Verifica se o cache existe e retorna o caminho completo ou false.
   *
   * @param  mixed $hash
   * @param  mixed $domain
   * @return string|bool
   */
  public static function check($domain, $hash)
  {
    // Guarda o nome e caminho do arquivo.
    $pathFile = self::pathHash($domain, $hash);

    // Verifica se o arquivo existe e retorna caminho.
    if (is_file($pathFile)) {
      return $pathFile;
    }

    return false;
  }

  /**
   * pathHash
   * 
   * Retorna o caminho completo para o arquivo de cache ou false.
   *
   * @param  mixed $hash
   * @param  mixed $domain
   * @return string|bool
   */
  private static function pathHash($domain, $hash)
  {
    // Monta o caminho base.
    $basePath = BASE_PATH_CACHE . $domain;

    // Caso não tenha a pasta, cria.
    if (!is_dir(BASE_PATH_CACHE . $domain)) {
      mkdir($basePath, 0777);
    }

    // Retorna o caminho completo do arquivo.
    return $basePath . '/' . str_replace(['/', '.php', '.html'], ['-', '', ''], $hash) . '.txt';
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
