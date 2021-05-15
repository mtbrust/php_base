<?php

/**
 * Modelo de controller para páginas.
 */
class BannersControllerPage extends ControllerPage
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
      'title'            => 'Banners',            // Título da página exibido na aba/janela navegador.
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
      'banners/BdBanners',

    );
    

    // Otimização das funções que serão usadas na controller.
    // Pasta classes.
    // Exemplo: 'classes/Noticias',
    // Exemplo uso controller: $var = Noticias::getInfo();
    $this->paramsClasses = array(
      'Midia',
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

    Self::novoBanner();
    $this->editaBanner();
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
      $this->paramsPage['banner_id'] = $this->attr[1];// Seleciona a página de notícias por id atribuindo o valor 1 ao selecionavel
      $this->paramsPage['banner'] = BdBanners::selecionaPorId($this->attr[1]);// Faz a busca no BdNoticias utilizando a função selecionaPorId buscando atributo 1
      //$this->paramsPage['noticia']['dataPostagem'] = date('Y-m-d' ,strtotime($this->paramsPage['noticia']['dataPostagem']));// Faz a busca na notícia pela dataPostagem formatando ela para Ano, Mês e Dia e devolvendo no campo do mesmo nome no form
      $r = BdMidia::selecionaPorId($this->paramsPage['banner']['idFoto']);// Faz a busca no BdMidia utilizando a função selecionaPorId procurando na noticia o param idFoto
      if ($r) {
          $this->paramsPage['banner']['nomeMidia'] = $r['nome'];//Define que utilazando a função selecionaPorId se faça uma busca no BdMidia e se obtenha o id da imagem com o nome dela
          $this->paramsPage['banner']['imagemDestaque'] = $r['urlMidia'];// Se $r existir significa que a noticia selecionada tem uma umagem relacionada a ela então se realiza a alteração e grava no BdMidia
      }
      $this->paramsPage['obj_editar_banner'] = ControllerRender::renderObj('banners/editar', $this->paramsPage['banner']);// Cria o obj_edtiar_noticia que define a localização da página e o param relacionado a ela
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
    //Lista todos os banners
    $params['URL_RAIZ'] = URL_RAIZ;
    $params['banners'] = BdBanners::selecionaTudo();
    $i = 0;
    foreach ($params['banners'] as $value){
        echo $value['idFoto'];
        if (isset($value['idFoto']))
        $params['banners'][$i]['urlMidia'] = BdMidia::selecionaPorId($value['idFoto'])['urlMidia'];
        $i++;
  }
    $html = ControllerRender::renderObj('listabanner', $params);
    $this->paramsTemplateObjs['lista'] = $html;
    $this->paramsPage['banners'] = BdBanners::selecionaTudo();
  }


  /**
   * Deleta um registro.
   * Usado para deletar um usuário ou classificá-lo como excluido.
   *
   * @return bool
   */
  public function delete()
  {
   $this->paramsPage['banner_id'] = $this->attr[1];
   $this->paramsPage['banners'] = BdBanners::selecionaPorId($this->attr[1]);
   BdBanners::deleta($this->attr[1]);
   Midia::deletar($this->paramsPage['banners']['idFoto']);
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

  public static function novoBanner(){
      //print_r($_POST);
      //exit();
      if (!empty($_POST['add'])){

          if (!empty($_POST['titulo'] && !empty($_FILES['imagemBanner']))){
              $fields = [
                  'titulo' => $_POST['titulo'],
                  'link' => $_POST['link'],
                  'idFoto' => Midia::armazenar($_FILES['imagemBanner'], null, 'banners/'),
                  'idStatus' => (isset($_POST['idStatus'])) ? 1:2
              ];

              if (!BdBanners::Adicionar($fields)){
                  return false;
              }
          }
      }

      return true;
  }


  public  function editaBanner(){
      //print_r($_POST);
      //exit();
      if (!empty($_POST['editar'])){
          $id = $this->attr[1];
          $idFoto = Midia::armazenar($_FILES['imagemBanner'], null, 'banners/');

          $fields = [
              'titulo' => $_POST['titulo'],
              'link' => $_POST['link'],
              'idFoto' => $idFoto,
              'idStatus' => (isset($_POST['idStatus'])) ? 1:2
          ];



          BdBanners::atualiza($id, $fields);
      }
  }
}
