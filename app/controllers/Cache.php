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
   * clear
   * 
   * Limpa todo o cache.
   *
   * @return void
   */
  public static function clear()
  {
    self::delTree(BASE_PATH_CACHE);
  }


  private static function delTree($dir)
  {
    if (is_dir($dir)) {
      $files = array_diff(scandir($dir), array('.', '..'));
      foreach ($files as $file) {
        (is_dir("$dir/$file")) ? self::delTree("$dir/$file") : unlink("$dir/$file");
      }
      return rmdir($dir);
    }
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
  private static function check($domain, $hash)
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
    self::creatDir($basePath);

    // Retorna o caminho completo do arquivo.
    return $basePath . '/' . str_replace(['/', '.php', '.html'], ['-', '', ''], $hash) . '.txt';
  }
  
  /**
   * creatDir
   * 
   * Cria as pastas do caminho informado, caso não exista a pasta.
   *
   * @param  mixed $basePath
   * @return void
   */
  private static function creatDir($basePath)
  {
    // Guarda caminho percorrido.
    $tmpPath = '';
    // Para cada pasta do caminho.
    foreach (explode('/', $basePath) as $dir) {
      // Verifica se é uma pasta.
      if (!is_dir($tmpPath . $dir)) {
        // Cria a pasta.
        mkdir($tmpPath . $dir, 0777);
      }
      // Guarda caminho percorrido.
      $tmpPath .= $dir . '/';
    }
  }
}
