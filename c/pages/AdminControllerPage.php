<?php

class AdminControllerPage extends ControllerPage
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
      'html'        => 'lte',   // Template HTML
      'head'        => 'lte',   // <head> da página.
      'top'         => 'lte',   // Topo da página.
      'header'      => 'lte',   // Menu da página.
      'nav'      => 'lte',   // Menu da página.
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
      'title'             => 'Dashboard',                                         // Título da página exibido na aba/janela navegador.
      'author'            => 'Mateus Brust',                                      // Autor do desenvolvimento da página ou responsável.
      'description'       => 'Administração',                                     // Resumo do conteúdo do site apresentado nas prévias das buscas em até 90 carecteres.
      'keywords'          => 'modelo, página, controllers, views',                // palavras minúsculas separadas por "," referente ao conteúdo da página em até 150 caracteres.
      'content-language'  => 'pt-br',                                             // Linguagem primária da página (pt-br).
      'content-type'      => 'utf-8',                                             // Tipo de codificação da página.
      'reply-to'          => 'mateus.brust@coopama.com.br',                       // E-mail do responsável da página.
      'generator'         => 'vscode',                                            // Programa usado para gerar página.
      'refresh'           => '',                                                  // Tempo para recarregar a página.
      'redirect'          => '',                                                  // URL para redirecionar usuário após refresh.
      'obs'               => 'Cria um meta obs.',                                 // Outra qualquer observação sobre a página.
      'URL_RAIZ'          => URL_RAIZ,                                            // Path.
      'PATH_MODEL_ASSETS' => URL_RAIZ . PATH_MODEL_ASSETS,                        // Path.
      'PATH_MODEL_CSS'    => URL_RAIZ . PATH_MODEL_CSS,                           // Path.
      'PATH_MODEL_IMG'    => URL_RAIZ . PATH_MODEL_IMG,                           // Path.
      'PATH_MODEL_JS'     => URL_RAIZ . PATH_MODEL_JS,                            // Path.
      'PATH_MODEL_UPLOAD' => URL_RAIZ . PATH_MODEL_UPLOAD,                        // Path.
      'PATH_MODEL_ADMIN'  => URL_RAIZ . PATH_MODEL_ADMIN,                         // Path.
      'favicon'           => URL_RAIZ . PATH_MODEL_IMG . 'favicon_coopama.png',   // Imagem favicon.
      'apple-touch-icon'  => URL_RAIZ . PATH_MODEL_IMG . 'favicon_coopama.png',   // Imagem aple.
      'logo'              => URL_RAIZ . PATH_MODEL_IMG . 'logo_coopama.png',      // Imagem Logo.
      'anoAtual'          => date('Y'),                                           // Imagem Logo.
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
      'tables/BdTablesCreate',   // Criação de tabelas.
      'tables/BdTablesDelete',   // Criação de tabelas.
      'pages/BdPagesInsert',   // Criação de tabelas.
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
  public function view()
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










    /**
     * API Simples para executar algumas funções do BD.
     * todo: Talvez seja melhor implementar essas funções na API geral.
     */
    // Predefinição do resultado
    $r['r'] = 'Erro.';

    // Primeiro parâmetro passado pela url após api.
    switch ($this->attr[1]) {
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
      case 'BdPagesInsert':
        if (class_exists("BdPagesInsert"))
          $r['r'] = BdPagesInsert::start();
        else
          $r['r'] = "Classe não instanciada.";
        break;
      default:
        $r['r'] = 'Erro. Parâmetro não definido.';
        break;
    }







    // Retorna json.
    echo json_encode($r);
  }
}
