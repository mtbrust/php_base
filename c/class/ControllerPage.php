<?php

/**
 * Classe pai para os Controllers das páginas.
 * Necessário implementar todos os possíveis métodos que poderão ser usados nas páginas.
 * Serve como interface para criação de controllerNames.
 */
class ControllerPage
{

  /**
   * Nome do Controller da página atual.
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
   * URL da página atual.
   *
   * @var string
   */
  protected $urlAtual;


  /**
   * Parâmetros gerais da página.
   * Segurança
   * Controller
   * Template
   * Global
   * Page
   * View
   * Bd
   * Classes
   *
   * @var array
   */
  protected $params;


  /**
   * Retorna os parametros de segurança.
   *
   * @param string $param
   * @return array
   */
  public function getParamsSecurity($param = false)
  {
    if ($param)
      return $this->params['security'][$param];
    return $this->params['security'];
  }


  /**
   * Retorna os parametros do template.
   *
   * @param string $param
   * @return array
   */
  public function getParamsTemplate($param = false)
  {
    if ($param)
      return $this->params['template'][$param];
    return $this->params['template'];
  }


  /**
   * Retorna os parametros do global.
   *
   * @param string $param
   * @return array
   */
  public function getParamsGlobal($param = false)
  {
    if ($param)
      return $this->params['global'][$param];
    return $this->params['global'];
  }


  /**
   * Retorna os parametros do page.
   *
   * @param string $param
   * @return array
   */
  public function getParamsPage($param = false)
  {
    if ($param)
      return $this->params['page'][$param];
    return $this->params['page'];
  }


  /**
   * Retorna os parametros do view.
   *
   * @param string $param
   * @return array
   */
  public function getParamsView($param = false)
  {
    if ($param)
      return $this->params['view'][$param];
    return $this->params['view'];
  }


  /**
   * Retorna os parametros do bd.
   *
   * @param string $param
   * @return array
   */
  public function getParamsBd($param = false)
  {
    if ($param)
      return $this->params['bd'][$param];
    return $this->params['bd'];
  }


  /**
   * Retorna os parametros do classes.
   *
   * @param string $param
   * @return array
   */
  public function getParamsClasses($param = false)
  {
    if ($param)
      return $this->params['classes'][$param];
    return $this->params['classes'];
  }



  /**
   * Construtor.
   * Controi a controller da página com valores default.
   */
  function __construct()
  {
    // Trata o nome do controller.
    $this->controllerName = Core::getInfoDirUrl('controller_name');

    // Pega os atributos (parametros passados pela url).
    $this->attr = Core::getInfoDirUrl('attr');

    // url da página atual.
    $this->urlAtual  = explode('.', Core::getInfoDirUrl('path_view'))[0];

    // Valores default de $paramsSecurity.
    $this->params['security'] = array(
      'session'    => true,          // Página guarda sessão.
      'permission' => '000000000',   // [9] Menu, Início, Adicionar, Editar, Listar (Básico), Listar Completo, Deletar, API, Testes.
      'formToken'  => false,         // Ativa necessidade de token para transações de formulários via post. usar parametro: ($this->params['page']['formToken']) input text: (<input name="f-formToken" type="text" value="{{formToken}}" hidden>').
    );

    // Valores default de $paramsTemplate a partir da pasta template.
    $this->params['template'] = array(
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

    // Valores que podem ser inseridos em todas página.
    // Exemplo: 'empresa' => 'COOPAMA',
    // Exemplo de uso view: <p><b>Empresa: </b> {{empresa}}</p>
    $this->params['global'] = array(
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
      'empresa'          => 'COOPAMA',                                           // Nome da empresa.
      'attr'             => $this->attr,                                         // url completo.
      'urlInfo'          => Core::getInfoDirUrl(),                               // array url info.
      'urlAtual'         => $this->urlAtual,                                     // url da página atual.
      'favicon'          => URL_RAIZ . PATH_MODEL_IMG . 'favicon_coopama.png',   // Imagem favicon.
      'icon'             => URL_RAIZ . PATH_MODEL_IMG . 'icon_coopama.png',      // Imagem Icon.
      'apple-touch-icon' => URL_RAIZ . PATH_MODEL_IMG . 'favicon_coopama.png',   // Imagem aple.
      'logo'             => URL_RAIZ . PATH_MODEL_IMG . 'logo_coopama.png',      // Imagem Logo.
      'anoAtual'         => date('Y'),                                           // Imagem Logo.
      // Puxar informações user.
    );

    // Valores default de $paramsView. Valores vazios são ignorados.
    //https://www.infowester.com/metatags.php
    $this->params['view'] = array(
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

    // Valores default para scripts. Quais scripts a página atual necessita.
    $this->params['scripts'] = array(
      'js/jquery.min.js',   // TESTE.
    );

    // Valores default para estilos. Quais estilos a página atual necessita.
    $this->params['styles'] = array(
      'css/jquery.min.css',   // TESTE.
    );

    // Valores para serem inseridos no corpo da página.
    // Exemplo: 'p_nome' => 'Mateus',
    // Exemplo uso view: <p><b>Nome: </b> {{p_nome}}</p>
    $this->params['page'] = array(
      // 'nome'              => 'Mateus',            // Exemplo
    );

    // Otimização das funções de banco de dados que serão usadas na controller.
    // Pasta e controller.
    // Exemplo: 'usuarios' => 'BdUsuarios',
    // Exemplo uso: $var = BdUsuarios::getInfo();
    $this->params['bd'] = array(
      // 'pasta' => 'BdArquivo',   // Exemplo
    );


    // Otimização das funções que serão usadas na controller.
    // Pasta classes.
    // Exemplo: 'classes/Noticias',
    // Exemplo uso controller: $var = Noticias::getInfo();
    $this->params['classes'] = array(
      // 'classes/Noticias',   // Exemplo
    );
  }


  /**
   * Inicia a verificação de controle e chama função correspondente.
   *
   * @return void
   */
  public function start()
  {
    // Carrega os parâmetros passados pela controller da página atual.
    $this->pre();

    // Processa os parâmetros passados pela controller da página atual. (Carrega o conteúdo html)
    $this->process();


    // Verifica se tem dados $_post e se tem segurança token.
    if ($_POST) {
      // Verifica se segurança de token está ativa
      if (isset($this->params['security']['formToken']) && $this->params['security']['formToken'] && isset($this->attr[0]) && $_POST['f-formToken'] != md5(date('d') . $this->attr[0])) {
        $_POST = null;
        echo 'Sem permissão para envio de dados. Ou token incorreto.';
        exit;
      }
    }

    // Caso não seja api, renderiza a view.
    $api = false;

    // Verifica url para ver qual REST usou.
    if ($this->attr && isset($this->attr[0])) {

      // Cria o token para validar formulários.
      $this->params['page']['formToken'] = md5(date('d') . $this->attr[0]);

      // Verifica qual o tipo de utilizaçãoo usuário quer.
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
        case 'getfull':
          if (ControllerSecurity::getPermissions('getFull'))
            $this->getFull();
          break;
        case 'delete':
          if (ControllerSecurity::getPermissions('delete'))
            $this->delete();
          break;
        case 'api':
          $api = true;
          if (ControllerSecurity::getPermissions('api'))
            $this->api();
          break;
        case 'test':
          if (ControllerSecurity::getPermissions('test'))
            $this->test();
          break;
        default:
          $this->params['page']['formToken'] = md5(date('d'));
          $this->index();
          break;
      }
    } else {
      $this->params['page']['formToken'] = md5(date('d'));
      $this->index();
    }



    // Renderiza o html e imprime na tela caso não seja solicitação de API da página.
    if (!$api) {
      echo ControllerRender::render($this->params);
    }
  }




  /**
   * Realiza o pré processamento da página atual.
   * Usado para definir os parâmetros de personalização da página filha.
   *
   * @return void
   */
  public function pre()
  {
    // Usado na página filha
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
    // Informações do delete.
    $this->params['page']['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . '</b>. Class atual <b>' . __CLASS__ . '</b>.<br>';

    // Caso use segurança de token ativa.
    $params['formToken'] = $this->params['page']['formToken'];


    return true;
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
    $this->params['page']['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . __CLASS__ . '</b>.<br>';

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
    // Informações do delete.
    $this->params['page']['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . '</b>. Class atual <b>' . __CLASS__ . '</b>.<br>';

    // Caso use segurança de token ativa.
    $params['formToken'] = $this->params['page']['formToken'];


    return true;
  }


  /**
   * Exibe registros.
   * Usado para retornar poucos registros permitidos em uma página separada.
   * Pode ser escolhido algum template (objs) para exibir os dados.
   *
   * @return void
   */
  public function get()
  {
    // Informações do delete.
    $this->params['page']['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . '</b>. Class atual <b>' . __CLASS__ . '</b>.<br>';

    // Caso use segurança de token ativa.
    $params['formToken'] = $this->params['page']['formToken'];

    return true;
  }


  /**
   * Exibe os registros completos.
   * Usado para retornar muitos registros em uma página separada.
   * Pode ser escolhido algum template (objs) para exibir os dados.
   *
   * @return void
   */
  public function getFull()
  {
    // Informações do delete.
    $this->params['page']['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . '</b>. Class atual <b>' . __CLASS__ . '</b>.<br>';

    // Caso use segurança de token ativa.
    $params['formToken'] = $this->params['page']['formToken'];

    return true;
  }


  /**
   * Deleta um registro.
   * Usado para deletar um usuário ou classificá-lo como excluido.
   *
   * @return bool
   */
  public function delete()
  {
    // Informações do delete.
    $this->params['page']['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . '</b>. Class atual <b>' . __CLASS__ . '</b>.<br>';

    // Caso use segurança de token ativa.
    $params['formToken'] = $this->params['page']['formToken'];

    return true;
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

    return true;
  }


  /**
   * Inicia a página de teste. 
   * Usada para realizar testes sem afetar a produção.
   *
   * @return bool
   */
  public function test()
  {
    // Informações do delete.
    $this->params['page']['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . '</b>. Class atual <b>' . __CLASS__ . '</b>.<br>';

    // Caso use segurança de token ativa.
    $params['formToken'] = $this->params['page']['formToken'];

    return true;
  }


  /**
   * Realiza o processamento das configurações da controller antes de criar a página e mostrar para o usuário.
   * Usado para chamar as dependências do banco de dados.
   * Usado para processar o nível de segurança do usuário.
   *
   * @return void
   */
  private function process()
  {

    // Verifica se página exige sessão (usuário logado).
    if ($this->params['security']['session']) {

      // Controle de sessão e permissões.
      $this->params['global']['permissions'] = ControllerSecurity::on($this->params['security']['permission'], $this->urlAtual);

      // Carrega informações de usuário.
      // Obtém os dados da tabela login na sessão [LOGIN]
      $login = ControllerSecurity::getSession();
      // Carrega dados tabela users.
      $user = BdUsers::selecionaPorId($login['idUser']);
      // Carrega foto de usuário ou foto default.
      if (isset($user['idFoto']))
        $user['urlFoto'] = BdMidia::selecionaPorId($user['idFoto'])['urlMidia'];
      else
        $user['urlFoto'] = URL_RAIZ . PATH_MODEL_IMG . 'default_perfil.png';
      // Joga para os parâmetros da página {{page.login}} informações da tabela Login e Usuário.
      $this->params['page']['userInfo'] = array_merge($login, $user);
    } // Fim sessão.

    // Carrega o template html definido na controller atual.
    $this->carregaTemplate();

    // Carrega classes de acesso ao banco definido na controller atual.
    $this->carregaBd();

    // Carrega classes de funções específicas, definida na controller atual.
    $this->carregaClasses();
  }


  /**
   * Carrega conteúdo html dos arquivos de template da pasta definida PATH_VIEW_TEMPLATES.
   * Carrega conteúdo html da página de conteúdo que será exibida dentro do template. definida em PATH_VIEW_PAGES.
   *
   * @return void
   */
  private function carregaTemplate()
  {
    // Carrega os arquivos do parâmetro template.
    foreach ($this->params['template'] as $key => $value) {
      // Parâmetro recebe o conteúdo HTML do arquivo.
      $this->params['template'][$key] = file_get_contents(PATH_VIEW_TEMPLATES . $key . '/' . $value . '.html');
    }
    // Carregar os outros parâmetros tipo obj (pensar como usar ele).
    // Mandar os parâmetros para dentro do render.

    // Monta caminho do arquivo HTML. Conteúdo da página atual. Dentro da pasta definida em PATH_VIEW_PAGES.
    $path_view = PATH_VIEW_PAGES . Core::getInfoDirUrl('path_view');
    // Caso não tenha permissão para Menu/Início, troca a view por modelo sem permissão HTML.
    if ($this->params['security']['session'] && !$this->params['global']['permissions']['index'])
      $path_view = PATH_VIEW_PAGES . 'modeloSemPermissao.html';
    // Parâmetro corpo recebe o conteúdo HTML. (irá ser renderizado junto com todos os parâmetros de template.)
    $this->params['template']['corpo'] = file_get_contents($path_view);

  }


  /**
   * Carrega os arquivos de classes PHP da pasta definida PATH_MODEL_BD.
   * POO pode ser usado na controller para executar funções específicas de banco de dados.
   * Caso o arquivo exista, ele é carregado.
   *
   * @return void
   */
  private function carregaBd()
  {
    // Carrega as controllers de BD passadas no parâmetro de BD (paramsBd). Para poder trabalhar com os dados da tabela na controller.
    foreach ($this->params['bd'] as $value) {
      $path_bd = PATH_MODEL_BD . $value . '.php';
      // Carrega arquivo.
      if (file_exists($path_bd)) {
        require_once $path_bd;
      }
    }
  }


  /**
   * Carrega os arquivos de classes PHP da pasta definida PATH_MODEL_CLASSES.
   * POO pode ser usado na controller para executar funções específicas.
   * Caso o arquivo exista, ele é carregado.
   *
   * @return void
   */
  private function carregaClasses()
  {
    // Carrega as classes passadas no parâmetro classes. Para poder trabalhar na controller.
    foreach ($this->params['classes'] as $value) {
      $path_class = PATH_MODEL_CLASSES . $value . '.php';
      // Carrega arquivo.
      if (file_exists($path_class)) {
        require_once $path_class;
      }
    }
  }
}
