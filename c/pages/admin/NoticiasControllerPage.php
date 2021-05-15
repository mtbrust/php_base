<?php

class NoticiasControllerPage extends ControllerPage
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
      'html'     => 'lte',       // Template HTML
      'head'     => 'lte',       // <head> da página.
      'top'      => 'lte',       // Topo da página.
      'header'   => 'lte',       // Menu da página.
      'nav'      => 'lte',       // Menu da página.
      // 'corpo'    => 'default',   // Reservado para arquivo html.
      'body_pre' => 'lte',       // Antes do CORPO dentro body.
      'body_pos' => 'lte',       // Depois do CORPO dentro body.
      'footer'   => 'lte',       // footer da página.
      'bottom'   => 'lte',       // Fim da página.
      //'maintenance' => 'manutencao',   // Página de manutenção (quando controller true).
    );

    // Objetos para serem inseridos dentro de partes do template.
    // O Processamento realiza a montagem. Algum template tem que conter um bloco para Obj ser incluido.
    $this->paramsTemplateObjs = array(
      'objeto_apelido'          => 'html',   // Carrega HTML do objeto e coloca no lugar indicado do corpo ou template.
      'pagina'                  => 'dataTable',
    );

    // Valores default de $paramsView. Valores vazios são ignorados.
    //https://www.infowester.com/metatags.php
    $this->paramsView = array(
      'title'             => 'Notícias',                                                         // Título da página exibido na aba/janela navegador.
      'author'            => 'COOPAMA',                                                          // Autor do desenvolvimento da página ou responsável.
      'description'       => '',   // Resumo do conteúdo do site apresentado nas prévias das buscas em até 90 carecteres.
      'keywords'          => '',                                    // palavras minúsculas separadas por "," referente ao conteúdo da página em até 150 caracteres.
      'content-language'  => 'pt-br',                                                                 // Linguagem primária da página (pt-br).
      'content-type'      => 'utf-8',                                                                 // Tipo de codificação da página.
      'reply-to'          => 'suporte@coopama.com.br',                                           // E-mail do responsável da página.
      'generator'         => 'vscode',                                                                // Programa usado para gerar página.
      'refresh'           => '',                                                                      // Tempo para recarregar a página.
      'redirect'          => '',                                                                      // URL para redirecionar usuário após refresh.
      'obs'               => 'Cria um meta obs.',                                                     // Outra qualquer observação sobre a página.
    );




    // Valores para serem inseridos no corpo da página.
    // Exemplo: 'p_nome' => 'Mateus',
    // Exemplo uso na view: <p><b>Nome: </b> {{p_nome}}</p>
    $this->paramsPage = array(
      'versão'              => 'v1.0',            // Exemplo
    );


    // Otimização das funções de banco de dados que serão usadas na controller.
    // Pasta BD.
    // Exemplo: 'noticias/BdNoticias',
    // Exemplo uso controller: $var = BdUsuarios::getInfo();
    $this->paramsBd = array(
      'noticias/BdNoticias',
      'noticias/BdNoticiasInsert',
      'midia/BdMidia',
    );


    // Otimização das funções que serão usadas na controller.
    // Pasta classes.
    // Exemplo: 'Noticias',
    // Exemplo uso controller: $var = Noticias::getInfo();
    $this->paramsClasses = array(
      'Noticias',   // Exemplo
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

      Self::novaNoticia();//realiza a ação de criar uma nova notícia
      Self::ativaNoticia(42,1);// ativa a notícia partindo do principío que ela inicia desativada
      Self::editarNoticia();// realiza a ação de editar a notícia

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
      Self::ativaNoticia(42,1);
      Self::fixaTopo(51);
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
      $this->paramsPage['noticia_id'] = $this->attr[1];// Seleciona a página de notícias por id atribuindo o valor 1 ao selecionavel
      $this->paramsPage['noticia'] = BdNoticias::selecionaPorId($this->attr[1]);// Faz a busca no BdNoticias utilizando a função selecionaPorId buscando atributo 1
      $this->paramsPage['noticia']['dataPostagem'] = date('Y-m-d' ,strtotime($this->paramsPage['noticia']['dataPostagem']));// Faz a busca na notícia pela dataPostagem formatando ela para Ano, Mês e Dia e devolvendo no campo do mesmo nome no form
      $r = BdMidia::selecionaPorId($this->paramsPage['noticia']['idFoto']);// Faz a busca no BdMidia utilizando a função selecionaPorId procurando na noticia o param idFoto
      if ($r) {
          $this->paramsPage['noticia']['nomeMidia'] = BdMidia::selecionaPorId($this->paramsPage['noticia']['idFoto'])['nome'];//Define que utilazando a função selecionaPorId se faça uma busca no BdMidia e se obtenha o id da imagem com o nome dela
          $this->paramsPage['noticia']['imagemDestaque'] = $r['urlMidia'];// Se $r existir significa que a noticia selecionada tem uma umagem relacionada a ela então se realiza a alteração e grava no BdMidia
      }
      $this->paramsPage['obj_editar_noticia'] = ControllerRender::renderObj('noticias/editar', $this->paramsPage['noticia']);// Cria o obj_edtiar_noticia que define a localização da página e o param relacionado a ela
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

      //Listar todas as Noticias
      $params['URL_RAIZ'] = URL_RAIZ;// Onde será feita a busca
      $params['noticias'] = BdNoticias::selecionaTudo();// Dentro do BdNoticias será aplica a função selecionaTudo
      //$params['nomeMidia'] = BdMidia::selecionaPorId($params['noticias']['idFoto'])['nome'];
      $html = ControllerRender::renderObj('datatable', $params);// Depois de tudo selecionado será exibido na page datatable
      $this->paramsTemplateObjs['p_lista'] = $html;// Cria uma lista para realizar a exibição
      $this->paramsPage['noticias'] = BdNoticias::selecionaTudo();// Outra vez dentro de BdNoticias aplica a função selecionaTudo com a chave noticias
  }


  /**
   * Deleta um registro.
   * Usado para deletar um usuário ou classificá-lo como excluido.
   *
   * @return bool
   */
  public function delete()
  {


      $this->paramsPage['noticia_id'] = $this->attr[1];//seleciona a noticia por id e partindo de um atributo 1
      $this->paramsPage['noticia'] = BdNoticias::selecionaPorId($this->attr[1]);
      BdNoticias::deleta($this->attr[1]);//deleta a noticia com atributo 1
      Midia::deletar($this->paramsPage['noticia']['idFoto']);//deleta midia relaciona a noticia excluida

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


  public static function novaNoticia()
  {
      if (!empty($_POST['adicionar'])) {

          //print_r($_POST);
          //exit();


              if (!empty($_POST['titulo']) && !empty($_POST['previa']) && !empty($_POST['texto'])) {

                  //Trabalha a data nesse trecho
                  $date = $_POST['dataPostagem'];//Atribui a variavel $date o post recebido da chave dataPostagem
                      $hour = date('H:i:s');//Atribui a variavel $hour, utilizando a função reservada date que faz a formatação, os valores de horas, minutos e segundos
                      $date = date('Y-m-d H:i:s',strtotime($date . $hour));//Atribui a variavel $date utilizando a função date ano, mês, dia, hora, minuto e segundo utilizando a função strtotime para converter e concatenar as variaveis $date e $hour

                  //Nesse trecho recebemos os campos preenchidos do form
                  $fields = [
                      'titulo' => $_POST['titulo'],
                      'previa' => $_POST['previa'],
                      'texto' => $_POST['texto'],
                      'dataPostagem' => $date,
                      'idFoto' => Midia::armazenar($_FILES['imagemDestaque'], null, 'noticias/'),// idFoto recebemos como imagemDestaque do form salvamos no banco Midia utilizando a função armazenas
                      'idStatus' => (isset($_POST['idStatus'])) ? 1 : 0,// Ao idStatus recebido defino que será 1(sim) ou 2(não)
                      'fixaTopo' => (isset($_POST['fixaTopo'])) ? 1 : 2// Ao fixaTopo recebido defino que será 1(sim) ou 2(não)
                  ];

                  //Trecho que contém a função adicionar que é auto explicativa. Ela recebe os campos passados acima
                  if (!BdNoticias::Adicionar($fields)) {
                      return false;
                      //exit();
                  }
              }
              return true;

      }
  }


    /**
     * Função para definir se é uma noticia ativa ou não
     * Se ativa é exibida junto com as outras senão fica oculta
     */


    public static function ativaNoticia($codNoticia, $idStatus = '1')
    {

        BdNoticias::executeQuery("UPDATE coopama_noticias SET idStatus = $idStatus WHERE id = " . (int)$codNoticia);

    }



    /**
     * Função para editar uma noticia registrada
     */


    public static function editarNoticia()
    {
        $date = $_POST['dataPostagem'];
        $hour = date(" H:i:s");
        $date = date("Y-m-d H:i:s",strtotime($date . $hour));

        if (!empty($_POST['editar'])) {
            $id = $_POST['editar'];
            $fields = [
                'titulo' => $_POST['titulo'],
                'previa' => $_POST['previa'],
                'texto' => $_POST['texto'],
                'dataPostagem' => $date,
                'idFoto' => Midia::armazenar($_FILES['imagemDestaque'], null, 'noticias/'),
                'idStatus' => (isset($_POST['idStatus'])) ? 1 : 2,
                'fixaTopo' => (isset($_POST['fixaTopo'])) ? 1 : 2
            ];
            BdNoticias::atualiza($id, $fields);
        }
    }



    /**
     * Função para definir se ficará no topo ou não
     * Apenas uma notícia fica no topo
     */

    public static function fixaTopo($codNoticia){
        Self::desfixaTopo();
        BdNoticias::executeQuery("UPDATE coopama_noticias SET fixaTopo = '1' WHERE id = " .(int)$codNoticia);
    }



    /**
     * Função genérica para tirar uma notícia do topo
     * Inicialmente ela é usada na função de fixar no topo
     */

    public static function desfixaTopo(){
        BdNoticias::executeQuery("UPDATE coopama_noticias SET fixaTopo = '0' WHERE fixaTopo = '1'");
    }
}
