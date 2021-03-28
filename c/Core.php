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
  private static $url_final;


  /**
   * Retorna $url_final
   *
   * @return array
   */
  public static function getUrlFinal()
  {
    return Self::$url_final;
  }


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

    // Carrega dependências específicas para página atual.
    $this->openDependencesPage();

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
   * Trabalha a URL amigável e parâmetros. Grava em Self::$url_final.
   *
   * @return void
   */
  private function checkUrl()
  {
    // Verifica se está na home
    if ($_GET) {

      $url = explode('/', $_GET['url']);
      // Busca a página e retorna os attr (atributos)
      Self::$url_final = $this->openFile(count($url), $url);

      // Tirar esta parte??????
      if (Self::$url_final['path']) {
        require_once Self::$url_final['path'];
      } else {
        require_once 'v/pages/404.php';
      }
    } else
      require_once 'v/pages/default.php';
  }




  /**
   * Carrega dependências específicas para página atual.
   *
   * @return void
   */
  private function openDependencesPage()
  {

    /**
     * Carrega controller da página atual ou controller default.
     */
    if (isset(Self::$url_final['file']) && isset(Self::$url_final['dir'])) {
      $controller_name = Self::$url_final['file'] . 'Controller';   // Controller da página atual.
      $path = Self::$url_final['dir'];                              // Diretório página.
      $path[0] = 'c';                                               // Diretório controller.
      $path .= $path . $controller_name . '.php';                   // Caminho completo controller.
      if (file_exists($path))
        require_once $path;                                         // Carrega controller se existir.
      else
        require_once 'c/pages/defaultController.php';               // Carrega controller default.

      // Instancia classe do controller
      $refl = new ReflectionClass($controller_name);
      $controller = $refl->newInstanceArgs();

      if ($_POST) {
        call_user_func(array($controller, '_post'));
      }

      $attr = Self::$url_final['attr'];
      if ($attr) {
        switch ($attr[0]) {
          case 'post':
            call_user_func(array($controller, 'post'));
            break;
          case 'put':
            call_user_func(array($controller, 'put'));
            break;
          case 'get':
            call_user_func(array($controller, 'get'));
            break;
          case 'delete':
            call_user_func(array($controller, 'delete'));
            break;
          default:
            call_user_func(array($controller, 'index'));
            break;
        }
      } else
        call_user_func(array($controller, 'index'));
    } else {
      require_once 'c/pages/defaultController.php';                 // Carrega controller default.
    }
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
    $url_final['path'] = '';
    $url_final['file'] = '';
    $url_final['url'] = '';
    $url_final['attr'] = array();

    // Finaliza na primeira posição da url.
    if ($length > 0) {
      $url_final =  $this->openFile((int)$length - 1, $url);
      $url_final['url'] .= $url[(int)$length - 1];

      // Espera proximo parâmetro.
      $proxima = true;

      // Verifica próximo parametro é uma página.
      if (count($url) != $length) {
        $dir = 'v/pages/' . $url_final['url'] . '/';
        $file = $url[$length];
        $path = $dir . $file . '.php';
        $proxima = !file_exists($path);
      }

      // Monta arquivo atual.
      $dir = 'v/pages/';
      $file = $url_final['url'];
      $path = $dir . $file . '.php';

      // Verifica se página atual existe e se não existe outra no próximo parametro.
      if (file_exists($path) && $proxima) {
        $url_final['file'] = $file;     // Grava path da página.
        $url_final['url'] = '';         // Reinicia a gravação da url.
        $url_final['dir'] = $dir;
        $url_final['path'] = $path;
        $url_final['attr'] = array();
        return $url_final;
      }

      // Monta os parametros
      $url_final['attr'] = explode('/', $url_final['url']);
      $url_final['url'] .= '/';
      return  $url_final;
    }

    $url_final['url'] = '';
    return $url_final;
  } // Fim function opemFile();






}
