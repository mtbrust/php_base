<?php

/**
 * Modelo de controller para páginas.
 */
class SegurancaControllerPage extends ControllerPage
{


  /**
   * Realiza o pré processamento da página inicial.
   * Usado para definir os parâmetros de personalização da página.
   *
   * @return void
   */
  public function pre()
  {

    // Valores default de $paramsSecurity.
    $this->paramsSecurity = array(
      'session'    => true,      // [true] Somente usuário logado. [false] Qualquer pessoa.
      'permission' => '00000',   // [1,0,0,0,0] Menu/Início, Adicionar, Editar, Listar, Deletar.
      'formToken'  => true,      // Ativa necessidade de token para transações de formulários via post. usar parametro: ($this->paramsPage['formToken']) input text: (<input name="f-formToken" type="text" value="{{formToken}}" hidden>').
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
      'html'     => 'lte',   // Template HTML
      'head'     => 'lte',   // <head> da página.
      'top'      => 'lte',   // Topo da página.
      'header'   => 'lte',   // Menu da página.
      'nav'      => 'lte',   // Menu da página.
      // 'corpo'    => 'default',   // Reservado para arquivo html.
      'body_pre' => 'lte',   // Antes do CORPO dentro body.
      'body_pos' => 'lte',   // Depois do CORPO dentro body.
      'footer'   => 'lte',   // footer da página.
      'bottom'   => 'lte',   // Fim da página.
      //'maintenance' => 'manutencao',   // Página de manutenção (quando controller true).
    );

    // Objetos para serem inseridos dentro de partes do template.
    // O Processamento realiza a montagem. Algum template tem que conter um bloco para Obj ser incluido.
    $this->paramsTemplateObjs = array(
      'objeto_apelido'          => 'pasta/arquivo.php',   // Carrega HTML do objeto e coloca no lugar indicado do corpo ou template.
    );

    // Valores default de $paramsView. Valores vazios são ignorados.
    //https://www.infowester.com/metatags.php
    $this->paramsView = array(
      'title'            => 'Segurança',            // Título da página exibido na aba/janela navegador.
      'author'           => 'Coopama',                  // Autor do desenvolvimento da página ou responsável.
      'description'      => '',                         // Resumo do conteúdo do site apresentado nas prévias das buscas em até 90 carecteres.
      'keywords'         => '',                         // palavras minúsculas separadas por "," referente ao conteúdo da página em até 150 caracteres.
      'content-language' => 'pt-br',                    // Linguagem primária da página (pt-br).
      'content-type'     => 'utf-8',                    // Tipo de codificação da página.
      'reply-to'         => 'suporte@coopama.com.br',   // E-mail do responsável da página.
      'generator'        => 'vscode',                   // Programa usado para gerar página.
      'refresh'          => '',                         // Tempo para recarregar a página.
      'redirect'         => '',                         // URL para redirecionar usuário após refresh.
      'obs'              => '',                         // Outra qualquer observação sobre a página.
    );




    // Valores para serem inseridos no corpo da página.
    // Exemplo: 'p_nome' => 'Mateus',
    // Exemplo uso view: <p><b>Nome: </b> {{p_nome}}</p>
    $this->paramsPage = array(
      'versão'              => 'v1.0',            // Exemplo
    );


    // Otimização das funções de banco de dados que serão usadas na controller.
    // Pasta e controller.
    // Exemplo: 'users/BdUsers',
    // Exemplo uso controller: $var = BdUsuarios::getInfo();
    $this->paramsBd = array(
      // 'permissions/BdPermissions',   // Não precisa. já puxa na Core.php geral.
      'status/BdStatus',   // Status
    );


    // Otimização das funções que serão usadas na controller.
    // Pasta classes.
    // Exemplo: 'classes/Noticias',
    // Exemplo uso controller: $var = Noticias::getInfo();
    $this->paramsClasses = array(
      'classes/Noticias',   // Exemplo
    );
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
    $this->paramsPage['post'] = $_POST;

    // Formulário de adicionar.
    $this->adicionar();

    // Formulário de atualização.
    $this->atualizar_grupo();


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

    // Guarda tipo.
    $tipo = $this->attr[1];
    // Verifica se foi passado o tipo: usuario ou grupo.
    if (empty($tipo)) {
      $grupo = BdStatus::selecionaPorGrupo('login/idGrupo');
      $login['login'] = BdLogin::selecionaTudo();
      $this->paramsPage['obj_post'] = ControllerRender::renderObj('seguranca/post_tipo', array_merge($grupo, $login));
      return false;
    }

    // Guarda ID.
    $id = $this->attr[2];
    // Verifica se passou id.
    if (empty($id)) {
      $this->paramsPage['obj_post'] = ControllerRender::renderObj('seguranca/post_tipo_id', $tipo);
      return false;
    }



    // Chama formulário para cada tipo.
    switch ($tipo) {
      case 'usuario':
        $r = BdUsers::selecionaPorId($id);
        if ($r) {
          $l = BdLogin::selecionaPorId($r['idLogin']);
          $formToken = array();
          if (isset($this->paramsPage['formToken']))
            $formToken = ['formToken' => $this->paramsPage['formToken']];
          $paginas['paginas'] = BdPages::selecionaTudo();
          $this->paramsPage['obj_post'] = ControllerRender::renderObj('seguranca/post_formulario_usuario', array_merge($r, $l, $formToken, $paginas));
        } else
          $this->paramsPage['obj_post'] = ControllerRender::renderObj('seguranca/post_sem_id', array($tipo, $id));
        break;
      case 'grupo':
        $r = BdStatus::selecionaPorId($id);
        if ($r) {
          $paginas['paginas'] = BdPages::selecionaTudo();
          $this->paramsPage['obj_post'] = ControllerRender::renderObj('seguranca/post_formulario_grupo', array_merge($r, $paginas));
        } else
          $this->paramsPage['obj_post'] = ControllerRender::renderObj('seguranca/post_sem_id', array($tipo, $id));
        break;
      default:
        # code...
        break;
    }



    return true;
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
    $this->paramsPage['content'] = 'Escolha uma permissão para editar em "LISTAR".';

    if ($this->attr[1]) {
      $params['permission'] = BdPermissions::selecionaPorId($this->attr[1]);
      $params['permission']['permissions'] = str_split($params['permission']['permissions']);

      // print_r($params);
      // exit;

      $params['formToken'] = $this->paramsPage['formToken'];
      if ($params['permission']['idLogin']) {
        $params['user'] = BdUsers::selecionaPorId(($params['permission']['idLogin']));
        $params['login'] = BdLogin::selecionaPorId($params['user']);
        $this->paramsPage['content'] = ControllerRender::renderObj('seguranca/put_user', $params);
      } elseif ($params['permission']['idGrupo']) {
        $params['grupo'] = BdStatus::selecionaPorId($params['permission']['idGrupo']);
        $this->paramsPage['content'] = ControllerRender::renderObj('seguranca/put_group', $params);
      }
    }

    return true;
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

    /**
     * Data Table
     */
    // Obtém os registros da tabela.
    $params['dados'] = BdPermissions::selecionaTudo();
    // Monta as colunas.
    //$params['colunas'] = ['ID', 'Matricula', 'ID_Usuário', 'ID_Grupo', 'Nome_Completo', 'Primeiro_Nome', 'Último_Nome', 'E-Mail', 'Usuário', 'CPF', 'Telefone', 'Ativo', 'Status', 'Observações']; // Caso precise ajustar os nomes das colunas.
    // Obtém a datatable html.
    // $params['acoes'] = [
    //   [
    //     'name' => 'Usuário',
    //     'icon' => 'fas fa-edit',
    //     'link' => '../put/user/',
    //     'btn' => 'btn-warning',
    //   ],
    //   [
    //     'name' => 'Grupo',
    //     'icon' => 'fas fa-edit',
    //     'link' => '../put/group/',
    //     'btn' => 'btn-warning',
    //   ],
    // ];
    $dataTable = ControllerRender::renderObj('modeloDataTable', $params);
    // Passa o html para página.
    $this->paramsPage['datatable'] = $dataTable;

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
   * Função para adicionar novo registro.
   *
   * @return true
   */
  public function adicionar()
  {
    // Verifica se foi o submit de adicionar.
    if (!empty($_POST['adicionar']) && $_POST['adicionar'] == 'login') {

      // Retorno da função.
      $id = false;

      // Verifica se os campos obrigatórios foram preenchidos.
      if (!empty($_POST['f-urlPage'])) {

        // Preparação das permissões.
        $permissions = '00000';
        if (isset($_POST['f-menu']))
          $permissions[0] = '1';
        if (isset($_POST['f-post']))
          $permissions[1] = '1';
        if (isset($_POST['f-put']))
          $permissions[2] = '1';
        if (isset($_POST['f-get']))
          $permissions[3] = '1';
        if (isset($_POST['f-delete']))
          $permissions[4] = '1';

        // Monta os campos e os valores.
        $fields = [
          'idLogin'  => $_POST['f-idLogin'],     // Administrador
          'nome'  => $_POST['f-nome'],
          'urlPagina' => $_POST['f-urlPage'],
          'obs' => $_POST['f-obs'],
          'permissions' => $permissions,
          'dtCreate' => date("Y-m-d H:i:s"),
        ];

        // print_r($fields);
        // exit;

        // Executa o INSERT.
        $id = BdPermissions::Adicionar($fields);
        if (!$id)
          return false;
      }

      // Caso ocorra tudo certo com a inserção.
      return $id;
    }
  }



  /**
   * Função para atualizar permissões do grupo.
   *
   * @return true
   */
  public function atualizar_grupo()
  {
    // Verifica se foi o submit de editar.
    if (isset($_POST['editar']) && isset($_POST['f-tipo']) && $_POST['f-tipo'] == 'grupo') {

      // Retorno da função.
      $id = $_POST['editar'];



      // Preparação das permissões.
      $permissions = '00000';
      if (isset($_POST['f-menu']))
        $permissions[0] = '1';
      if (isset($_POST['f-post']))
        $permissions[1] = '1';
      if (isset($_POST['f-put']))
        $permissions[2] = '1';
      if (isset($_POST['f-get']))
        $permissions[3] = '1';
      if (isset($_POST['f-delete']))
        $permissions[4] = '1';

      // Monta os campos e os valores.
      $fields = [
        'nome'  => $_POST['f-nome'],
        'urlPagina' => $_POST['f-urlPage'],
        'obs' => $_POST['f-obs'],
        'permissions' => $permissions,
      ];

      // print_r($fields);
      // exit;

      // Executa o UPDATE.
      if (!BdPermissions::atualiza($id, $fields))
        return false;


      // Caso ocorra tudo certo com a inserção.
      return true;
    }
  }
}
