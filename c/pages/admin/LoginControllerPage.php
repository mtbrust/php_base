<?php

class LoginControllerPage extends ControllerPage
{


  /**
   * Realiza o pré processamento da página inicial.
   * Usado para definir os parâmetros de personalização da página.
   * Inicia as variáveis no pre processamento.
   *
   * @return void
   */
  public function pre()
  {

    // Valores default de $paramsSecurity.
    $this->paramsSecurity = array(
      'session'    => true,      // Página guarda sessão.
      'permission' => '11111',   // [1,0,0,0,0] Menu/Início, Adicionar, Editar, Listar, Deletar.
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
      'html'        => 'lte',   // Template HTML
      'head'        => 'lte',   // <head> da página.
      'top'         => 'lte',   // Topo da página.
      'header'      => 'lte',   // Menu da página.
      'nav'         => 'lte',   // Menu da página.
      //'corpo'        => 'default',   // Reservado para arquivo html.
      'body_pre'    => 'lte',   // Antes do CORPO dentro body.
      'body_pos'    => 'lte',   // Depois do CORPO dentro body.
      'footer'      => 'lte',   // footer da página.
      'bottom'      => 'lte',   // Fim da página.
      //'maintenance' => 'paper',   // Página de manutenção (quando controller true).
    );

    // Objetos para serem inseridos dentro de partes do template.
    // O Processamento realiza a montagem. Algum template tem que conter um bloco para Obj ser incluido.
    $this->paramsTemplateObjs = array(
      'objeto_apelido'          => 'pasta/arquivo.php',   // Carrega HTML do objeto e coloca no lugar indicado do corpo ou template.
    );

    // Valores default de $paramsView. Valores vazios são ignorados.
    //https://www.infowester.com/metatags.php
    $this->paramsView = array(
      'title'            => 'Login',                                // Título da página exibido na aba/janela navegador.
      'author'           => 'COOPAMA',                              // Autor do desenvolvimento da página ou responsável.
      'description'      => 'Administração',                        // Resumo do conteúdo do site apresentado nas prévias das buscas em até 90 carecteres.
      'keywords'         => 'modelo, página, controllers, views',   // palavras minúsculas separadas por "," referente ao conteúdo da página em até 150 caracteres.
      'content-language' => 'pt-br',                                // Linguagem primária da página (pt-br).
      'content-type'     => 'utf-8',                                // Tipo de codificação da página.
      'reply-to'         => 'suporte@coopama.com.br',               // E-mail do responsável da página.
      'generator'        => 'vscode',                               // Programa usado para gerar página.
      'refresh'          => '',                                     // Tempo para recarregar a página.
      'redirect'         => '',                                     // URL para redirecionar usuário após refresh.
      'obs'              => 'Cria um meta obs.',                    // Outra qualquer observação sobre a página.
      'anoAtual'         => date('Y'),                              // Imagem Logo.
    );




    // Valores para serem inseridos no corpo da página.
    // Exemplo: 'p_nome' => 'Mateus',
    // Exemplo uso view: <p><b>Nome: </b> {{p_nome}}</p>
    $this->paramsPage = array(
      'nome'              => 'Mateus',            // Exemplo
    );


    // Otimização das funções de banco de dados que serão usadas na controller.
    // Sintaxe: 'Pasta/controller', (sem o .php)
    // Exemplo: 'usuarios/BdUsuarios',
    // Exemplo uso controller: $var = BdUsuarios::getInfo();
    $this->paramsBd = array(
      'login/BdLoginInsert',   // Criação de tabelas.
      'login/BdLogin',         // Criação de tabelas.
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

    // $this->paramsPage['login_add'] = BdLogin::Adicionar(array(
    //   'matricula' => '2100',
    //   'full_name' => 'Rafael',
    //   'email'     => 'rafael@coopama.com.br',
    // ));
    
    // $this->paramsPage['login_atualiza'] = BdLogin::atualiza(6, array(
    //   'matricula' => '2100',
    //   'fullName' => 'Lucas',
    //   'email'     => 'lucas@coopama.com.br',
    //   'senha'     => '123456',
    //   'cpf'       => '12312312312',
    // ));
    $this->paramsPage['login_qtd'] = BdLogin::quantidade();
    // $this->paramsPage['login_deleta'] = BdLogin::deleta(5);
    $this->paramsPage['login_tudo'] = BdLogin::selecionaTudo();
    $this->paramsPage['login_1'] = BdLogin::selecionaPorId(2);


    /**
     * Data Table
     */
    // Obtém os registros da tabela.
    $params['dados'] = BdLogin::selecionaTudo();
    // Monta as colunas.
    $params['colunas'] = ['ID', 'Matricula', 'ID_Usuário', 'ID_Grupo', 'Nome_Completo', 'Primeiro_Nome', 'Último_Nome', 'E-Mail', 'Usuário', 'CPF', 'Telefone', 'Ativo', 'Status', 'Observações']; // Caso precise ajustar os nomes das colunas.
    // Obtém a datatable html.
    $dataTable = ControllerRender::renderObj('modeloDataTable', $params);
    // Passa o html para página.
    $this->paramsPage['datatable'] = $dataTable;

    



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


}
