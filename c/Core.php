<?php

/**
 * Motor do aplicativo
 * @author Mateus Brust <mtbrust@gmail.com>
 * 
 * Carrega as dependências.
 * Trabalha a url atual.
 * Guarda o arquivo atual e os parametros.
 * Constrói a página.
 */
class Core
{

  /**
   * Informações de 
   * ['url']      -> contém a Url de controle recursivo. (ignorar)
   * ['dir']      -> Caminho do diretório atual acessado.
   * ['file']     -> Nome do arquivo da página atual acessada.
   * ['path']     -> Caminho do diretório = arquivo.
   * ['attr']     -> são os atributos após o file. var array.
   * 
   * Exemplo: 
   * $_GET        -> "site.com/admin/posts/create/teste"
   * Diretório    -> "/v/admin/posts.php"
   * 
   * As posições irão conter:
   * file         -> v/admin/posts.php
   * attr         -> [create, teste]
   *
   * @var [array]
   */
  private static $urlFinal;


  /**
   * Retorna $urlFinal
   *
   * @return array
   */
  public static function getUrlFinal()
  {
    return Self::$urlFinal;
  }



  /**
   * Instância do controller da página atual.
   *
   * @var Controller
   */
  private $controller;

















  /**
   * Executa o motor do aplicativo.
   *
   * @return void
   */
  public function start()
  {

    // Carrega todas as dependências iniciais do aplicativo.
    $this->openDependences();

    // Trabalha a URL amigável e obtém a view e os parâmetros.
    $this->checkUrl();

    // Carrega controller da página atual.
    $this->openControllerPage();

    // Executa controle da página atual.
    $this->controller->start();

    // Desenha a página para usuário.
    $this->renderPage();
  }




  /**
   * Carrega todas as dependências do aplicativo.
   *
   * @return void
   */
  private function openDependences()
  {

    require 'vendor/autoload.php';                  // Carrega todas as dependências do composer.
    require_once 'c/class/Controller.php';          // Carrega classe pai controller

    // PENDÊNCIAS
    // Carregar classes e banco de dados...
    // Carregar segurança
    // Variáveis globais
    // Config
  }



  /**
   * Trabalha a URL amigável e parâmetros. Grava em Self::$urlFinal.
   *
   * @return void
   */
  private function checkUrl()
  {
    // Verifica se está na home
    if ($_GET) {

      $url = explode('/', $_GET['url']);
      // Busca a página e retorna os attr (atributos)
      Self::$urlFinal = $this->openFile(count($url), $url);

    }
  }




  /**
   * Carrega controller página atual.
   *
   * @return void
   */
  private function openControllerPage()
  {

    /**
     * Carrega controller da página atual ou controller default.
     */
    if (isset(Self::$urlFinal['file']) && isset(Self::$urlFinal['dir'])) {
      $controller_name = Self::$urlFinal['file'] . 'Controller';    // Controller da página atual.
      $path = Self::$urlFinal['dir'];                               // Diretório página.
      $path[0] = 'c';                                               // Diretório controller.
      $path .= $controller_name . '.php';                           // Caminho completo controller.

    } else if (!isset(Self::$urlFinal['attr'])) {
      // Caso não tenha parâmetro, chama a view index.php
      Self::$urlFinal = array(
        'file'  => 'index',                                         // Define file index.
        'dir'   => 'v/pages',                                       // Define diretório da view index.
        'path'  => 'v/pages/index.php',                             // Define path da view index.
        'attr'  => array( 0 => null)                                  // Define attr index.
      );
      $controller_name = 'IndexController';                         // Preenche com controller default.
      $path = 'c/pages/indexController.php';                        // Preenche com path default.

    } else {
      // Caso tenha um parametro na url mas sem view.

      Self::$urlFinal['file'] = 'default';                          // Define file default.
      Self::$urlFinal['dir'] = 'v/pages';                           // Define diretório da view default.
      Self::$urlFinal['path'] = 'v/pages/default.php';              // Define path da view default.

      // Tira primeiro atributo, pois se refere a página.
      unset(Self::$urlFinal['attr'][0]);
      Self::$urlFinal['attr'] = array_values(Self::$urlFinal['attr']);
      if (!Self::$urlFinal['attr']) {
        Self::$urlFinal['attr'] = array( 0 => null);
      }

      // Controller default
      $path = '';
    }

    // Verifica se existe controller.
    if (!file_exists($path)) {
      $controller_name = 'DefaultController';                     // Preenche com controller default.
      $path = 'c/pages/defaultController.php';                    // Preenche com path default.
    }

    // Carrega controller.
    require_once $path;

    // Instancia classe do controller
    $refl = new ReflectionClass(ucfirst($controller_name));
    $this->controller = $refl->newInstanceArgs();
  }




  /**
   * Desenha a página para usuário.
   *
   * @return void
   */
  private function renderPage()
  {

    // Prepara o twig
    $loader = new \Twig\Loader\FilesystemLoader('v/');
    $twig = new \Twig\Environment($loader);
    $template = $twig->load('templates/default.html');

    $parametros = array();
    $parametros['nome'] = "Mateus";

    $conteudo = $template->render($parametros);
    echo $conteudo;
  }



  /**
   * Trabalha a URL atual e divide ela em página e parâmetros.
   *
   * @param [int] $length
   * @param [string] $url
   * @return array
   */
  private function openFile($length, $url)
  {
    // Grava url e atributos.
    $urlFinal['path'] = '';
    $urlFinal['file'] = '';
    $urlFinal['url'] = '';
    $urlFinal['attr'] = array();

    // Finaliza na primeira posição da url.
    if ($length > 0) {
      $urlFinal =  $this->openFile((int)$length - 1, $url);
      $urlFinal['url'] .= $url[(int)$length - 1];

      // Espera proximo parâmetro.
      $proxima = true;

      // Verifica próximo parametro é uma página.
      if (count($url) != $length) {
        $dir = 'v/pages/' . $urlFinal['url'] . '/';
        $file = $url[$length];
        $path = $dir . $file . '.php';
        $proxima = !file_exists($path);
      }

      // Monta arquivo atual.
      $dir = 'v/pages/';
      $file = $urlFinal['url'];
      $path = $dir . $file . '.php';

      // Verifica se página atual existe e se não existe outra no próximo parametro.
      if (file_exists($path) && $proxima) {
        $urlFinal['file'] = $file;     // Grava path da página.
        $urlFinal['url'] = '';         // Reinicia a gravação da url.
        $urlFinal['dir'] = $dir;
        $urlFinal['path'] = $path;
        $urlFinal['attr'] = array( 0 => null);
        return $urlFinal;
      }

      // Monta os parametros
      $urlFinal['attr'] = explode('/', $urlFinal['url']);
      $urlFinal['url'] .= '/';
      return  $urlFinal;
    }

    $urlFinal['url'] = '';
    return $urlFinal;
  } // Fim function opemFile();






}
