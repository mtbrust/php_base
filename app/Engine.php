<?php

use classes\DevHelper;
use Respect\Validation\Rules\Lowercase;

/**
 * Classe responsável pelo motor da aplicação.
 * 
 * @author Mateus Brust
 */
class Engine
{

  private static $checkIn             = [];
  private static $infoUrl             = [];
  private static $endpointClass;
  private static $endPointParams      = [];
  private static $checkSecurity       = [];
  private static $renderCacheEndPoint = [];
  private static $endPointProcess     = [];
  private static $renderEndPoint      = [];


  /**
   * start
   * Inicia o motor do APP.
   * Executa em sequência o processo para execução do endpoint solicitado.
   * 
   * @author Mateus Brust
   *
   * @return void
   */
  public static function start()
  {
    // Seta algumas configs e carrega as dependências.
    self::checkIn();

    // Carrega informações da url e qual é o endpoint.
    self::friendlyUrl();
    
    // Carrega parâmetros do endPoint.
    self::endPointParams();

    // Segurança
    self::checkSecurity();

    // Chache
    self::renderCacheEndpoint();

    // Processa o endpoint
    self::endPointProcess();

    // Renderiza endpoint
    self::renderEndpoint();

    // Desliga Motor.
    self::checkOut();
  }
  

  /**
   * checkIn
   * Liga o Motor
   * Carrega as configurações iniciais.
   * 
   * @author Mateus Brust
   *
   * @return bool
   */
  private static function checkIn()
  {

    // Inicializa as configurações e variáveis de ambiente.
    require_once('./config.php'); // Constantes

    // Seta relógio para horário de brasília.
    date_default_timezone_set(BASE_CONFIG['TIMEZONE']);

    // Opções de exibição de erros PHP.
    ini_set('display_errors', BASE_CONFIG['SHOW_ERRORS']);
    error_reporting(E_ALL);

    // Verifica se existe o arquivo vendor.
    if (file_exists('./vendor/autoload.php')) {
      // Carrega as demais dependências.
      require_once('./vendor/autoload.php'); // Bibliotecas Vendor
    }else{
      // Informa para usuário que é preciso instalar as dependências.
      echo 'Necessário a instalação das dependências do composer. Execute o comando na raiz do projeto: $ composer install';
      exit;
    }
    
    // Carrega Controllers padrão do app.
    self::loadAppDirClasses(BASE_DIR . 'app/controllers/');
    
    // Carrega Bds padrão do app.
    self::loadAppDirClasses(BASE_DIR . 'app/bds/');
    
    // Carrega Classes padrão do app.
    self::loadAppDirClasses(BASE_DIR . 'app/classes/');
    
    // Finaliza função checkin.
    return self::$checkIn = true;
  }

  /**
   * friendlyUrl
   * Carrega informações da url.
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
   * @return bool
   */
  private static function friendlyUrl()
  {
    // Guarda informações da url.
    self::$infoUrl = \controllers\FriendlyUrl::start();

    // Finaliza função.
    if (self::$infoUrl) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * endPointParams
   * Carrega parâmetros do endPoint.
   * 
   * @author Mateus Brust
   *
   * @return bool
   */
  private static function endPointParams()
  {
    // Carrega o arquivo do endpoint.
    require_once self::$infoUrl['controller_path'];

    // Instancia a classe do endpoint e salva nos parâmetros do Core.
    try {
      // Instância a classe.
      $class = new \ReflectionClass('\\' . self::$infoUrl['namespace'] . '\\' . self::$infoUrl['controller_name']);
      self::$endpointClass = (object)$class->newInstanceArgs();
    } catch (\Throwable $th) {
      echo 'Verifique a classe do endpoint "' . self::$infoUrl['file_endpoint'] . '", e se endpoint existe em "' . self::$infoUrl['path_endpoint'] . '".';
      exit;
    }

    // Verifica se foi chamado submenu (função personalizada).
    self::checkMenu();

    // Carrega os parâmetros personalizados do endpoint.
    self::$endPointParams = self::$endpointClass->getParameters(self::$infoUrl);

    // Carrega os parâmetros do banco de dados caso tenha.
    // todo - carregar os parâmetros do banco de dados.

    // Manda parâmetros atualizados para a controller.
    self::$endpointClass->setParameters(self::$endPointParams);

    // Finaliza função.
    return true;
  }

  /**
   * checkSecurity
   * Função executa as opções de segurança para o endpoint atual.
   * Caso não tenha as permissões necessárias redireciona para outra página.
   * 
   * @author Mateus Brust
   *
   * @return bool
   */
  private static function checkSecurity()
  {
    // Verifica sessão e segurança.
    self::$checkSecurity = \controllers\Security::start(self::$endPointParams['security'], self::$endPointParams['menus'], self::$infoUrl);

    // Manda parâmetros atualizados para a controller.
    self::$endpointClass->setParameters(['security' => self::$checkSecurity]);

    // Finaliza função.
    return true;
  }

  /**
   * Carrega parâmetros do endPoint.
   * 
   * @author Mateus Brust
   *
   * @return bool
   */
  private static function renderCacheEndpoint()
  {
    // Verifica se tem cache e se cache está dentro do tempo e usa ou não.
    self::$renderCacheEndPoint = \controllers\Render::getCacheEndpoint(self::$endPointParams['render']);

    // Verifica se renderizou o cache.
    if (self::$renderCacheEndPoint) {

      // Configura tipo de retorno.
      header("Content-Type: " . self::$endPointParams['render']['content_type'] . "; charset=" . self::$endPointParams['render']['charset']);

      return true;
    } else {
      return false;
    }
  }

  /**
   * Carrega parâmetros do endPoint.
   * 
   * @author Mateus Brust
   *
   * @return bool
   */
  private static function endPointProcess()
  {
    // Caso tenha cache, não processa o endpoint.
    if (self::$renderCacheEndPoint) {
      return true;
    }

    // Instancia a classe do endpoint e salva nos parâmetros do Core.
    try {
      // Instância a classe.
      $class = new \ReflectionClass('\\' . self::$infoUrl['namespace'] . '\\' . self::$infoUrl['controller_name']);
      self::$endpointClass = (object)$class->newInstanceArgs();
    } catch (\Throwable $th) {
      echo 'Verifique a classe do endpoint "' . self::$infoUrl['file_endpoint'] . '", e se endpoint existe em "' . self::$infoUrl['path_endpoint'] . '".';
      exit;
    }

    // Chama o processamento do endpoint.
    self::$endPointParams = self::$endpointClass->start(self::$infoUrl['func'], self::$checkSecurity);

    // Finaliza função.
    return true;
  }

  /**
   * Carrega parâmetros do endPoint.
   * 
   * @author Mateus Brust
   *
   * @return bool
   */
  private static function renderEndpoint()
  {
    // Caso tenha cache, mostra na tela e finaliza.
    if (self::$renderCacheEndPoint) {
      // Renderiza o cache.
      echo self::$renderCacheEndPoint;
      return true;
    }

    // Renderiza o resultado final do processamento do endPoint e do motor.
    $endpoint = \controllers\Render::endPoint(self::$endPointParams);

    // Configura tipo de retorno.
    header("Content-Type: " . self::$endPointParams['render']['content_type'] . "; charset=" . self::$endPointParams['render']['charset']);

    // Verifica se resultado é uma string (provavelmente deu certo).
    if (is_string($endpoint)) {
      // Exibe o resultado do processamento.
      echo $endpoint;
    } else {
      // Verifica se resultado é um array.
      if (is_array($endpoint)) {
        // Imprime a saída de array. (provavelmente deu erro.);
        echo '<pre>';
        print_r($endpoint);
        echo '</pre>';
      } else {
        // Conteúdo não reconhecido.
        echo 'unrecognized content';
      }
    }

    // Finaliza função.
    return true;
  }

  /**
   * Desliga o Motor.
   * 
   * @author Mateus Brust
   *
   * @return bool
   */
  private static function checkOut()
  {
    // Finaliza. 
    // Grava um log do motor.
    // Desliga a chave.
    // Puxa o freio de mão.

    // Finaliza função.
    return true;
  }


  /**
   * checkMenu
   * 
   * Verifica se o parâmetro passado é uma função a ser executada. 
   * Alivia o carregamento da página e ajuda no dinamismo.
   *
   * @return void
   */
  private static function checkMenu()
  {
    // Menu default padrão
    $menu = 'get';

    // Verificar no headers qual o metodo que chegou.
    if ($_SERVER['REQUEST_METHOD'] != 'GET') {
      // Obtém o método via cabeçalho.
      $menu = strtolower($_SERVER['REQUEST_METHOD']);

      // Verifica se função solicitada existe no endpoint.
      if (!method_exists(self::$endpointClass, $menu)) {

        header('Content-Type: application/json; charset=utf-8');

        // Seta na requisição erro 400
        http_response_code(400);

        // Mensagem para ajustar função.
        echo '{"msg": "É necessário implementar a função: ' . strtoupper($menu) . ' no endpoint atual: ' . \controllers\FriendlyUrl::getParameters('controller_path') . '"}';
        exit;
      }
    } else {
      // Verifica se primeiro parâmetro é uma função da controller ou apenas parâmetro.
      if (!empty(self::$infoUrl['attr'][0]) && method_exists(self::$endpointClass, self::$infoUrl['attr'][0])) {
        $menu = self::$infoUrl['attr'][0];
      }
    }

    // Acrescenta nas informações de variável qual função (menu) está sendo chamado.
    self::$infoUrl['func'] = $menu;

    // Cadastra um parâmetro nas informações de url.
    \controllers\FriendlyUrl::setParameters('func', $menu);

    // Cadastra um parâmetro nas informações do endpoint.
    // self::$endPointParams['infoUrl']['func'] = $menu;
  }

  
  /**
   * loadAppDirClasses
   * 
   * Carrega as classes em pastas de APP.
   * Responsável por carregar todas as classes de uma pasta.
   *
   * @param  mixed $appDirPath
   * @return void
   */
  private static function loadAppDirClasses($appDirPath)
  {
    // Obtém diretório.
    $diretorio = dir($appDirPath);

    // Percorre todo diretório.
    while ($arquivo = $diretorio->read()) {
      // Pula o diretório "." e "..".
      if (!($arquivo == '.' || $arquivo == '..')) {

        // Separa string pelo ".".
        $tmp = explode('.', $arquivo);

        // Verifica se é um arquivo php.
        if(end($tmp) == 'php'){
          require_once($appDirPath . $arquivo);
        }
      }
    }
    $diretorio->close();
  }
}
