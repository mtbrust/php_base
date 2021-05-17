<?php

/**
 * Modelo de controller para páginas.
 */
class PaginasControllerPage extends ControllerPage
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
      'title'            => 'Páginas',            // Título da página exibido na aba/janela navegador.
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
      'pages/BdPages',   // Acrescentado no core
    );


    // Otimização das funções que serão usadas na controller.
    // Pasta classes.
    // Exemplo: 'classes/Noticias',
    // Exemplo uso controller: $var = Noticias::getInfo();
    $this->paramsClasses = array(
      // 'classes/Noticias',   // Exemplo
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

    // Adiciona página individual.
    $this->adicionarPage();

    // Adiciona lista de páginas. (Adicionar todos)
    $this->adicionarPages();

    // Adiciona uma de páginas. (Adicionar este)
    $this->adicionarSinglePages();

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
    $this->paramsPage['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . __CLASS__ . '</b>.<br>';

    // Formulário de páginas.
    $list = $this->pagesDir();
    $this->paramsPage['obj_post'] = ControllerRender::renderObj('pages/post_page', $list);

    // Carrega os registros de páginas.
    $pages = BdPages::selecionaTudo();

    // Monta a tabela de páginas.
    $html = $this->tablePages($list, $pages);
    $this->paramsPage['obj_post_dir'] = ControllerRender::renderObj('pages/post_dir_pages', $html);


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
    $this->paramsPage['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . __CLASS__ . '</b>.<br>';
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
    $params['dados'] = BdPages::selecionaTudo();
    // Monta as colunas.
    //$params['colunas'] = ['ID', 'Matricula', 'ID_Usuário', 'ID_Grupo', 'Nome_Completo', 'Primeiro_Nome', 'Último_Nome', 'E-Mail', 'Usuário', 'CPF', 'Telefone', 'Ativo', 'Status', 'Observações']; // Caso precise ajustar os nomes das colunas.
    // Obtém a datatable html.
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
    return true;
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

    $this->paramsPage['rest'] = 'Implementar função <b>' . __FUNCTION__ . '</b> da classe <b>' . $this->controllerName . __CLASS__ . '</b>.<br>';
    return true;
  }







  /**
   * Busca as páginas e ordena dentro do diretório pages.
   * Retorna um array com [bd,dir,page,url] de cada página.
   *
   * @return void
   */
  public function pagesDir()
  {
    //header('Content-Type: application/json');
    $list = $this->recursivePagesDir();

    // Compara se $a é maior que $b
    function cmpUrl($a, $b)
    {
      return $a['url'] > $b['url'];
    }

    // Compara se $a é maior que $b
    function cmpDir($a, $b)
    {
      return $a['dir'] > $b['dir'];
    }

    // Ordena
    usort($list, 'cmpDir');
    usort($list, 'cmpUrl');

    return $list;
  }



  /**
   * Páginas do diretório recursivo.
   * Retorna um array com [bd,dir,page,url] de cada página.
   *
   * @param integer $i
   * @param array $list
   * @param string $path
   * @param string $dir
   * @return array
   */
  public function recursivePagesDir($i = 0, $list = array(), $path = DIR_RAIZ . PATH_VIEW_PAGES, $dir = '')
  {
    // Carrega objeto de diretório.
    $diretorio = dir($path . $dir);

    // Anda pelos itens dentro de $diretório.
    while ($arquivo = $diretorio->read()) {

      // Caso não seja '.' (Pasta atual) nem '..' (Pasta anterior), segue o código.
      if ($arquivo != '.' && $arquivo != '..') {
        // Verifica se é um diretório.
        if (is_dir($path . $dir . $arquivo)) {
          // Entra novamente na função com a pasta atual e retorna o array (lista de arquivos).
          $list = $this->recursivePagesDir($i, $list, $path, $dir . $arquivo . '/');
          // Continua da posição que parou após o recursivo.
          $i = count($list);
        } else {
          $file = explode('.', $arquivo);
          if ($file[1] == "html") {
            // Cadastra o arquivo na próxima posição do array.
            $list[$i]['bd'] = false;
            $list[$i]['dir'] = $dir;
            $list[$i]['page'] = $arquivo;
            $list[$i]['url'] = $dir . $file[0] . '/';
          }
        }
        // Anda mais uma posição do array.
        $i++;
      }
    }
    // Fecha diretório.
    $diretorio->close();

    // Retorna array.
    return $list;
  }


  /**
   * Cria uma tabela HTML com os valores do array de páginas.
   *
   * @param array $list
   * @return string
   */
  public function tablePages($list, $pages)
  {
    // Início da tabela.
    $html = "<div class='table-responsive p-0'><table class='table table-hover table-hover text-nowrap table-bordered'>
    <thead>
    <tr>
      <th>ID</th>
      <th>BD</th>
      <th>Diretório</th>
      <th>Página</th>
      <th>Url</th>
      <th>Cadastrar</th>
    </tr>
    </thead>
    <tbody>";

    // Inicia a criação das linhas da tabela.
    foreach ($list as $key => $value) {
      $i_checkbox = '<td><input type="checkbox" name="bd_' . $key . '" id="" value="1"></td>';
      $i_btn = '<td><button type="submit" name="adicionar" value="page_' . $value['url'] . '" class="btn btn-success"><i class="fas fa-plus-circle"></i> Adicionar Este</button></td>';
      foreach ($pages as $page) {
        if ($page['url'] == $value['url']) {
          $i_checkbox = '<td><input type="checkbox" name="bd_' . $key . '" id="" value="1" checked disabled></td>';
          $i_btn = '<td><button type="submit" name="adicionar" value="page_' . $value['url'] . '" class="btn btn-success disabled"><i class="fas fa-plus-circle"></i> Adicionar Este</button></td>';
        }
      }
      $html .= '<tr>';
      $html .= '<td>' . $key . '</td>';
      $html .= $i_checkbox;
      $html .= '<td>' . $value['dir'] . '</td>';
      $html .= '<td>' . $value['page'] . '</td>';
      $html .= '<td>' . $value['url'] . '<input type="text" name="url_' . $key . '" value="' . $value['url'] . '" hidden></td>';
      $html .= $i_btn;
      $html .= '</tr>';
    }

    // Finaliza tabela.
    $html .= "</tbody></table></div>";
    $html .= '<input type="text" name="qtd" value="' . count($list) . '" hidden>';


    return $html;
  }


  /**
   * Função para adicionar novo registro.
   *
   * @return bool
   */
  public static function adicionarPage()
  {


    // Verifica se foi o submit de adicionar.
    if (isset($_POST['adicionar']) && $_POST['adicionar'] == "page") {

      // Retorno da função.
      $id = false;

      // Verifica se os campos obrigatórios foram preenchidos.
      if (!empty($_POST['f-nome']) && !empty($_POST['f-url'])) {

        $permission = '00000';
        $permission[0] = (isset($_POST['f-menu'])) ? 1 : 0;
        $permission[1] = (isset($_POST['f-post'])) ? 1 : 0;
        $permission[2] = (isset($_POST['f-put'])) ? 1 : 0;
        $permission[3] = (isset($_POST['f-get'])) ? 1 : 0;
        $permission[4] = (isset($_POST['f-delete'])) ? 1 : 0;

        $paramsSecurity = [
          'session'    => true,      // [true] Somente usuário logado. [false] Qualquer pessoa.
          'permission' => $permission,   // [1,0,0,0,0] Menu/Início, Adicionar, Editar, Listar, Deletar.
        ];

        // Monta os campos e os valores.
        $fields = [
          'nome' => $_POST['f-nome'],
          'url' => $_POST['f-url'],
          'paramsSecurity' => serialize($paramsSecurity),
          'idStatus' => 1,

          // Controle
          'dtCreate' => date("Y-m-d H:i:s"),
        ];

        // header('Content-Type: application/json');
        // print_r($fields);
        // print_r(unserialize($fields['paramsSecurity']));
        // //print_r($_POST);
        // exit;

        // Executa o INSERT.
        $id = BdPages::Adicionar($fields);
        if (!$id)
          return false;
      }

      // Caso ocorra tudo certo com a inserção.
      return $id;
    }
  }


  /**
   * Função para adicionar novo registro.
   *
   * @return bool
   */
  public static function adicionarPages()
  {

    // Verifica se foi o submit de adicionar.
    if (isset($_POST['adicionar']) && $_POST['adicionar'] == "pages") {

      // Retorno da função.
      $id = false;

      // Para bloquear todos os acessos. Usado na refatoração do sistema. Caso perca todos os cadastros.
      $permission = '00000';

      // Padrão para conteúdo do campo.
      $paramsSecurity = [
        'session'    => true,      // [true] Somente usuário logado. [false] Qualquer pessoa.
        'permission' => $permission,   // [1,0,0,0,0] Menu/Início, Adicionar, Editar, Listar, Deletar.
      ];

      // Transforma em string.
      $paramsSecurity = serialize($paramsSecurity);

      $result = true;

      // Pega a quantidade de registros.
      $qtd = (isset($_POST['qtd'])) ? $_POST['qtd'] : -1;
      // Percorre todos os registros.
      while ($qtd >= 0) {
        // Verifica se registro foi selecionado.
        if (isset($_POST['bd_' . $qtd])) {

          // Monta os campos e os valores.
          $fields = [
            'nome' => $_POST['url_' . $qtd],
            'url' => $_POST['url_' . $qtd],
            'paramsSecurity' => $paramsSecurity,
            'idStatus' => 1,

            // Controle
            'dtCreate' => date("Y-m-d H:i:s"),
          ];

          // print_r($fields);
          // exit;

          // Realiza o insert.
          $id = BdPages::Adicionar($fields);
          if (!$id)
            $result = false;
        }
        $qtd--;
      };

      // Verifica se deu erro em algum registro.
      if (!$result)
        return false;

      // Caso ocorra tudo certo com a inserção.
      return true;
    }
  }


  /**
   * Função para adicionar novo registro.
   *
   * @return bool
   */
  public static function adicionarSinglePages()
  {


    // Verifica se foi o submit de adicionar.
    if (isset($_POST['adicionar']) && $_POST['adicionar'] != 'page' && explode('_', $_POST['adicionar'])[0] == "page") {

      // Retorno da função.
      $page = explode('_', $_POST['adicionar'])[1];


      $permission = '00000';

      $paramsSecurity = [
        'session'    => true,      // [true] Somente usuário logado. [false] Qualquer pessoa.
        'permission' => $permission,   // [1,0,0,0,0] Menu/Início, Adicionar, Editar, Listar, Deletar.
      ];

      // Monta os campos e os valores.
      $fields = [
        'nome' => $page,
        'url' => $page,
        'paramsSecurity' => serialize($paramsSecurity),
        'idStatus' => 1,

        // Controle
        'dtCreate' => date("Y-m-d H:i:s"),
      ];

      // header('Content-Type: application/json');
      // print_r($fields);
      // print_r(unserialize($fields['paramsSecurity']));
      // //print_r($_POST);
      // exit;

      // Executa o INSERT.
      $id = BdPages::Adicionar($fields);
      if (!$id)
        return false;

      // Caso ocorra tudo certo com a inserção.
      return $id;
    }
  }
}
