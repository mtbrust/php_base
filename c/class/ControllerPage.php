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
      return $this->paramsView[$param];
    return $this->paramsView;
  }


  /**
   * Parâmetros para construção da view.
   *
   * @var array
   */
  protected $paramsPage;
  public function getParamsPage($param = false)
  {
    if ($param)
      return $this->paramsPage[$param];
    return $this->paramsPage;
  }


  /**
   * Parâmetros para utilização do BD.
   *
   * @var array
   */
  protected $paramsBd;
  public function getParamsBd($param = false)
  {
    if ($param)
      return $this->paramsBd[$param];
    return $this->paramsBd;
  }


  /**
   * Construtor.
   */
  function __construct()
  {
    // Trata o nome do controller.
    $this->controllerName = Core::getInfoDirUrl('controller_name');

    // Pega os atributos (parametros passados pela url).
    $this->attr = Core::getInfoDirUrl('attr');

    // Valores default de $paramsSecurity.
    $this->paramsSecurity = array(
      'session'    => true,   // Página guarda sessão.
      'permission' => 0,      // Nível de acesso a página. 0 a 100.
    );

    // Valores default de $paramsController.
    $this->paramsController = array(
      '_post'       => false,   // Permitir funções $_POST.
      'put'         => false,   // Permitir funções put.
      'get'         => false,   // Permitir funções get.
      'delete'      => false,   // Permitir funções delete.
      'index'       => false,   // Permitir funções index.
      'maintenance' => false,   // Exibir página em manutenção.
    );

    // Valores default de $paramsTemplate a partir da pasta template.
    $this->paramsTemplate = array(
      'html'        => 'default',   // Template HTML
      'head'        => 'default',   // <head> da página.
      'top'         => 'default',   // Topo da página.
      'header'      => 'default',   // Menu da página.
      'corpo'       => 'default',   // Reservado para CORPO.
      'body_pre'    => 'default',   // Antes do CORPO dentro body.
      'body_pos'    => 'default',   // Depois do CORPO dentro body.
      'footer'      => 'default',   // footer da página.
      'bottom'      => 'default',   // Fim da página.
      'maintenance' => 'default',   // Página de manutenção (quando controller true).
    );

    // objetos para serem inseridos dentro de partes do template.
    // O Processamento realiza a montagem. Algum template tem que conter um bloco para Obj ser incluido.
    $this->paramsTemplateObjs = array(
      'objeto_name'          => '',   // Carrega HTML do objeto e coloca no lugar indicado do corpo ou template.
    );

    // Valores default de $paramsView. Valores vazios são ignorados.
    //https://www.infowester.com/metatags.php
    $this->paramsView = array(
      'title'            => 'default',   // Título da página exibido na aba/janela navegador.
      'author'           => 'default',   // Autor do desenvolvimento da página ou responsável.
      'description'      => 'default',   // Resumo do conteúdo do site apresentado nas prévias das buscas em até 90 carecteres.
      'keywords'         => 'default',   // palavras minúsculas separadas por "," referente ao conteúdo da página em até 150 caracteres.
      'content-language' => 'default',   // Linguagem primária da página (pt-br).
      'content-type'     => 'default',   // Tipo de codificação da página.
      'reply-to'         => 'default',   // E-mail do responsável da página.
      'generator'        => 'default',   // Programa usado para gerar página.
      'refresh'          => 'default',   // Tempo para recarregar a página.
      'redirect'         => 'default',   // URL para redirecionar usuário após refresh.
      'obs'              => 'default',   // Outra qualquer observação sobre a página.
    );

    // Valores para serem inseridos no corpo da página.
    // Exemplo: 'p_nome' => 'Mateus',
    // Exemplo uso view: <p><b>Nome: </b> {{p_nome}}</p>
    $this->paramsPage = array(
      'nome'              => 'Mateus',            // Exemplo
    );

    // Otimização das funções de banco de dados que serão usadas na controller.
    // Pasta e controller.
    // Exemplo: 'usuarios' => 'BdUsuarios',
    // Exemplo uso: $var = BdUsuarios::getInfo();
    $this->paramsBd = array(
      //'pasta' => 'BdArquivo',   // Exemplo
    );
  }


  /**
   * Inicia a verificação de controle e chama função correspondente.
   *
   * @return void
   */
  public function start()
  {
    // Carrega os parâmetros passados pela controller.
    $this->pre();

    // Carrega os parâmetros para a view. (carrega as classes e variáveis)
    $this->view();

    // Processa os parâmetros passados pela controller. (Carrega o conteúdo html)
    $this->process();

    // Verifica se tem dados $_post para enviar para _post.
    if ($_POST) {
      $this->_post();
    }

    // Caso não seja api, renderiza a view.
    $api = false;

    // Verifica url para ver qual REST usou.
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
          $api = true;
          $this->api();
          break;
        default:
          $this->index();
        break;
      }
    } else {
      $this->index();
    }

    // Renderiza o html.
    if (!$api){
      ControllerRender::render($this->paramsSecurity, $this->paramsController, $this->paramsTemplate, $this->paramsTemplateObjs, $this->paramsView, $this->paramsPage);
    }
    
    
  }


  /**
   * Quando é enviado dados via post.
   * Executa as ações necessárias com os dados repassados via &_POST.
   * Dados para serem cadastrados, alterados, ou para simplesmente dinâmica da página.
   *
   * @return bool
   */
  public function _post()
  {
    $this->paramsPage['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . __CLASS__ . '</b>.<br>';

    return false;
  }


  /**
   * Cria um registro
   * Exibe página para criação de registros.
   * Leve pois não busca dados no banco de dados para preencher o formulário.
   *
   * @return bool
   */
  public function post()
  {
    $this->paramsPage['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . __CLASS__ . '</b>.<br>';

    return false;
  }


  /**
   * Atualiza registros.
   * Exibe uma página com formulário para atualização de registros.
   * Caso passe parâmetros na url, já realiza essas alterações.
   * Caso chame a página sem parâmetros é exibido formulário com os dados de referência para atualização.
   *
   * @return bool
   */
  public function put()
  {
    $this->paramsPage['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . __CLASS__ . '</b>.<br>';

    return false;
  }


  /**
   * Exibe registros.
   * Usado para retornar muitos registros em uma página separada.
   * Pode ser escolhido algum template (objs) para exibir os dados.
   *
   * @return void
   */
  public function get()
  {

    $this->paramsPage['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . __CLASS__ . '</b>.<br>';

    return false;
  }


  /**
   * Deleta um registro.
   * Usado para deletar um usuário ou classificá-lo como excluido.
   *
   * @return bool
   */
  public function delete()
  {
    $this->paramsPage['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . __CLASS__ . '</b>.<br>';

    return false;
  }


  /**
   * Inicia a api da página. 
   * Usada para carregar especificidades da página.
   * Alivia o carregamento da página e ajuda no dinamismo.
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
   * Usado para mostrar função da página, informações e prévias.
   * Páginas estáticas com intuito de exibir apenas informações.
   * Chama a view e renderiza ela no motor.
   *
   * @return bool
   */
  public function index()
  {
    //ControllerRender::render($this->paramsSecurity, $this->paramsController, $this->paramsTemplate, $this->paramsTemplateObjs, $this->paramsView, $this->paramsPage);
    return true;
  }


  /**
   * Realiza o pré processamento da página inicial.
   * Usado para definir os parâmetros de personalização da página.
   *
   * @return void
   */
  public function pre()
  {
    //echo '<br>Classe pai.';
  }


  /**
   * View.
   * Usado para criar os parâmetros e dados disponibilizados na view.
   * É executado depois do preprocessamento()
   *
   * @return bool
   */
  public function view()
  {
    // Exemplos
    // $this->paramsPage['nome'] = 'Mateus';
    // $this->paramsPage['usuarios'] = BdUsuarios::getAll();

    return false;
  }


  /**
   * Realiza o processamento dos parâmetros.
   * Usado para chamar as dependências do banco de dados.
   * Usado para processar o nível de segurança do usuário.
   *
   * @return void
   */
  public function process()
  {

    $path_view = PATH_VIEW_PAGES . Core::getInfoDirUrl('path_view');
    $this->paramsTemplate['corpo'] = file_get_contents($path_view);

    // print_r(Core::getInfoDirUrl());
    // exit;

    // Carrega os arquivos no parâmetro.
    foreach ($this->paramsTemplate as $key => $value) {
      if ($key == 'corpo') {
      } else
        $this->paramsTemplate[$key] = file_get_contents(PATH_VIEW_TEMPLATES . $key . '/' . $value . '.html');
    }
    // Carregar os outros parâmetros tipo obj (pensar como usar ele).
    // Mandar os parâmetros para dentro do render.

    // Carrega as controllers passadas no parâmetro BD. Para poder trabalhar com os dados na página (view).
    foreach ($this->paramsBd as $value) {
      $path_bd = PATH_MODEL_BD . $value . '.php';
      // Carrega arquivo.
      if (file_exists($path_bd)) {
        require_once $path_bd;
      }
    }
  }
}
