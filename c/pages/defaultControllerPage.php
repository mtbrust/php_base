<?php

/**
 * Controller defaul.
 * Usado para [v]views sem arquivo de controle.
 */
class DefaultControllerPage extends ControllerPage
{
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
      'html'        => 'default',   // Template HTML
      'head'        => 'default',   // <head> da página.
      'top'         => 'default',   // Topo da página.
      'header'      => 'default',   // Menu da página.
      //'corpo'        => 'default',   // Reservado para arquivo html.
      'body_pre'    => 'default',   // Antes do CORPO dentro body.
      'body_pos'    => 'default',   // Depois do CORPO dentro body.
      'footer'      => 'default',   // footer da página.
      'bottom'      => 'default',   // Fim da página.
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
      'title'             => 'Página Modelo',                                                         // Título da página exibido na aba/janela navegador.
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
      'pasta/BdArquivo',   // Exemplo
    );

  }
}