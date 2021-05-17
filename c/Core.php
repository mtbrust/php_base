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
   * Informações de páginas que estão no DIRETÓRIO do projeto.
   * ['path_dir']           -> Caminho relativo do diretório a partir da view.
   * ['path_view']          -> Caminho relativo do arquivo html a partir da view.
   * ['dir']                -> Nome do diretório.
   * ['file']               -> Nome do arquivo.
   * ['file_name']          -> Nome do arquivo com extensão (file.html).
   * ['controller_name']    -> Nome da classe controller.
   * ['controller_path']    -> Caminho relativo da classe controller php.
   * ['url']                -> Url completa.
   * ['attr']               -> Após a url do arquivo ou pasta, o resto do caminho da url vira um array de atributos.
   * 
   * Exemplo: 
   * $_GET        -> "site.com/admin/posts/create/teste"
   * Diretório    -> "/v/pages/admin/posts.php"
   * 
   * As posições irão conter:
   * file         -> v/pages/admin/posts.php
   * attr         -> [create, teste]
   *
   * @var [array]
   */
  private static $infoDirUrl = false;
  public static function getInfoDirUrl($param = null)
  {
    if ($param)
      return Self::$infoDirUrl[$param];
    return Self::$infoDirUrl;
  }



  /**
   * Informações de páginas que estão no BANCO DE DADOS do projeto.
   * ['path_dir']           -> Caminho relativo do diretório a partir da view.
   * ['path_view']          -> Caminho relativo do arquivo html a partir da view.
   * ['dir']                -> Nome do diretório.
   * ['file']               -> Nome do arquivo.
   * ['file_name']          -> Nome do arquivo com extensão (file.html).
   * ['controller_name']    -> Nome da classe controller.
   * ['controller_path']    -> Caminho relativo da classe controller php.
   * ['url']                -> Url completa.
   * ['attr']               -> Após a url do arquivo ou pasta, o resto do caminho da url vira um array de atributos.
   * 
   * Exemplo: 
   * $_GET        -> "site.com/admin/posts/create/teste"
   * Diretório    -> "/v/pages/admin/posts.php"
   * 
   * As posições irão conter:
   * file         -> v/pages/admin/posts.php
   * attr         -> [create, teste]
   *
   * @var [array]
   */
  private static $infoBdUrl = false;
  public function getInfoBdUrl($param = false)
  {
    if ($param)
      return $this->infoBdUrl[$param];
    return $this->infoBdUrl;
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
     * Inicia a segurança da página.
     */
    ControllerSecurity::start();


    /**
     * Inicia banco de dados
     * Cria conexão.
     */
    Bd::start();


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
       * Obtém as informações das paginas no DIRETÓRIO em decorrência da url. 
       * Caso VIEWS_DIR esteja ativado no arquivo config.php
       */
      if (VIEWS_DIR)
        Self::$infoDirUrl = $this->scanInfoDirUrl(Self::$url);
      //print_r(Self::$infoDirUrl);
      


      /**
       * Obtém as informações das paginas no BANCO DE DADOS em decorrência da url.
       * Caso VIEWS_BD esteja ativado no arquivo config.php
       */
      if (VIEWS_BD)
        Self::$infoBdUrl = $this->scanInfoBdUrl(Self::$url);
      
      /**
       * Obtém o controller da página atual. Logo após executa.
       */
      $this->controllerPage = $this->getControllerPage();
      $this->controllerPage->start();
    }


    /**
     * Finaliza conexão com banco de dados
     * Fecha conexão.
     */
    Bd::close();
  }




  /**
   * Carrega todas as dependências do aplicativo.
   *
   * @return void
   */
  private function requireDependences()
  {

    require_once 'config.php';                            // Carrega constantes.
    require 'vendor/autoload.php';                        // Carrega todas as dependências do composer.

    require_once 'm/bd/Bd.php';                           // Carrega classe pai banco de dados.
    require_once 'm/bd/pages/BdPagesSelect.php';          // Verificar se tem página no banco de dados. // Não implementado.
    require_once 'm/bd/login/BdLogin.php';                // Controle tabela Midia.
    require_once 'm/bd/midia/BdMidia.php';                // Controle tabela Midia.
    require_once 'm/bd/users/BdUsers.php';                // Controle tabela Users.
    require_once 'm/bd/permissions/BdPermissions.php';    // Controle tabela Users.
    require_once 'm/bd/pages/BdPages.php';                // Controle tabela Users.

    require_once PATH_CONTROLLER_CLASS . 'ControllerApi.php';       // Carrega classe pai controllerApi.
    require_once PATH_CONTROLLER_CLASS . 'ControllerPage.php';      // Carrega classe pai controllerPage.
    require_once PATH_CONTROLLER_CLASS . 'ControllerRender.php';    // Carrega classe pai controllerRender.
    require_once PATH_CONTROLLER_CLASS . 'ControllerSecurity.php';  // Carrega classe pai controllerSecurity.
    
    // PENDÊNCIAS
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
   * Obtém as informações das paginas no DIRETÓRIO em decorrência da url.
   * ['path_dir']           -> Caminho relativo do diretório a partir da view.
   * ['path_view']          -> Caminho relativo do arquivo html a partir da view.
   * ['dir']                -> Nome do diretório.
   * ['file']               -> Nome do arquivo.
   * ['file_name']          -> Nome do arquivo com extensão (file.html).
   * ['controller_name']    -> Nome da classe controller.
   * ['controller_path']    -> Caminho relativo da classe controller php.
   * ['url']                -> Url completa.
   * ['attr']               -> Após a url do arquivo ou pasta, o resto do caminho da url vira um array de atributos.
   *
   * @param array $url
   * @return array
   */
  private function scanInfoDirUrl($url)
  {
    // Caso seja o domínio raíz chama a index. 
    if (empty($url)) {
      $infoDirUrl['path_dir'] = '';
      $infoDirUrl['path_view'] = 'index.html';
      $infoDirUrl['dir']  = '';
      $infoDirUrl['file'] = 'index';
      $infoDirUrl['file_name'] = 'index.html';
      $infoDirUrl['controller_name'] = 'IndexControllerPage';
      $infoDirUrl['controller_path'] = 'IndexControllerPage.php';
      $infoDirUrl['url']  = '';
      $infoDirUrl['attr'] = array();
    } else {
      // Inicia os atributos da infoUrl zerados.
      $infoDirUrl['path_dir'] = '';
      $infoDirUrl['path_view'] = 'default.html';
      $infoDirUrl['dir']  = '';
      $infoDirUrl['file'] = '';
      $infoDirUrl['file_name'] = '';
      $infoDirUrl['controller_name'] = '';
      $infoDirUrl['controller_path'] = '';
      $infoDirUrl['url']  = '';
      $infoDirUrl['attr'] = array();

      // Inicia variáveis de controle.
      $p_url = '';
      $p_dir_ant = '';
    }

    // Percorre cada posição da url em busca de uma página.
    foreach ($url as $key => $value) {

      // Verifica final da url / e finaliza (site.com/url/).
      if (!empty($value)) {


        // Variáveis de Diretório
        $p_dir      = $value . '/';                                // Nome da pasta com / no final.
        $p_path_dir = $infoDirUrl['url'] . $p_dir;                 // Caminho completo da pasta.
        $isDir      = file_exists(PATH_VIEW_PAGES . $p_path_dir);  // Verifica se é uma pasta.

        // Variáveis de Arquivo
        $p_file_view = $value . '.html';                             // Nome do arquivo com extensão.
        $p_path_view = $infoDirUrl['path_dir'] . $p_file_view;       // Caminho completo do arquivo.
        $isFile      = file_exists(PATH_VIEW_PAGES . $p_path_view);  // Verifica se é um arquivo.

        // echo '<br>' . $p_path_view;
        // echo '<br>' . $isFile;

        // Variáveis de Arquivo Index
        $p_file_view_index = 'index.html';                                       // Nome do arquivo com extensão.
        $p_path_view_index = $p_path_dir . $p_file_view_index;                   // Caminho completo do arquivo.
        $isFileIndexindex  = file_exists(PATH_VIEW_PAGES . $p_path_view_index);  // Verifica se é um arquivo.

        // Variáveis de Controle
        $p_url .= $value . '/';                                                   // Concatena caminho atual com anterior. (attr)
        $p_dir_ant .= $infoDirUrl['url'];                                              // Salva a pasta anterior.
        $infoDirUrl['url'] .= $p_dir;                                                  // Concatena caminho atual com anterior. (url)

        // Caso seja um diretório
        if ($isDir) {
          $infoDirUrl['path_dir'] .= $p_dir;                                           // Caminho completo do diretório com / no final.
          $infoDirUrl['dir']  = $value;                                                // Nome do diretório.
        }

        // Caso seja um arquivo
        if ($isFile) {
          $infoDirUrl['file']      = $value;        // Nome do arquivo html.
          $infoDirUrl['file_name'] = $p_file_view;  // Nome do arquivo html com extensão.
          $infoDirUrl['path_view'] = $p_path_view;  // Caminho completo do arquivo html.
        } else if ($isFileIndexindex && $isDir) {
          $infoDirUrl['file']      = 'index';             // Nome do arquivo html.
          $infoDirUrl['file_name'] = 'index.html';        // Nome do arquivo html com extensão.
          $infoDirUrl['path_view'] = $p_path_view_index;  // Caminho completo do arquivo html.
        }

        // Caso tenha arquivo ou diretório na view.
        if ($isFile || $isDir || $isFileIndexindex) {
          $infoDirUrl['controller_name'] = ucfirst($value) . 'ControllerPage';                   // Cria nome da controller.
          $infoDirUrl['controller_path'] = $p_dir_ant . ucfirst($value) . 'ControllerPage.php';  // Cria endereço do arquivo controller.
          $p_url = '';                                                   // Zera sequencia da url para gerar attr.
        } else {
          $infoDirUrl['attr'] = explode('/', $p_url);     // Cria vetor com os parametros após página.
          unset($infoDirUrl['attr'][$key]);         // Tira último parâmetro (vazio).
        }
      }
    }
    return $infoDirUrl;                                                              // Retorna array com as informações da url.
  }





  /**
   * Obtém as informações das paginas no BANCO DE DADOS em decorrência da url.
   * ['path_dir']           -> Caminho relativo do diretório a partir da view.
   * ['path_view']          -> Caminho relativo do arquivo html a partir da view.
   * ['dir']                -> Nome do diretório.
   * ['file']               -> Nome do arquivo.
   * ['file_name']          -> Nome do arquivo com extensão (file.html).
   * ['controller_name']    -> Nome da classe controller.
   * ['controller_path']    -> Caminho relativo da classe controller php.
   * ['url']                -> Url completa.
   * ['attr']               -> Após a url do arquivo ou pasta, o resto do caminho da url vira um array de atributos.
   *
   * @param array $url
   * @return array
   */
  private function scanInfoBdUrl($url)
  {
    // Caso seja o domínio raíz chama a index. 
    if (empty($url)) {
      $infoDirUrl['path_dir'] = '';
      $infoDirUrl['path_view'] = 'index.html';
      $infoDirUrl['dir']  = '';
      $infoDirUrl['file'] = 'index';
      $infoDirUrl['file_name'] = 'index.html';
      $infoDirUrl['controller_name'] = 'IndexControllerPage';
      $infoDirUrl['controller_path'] = 'IndexControllerPage';
      $infoDirUrl['url']  = '';
      $infoDirUrl['attr'] = array();
    } else {
      // Inicia os atributos da infoUrl zerados.
      $infoDirUrl['path_dir'] = '';
      $infoDirUrl['path_view'] = '';
      $infoDirUrl['dir']  = '';
      $infoDirUrl['file'] = '';
      $infoDirUrl['file_name'] = '';
      $infoDirUrl['controller_name'] = '';
      $infoDirUrl['controller_path'] = '';
      $infoDirUrl['url']  = '';
      $infoDirUrl['attr'] = array();

      // Inicia variáveis de controle.
      $p_url = '';
      $p_dir_ant = '';
    }

    // Percorre cada posição da url em busca de uma página.
    foreach ($url as $key => $value) {

      // Verifica final da url / e finaliza (site.com/url/).
      if (empty($value)) {
        break;
      }

      // Variáveis de Diretório
      $p_dir = $value . '/';                                                      // Nome da pasta com / no final.
      $p_path_dir = $infoDirUrl['url'] . $p_dir;                                     // Caminho completo da pasta.
      $isDir = file_exists(PATH_VIEW_PAGES . $p_path_dir);                        // Verifica se é uma pasta.

      // Variáveis de Arquivo
      $p_file_view = $value;                                            // Nome do arquivo com extensão.
      $p_path_view = $infoDirUrl['path_dir'] . $p_file_view;                         // Caminho completo do arquivo.
      $isFile = file_exists(PATH_VIEW_PAGES . $p_path_view);                      // Verifica se é um arquivo.
      //echo '<br>'.$p_path_view .'<br>';
      $page_id = BdPagesSelect::selectIdPage($p_path_view);

      // Variáveis de Controle
      $p_url .= $value . '/';                                                     // Concatena caminho atual com anterior. (attr)
      $p_dir_ant .= $infoDirUrl['url'];                                              // Salva a pasta anterior.
      $infoDirUrl['url'] .= $p_dir;                                                  // Concatena caminho atual com anterior. (url)

      // Caso seja um diretório
      if ($isDir) {
        $infoDirUrl['path_dir'] .= $p_dir;                                           // Caminho completo do diretório com / no final.
        $infoDirUrl['dir']  = $value;                                                // Nome do diretório.
      }

      // Caso seja um arquivo
      if ($isFile) {
        $infoDirUrl['file'] = $value;                                                // Nome do arquivo html.
        $infoDirUrl['file_name'] = $p_file_view;                                     // Nome do arquivo html com extensão.
        $infoDirUrl['path_view'] = $p_path_view;                                     // Caminho completo do arquivo html.
      }

      // Caso tenha arquivo ou diretório na view.
      if ($isFile || $isDir) {
        $infoDirUrl['controller_name'] = ucfirst($value) . 'ControllerPage';         // Cria nome da controller.
        $infoDirUrl['controller_path'] = $p_dir_ant . ucfirst($value) . 'ControllerPage.php'; // Cria endereço do arquivo controller.
        $p_url = '';                                                              // Zera sequencia da url para gerar attr.
      } else {
        $infoDirUrl['attr'] = explode('/', $p_url);                                  // Cria vetor com os parametros após página.
        unset($infoDirUrl['attr'][$key - 1]);                                        // Tira último parâmetro (vazio).
      }
    }

    
    return $infoDirUrl;                                                              // Retorna array com as informações da url.
  }





  /**
   * Obtém as informações das paginas no BANCO DE DADOS em decorrência da url.
   * ['path_dir']           -> Caminho relativo do diretório a partir da view.
   * ['path_view']          -> Caminho relativo do arquivo html a partir da view.
   * ['dir']                -> Nome do diretório.
   * ['file']               -> Nome do arquivo.
   * ['file_name']          -> Nome do arquivo com extensão (file.html).
   * ['controller_name']    -> Nome da classe controller.
   * ['controller_path']    -> Caminho relativo da classe controller php.
   * ['url']                -> Url completa.
   * ['attr']               -> Após a url do arquivo ou pasta, o resto do caminho da url vira um array de atributos.
   *
   * @param array $url
   * @return array
   */
  private function scanInfoApi($url)
  {
    // Caso seja o domínio raíz chama a index. 
    if (empty($url)) {
      $infoDirUrl['path_dir'] = '';
      $infoDirUrl['path_view'] = 'index.html';
      $infoDirUrl['dir']  = '';
      $infoDirUrl['file'] = 'index';
      $infoDirUrl['file_name'] = 'index.html';
      $infoDirUrl['controller_name'] = 'IndexControllerApi';
      $infoDirUrl['controller_path'] = 'IndexControllerApi';
      $infoDirUrl['url']  = '';
      $infoDirUrl['attr'] = array();
    } else {
      // Inicia os atributos da infoUrl zerados.
      $infoDirUrl['path_dir'] = '';
      $infoDirUrl['path_view'] = '';
      $infoDirUrl['dir']  = '';
      $infoDirUrl['file'] = '';
      $infoDirUrl['file_name'] = '';
      $infoDirUrl['controller_name'] = '';
      $infoDirUrl['controller_path'] = '';
      $infoDirUrl['url']  = '';
      $infoDirUrl['attr'] = array();

      // Inicia variáveis de controle.
      $p_url = '';
      $p_dir_ant = '';
    }

    // Percorre cada posição da url em busca de uma página.
    foreach ($url as $key => $value) {

      // Verifica final da url / e finaliza (site.com/url/).
      if (empty($value)) {
        break;
      }

      // Variáveis de Diretório
      $p_dir = $value . '/';                                                      // Nome da pasta com / no final.
      $p_path_dir = $infoDirUrl['url'] . $p_dir;                                     // Caminho completo da pasta.
      $isDir = file_exists(PATH_VIEW_PAGES . $p_path_dir);                        // Verifica se é uma pasta.

      // Variáveis de Arquivo
      $p_file_view = $value . '.html';                                            // Nome do arquivo com extensão.
      $p_path_view = $infoDirUrl['path_dir'] . $p_file_view;                         // Caminho completo do arquivo.
      $isFile = file_exists(PATH_VIEW_PAGES . $p_path_view);                      // Verifica se é um arquivo.

      // Variáveis de Controle
      $p_url .= $value . '/';                                                     // Concatena caminho atual com anterior. (attr)
      $p_dir_ant .= $infoDirUrl['url'];                                              // Salva a pasta anterior.
      $infoDirUrl['url'] .= $p_dir;                                                  // Concatena caminho atual com anterior. (url)

      // Caso seja um diretório
      if ($isDir) {
        $infoDirUrl['path_dir'] .= $p_dir;                                           // Caminho completo do diretório com / no final.
        $infoDirUrl['dir']  = $value;                                                // Nome do diretório.
      }

      // Caso seja um arquivo
      if ($isFile) {
        $infoDirUrl['file'] = $value;                                                // Nome do arquivo html.
        $infoDirUrl['file_name'] = $p_file_view;                                     // Nome do arquivo html com extensão.
        $infoDirUrl['path_view'] = $p_path_view;                                     // Caminho completo do arquivo html.
      }

      // Caso tenha arquivo ou diretório na view.
      if ($isFile || $isDir) {
        $infoDirUrl['controller_name'] = ucfirst($value) . 'ControllerApi';         // Cria nome da controller.
        $infoDirUrl['controller_path'] = $p_dir_ant . ucfirst($value) . 'ControllerApi.php'; // Cria endereço do arquivo controller.
        $p_url = '';                                                              // Zera sequencia da url para gerar attr.
      } else {
        $infoDirUrl['attr'] = explode('/', $p_url);                                  // Cria vetor com os parametros após página.
        unset($infoDirUrl['attr'][$key - 1]);                                        // Tira último parâmetro (vazio).
      }
    }
    return $infoDirUrl;                                                              // Retorna array com as informações da url.
  }




  /**
   * Obtém controllerPage da página atual.
   *
   * @return Controller
   */
  private function getControllerPage()
  {

    /**
     * Verifica controller dos diretórios.
     */
    if (VIEWS_DIR) {

      // Seta parâmetros default para a controller da pagina.
      $controller_name = 'DefaultControllerPage';
      $controller_path = PATH_CONTROLLER_PAGES . 'DefaultControllerPage.php';

      // Verifica se controller_path não está vazio.
      if (!empty(Self::$infoDirUrl['controller_path'])) {
        // Verifica se controller da página existe.
        if (file_exists(PATH_CONTROLLER_PAGES . Self::$infoDirUrl['controller_path'])) {

          // Arquivo existe, então chama controller da página.
          $controller_path = PATH_CONTROLLER_PAGES . Self::$infoDirUrl['controller_path'];
          $controller_name = Self::$infoDirUrl['controller_name'];
        }
      }

      // Carrega arquivo controllerPage da página autal.
      require_once $controller_path;

      // Instancia a classe do controllerPage e salva nos parâmetros do Core.
      try {
        $refl = new ReflectionClass(ucfirst($controller_name));
        return $refl->newInstanceArgs();
      } catch (\Throwable $th) {
        throw new Exception('Verifique se a controller ' . $controller_name . ' está com nome correto, e se ela existe em ' . $controller_path . '.');
      }
    }


    $controller_name = 'DefaultControllerPage';                       // Preenche com controller default.
    $path_dir = PATH_CONTROLLER_PAGES . 'DefaultControllerPage.php';  // Preenche com path default.

    /**
     * Verifica controller do BD.
     */
    if (VIEWS_BD) {
    }

    /**
     * Verifica se existe a view html.
     */
    if (!empty(Self::$infoDirUrl['file'])) {
      $posicao = "<br>Verifica se existe a view html.";

      $controller_name = Self::$infoDirUrl['file'] . 'ControllerPage';   // ControllerPage da página atual.
      //$path = Self::$infoDirUrl['path'] . $controller_name . '.php';
      $path[0] = 'c';                                                 // Diretório controllerPage.

      /**
       * Verifica se existe pasta.
       */
    } elseif (!empty(Self::$infoDirUrl['dir'])) {
      $posicao = "<br>Verifica se existe pasta.";

      $controller_name = Self::$infoDirUrl['path'] . 'ControllerPage';   // ControllerPage da página atual.
      $controller_name[0] = 'c';                                      // Diretório controllerPage.
      $path = $controller_name . '.php';

      /**
       * Verifica se não tem parâmetros
       */
    } else if (isset(Self::$infoDirUrl['attr'])) {
      $posicao = "<br>Verifica se não tem parâmetros.";


      // Atribui a view index.php
      Self::$infoDirUrl = array(
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
      $posicao = "<br>Caso tenha parametros mas sem view.";


      // Caso tenha um parametro na url mas sem view.
      Self::$infoDirUrl['path'] = PATH_VIEW_PAGES . 'Default.php';     // Define path da view default.
      Self::$infoDirUrl['dir'] = PATH_VIEW_PAGES;                      // Define diretório da view default.
      Self::$infoDirUrl['file'] = 'default';                           // Define file default.

      // Tira primeiro atributo, pois se refere a página.
      unset(Self::$infoDirUrl['attr'][0]);
      Self::$infoDirUrl['attr'] = array_values(Self::$infoDirUrl['attr']);
      if (!Self::$infoDirUrl['attr']) {
        Self::$infoDirUrl['attr'] = array(0 => null);
      }

      // controllerPage default
      $path = '';
    }
  }
}
