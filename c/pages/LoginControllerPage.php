<?php

class LoginControllerPage extends ControllerPage
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
      'session'    => false,          // [true] Somente usuário logado. [false] Qualquer usuário.
      'permission' => '100000000',   // [9] Menu, Início, Adicionar, Editar, Listar (Básico), Listar Completo, Deletar, API, Testes.
      'formToken'  => false,         // Ativa necessidade de token para transações de formulários via post. usar parametro:($this->paramsPage['formToken']) input text: (<input name="f-formToken" type="text" value="{{formToken}}" hidden>').
    );

    // Valores default de $paramsTemplate a partir da pasta template.
    $this->params['template'] = array(
      'html'        => 'login',   // Template HTML
      'head'        => 'login',   // <head> da página.
      // 'top'         => 'default',   // Topo da página.
      // 'header'      => 'default',   // Menu da página.
      // 'corpo'        => 'default',   // Reservado para arquivo html.
      // 'body_pre'    => 'default',   // Antes do CORPO dentro body.
      // 'body_pos'    => 'default',   // Depois do CORPO dentro body.
      // 'footer'      => 'default',   // footer da página.
      // 'bottom'      => 'default',   // Fim da página.
      //'maintenance' => 'paper',   // Página de manutenção (quando controller true).
    );

    // Valores para configurações da página html.
    // https://www.infowester.com/metatags.php
    $this->params['view'] = array(
      'title'            => 'Login',                    // Título da página exibido na aba/janela navegador.
      'author'           => 'COOPAMA',         // Autor do desenvolvimento da página ou responsável.
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
      'versão'              => 'v1.0',            // Exemplo
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

    // Verifica se teve post.
    if ($_POST) {
      // Tratativa dos dados
      $login = $_POST['login'];
      $senha = md5($_POST['senha']);

      // Busca no banco de dados. e inicia a sessão.
      $user = BdLogin::verificaLogin($login, $senha);
      ControllerSecurity::create($user);
    }


    // Verifica se foi passado parametro de sair na url.
    if ($this->attr && isset($this->attr[0]) && $this->attr[0] == 'sair') {
      ControllerSecurity::sair();
    }

    return true;
  }
}
