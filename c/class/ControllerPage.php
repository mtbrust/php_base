<?php

/**
 * Classe pai para os controllerNames.
 * Necessário implementar todos os possíveis métodos que poderão ser usados.
 * Serve como modelo para criação de controllerNames.
 */
class ControllerPage
{

  /**
   * Nome do controllerName atual.
   *
   * @var string
   */
  protected $controllerName;


  /**
   * Parametros passados pela URL.
   *
   * @var array
   */
  protected $attr;


  /**
   * Parametros para segurança da página personalizado.
   *
   * @var array
   */
  protected $paramsSecurity;
  public function getParamsSecurity($param = false)
  {
    if ($param)
      return $this->paramsSecurity[$param];
    return $this->paramsSecurity;
  }


  /**
   * Parâmetros para controle do polimorfismo controller.
   *
   * @var array
   */
  protected $paramsController;
  public function getParamsController($param = false)
  {
    if ($param)
      return $this->paramsController[$param];
    return $this->paramsController;
  }


  /**
   * Parâmetros para controle de templates e modelos.
   *
   * @var array
   */
  protected $paramsTemplate;
  public function getParamsTemplate($param = false)
  {
    if ($param)
      return $this->paramsTemplate[$param];
    return $this->paramsTemplate;
  }


  /**
   * Parâmetros para construção da view.
   *
   * @var array
   */
  protected $paramsView;
  public function getParamsView($param = false)
  {
    if ($param)
      return $this->paramsView;
    return $this->paramsView[$param];
  }


  /**
   * Construtor.
   */
  function __construct()
  {
    // Trata o nome do controller.
    $this->controllerName = ucfirst(Core::getUrlFinal()['file']);

    // Pega os atributos (parametros passados pela url).
    $this->attr = Core::getUrlFinal()['attr'];

    // Valores default de $paramsSecurity.
    $this->paramsSecurity = array(
      'session'           => true,                    // Página guarda sessão.
      'permission'        => 0,                       // Nível de acesso a página. 0 a 7.
    );

    // Valores default de $paramsController.
    $this->paramsController = array(
      '_post'             => false,                   // Permitir funções $_POST.
      'put'               => false,                   // Permitir funções put.
      'get'               => false,                   // Permitir funções get.
      'delete'            => false,                   // Permitir funções delete.
      'index'             => false,                   // Permitir funções index.
      'maintenance'       => false,                   // Exibir página em manutenção.
    );

    // Valores default de $paramsTemplate a partir da pasta template.
    $this->paramsTemplate = array(
      'template'          => 'default',               // Template HTML
      'head'              => 'default',               // <head> da página.
      'top'               => 'default',               // Topo da página.
      'header'            => 'default',               // Cabeçalho da página.
      'nav'               => 'default',               // Menu da página.
      'antes'             => 'default',               // Antes section conteúdo body.
      'depois'            => 'default',               // Depois section conteúdo body.
      'footer'            => 'default',               // footer da página.
      'botton'            => 'default',               // Fim da página.
      'maintenance'       => 'default',               // Página de manutenção (quando controller true).
    );

    // Valores default de $paramsView.
    //https://www.infowester.com/metatags.php
    $this->paramsView = array(
      'title'             => 'default',               // Título da página exibido na aba/janela navegador.
      'author'            => 'default',               // Autor do desenvolvimento da página ou responsável.
      'description'       => 'default',               // Resumo do conteúdo do site apresentado nas prévias das buscas em até 90 carecteres.
      'keywords'          => 'default',               // palavras minúsculas separadas por "," referente ao conteúdo da página em até 150 caracteres.
      'content-language'  => 'default',               // Linguagem primária da página (pt-br).
      'content-type'      => 'default',               // Tipo de codificação da página.
      'reply-to'          => 'default',               // E-mail do responsável da página.
      'generator'         => 'default',               // Programa usado para gerar página.
      'refresh'           => 'default',               // Tempo para recarregar a página.
      'redirect'          => 'default',               // URL para redirecionar usuário após refresh.
      'obs'               => 'default',               // Outra qualquer observação sobre a página.
    );
  }


  /**
   * Inicia a verificação de controle e chama função correspondente.
   *
   * @return void
   */
  public function start()
  {

    // Verifica se tem dados $_post para enviar para _post.
    if ($_POST) {
      $this->_post();
    }

    // Verifica os atributos para ver em qual GET vai cair.
    //$attr = Self::$urlFinal['attr'];
    if ($this->attr) {
      switch ($this->attr[0]) {
        case 'post':
          $this->post();
          break;
        case 'put':
          $this->put();
          break;
        case 'get':
          $this->get();
          break;
        case 'delete':
          $this->delete();
          break;
        case 'api':
          $this->api();
          break;
        default:
          $this->index();
          break;
      }
    } else {
      $this->index();
    }
  }


  /**
   * Quando é enviado dados via post.
   *
   * @return bool
   */
  public function _post()
  {
    echo 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . __CLASS__ . '</b>.<br>';
    var_dump($_POST);

    return false;
  }


  /**
   * Cria um registro
   *
   * @return bool
   */
  public function post()
  {
    echo 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . __CLASS__ . '</b>.<br>';
    print_r($this->attr);

    return false;
  }


  /**
   * Atualiza registros
   *
   * @return bool
   */
  public function put()
  {
    echo 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . __CLASS__ . '</b>.<br>';
    print_r($this->attr);

    return false;
  }


  /**
   * Exibe registros.
   *
   * @return void
   */
  public function get()
  {
    echo 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . __CLASS__ . '</b>.<br>';
    print_r($this->attr);

    return false;
  }


  /**
   * Deleta um registro.
   *
   * @return bool
   */
  public function delete()
  {
    echo 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . __CLASS__ . '</b>.<br>';

    return false;
  }


  /**
   * Inicia a api da página.
   *
   * @return bool
   */
  public function api()
  {
    header('Content-Type: application/json');
    echo json_encode(array(
      'status' => 'OK',
      'msg' => 'Implementar a api da ' . $this->controllerName . __CLASS__ . '.'
    ));

    return false;
  }


  /**
   * Exibe a página inicial.
   *
   * @return bool
   */
  public function index()
  {
    echo 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . __CLASS__ . '</b>.<br>';
    print_r($this->attr);

    return false;
  }
}

// $c = new controllerName;
// $c->index();