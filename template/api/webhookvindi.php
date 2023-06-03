<?php

namespace api;

/**
 * ORIENTAÇÕES DO MODELO PADRÃO
 * Modelo padrão de controller para o endpoint (páginas ou APIs).
 * Modelo contém todas as informações que são possíveis usar dentro de uma controller.
 * É possível tirar, acrescentar ou mudar parâmetros para obter resultados mais eficientes e personalizados.
 * 
 * ORIENTAÇÕES DA CONTROLLER
 * Os arquivos e classes são carregados após a função loadParams().
 * O método padrão para visualização é a index().
 * Na função index, é realizada toda a programação das informações do endpoint.
 * É possível chamar outras funções (Sub-Menus) usando parâmetros (Url e LoadParams).
 * Outras funções (Sub-Menus) são chamados de acordo com a estrutura personalizada no parâmetros "menus".
 * 
 * O nome da controller é o mesmo que o endpoint da url sem os "-".
 * Porém é possível passar pela url o endpoint "/quem-somos", pois o sistema irá tirar os "-".
 * O nome da controller vai ficar como "quemsomos".
 * 
 */
class webhookvindi extends \controllers\EndPoint
{

  /**
   * * *******************************************************************************************
   * PERSONALIZAÇÃO DO ENDPOINT
   * * *******************************************************************************************
   */


  /**
   * loadParams
   * Carrega os parâmetros de personalização do endpoint.
   * Valores Default vem da config.
   * 
   * * Opções com * podem ser modificadas no processamento.
   *
   * @return void
   */
  public function loadParams()
  {
    // Opções de renderização.
    self::$params['render']      = [
      // 'cache'        => false,                // Ativa uso de cache para resultado.
      'cacheTime'    => (60 * 30),            // Tempo para renovar cache em segundos. (30 Minutos).
      // 'cacheParams'    => true,       // Cache por parametros (attr).
      'content_type' => 'application/json',   // * Tipo do retorno padrão do cabeçalho http.
      // 'charset'      => 'utf-8',              // * Tipo de codificação do cabeçalho http.
    ];

    // Configuração personalizada do endpoins.
    self::$params['config']      = [
      // CONFIGURAÇÕES ENDPOINT
      // *********************
      // 'visita'    => true,        // Gravar registro de acesso.
      // 'bdParams'  => false,       // Parâmetros da controller vem do BD.
      // 'bdContent' => false,       // Conteúdo da página vem do BD.
      // 'versao'    => 'v1.0',      // Versão da controller atual.
      // 'feedback'  => true,        // FeedBack padrão de transações.
      // 'class'     => __CLASS__,   // Guarda classe atual


      // PAGES - INFORMAÇÕES ADICIONAIS PARA HEAD
      // *********************
      // Arquivo js ou css, o próprio código ou livre para acrescentar conteúdo na head.
      // 'head'           => '',   // Inclui antes de fechar a tag </head>
      // 'scriptHead'     => '',   // Escreve dentro de uma tag <script></script> antes da </head>.
      // 'scriptBody'     => '',   // Escreve dentro de uma tag <script></script> antes da </body>.
      // 'styleHead'      => '',   // Escreve dentro de uma tag <style></style> antes da </head>.
      // 'styleBody'      => '',   // Escreve dentro de uma tag <style></style> antes da </body>.


      // PAGES - INFORMAÇÕES DE SEO HTML
      // *********************
      // Informações que vão ser usadas para SEO na página.
      'title'            => \controllers\FriendlyUrl::getParameters('title_endpoint'),  // Título da página exibido na aba/janela navegador.
      // 'author'           => 'Mateus Brust',            // Autor do desenvolvimento da página ou responsável.
      // 'description'      => '',                        // Resumo do conteúdo do site em até 90 carecteres.
      // 'keywords'         => '',                        // palavras minúsculas separadas por "," em até 150 caracteres.
      // 'content_language' => 'pt-BR',                   // Linguagem primária da página (pt-br).
      // 'content_type'     => 'text/html',               // Tipo de codificação da página.
      // 'reply_to'         => 'contato@CETRUS.com.br',     // E-mail do responsável da página.
      // 'charset'          => 'utf-8',                   // Charset da página.
      // 'image'            => 'logo.png',                // Imagem redes sociais.
      // 'url'              => 'CETRUS',                    // Url para instagram.
      // 'site'             => 'CETRUS',                    // Site para twitter.
      // 'creator'          => 'CETRUS',                    // Perfil criador twitter.
      // 'author_article'   => 'CETRUS',                    // Autor do artigo da página atual.
      // 'generator'        => 'vscode',                  // Programa usado para gerar página.
      // 'refresh'          => false,                     // Tempo para recarregar a página.
      // 'redirect'         => false,                     // URL para redirecionar usuário após refresh.
      // 'favicon'          => 'favicon.ico',             // Imagem do favicon na página.
      // 'icon'             => 'favicon.ico',             // Imagem ícone da empresa na página.
      // 'appletouchicon'   => 'favicon.ico',             // Imagem da logo na página.
    ];

    // Opções de segurança.
    self::$params['security']    = [

      // // Controller usará controller de segurança.
      // 'ativo'             => true,

      // // Usuário só acessa logado.
      // 'session'           => false,

      // // Nome da sessão deste modulo (www).
      // 'sessionName'       => VC_PATHS['M_NAME'],

      // // Tempo para sessão acabar.
      // 'sessionTimeOut'    => (60 * 30),

      // // Caminho para página de login.
      // 'loginPage'         => '/' . VC_PATHS['DIR_BASE'] . VC_PATHS['M_NAME'] . '/login/', // Page login dentro do modelo.

      // // Caminho para página restrita.
      // 'restrictPage'      => '/' . VC_PATHS['DIR_BASE'] . VC_PATHS['M_NAME'] . '/admin/', // Page admin dentro do modelo.

      // // Permissões personalizadas da página atual. [9] Menu, Início, Adicionar, Editar, Listar (Básico), Listar Completo, Deletar, API, Testes.
      // 'permission'        => '111111111',

      // // Transações de dados (GET - POST) apenas com token. Usar classe Tokens. Exemplo: (<input name="token" type="text" value="{{token}}" hidden>').
      // 'token'             => true, // Só aceitar com token.

      // // FeedBack padrão de nível de acesso.
      // 'feedback'          => true,

      // // Receber transações externas. Dados de outras origens.
      // 'origin'            => [
      //     // 'v3.local',  // URL teste.
      // ],

      // // Grupos que tem permissão TOTAL a esta controller. Usar apenas para teste.
      // 'groups'            => [
      //     // 1, // Grupo ID: 1.
      // ],

      // // IDs que tem permissão TOTAL a esta controller. Usar apenas para teste.
      // 'ids'            => [
      //     // 1, // Login ID: 1.
      // ],
    ];

    // Informações extras.
    // Informações na config não podem ser modificadas no endpoint.
    // Informações adicionais podem ser modificadas no processamento.
    self::$params['info'] = [

      // Valor adicional
      // 'campo' => 'valor',


    ];

    // Carrega controllers de bancos de dados.
    self::$params['bds']         = [
      // 'BdResponsávelFinanceiro',
    ];

    // Carrega classes de apoio.
    self::$params['classes']     = [
      // 'Graficos',
      // 'Slugifi',
      // 'Midia',
    ];

    // Carrega controllers para reutilizar funções.
    self::$params['controllers'] = [
      // // Controllers de API
      // 'api' => [
      //     'v1/default',
      //     'modulo/controller',
      // ],

      // // Controllers de Páginas
      // 'pages' => [
      //     'teste/index',
      //     'modulo/controller',
      // ],
    ];

    // Monta estrutura de parâmetros passados na url.
    self::$params['menus']       = [
      // // Função:
      // 'index' => [
      //     'title'      => 'Início',      // Nome exibido no menu. Somente pages.
      //     'permission' => '110000000',   // Permissões necessárias para acesso.
      //     'groups'     => [],            // Quais grupos tem acesso a esse menu.
      //     'ids'        => [],            // Quais ids tem acesso a esse menu.
      // ],

      // // Função:
      // 'post' => [
      //     'title'      => 'Adicionar',   // Nome exibido no menu. Somente pages.
      //     'permission' => '101000000',   // Permissões necessárias para acesso.
      //     'groups'     => [],            // Quais grupos tem acesso a esse menu.
      //     'ids'        => [],            // Quais ids tem acesso a esse menu.
      // ],

      // // Função:
      // 'put' => [
      //     'title'      => 'Atualizar',   // Nome exibido no menu. Somente pages.
      //     'permission' => '100100000',   // Permissões necessárias para acesso.
      //     'groups'     => [],            // Quais grupos tem acesso a esse menu.
      //     'ids'        => [],            // Quais ids tem acesso a esse menu.
      // ],

      // // Função:
      // 'get' => [
      //     'title'      => 'Listar',      // Nome exibido no menu. Somente pages.
      //     'permission' => '100010000',   // Permissões necessárias para acesso.
      //     'groups'     => [],            // Quais grupos tem acesso a esse menu.
      //     'ids'        => [],            // Quais ids tem acesso a esse menu.
      // ],

      // // Função:
      // 'getfull' => [
      //     'title'      => 'Listar Completo',   // Nome exibido no menu. Somente pages.
      //     'permission' => '100001000',         // Permissões necessárias para acesso.
      //     'groups'     => [],                  // Quais grupos tem acesso a esse menu.
      //     'ids'        => [],                  // Quais ids tem acesso a esse menu.
      // ],

      // // Função:
      // 'delete' => [
      //     'title'      => 'Deletar',     // Nome exibido no menu. Somente pages.
      //     'permission' => '100000100',   // Permissões necessárias para acesso.
      //     'groups'     => [],            // Quais grupos tem acesso a esse menu.
      //     'ids'        => [],            // Quais ids tem acesso a esse menu.
      // ],

      // // Função:
      // 'test' => [
      //     'title'      => 'Teste',       // Nome exibido no menu. Somente pages.
      //     'permission' => '100000010',   // Permissões necessárias para acesso.
      //     'groups'     => [],            // Quais grupos tem acesso a esse menu.
      //     'ids'        => [],            // Quais ids tem acesso a esse menu.
      // ],

      // // Função:
      // 'dashboard' => [
      //     'title'      => 'Dash Board',   // Nome exibido no menu. Somente pages.
      //     'permission' => '110100010',    // Permissões necessárias para acesso.
      //     'groups'     => [3],            // Quais grupos tem acesso a esse menu.
      //     'ids'        => [],             // Quais ids tem acesso a esse menu.
      // ],
    ];

    // Carrega estrutura html. Somente pages.
    self::$params['structure']   = [
      // // Origem
      // 'html'        => 'default',   // Estrutura HTML geral.

      // // Complementos
      // 'head'         => 'default',   // <head> da página.
      // 'top'          => 'default',   // Logo após a tag <body>.
      // 'header'       => 'default',   // Após a estrutura "top".
      // 'nav'          => 'default',   // Dentro do header ou personalizado.
      // 'content_top'  => 'default',   // Antes do conteúdo da página.
      // 'content_page' => 'default',   // Reservado para conteúdo da página. Sobrescrito depois.
      // 'content_end'  => 'default',   // Depois do conteúdo da página.
      // 'footer'       => 'default',   // footer da página.
      // 'end'          => 'default',   // Fim da página.
    ];

    // Carrega na página scripts (template/assets/js/) Somente pages.
    self::$params['scripts']     = [
      'js' => [
        // 'jquery.min.js',   		// Exemplo.
      ],
      'libs' => [
        // 'lib/jquery.min.js',   		// Exemplo.
      ],
    ];

    // Carrega na página estilos (template/assets/css/) Somente pages.
    self::$params['styles']      = [
      // 'endpoint-min.css',   // Exemplo.
    ];

    // Carrega na página plugins (template/assets/css/) Somente pages.
    self::$params['plugins']     = [
      // 'modelo',   // Exemplo.
    ];
  }

  public function index()
  {

    self::$params['response'] = [
      'error' => false,
      'msg' => 'Entrou na função: ' . __FUNCTION__,
      'msg2' => 'Mensagem 2',
    ];

    
  }

  public function foo_personalizada()
  {
    self::$params['response'] = [
      'error' => false,
      'msg' => 'Entrou na função: ' . __FUNCTION__,
    ];
  }
}