<?php

/**
 * Modelo de controller para páginas.
 */
class MeusdadosControllerPage extends ControllerPage
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
      'permission' => '10000',   // [1,0,0,0,0] Menu/Início, Adicionar, Editar, Listar, Deletar.
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
      //'objeto_formulario'          => 'meusdados/formulario.html',   // Carrega HTML do objeto e coloca no lugar indicado do corpo ou template.
    );

    // Valores default de $paramsView. Valores vazios são ignorados.
    //https://www.infowester.com/metatags.php
    $this->paramsView = array(
      'title'            => 'Meus Dados',            // Título da página exibido na aba/janela navegador.
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
      // 'midias/BdMidias',   // Exemplo
    );


    // Otimização das funções que serão usadas na controller.
    // Pasta classes.
    // Exemplo: 'classes/Noticias',
    // Exemplo uso controller: $var = Noticias::getInfo();
    $this->paramsClasses = array(
      'Midia',   // Exemplo
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

    Self::atualizarMeusDados();

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
   * Exibe a página inicial.
   * Usado para criar os parâmetros e dados disponibilizados na view.
   * É executado depois do preprocessamento()
   *
   * @return bool
   */
  public function index()
  {

    $this->paramsPage['obj_formulario'] = ControllerRender::renderObj('meusdados/formulario', $this->paramsPage);

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
  public function atualizarMeusDados()
  {
    // Verifica se foi o submit de adicionar.
    if (!empty($_POST['atualizar']) && $_POST['atualizar'] == 'meusdados') {

      // Retorno da função.
      $id = false;

      // Verifica se os campos obrigatórios foram preenchidos.
      if (!empty($_POST['f-nome']) && !empty($_POST['f-email']) && !empty($_POST['f-cpf']) && !empty($_POST['f-telefone'])) {

        // Tratamento do CPF.
        function limpaNumero($valor)
        {
          $valor = preg_replace('/[^0-9]/', '', $valor);
          return $valor;
        }

        // Verifica se usuário alterou foto.
        $idFoto = 0;
        if ($_FILES['f-fotoPerfil'])
         $idFoto = Midia::armazenar($_FILES['f-fotoPerfil'], null, 'users/');

        // Monta os campos e os valores.
        $fieldsUser = [
          'nome' => $_POST['f-nome'],
          'emailProfissional' => $_POST['f-email'],
          'cpf' => limpaNumero($_POST['f-cpf']),
          'telefone1' => limpaNumero($_POST['f-telefone']),
          'dataNascimento' => $_POST['f-dtNascimento'],
          'idFoto' => $idFoto,
        ];

        // Caso não tenha foto, tira a id foto da atualização.
        if (!$idFoto)
          unset($fieldsUser['idFoto']);

        // Apaga foto anterior
        if ($idFoto)
        {
          Midia::deletar($this->paramsPage['userInfo']['idFoto']);
        }

        $nome = explode(' ', $_POST['f-nome']);
        $fieldsLogin = [
          'fullName' => $_POST['f-nome'],
          'firstName' => $nome[0],
          'lastName' => end($nome),
          'userName' => explode('@', $_POST['f-email'])[0],
          'email' => $_POST['f-email'],
          'cpf' => limpaNumero($_POST['f-cpf']),
          'telefone' => limpaNumero($_POST['f-telefone']),
        ];

        // Executa o INSERT.
        $r = BdUsers::atualiza($this->paramsPage['userInfo']['idUser'], $fieldsUser);
        if (!$r)
          return false;

        // Executa o INSERT.
        $r = BdLogin::atualiza($this->paramsPage['userInfo']['idLogin'], $fieldsLogin);
        if (!$r)
          return false;

        // Atualiza sessão.
        ControllerSecurity::atualiza(BdLogin::selecionaPorId($this->paramsPage['userInfo']['idLogin']));

        // Ocorreu tudo bem. redireciona para atualizar os dados.
        header("location: " . URL_RAIZ . "admin/meusdados/");

        // Atualiza os dados dos parametros.
        // $this->paramsPage['userInfo']['nome']              = $fieldsUser['nome'];
        // $this->paramsPage['userInfo']['emailProfissional'] = $fieldsUser['emailProfissional'];
        // $this->paramsPage['userInfo']['cpf']               = $fieldsUser['cpf'];
        // $this->paramsPage['userInfo']['telefone1']         = $fieldsUser['telefone1'];
        // $this->paramsPage['userInfo']['dataNascimento']    = $fieldsUser['dataNascimento'];
        // $this->paramsPage['userInfo']['idFoto']            = $fieldsUser['idFoto'];

      }

      // Caso ocorra tudo certo com a inserção.
      return true;
    }
  }
}
