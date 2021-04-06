<?php

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
      'title'             => 'Configurações',                                                         // Título da página exibido na aba/janela navegador.
      'author'            => 'Mateus Brust',                                                          // Autor do desenvolvimento da página ou responsável.
      'description'       => 'Página criada para mostrar como é a criação de controllers e views.',   // Resumo do conteúdo do site apresentado nas prévias das buscas em até 90 carecteres.
      'keywords'          => 'modelo, página, controllers, views',                                    // palavras minúsculas separadas por "," referente ao conteúdo da página em até 150 caracteres.
      'content-language'  => 'pt-br',                                                                 // Linguagem primária da página (pt-br).
      'content-type'      => 'utf-8',                                                                 // Tipo de codificação da página.
      'reply-to'          => 'mateus.brust@coopama.com.br',                                           // E-mail do responsável da página.
      'generator'         => 'vscode',                                                                // Programa usado para gerar página.
      'refresh'           => '',                                                                      // Tempo para recarregar a página.
      'redirect'          => '',                                                                      // URL para redirecionar usuário após refresh.
      'obs'               => 'Cria um meta obs.',                                                     // Outra qualquer observação sobre a página.
      'PATH_MODEL_ASSETS' => URL_RAIZ . PATH_MODEL_ASSETS,                                            // Path.
      'PATH_MODEL_CSS'    => URL_RAIZ . PATH_MODEL_CSS,                                               // Path.
      'PATH_MODEL_IMG'    => URL_RAIZ . PATH_MODEL_IMG,                                               // Path.
      'PATH_MODEL_JS'     => URL_RAIZ . PATH_MODEL_JS,                                                // Path.
      'PATH_MODEL_UPLOAD' => URL_RAIZ . PATH_MODEL_UPLOAD,                                            // Path.
      'PATH_MODEL_ADMIN'  => URL_RAIZ . PATH_MODEL_ADMIN,                                             // Path.
      'favicon'           => URL_RAIZ . PATH_MODEL_IMG . 'favicon_coopama.png',                       // Imagem favicon.
      'apple-touch-icon'  => URL_RAIZ . PATH_MODEL_IMG . 'favicon_coopama.png',                       // Imagem aple.
      'logo'              => URL_RAIZ . PATH_MODEL_IMG . 'logo_coopama.png',                          // Imagem Logo.
      'anoAtual'          => date('Y'),                                                               // Imagem Logo.
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
    // Exemplo uso controller: $var = BdUsuarios::getInfo();
    $this->paramsBd = array(
      'tables' => 'BdTablesCreate',   // Exemplo
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
    echo '_POST - MODELO<br>';
    var_dump($_POST);

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
    echo 'POST - MODELO<br>';
    print_r($this->attr);

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
    echo 'PUT - MODELO<br>';
    print_r($this->attr);

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
    echo 'GET - MODELO<br>';
    print_r($this->attr);

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
    echo 'DELETE - MODELO<br>';
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
}