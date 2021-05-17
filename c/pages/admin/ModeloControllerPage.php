<?php

/**
 * Modelo de controller para páginas.
 */
class ModeloControllerPage extends ControllerPage
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
      'permission' => '111111111',   // [9] Menu, Início, Adicionar, Editar, Listar (Básico), Listar Completo, Deletar, API, Testes.
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

    // Valores para configurações da página html.
    // https://www.infowester.com/metatags.php
    $this->params['view'] = array(
      'title'            => 'Página Modelo Admin',            // Título da página exibido na aba/janela navegador.
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
    // $this->params['page']['nome'] = 'Mateus';
    // $this->params['page']['usuarios'] = BdUsuarios::getAll();
    
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
    // Informações desta função.
    $this->params['page']['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . '</b>. Class atual <b>' . __CLASS__ . '</b>.<br>';
    
    // Caso use segurança de token ativa.
    $params['formToken'] = $this->params['page']['formToken'];
    
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
    // Informações desta função.
    $this->params['page']['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . '</b>. Class atual <b>' . __CLASS__ . '</b>.<br>';
    
    // Caso use segurança de token ativa.
    $params['formToken'] = $this->params['page']['formToken'];
    
    return true;
  }


  /**
   * Exibe os registros selecionados e permitidos.
   * Usado para retornar poucos registros permitidos em uma página separada.
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
    //$params['dados'] = BdModelo::selecionaTudo();
    // Monta as colunas.
    //$params['colunas'] = ['ID', 'Matricula', 'ID_Usuário', 'ID_Grupo', 'Nome_Completo', 'Primeiro_Nome', 'Último_Nome', 'E-Mail', 'Usuário', 'CPF', 'Telefone', 'Ativo', 'Status', 'Observações']; // Caso precise ajustar os nomes das colunas.
    // Obtém a datatable html.
    //$dataTable = ControllerRender::renderObj('modeloDataTable', $params);
    // Passa o html para página.
    //$this->params['page']['datatable'] = $dataTable;

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
    // Informações desta função.
    $this->params['page']['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . '</b>. Class atual <b>' . __CLASS__ . '</b>.<br>';
    
    // Caso use segurança de token ativa.
    $params['formToken'] = $this->params['page']['formToken'];

    // teste
    $this->params['page']['teste'] = 'teste';


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
    // Informações desta função.
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
    // Cabeçalho para visualizar em JSON no caso de acesso direto.
    header('Content-Type: application/json');

    // Retorno exemplo para Json.
    echo json_encode(array(
      'status' => 'OK',
      'msg' => 'Implementar a api da ' . $this->controllerName . __CLASS__ . '.'
    ));

    // Retorna true após a execução de todo o comando.
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

    $this->params['page']['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . __CLASS__ . '</b>.<br>';
    return true;
  }
}