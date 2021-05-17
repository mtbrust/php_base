<?php

class AdminControllerPage extends ControllerPage
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
    $this->params['security'] = array(
      'session'    => true,          // [true] Somente usuário logado. [false] Qualquer usuário.
      'permission' => '110000000',   // [9] Menu, Início, Adicionar, Editar, Listar (Básico), Listar Completo, Deletar, API, Testes.
      'formToken'  => true,         // Ativa necessidade de token para transações de formulários via post. usar parametro:($this->params['page']['formToken']) input text: (<input name="f-formToken" type="text" value="{{formToken}}" hidden>').
    );

    // Valores default de $paramsTemplate a partir da pasta template.
    $this->params['template'] = array(
      'html'     => 'lte',   // Template HTML
      'head'     => 'lte',   // <head> da página.
      'top'      => 'lte',   // Topo da página.
      'header'   => 'lte',   // Menu da página.
      'nav'      => 'lte',   // Menu da página.
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

    // Valores para configurações da página html.
    // https://www.infowester.com/metatags.php
    $this->params['view'] = array(
      'title'            => 'DashBoard',            // Título da página exibido na aba/janela navegador.
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
      'scriptHead'       => '',                         // Escreve dentro de uma tag <script></script> antes da </head>.
      'scriptBody'       => '',                         // Escreve dentro de uma tag <script></script> antes da </body>.
      'styleHead'        => '',                         // Escreve dentro de uma tag <script></script> antes da </head>.
      'styleBody'        => '',                         // Escreve dentro de uma tag <script></script> antes da </body>.
    );

    // Valores default para scripts. Quais scripts a página atual necessita.
    $this->params['scripts'] = array(
      'js/jquery.min.js',   // TESTE.
    );

    // Valores default para estilos. Quais estilos a página atual necessita.
    $this->params['styles'] = array(
      'css/jquery.min.css',   // TESTE.
    );

    // Valores de conteúdo para serem inseridos no corpo da página.
    // Exemplo: 'p_nome' => 'Mateus',
    // Exemplo uso view: <p><b>Nome: </b> {{p_nome}}</p>
    $this->params['page'] = array(
      'versao'              => 'v1.0',            // Exemplo
    );

    // Otimização das funções de banco de dados que serão usadas na controller.
    // Pasta e controller.
    // Exemplo: 'users/BdUsers',
    // Exemplo uso controller: $var = BdUsuarios::getInfo();
    $this->params['bd'] = array(
      'pasta/BdNome',   // Exemplo
    );

    // Otimização das funções que serão usadas na controller.
    // Pasta classes.
    // Exemplo: 'classes/Midia',
    // Exemplo uso controller: $var = Noticias::getInfo();
    $this->params['classes'] = array(
      'classes/Midia',   // Exemplo
    );

  } // pre.



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
   * View.
   * Usado para criar os parâmetros e dados disponibilizados na view.
   * É executado depois do preprocessamento()
   *
   * @return bool
   */
  public function index()
  {
    // Exemplos
    // $this->paramsPage['nome'] = 'Mateus';
    // $this->paramsPage['usuarios'] = BdUsuarios::getAll();

    $this->paramsPage['cwd'] = getcwd();

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
    // Resultado é um json
    header('Content-Type: application/json');




    // Retorna json.
    echo json_encode(['status' => 'ok']);
  }
}
