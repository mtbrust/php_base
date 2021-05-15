<?php

/**
 * Configurações controller para página.
 */
class ConfiguracoesControllerPage extends ControllerPage
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
      'session'    => false,      // [true] Somente usuário logado. [false] Qualquer pessoa.
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
      'html'     => 'lte',   // Template HTML
      'head'     => 'lte',   // <head> da página.
      'top'      => 'lte',   // Topo da página.
      'header'   => 'lte',   // Menu da página.
      'nav'      => 'lte',       // Menu da página.
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
      'title'            => 'Configurações',            // Título da página exibido na aba/janela navegador.
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
      'tables/BdTablesCreate',
      'tables/BdTablesDelete',
      'login/BdLogin',
      'login/BdLoginInsert',
      'users/BdUsers',
      'midia/BdMidia',
      'status/BdStatusInsert',
      'permissions/BdPermissionsInsert',
    );


    // Otimização das funções que serão usadas na controller.
    // Pasta classes.
    // Exemplo: 'Noticias',
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
    $this->paramsPage['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . __CLASS__ . '</b>.<br>';
    $this->paramsPage['post'] = $_POST;


    //print_r($_FILES);
    Midia::armazenar($_FILES['file'], null, null, true);
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
    // $this->paramsPage['nome'] = 'Mateus';
    //$this->paramsPage['users'] = BdUsers::selecionaTudo();

    // Como cadastrar midia.
    // $idmidia = Midia::add($_POST['imagem'], 'noticias', 'foto');
    // $urlFoto = Midia::get($idmidia);

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
    header('Content-Type: application/json; charset=utf-8;');

    /**
     * API Simples para executar algumas funções do BD.
     * todo: Talvez seja melhor implementar essas funções na API geral.
     */
    // Predefinição do resultado
    $r['r'] = 'Erro.';

    // Parametro.
    $parametro = $this->attr[1];


    // Primeiro parâmetro passado pela url após api.
    switch ($parametro) {
      case 'BdTablesCreate':
        if (class_exists("BdTablesCreate"))
          $r['r'] = BdTablesCreate::start();
        else
          $r['r'] = "Classe não instanciada.";
        break;
      case 'BdTablesDelete':
        if (class_exists("BdTablesDelete"))
          $r['r'] = BdTablesDelete::start();
        else
          $r['r'] = "Classe não instanciada.";
        break;
      case 'BdLoginInsert':
        if (class_exists("BdLoginInsert"))
          $r['r'] = BdLoginInsert::start();
        else
          $r['r'] = "Classe não instanciada.";
        break;
      case 'BdStatusInsert':
        if (class_exists("BdStatusInsert"))
          $r['r'] =  BdStatusInsert::start();
        else
          $r['r'] = "Classe não instanciada.";
        break;
      case 'BdPermissionsInsert':
        if (class_exists("BdStatusInsert"))
          $r['r'] =  BdPermissionsInsert::start();
        else
          $r['r'] = "Classe não instanciada.";
        break;
      default:
        $r['r'] = 'Erro. Parâmetro não definido.';
        break;
    }
    // Retorna json.
    echo json_encode($r);

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
}
