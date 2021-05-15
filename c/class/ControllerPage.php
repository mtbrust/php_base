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
   * Parâmetros para utilização de classes.
   *
   * @var array
   */
  protected $paramsClasses;
  public function getParamsClasses($param = false)
  {
    if ($param)
      return $this->paramsClasses[$param];
    return $this->paramsClasses;
  }


  /**
   * Parâmetros para utilização do BD.
   *
   * @var array
   */
  private $paramsGlobal;
  public function getParamsGlobal($param = false)
  {
    if ($param)
      return $this->paramsGlobal[$param];
    return $this->paramsGlobal;
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
      'session'    => true,    // Página guarda sessão.
      'permission' => 0,       // [1,0,0,0,0] Visualização básica, visualização total, Criação, Edição, Exclusão.
      'formToken'  => false,   // Ativa necessidade de token para transações de formulários via post. usar parametro: ($this->paramsPage['formToken']) input text: (<input name="f-formToken" type="text" value="{{formToken}}" hidden>').
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


    // Otimização das funções que serão usadas na controller.
    // Pasta classes.
    // Exemplo: 'classes/Noticias',
    // Exemplo uso controller: $var = Noticias::getInfo();
    $this->paramsClasses = array(
      // 'classes/Noticias',   // Exemplo
    );


    // Valores que podem ser inseridos em todas página.
    // Exemplo: 'empresa' => 'COOPAMA',
    // Exemplo de uso view: <p><b>Empresa: </b> {{empresa}}</p>
    $this->paramsGlobal = array(
      // Config
      'DIR_RAIZ'          => DIR_RAIZ,                       // Path dir desde a raíz.
      'URL_RAIZ'          => URL_RAIZ,                       // Path URL.
      'PATH_MODEL_ASSETS' => URL_RAIZ . PATH_MODEL_ASSETS,   // Path m/assets/.
      'PATH_MODEL_CSS'    => URL_RAIZ . PATH_MODEL_CSS,      // Path m/assets/css/.
      'PATH_MODEL_IMG'    => URL_RAIZ . PATH_MODEL_IMG,      // Path m/assets/img.
      'PATH_MODEL_JS'     => URL_RAIZ . PATH_MODEL_JS,       // Path m/assets/js.
      'PATH_MODEL_MIDIA'  => URL_RAIZ . PATH_MODEL_MIDIA,    // Path m/midia.
      'PATH_MODEL_ADMIN'  => URL_RAIZ . PATH_MODEL_ADMIN,    // Path.

      // Informações gerais
      'empresa'           => 'COOPAMA',                                           // Nome da empresa.
      'attr'              => $this->attr,                                         // url completo.
      'url'               => Core::getInfoDirUrl(),                               // array url info.
      'url_atual'         => explode('.', Core::getInfoDirUrl('path_view'))[0],   // url da página atual.
      'favicon'           => URL_RAIZ . PATH_MODEL_IMG . 'favicon_coopama.png',   // Imagem favicon.
      'icon'              => URL_RAIZ . PATH_MODEL_IMG . 'icon_coopama.png',   // Imagem Icon.
      'apple-touch-icon'  => URL_RAIZ . PATH_MODEL_IMG . 'favicon_coopama.png',   // Imagem aple.
      'logo'              => URL_RAIZ . PATH_MODEL_IMG . 'logo_coopama.png',      // Imagem Logo.
      'anoAtual'          => date('Y'),                                           // Imagem Logo.
      // Puxar informações user.
    );
  }


  /**
   * Inicia a verificação de controle e chama função correspondente.
   *
   * @return void
   */
  public function start()
  {
    
    // Pré processamento. Segurança - // DEPRECATED - DESATIVADO
    $this->pre();


    // Processa os parâmetros passados pela controller. (Carrega o conteúdo html)
    $this->process();


    // Verifica se tem dados $_post para enviar para _post.
    if ($_POST) {
      // Verifica se segurança de token está ativa
      if (isset($this->paramsSecurity['formToken']) && $this->paramsSecurity['formToken'] && isset($this->attr[0]) && $_POST['f-formToken'] != md5(date('d') . $this->attr[0])){
        $_POST = null;
        echo 'Sem permissão para envio de dados. Ou token incorreto.';
        exit;
      }
      
      $this->_post();
    }

    // Caso não seja api, renderiza a view.
    $api = false;

    // Verifica url para ver qual REST usou.
    if ($this->attr && isset($this->attr[0])) {

      // Cria o token para validar formulários.
      $this->paramsPage['formToken'] = md5(date('d') . $this->attr[0]);

      // Verifica qual o tipo de utilização.
      switch ($this->attr[0]) {
        case 'post':
          if (ControllerSecurity::getPermissions('post'))
            $this->post();
          break;
        case 'put':
          if (ControllerSecurity::getPermissions('put'))
            $this->put();
          break;
        case 'get':
          if (ControllerSecurity::getPermissions('get'))
            $this->get();
          break;
        case 'delete':
          if (ControllerSecurity::getPermissions('delete'))
            $this->delete();
          break;
        case 'api':
          $api = true;
          $this->api();
          break;
        case 'test':
          $this->test();
          break;
        default:
          $this->paramsPage['formToken'] = md5(date('d'));
          $this->index();
          break;
      }
    } else {
      $this->paramsPage['formToken'] = md5(date('d'));
      $this->index();
    }



    // Renderiza o html.
    if (!$api) {
      ControllerRender::render($this->paramsSecurity, $this->paramsController, $this->paramsTemplate, $this->paramsTemplateObjs, $this->paramsView, array_merge($this->paramsPage, $this->paramsGlobal));
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
   * Inicia a página de teste. 
   * Usada para realizar testes sem afetar a produção.
   *
   * @return bool
   */
  public function test()
  {
    $this->paramsPage['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . __CLASS__ . '</b>.<br>';

    return false;
  }


  /**
   * Exibe a página inicial.
   * Usado para criar os parâmetros e dados disponibilizados na view.
   * É executado depois do preprocessamento()
   *
   * @return bool
   */
  public function index()
  {
    // $this->paramsPage['nome'] = 'Mateus';
    // $this->paramsPage['usuarios'] = BdUsuarios::getAll();
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
    // DEPRECATED - DESATIVADO
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
    
    // Verifica se página exige sessão (usuário logado).
    if ($this->paramsSecurity['session']) {
      ControllerSecurity::on();

      // Obtém os dados da sessão [LOGIN]
      $userInfo = ControllerSecurity::getSession();

      // Verifica se existe usuário para este login, caso não exista, cria.
      $idUser = (isset($userInfo['idUser'])) ? $userInfo['idUser'] : null;
      if (!$idUser) {
        // Dados repetidos Login x Users.
        $fields = [
          'idLogin' => $userInfo['id'],
          'nome' => $userInfo['fullName'],
          'telefone1' => $userInfo['telefone'],
          'emailProfissional' => $userInfo['email'],
          'cpf' => $userInfo['cpf'],
        ];
        $idUser = BdUsers::Adicionar($fields); // Adiciona no banco.

        // Atualiza ID do usuário na tabela login.
        BdLogin::atualiza($userInfo['id'], ['idUser' => $idUser]);
        // Atualiza Sessão com id do novo usuário.
        ControllerSecurity::setSession('idUser', $idUser);
        // Atualiza a variável de informações do usuário logado.
        $userInfo['idUser'] = $idUser;
      }

      // Carrega dados tabela users.
      $user = BdUsers::selecionaPorId($idUser);

      // Carrega foto de usuário ou foto default.
      if (isset($user['idFoto']))
        $user['urlFoto'] = BdMidia::selecionaPorId($user['idFoto'])['urlMidia'];
      else
        $user['urlFoto'] = URL_RAIZ . PATH_MODEL_IMG . 'default_perfil.png';

      // Joga para os parâmetros globais {{userInfo}} informações da tabela Login e Usuário.
      $this->paramsPage['userInfo'] = array_merge($userInfo, $user);

      

      // Executa as permissões de segurança do usuário e grupo.
      $idGrupo = 0;
      if (isset($userInfo['idGrupo']))
        $idGrupo = $userInfo['idGrupo'];
      // Seta as permissões na classe. (parametro: permissions)
      //$urlPage = Core::getInfoDirUrl('path_dir') . Core::getInfoDirUrl('file') . '/';
      $urlPage = explode('.', Core::getInfoDirUrl('path_view'))[0] . '/';
      ControllerSecurity::setPermissions($this->paramsSecurity['permission'], $idUser, $idGrupo, $urlPage);
      $this->paramsGlobal['permissions'] = ControllerSecurity::getPermissions();
    } // Fim sessão.



    // Pega caminho do arquivo HTML da pasta v/pages/.
    $path_view = PATH_VIEW_PAGES . Core::getInfoDirUrl('path_view');
    // Caso não tenha permissão para Menu/Início, troca a view por modelo sem permissão HTML.
    if ($this->paramsSecurity['session'] && !ControllerSecurity::getPermissions('menu'))
      $path_view = PATH_VIEW_PAGES . 'modeloSemPermissao.html';
    // Parâmetro corpo recebe o conteúdo HTML. (irá ser renderizado junto com todos os parâmetros de template.)
    $this->paramsTemplate['corpo'] = file_get_contents($path_view);


    // print_r(Core::getInfoDirUrl());
    // exit;

    // Carrega os arquivos no parâmetro template.
    foreach ($this->paramsTemplate as $key => $value) {
      if ($key == 'corpo') {
      } else {
        // Parâmetro recebe o conteúdo HTML do arquivo.
        $this->paramsTemplate[$key] = file_get_contents(PATH_VIEW_TEMPLATES . $key . '/' . $value . '.html');
      }
    }
    // Carregar os outros parâmetros tipo obj (pensar como usar ele).
    // Mandar os parâmetros para dentro do render.


    // Carrega as controllers de BD passadas no parâmetro de BD (paramsBd). Para poder trabalhar com os dados da tabela na controller.
    foreach ($this->paramsBd as $value) {
      $path_bd = PATH_MODEL_BD . $value . '.php';
      // Carrega arquivo.
      if (file_exists($path_bd)) {
        require_once $path_bd;
      }
    }


    // Carrega as classes passadas no parâmetro classes. Para poder trabalhar com os objetos na página (view).
    foreach ($this->paramsClasses as $value) {
      $path_class = PATH_MODEL_CLASSES . $value . '.php';
      // Carrega arquivo.
      if (file_exists($path_class)) {
        require_once $path_class;
      }
    }
  }


  /**
   * Realiza a segurança da página atual.
   * Usado para definir os parâmetros de personalização da página.
   *
   * @return void
   */
  public function security()
  {
    //echo '<br>Classe pai.';
  }
}
