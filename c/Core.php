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
   * ['url']      -> contém a Url do navegador.
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
   * Instância do controllerPage da página atual.
   *
   * @var ControllerPage
   */
  private $controllerPage;



  /**
   * Instância do controllerPage da página atual.
   *
   * @var ControllerApi
   */
  private $controllerApi;

















  /**
   * Executa o motor do aplicativo.
   *
   * @return void
   */
  public function start()
  {

    // Carrega todas as dependências iniciais do aplicativo.
    $this->openDependences();

    // Caso o usuário acesse a API. Senão procura as views.
    if ($_GET && $_GET['url'][0] == 'a' && $_GET['url'][1] == 'p' && $_GET['url'][2] == 'i') {

      // Trabalha a URL amigável e obtém a view e os parâmetros.
      $this->checkUrl('c/');

      echo "<br><hr>Oi?<br>";
      print_r(Self::$urlFinal);

      // Carrega controller da página atual e executa.
      $this->openControllerApi();
      $this->controllerApi->start();

    } else {

      // Trabalha a URL amigável e obtém a view e os parâmetros.
      $this->checkUrl('v/pages/');

      // Carrega controller da página atual e executa.
      $this->openControllerPage();
      $this->controllerPage->start();

    }

    // Desenha a página para usuário.
    //$this->renderPage();
  }




  /**
   * Carrega todas as dependências do aplicativo.
   *
   * @return void
   */
  private function openDependences()
  {

    require 'vendor/autoload.php';                  // Carrega todas as dependências do composer.
    require_once 'c/class/controllerPage.php';          // Carrega classe pai controllerPage

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
  private function checkUrl($pasta)
  {
    // Verifica se está na home
    if ($_GET) {

      $url = explode('/', $_GET['url']);
      // Busca a página e retorna os attr (atributos), path do arquivo, diretorio do arquivo e nome do arquivo.
      Self::$urlFinal = $this->verificaURL(count($url), $url, $pasta);
      // Restaura a url.
      Self::$urlFinal['url'] = $_GET['url'];
    } else {
      // Caso não passe nada por URL.
      Self::$urlFinal['attr'] = array(0 => null);
    }
  }




  /**
   * Carrega controllerPage da página atual.
   *
   * @return void
   */
  private function openControllerPage()
  {

    /**
     * Carrega controllerPage da página atual ou controllerPage default.
     */
    if (isset(Self::$urlFinal['file']) && isset(Self::$urlFinal['dir'])) {

      $controller_name = Self::$urlFinal['file'] . 'ControllerPage';    // controllerPage da página atual.
      $path = Self::$urlFinal['dir'];                               // Diretório página.
      $path[0] = 'c';                                               // Diretório controllerPage.
      $path .= $controller_name . '.php';                           // Caminho completo controllerPage.

    } else if (!isset(Self::$urlFinal['attr'])) {

      // Caso não tenha parâmetro, chama a view index.php
      Self::$urlFinal = array(
        'file'  => 'index',                                         // Define file index.
        'dir'   => 'v/pages',                                       // Define diretório da view index.
        'path'  => 'v/pages/index.php',                             // Define path da view index.
        'attr'  => array(0 => null)                                  // Define attr index.

      );

      $controller_name = 'IndexControllerPage';                         // Preenche com controllerPage default.
      $path = 'c/pages/indexControllerPage.php';                        // Preenche com path default.

    } else {

      // Caso tenha um parametro na url mas sem view.
      Self::$urlFinal['file'] = 'default';                          // Define file default.
      Self::$urlFinal['dir'] = 'v/pages';                           // Define diretório da view default.
      Self::$urlFinal['path'] = 'v/pages/default.php';              // Define path da view default.

      // Tira primeiro atributo, pois se refere a página.
      unset(Self::$urlFinal['attr'][0]);
      Self::$urlFinal['attr'] = array_values(Self::$urlFinal['attr']);
      if (!Self::$urlFinal['attr']) {
        Self::$urlFinal['attr'] = array(0 => null);
      }

      // controllerPage default
      $path = '';
    }


    // Verifica se existe controller.
    if (!file_exists($path)) {
      $controller_name = 'DefaultControllerPage';                     // Preenche com controller default.
      $path = 'c/pages/defaultControllerPage.php';                    // Preenche com path default.
    }

    // Carrega arquivo controllerPage da página autal.
    require_once $path;

    // Instancia a classe do controllerPage e salva nos parâmetros do Core.
    $refl = new ReflectionClass(ucfirst($controller_name));
    $this->controllerPage = $refl->newInstanceArgs();
  }




  /**
   * Carrega controllerPage da página atual.
   *
   * @return void
   */
  private function openControllerApi()
  {
    
    /**
     * Carrega controllerApi da página atual ou controllerApi default.
     */
    if (isset(Self::$urlFinal['file']) && isset(Self::$urlFinal['dir'])) {

      $controller_name = Self::$urlFinal['file'] . 'ControllerApi';    // controllerApi da página atual.
      $path = Self::$urlFinal['dir'];                               // Diretório página.
      //$path[0] = 'c';                                               // Diretório controllerApi.
      $path .= $controller_name . '.php';                           // Caminho completo controllerApi.

    } else if (!isset(Self::$urlFinal['attr'])) {

      // Caso não tenha parâmetro, chama a view index.php
      Self::$urlFinal = array(
        'file'  => 'index',                                         // Define file index.
        'dir'   => 'c/api',                                       // Define diretório da view index.
        'path'  => 'c/api/index.php',                             // Define path da view index.
        'attr'  => array(0 => null)                                  // Define attr index.

      );

      $controller_name = 'IndexControllerApi';                         // Preenche com controllerApi default.
      $path = 'c/api/indexControllerApi.php';                        // Preenche com path default.

    } else {

      // Caso tenha um parametro na url mas sem view.
      Self::$urlFinal['file'] = 'default';                          // Define file default.
      Self::$urlFinal['dir'] = 'c/api';                           // Define diretório da view default.
      Self::$urlFinal['path'] = 'c/api/default.php';              // Define path da view default.

      // Tira primeiro atributo, pois se refere a página.
      unset(Self::$urlFinal['attr'][0]);
      Self::$urlFinal['attr'] = array_values(Self::$urlFinal['attr']);
      if (!Self::$urlFinal['attr']) {
        Self::$urlFinal['attr'] = array(0 => null);
      }

      // controllerApi default
      $path = '';
    }


    // Verifica se existe controller.
    if (!file_exists($path)) {
      $controller_name = 'DefaultControllerPage';                     // Preenche com controller default.
      $path = 'c/pages/defaultControllerPage.php';                    // Preenche com path default.
    }

    // Carrega arquivo controllerPage da página autal.
    require_once $path;

    // Instancia a classe do controllerPage e salva nos parâmetros do Core.
    $refl = new ReflectionClass(ucfirst($controller_name));
    $this->controllerPage = $refl->newInstanceArgs();
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
    $template = $twig->load('templates/' . $this->controllerPage->getParamsTemplate('template') . '.html');

    $parametros = array();
    $parametros['nome'] = "Mateus";

    $conteudo = $template->render($parametros);
    echo $conteudo;
    echo $this->controllerPage->getParamsTemplate('template');
  }



  /**
   * Trabalha a URL atual e divide ela em página e parâmetros.
   * Parâmetros de 
   * ['url']      -> contém a Url do navegador.
   * ['dir']      -> Caminho do diretório atual acessado.
   * ['file']     -> Nome do arquivo da página atual acessada.
   * ['path']     -> Caminho do diretório = arquivo.
   * ['attr']     -> são os atributos após o file. var array.
   *
   * @param [int] $length
   * @param [string] $url
   * @return array
   */
  private function verificaURL($length, $url, $pasta)
  {
    // Grava url e atributos.
    $urlFinal['path'] = '';
    $urlFinal['file'] = '';
    $urlFinal['url'] = '';
    $urlFinal['attr'] = array();



    // Finaliza na primeira posição da url.
    if ($length > 0) {
      $urlFinal =  $this->verificaURL((int)$length - 1, $url, $pasta);
      $urlFinal['url'] .= $url[(int)$length - 1];

      // Espera proximo parâmetro.
      $proxima = true;

      // Verifica próximo parametro é uma página.
      if (count($url) != $length) {
        $dir = $pasta . $urlFinal['url'] . '/';
        $file = $url[$length];
        $path = $dir . $file . '.php';
        $proxima = !file_exists($path);
      }

      // Monta arquivo atual.
      $dir = $pasta;
      $file = $urlFinal['url'];
      $path = $dir . $file . '.php';

      // Verifica se página atual existe e se não existe outra no próximo parametro.
      if (file_exists($path) && $proxima) {
        $urlFinal['file'] = $file;     // Grava path da página.
        $urlFinal['url'] = '';         // Reinicia a gravação da url.
        $urlFinal['dir'] = $dir;
        $urlFinal['path'] = $path;
        $urlFinal['attr'] = array(0 => null);
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
