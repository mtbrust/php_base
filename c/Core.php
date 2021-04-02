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
   * Array com as posições da url atual.
   *
   * @var array
   */
  private static $url;



  /**
   * Informações de páginas que estão no diretório do projeto.
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
  private static $infoUrl;



  /**
   * Retorna $infoUrl
   *
   * @return array
   */
  public static function getinfoUrl()
  {
    return Self::$infoUrl;
  }



  /**
   * Informações de páginas que estão apenas no banco de dados.
   * ['url']      -> contém a Url do navegador.
   * ['dir']      -> Caminho do diretório atual acessado.
   * ['file']     -> Nome do arquivo da página atual acessada.
   * ['path']     -> Caminho do diretório = arquivo.
   * ['attr']     -> são os atributos após o file. var array.
   * 
   * 
   * As posições irão conter:
   * file         -> v/admin/posts.php
   * attr         -> [create, teste]
   *
   * @var [array]
   */
  private static $infoBdUrl;



  /**
   * Retorna $infoBdUrl
   *
   * @return array
   */
  public static function getinfoBdUrl()
  {
    return Self::$infoBdUrl;
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

    /**
     * Carrega todas as dependências iniciais do aplicativo.
     */
    $this->requireDependences();


    /**
     * Obtém o array da url atual.
     */
    Self::$url = $this->getUrl();
    //print_r(Self::$url);


    /**
     * Verifica se usuário solicitou uma api ou view.
     */
    if (Self::$url && Self::$url[0] == 'api') {
      echo '<br>Solicitação de API.';
    } else {

      /**
       * Obtém as informações das paginas no diretório atual em decorrência da url. 
       */
      Self::$infoUrl = $this->getInfoUrlPage(count(Self::$url), Self::$url);
      print_r(Self::$infoUrl);

      /**
       * Obtém as informações das páginas no banco de dados em decorrência da url. 
       */
      Self::$infoBdUrl = $this->getInfoUrlBdPages(count(Self::$url), Self::$url);
      //print_r(Self::$infoBdUrl);

      /**
       * Obtém o controller da página atual. Logo após executa.
       */
      $this->controllerPage = $this->getControllerPage();
      $this->controllerPage->start();


    }






    /*
    // Caso o usuário acesse a API. Senão procura as views.
    if ($_GET && $_GET['url'][0] == 'a' && $_GET['url'][1] == 'p' && $_GET['url'][2] == 'i') {

      // Trabalha a URL amigável e obtém a view e os parâmetros.
      $this->checkUrl('c/');

      echo "<br><hr>Oi?<br>";
      print_r(Self::$infoUrl);

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

    print_r(Self::$infoUrl);
    */

    // Desenha a página para usuário.
    $this->renderPage();
  }




  /**
   * Carrega todas as dependências do aplicativo.
   *
   * @return void
   */
  private function requireDependences()
  {
    require_once 'config.php';                      // Carrega constantes.
    require 'vendor/autoload.php';                  // Carrega todas as dependências do composer.
    require_once 'c/class/controllerPage.php';      // Carrega classe pai controllerPage.
    require_once 'c/class/controllerRender.php';    // Carrega classe pai controllerPage.

    // PENDÊNCIAS
    // Carregar classes e banco de dados...
    // Carregar segurança
    // Variáveis globais
    // Config
  }


  /**
   * Retorna array com a url atual ou false.
   *
   * @return array
   */
  private function getUrl()
  {
    if ($_GET) {
      return explode('/', $_GET['url']);
    }
    return array();
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
  private function getInfoUrlPage($length, $url)
  {
    // Inicia os atributos.
    $infoUrl['path'] = '';
    $infoUrl['dir'] = '';
    $infoUrl['file'] = '';
    $infoUrl['url'] = '';
    $infoUrl['attr'] = array();

    // Finaliza quando chegar na primeira posição da url.
    if ($length > 0) {
      // Processa da primeira posição para última.
      $infoUrl =  $this->getInfoUrlPage((int)$length - 1, $url);

      // Caso só tenha uma barra no final da url não precisa executar a verificação.
      if (!empty($url[(int)$length - 1])) {

        // Obtém url na posição recursiva atual.
        $infoUrl['url'] .= $url[(int)$length - 1];
        $parametro_atual = $url[(int)$length - 1];

        // Verifica se é um arquivo e salva na variável de controle.
        $isFile = file_exists(PATH_VIEW_PAGES . $infoUrl['dir'] . '/' . $parametro_atual . '.html');
        if ($isFile) {
          $infoUrl['file'] = $parametro_atual;
          $infoUrl['path'] = PATH_VIEW_PAGES . $infoUrl['dir'] . $infoUrl['file'];
        }

        // Verifica se é uma pasta e salva na variável de controle.
        $isDir = file_exists(PATH_VIEW_PAGES . $infoUrl['dir'] . '/' . $parametro_atual);
        if ($isDir) {
          $infoUrl['dir'] .= $parametro_atual . '/';
          if (!$isFile) {
            $infoUrl['path'] = PATH_VIEW_PAGES . $infoUrl['dir'];
          }
        }

        // Espera proximo parâmetro.
        $isDirProxima = false;
        $isFileProxima = false;

        // Verifica próximo parametro é uma página.html.
        if (!empty($url[$length])) {
          // Monta caminho do próximo parametro da url.
          $path = PATH_VIEW_PAGES . $infoUrl['dir'] . $url[$length];

          $isDirProxima = file_exists($path);
          $isFileProxima = file_exists($path . '.html');
        }

        if (($isFile || $isDir) && !$isFileProxima && !$isDirProxima) {
          $infoUrl['url'] = '';
        }

        // Verifica se existe página atual e se não existe arquivo ou pasta no próximo parametro.
        if (($isFile || $isDir) && !$isFileProxima && !$isDirProxima) {
          $infoUrl['attr'] = array(0 => null);
          return $infoUrl;
        }

        // Monta os parametros
        $infoUrl['attr'] = explode('/', $infoUrl['url']);
        $infoUrl['url'] .= '/';
        return  $infoUrl;
      }
    }

    $infoUrl['url'] = '';
    return $infoUrl;
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
  private function getInfoUrlBdPages($length, $url)
  {
    // Inicia os atributos.
    $infoUrl['path'] = '';
    $infoUrl['dir'] = '';
    $infoUrl['file'] = '';
    $infoUrl['url'] = '';
    $infoUrl['attr'] = array();

    // IMPLEMENTAR JUNTO AO BANCO DE DADOS.

  }




  /**
   * Carrega controllerPage da página atual.
   *
   * @return Controller
   */
  private function getControllerPage()
  {
    

    /**
     * Verifica se existe a view html.
     */
    if (!empty(Self::$infoUrl['file'])) {

      $controller_name = Self::$infoUrl['path'] . 'ControllerPage';   // controllerPage da página atual.
      $controller_name[0] = 'c';                                      // Diretório controllerPage.
      $path = $controller_name . '.php';

      /**
       * Verifica se existe pasta.
       */
    } elseif(!empty(Self::$infoUrl['dir'])){
    
      $controller_name = Self::$infoUrl['path'] . 'ControllerPage';   // controllerPage da página atual.
      $controller_name[0] = 'c';                                     // Diretório controllerPage.
      $path = $controller_name . '.php';

      /**
       * Verifica se não tem parâmetros
       */
    } else if (isset(Self::$infoUrl['attr'])) {

      

      // Atribui a view index.php
      Self::$infoUrl = array(
        'path'  => PATH_VIEW_PAGES . 'index.php',                   // Define path da view index.
        'dir'   => PATH_VIEW_PAGES,                                 // Define diretório da view index.
        'file'  => 'index',                                         // Define file index.
        'attr'  => array(0 => null)                                 // Define attr index.

      );

      // Atribui a view o controller index.
      $controller_name = 'IndexControllerPage';                     // Preenche com controllerPage default.
      $path = PATH_CONTROLLER_PAGES . 'indexControllerPage.php';    // Preenche com path default.


      /**
       * Caso tenha parametros mas sem view.
       */
    } else {
      

      // Caso tenha um parametro na url mas sem view.
      Self::$infoUrl['path'] = PATH_VIEW_PAGES . 'Default.php';     // Define path da view default.
      Self::$infoUrl['dir'] = PATH_VIEW_PAGES;                      // Define diretório da view default.
      Self::$infoUrl['file'] = 'default';                           // Define file default.

      // Tira primeiro atributo, pois se refere a página.
      unset(Self::$infoUrl['attr'][0]);
      Self::$infoUrl['attr'] = array_values(Self::$infoUrl['attr']);
      if (!Self::$infoUrl['attr']) {
        Self::$infoUrl['attr'] = array(0 => null);
      }

      // controllerPage default
      $path = '';
    }

    echo '<br>';
    print_r($controller_name);
    echo '<br>';
    print_r($path);
    echo '<br>';
    print_r(Self::$infoUrl);
    echo '<br>';

    // Verifica se existe controller.
    if (!file_exists($path)) {
      $controller_name = 'DefaultControllerPage';                     // Preenche com controller default.
      $path = PATH_CONTROLLER_PAGES . 'defaultControllerPage.php';                    // Preenche com path default.
    }

    // Carrega arquivo controllerPage da página autal.
    require_once $path;

    // Instancia a classe do controllerPage e salva nos parâmetros do Core.
    $refl = new ReflectionClass(ucfirst($controller_name));
    return $refl->newInstanceArgs();
  }





































  /**
   * Trabalha a URL amigável e parâmetros. Grava em Self::$infoUrl.
   *
   * @return void
   */
  private function checkUrl($pasta)
  {
    // Verifica se está na home
    if ($_GET) {

      $url = explode('/', $_GET['url']);
      // Busca a página e retorna os attr (atributos), path do arquivo, diretorio do arquivo e nome do arquivo.
      Self::$infoUrl = $this->verificaUrlPage(count($url), $url, $pasta);
      // Restaura a url.
      Self::$infoUrl['url'] = $_GET['url'];
    } else {
      // Caso não passe nada por URL.
      Self::$infoUrl['attr'] = array(0 => null);
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
    if (isset(Self::$infoUrl['file']) && isset(Self::$infoUrl['dir'])) {

      $controller_name = Self::$infoUrl['file'] . 'ControllerPage';    // controllerPage da página atual.
      $path = Self::$infoUrl['dir'];                               // Diretório página.
      $path[0] = 'c';                                               // Diretório controllerPage.
      $path .= $controller_name . '.php';                           // Caminho completo controllerPage.

    } else if (!isset(Self::$infoUrl['attr'])) {

      // Caso não tenha parâmetro, chama a view index.php
      Self::$infoUrl = array(
        'file'  => 'index',                                         // Define file index.
        'dir'   => 'v/pages',                                       // Define diretório da view index.
        'path'  => 'v/pages/index.php',                             // Define path da view index.
        'attr'  => array(0 => null)                                  // Define attr index.

      );

      $controller_name = 'IndexControllerPage';                         // Preenche com controllerPage default.
      $path = 'c/pages/indexControllerPage.php';                        // Preenche com path default.

    } else {

      // Caso tenha um parametro na url mas sem view.
      Self::$infoUrl['file'] = 'default';                          // Define file default.
      Self::$infoUrl['dir'] = 'v/pages';                           // Define diretório da view default.
      Self::$infoUrl['path'] = 'v/pages/default.php';              // Define path da view default.

      // Tira primeiro atributo, pois se refere a página.
      unset(Self::$infoUrl['attr'][0]);
      Self::$infoUrl['attr'] = array_values(Self::$infoUrl['attr']);
      if (!Self::$infoUrl['attr']) {
        Self::$infoUrl['attr'] = array(0 => null);
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
    if (isset(Self::$infoUrl['file']) && isset(Self::$infoUrl['dir'])) {

      $controller_name = Self::$infoUrl['file'] . 'ControllerApi';    // controllerApi da página atual.
      $path = Self::$infoUrl['dir'];                               // Diretório página.
      //$path[0] = 'c';                                               // Diretório controllerApi.
      $path .= $controller_name . '.php';                           // Caminho completo controllerApi.

    } else if (!isset(Self::$infoUrl['attr'])) {

      // Caso não tenha parâmetro, chama a view index.php
      Self::$infoUrl = array(
        'file'  => 'index',                                         // Define file index.
        'dir'   => 'c/api',                                       // Define diretório da view index.
        'path'  => 'c/api/index.php',                             // Define path da view index.
        'attr'  => array(0 => null)                                  // Define attr index.

      );

      $controller_name = 'IndexControllerApi';                         // Preenche com controllerApi default.
      $path = 'c/api/indexControllerApi.php';                        // Preenche com path default.

    } else {

      // Caso tenha um parametro na url mas sem view.
      Self::$infoUrl['file'] = 'default';                          // Define file default.
      Self::$infoUrl['dir'] = 'c/api';                           // Define diretório da view default.
      Self::$infoUrl['path'] = 'c/api/default.php';              // Define path da view default.

      // Tira primeiro atributo, pois se refere a página.
      unset(Self::$infoUrl['attr'][0]);
      Self::$infoUrl['attr'] = array_values(Self::$infoUrl['attr']);
      if (!Self::$infoUrl['attr']) {
        Self::$infoUrl['attr'] = array(0 => null);
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
    $template = $twig->load('templates/default.html');

    $parametros = array();
    $parametros['nome'] = "Mateus";

    $conteudo = $template->render($parametros);
    echo $conteudo;
    //echo $this->controllerPage->getParamsTemplate('template');
    echo '<hr>';




    // Arquivos físicos.
    $vurlf = new \Twig\Loader\ArrayLoader([
      'base.html' => 'Físico  {% block content %}{% endblock %}',
    ]);

    // Arquivos virtuais
    $vurlv = new \Twig\Loader\ArrayLoader([
      'base.html' => 'Virtual {% block content %}{% endblock %}',
    ]);

    // Base html
    $html_base = new \Twig\Loader\ArrayLoader([
      'index.html' => '{% extends "base.html" %}{% block content %}oi: {{ name }}{% endblock %}',
      'base.html'  => 'Default',
    ]);

    // Sequência de prioridade. Arquivos físicos depois Virtuais.
    $loader = new \Twig\Loader\ChainLoader([$vurlf, $vurlv, $html_base]);
    $twig = new \Twig\Environment($loader);
    echo $twig->render('index.html', ['name' => 'Fabien']);
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
  private function verificaUrlPage($length, $url, $pasta)
  {
    // Grava url e atributos.
    $infoUrl['path'] = '';
    $infoUrl['dir'] = '';
    $infoUrl['file'] = '';
    $infoUrl['url'] = '';
    $infoUrl['attr'] = array();



    // Finaliza na primeira posição da url.
    if ($length > 0) {
      $infoUrl =  $this->verificaUrlPage((int)$length - 1, $url, $pasta);
      $infoUrl['url'] .= $url[(int)$length - 1];

      // Espera proximo parâmetro.
      $proxima = true;

      // Verifica próximo parametro é uma página.
      if (count($url) != $length) {
        $dir = $pasta . $infoUrl['url'] . '/';
        $file = $url[$length];
        $path = $dir . $file . '.php';
        $proxima = !file_exists($path);
      }

      // Monta arquivo atual.
      $dir = $pasta;
      $file = $infoUrl['url'];
      $path = $dir . $file . '.php';

      // Verifica se página atual existe e se não existe outra no próximo parametro.
      if (file_exists($path) && $proxima) {
        $infoUrl['file'] = $file;     // Grava path da página.
        $infoUrl['url'] = '';         // Reinicia a gravação da url.
        $infoUrl['dir'] = $dir;
        $infoUrl['path'] = $path;
        $infoUrl['attr'] = array(0 => null);
        return $infoUrl;
      }

      // Monta os parametros
      $infoUrl['attr'] = explode('/', $infoUrl['url']);
      $infoUrl['url'] .= '/';
      return  $infoUrl;
    }

    $infoUrl['url'] = '';
    return $infoUrl;
  }
}
