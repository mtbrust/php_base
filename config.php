<?php

/**
 * * BASE_NAME
 * Nome do Framework
 * Não usar espaços e caracteres especiais.
 */
define('BASE_NAME', 'BASE_PHP');


/**
 * * BASE_DOMAIN
 * Nome do Domínio
 * (localhost, www.dominio.com.br, etc.)
 */
define('BASE_DOMAIN', $_SERVER['SERVER_NAME']);


/**
 * * BASE_URL
 * URL Atual do projeto 
 * Exemplos do que pode conter:
 * (localhost, vhost, www.domínio.com.br, localhost/pasta/, www.domínio.com.br/pasta/, etc.)
 * Usado para definir variáveis de ambiente (DEV, HOMOLOG, PROD)
 */
define('BASE_URL', 'http' . ((isset($_SERVER['HTTPS'])) ? 's' : '') . '://' . $_SERVER['SERVER_NAME'] . str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));


/**
 * * BASE_DIR
 * Diretório Atual do projeto. 
 * (Caminho completo para pasta raíz deste projeto)
 */
define('BASE_DIR', str_replace('\\', '/', realpath(dirname(__FILE__))) . '/');


/**
 * * BASE_DIR_RELATIVE
 * Diretório relativo do projeto. 
 * (Caminho relativo deste projeto, caso não seja um dómínio direto, pega o caminho para a index.)
 */
define('BASE_DIR_RELATIVE', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));


/**
 * * BASE_IP
 * Ip do usuário atual
 * (::1, 127.0.0.1, 192.168.0.1, 60.0.0.123, etc.)
 */
define('BASE_IP', $_SERVER['SERVER_ADDR']);


/**
 * * BASE_PATH_PAGES_CONTROLLERS
 * Caminho base para as páginas php.
 */
define('BASE_PATH_PAGES_CONTROLLERS', 'template/pages/c/');


/**
 * * BASE_PATH_PAGES_VIEWS
 * Caminho base para as páginas html (twig).
 */
define('BASE_PATH_PAGES_VIEWS', 'template/pages/v/');


/**
 * * BASE_PATH_API
 * Caminho base para os endpoints.
 */
define('BASE_PATH_API', 'template/api/');


/**
 * * AMBIENTE
 * Personalização do ambiente automaticamente pela base URL.
 */
switch (BASE_URL) {

    // Ambiente de Homologação.
  case 'HOMOLOG':   // Para forçar valor no Switch.
  case 'http://basephp.desv.com.br/':   // basephp.com.br
  case 'https://basephp.desv.com.br/':   // basephp.com.br
    // Define nome do ambiente.
    define("BASE_ENV", "HOMOLOG");
    // Carrega configurações personalizadas.
    require_once('env-homolog.php');
    break;

    // Ambiente de Produção.
  case 'DEV':   // Para forçar valor no Switch.
  case 'http://basephp.local/':   
  case 'https://basephp.local/':   
    // Define nome do ambiente.
    define("BASE_ENV", "DEV");
    // Carrega configurações personalizadas.
    require_once('env-development.php');
    break;

    // Ambiente de Desenvolvimento.
  default:
  // Define nome do ambiente.
    define("BASE_ENV", "PROD");
    // Carrega configurações personalizadas.
    require_once('env-production.php');
    break;
}


/**
 * * BANCO DE DADOS
 * Conexão com os bancos de dados de acordo com ambiente.
 */
switch (BASE_ENV) {
    // Ambiente de Desenvolvimento.
  case 'DEV':
    define("BASE_BDS", [
      [
        'TITLE'    => 'VINDI HOMOLOGAÇÃO',
        'ACTIVE'     => true,
        'DBMANAGER' => 'mysql',
        'HOST'      => '192.168.0.12',
        'PORT'      => '3306',
        'USERNAME'  => 'vindi_homolog',
        'PASSWORD'  => 'Sp_H0m0l@2019',
        'DATABASE'  => 'vindi_homolog',
        'CHARSET'   => 'utf8',
        'PREFIX'    => '',
      ],
      [
        'TITLE'     => 'VINDI LOCAL DEV',
        'ACTIVE'     => true,
        'DBMANAGER' => 'mysql',
        'HOST'      => 'localhost',
        'PORT'      => '3306',
        'USERNAME'  => 'root',
        'PASSWORD'  => '',
        'DATABASE'  => 'vindi_api',
        'CHARSET'   => 'utf8',
        'PREFIX'    => 'vindi_',
      ],
      [
        'TITLE'     => 'VINDI LOCAL DEV', // Exemplo.
        'ACTIVE'     => true,
        'DBMANAGER' => 'mysql',
        'HOST'      => 'localhost',
        'PORT'      => '3306',
        'USERNAME'  => 'root',
        'PASSWORD'  => '',
        'DATABASE'  => 'vindi_api',
        'CHARSET'   => 'utf8',
        'PREFIX'    => 'vindi_',
      ],
    ]);
    break;

    // Ambiente de Homologação.
  case 'HOMOLOG':
    define("BASE_BDS", [
      [
        'TITLE'    => 'VINDI HOMOLOGAÇÃO',
        'ACTIVE'     => true,
        'DBMANAGER' => 'mysql',
        'HOST'      => '192.168.0.12',
        'PORT'      => '3306',
        'USERNAME'  => 'vindi_homolog',
        'PASSWORD'  => 'Sp_H0m0l@2019',
        'DATABASE'  => 'vindi_homolog',
        'CHARSET'   => 'utf8',
        'PREFIX'    => '',
      ],
      [
        'TITLE'    => 'VINDI HOMOLOGAÇÃO',
        'ACTIVE'     => true,
        'DBMANAGER' => 'mysql',
        'HOST'      => '192.168.0.12',
        'PORT'      => '3306',
        'USERNAME'  => 'vindi_homolog',
        'PASSWORD'  => 'Sp_H0m0l@2019',
        'DATABASE'  => 'vindi_api',
        'CHARSET'   => 'utf8',
        'PREFIX'    => '',
      ],
      [
        'TITLE'    => 'LYCEUM HOMOLOGAÇÃO', // Exemplo.
        'ACTIVE'     => true,
        'DBMANAGER' => 'mysql',
        'HOST'      => 'localhost',
        'PORT'      => '3306',
        'USERNAME'  => 'root',
        'PASSWORD'  => '',
        'DATABASE'  => 'vindi_api',
        'CHARSET'   => 'utf8',
        'PREFIX'    => 'vindi_',
      ],
    ]);
    break;

    // Ambiente de Produção.
  case 'PROD':
    define("BASE_BDS", [
      [
        'TITLE'    => 'VINDI PRODUÇÃO',
        'ACTIVE'     => true,
        'DBMANAGER' => 'mysql',
        'HOST'      => '192.168.0.12',
        'PORT'      => '3306',
        'USERNAME'  => 'vindi_prod',
        'PASSWORD'  => 'Sp_Pr0d3@2019',
        'DATABASE'  => 'vindi_prod',
        'CHARSET'   => 'utf8',
        'PREFIX'    => '',
      ]
    ]);
    break;

    // Caso tenha algum problema zera o valor.
  default:
    define("BASE_BDS", [[]]);
    break;
}


/**
 * * AUTORIZAÇÕES
 * Autorizações de APIs, TOKENS, Terceiros, Logins, etc de acordo com ambiente.
 */
switch (BASE_ENV) {
    // Ambiente de Desenvolvimento.
  case 'DEV':
    define("BASE_AUTH", [
      // Exemplo
      'CAMPO' => 'valor',
    ]);
    break;

    // Ambiente de Homologação.
  case 'HOMOLOG':
    define("BASE_AUTH", [
      // Exemplo
      'CAMPO' => 'valor',
    ]);
    break;

    // Ambiente de Produção.
  case 'PROD':
    define("BASE_AUTH", [
      // Exemplo
      'CAMPO' => 'valor',
    ]);
    break;

    // Caso tenha algum problema zera o valor.
  default:
    define("BASE_AUTH", []);
    break;
}


/**
 * * CONFIGURAÇÕES
 * Configurações personalizadas de acordo com ambiente.
 */
switch (BASE_ENV) {
    // Ambiente de Desenvolvimento.
  case 'DEV':
    define("BASE_CONFIG", [
      'SHOW_ERRORS' => 1,
      'CAMPO' => 'valor',
    ]);
    break;

    // Ambiente de Homologação.
  case 'HOMOLOG':
    define("BASE_CONFIG", [
      'SHOW_ERRORS' => 1,
      'CAMPO' => 'valor',
    ]);
    break;

    // Ambiente de Produção.
  case 'PROD':
    define("BASE_CONFIG", [
      'SHOW_ERRORS' => 1,
      'CAMPO' => 'valor',
    ]);
    break;

    // Caso tenha algum problema zera o valor.
  default:
    define("BASE_CONFIG", []);
    break;
}


/**
 * * PARÂMETROS DEFAULT - RENDERIZAÇÃO
 * Opções de renderização.
 * 
 * * Opções com * podem ser modificadas no processamento do endpoint.
 */
define("BASE_PARAMS_RENDER", [
  'cache'        => false,                 // Ativa uso de cache para resultado.
  'cacheTime'    => (60 * 60 * 24),       // Tempo para renovar cache em segundos. (1 dia).
  'cacheParams'    => true,       // Cache por parametros (attr).
  'content_type' => 'application/json',   // * Tipo do retorno padrão do cabeçalho http.
  // 'content_type' => 'text/html',          // * Tipo do retorno padrão do cabeçalho http.
  'charset'      => 'utf-8',              // * Tipo de codificação do cabeçalho http.
]);


/**
 * * PARÂMETROS DEFAULT - CONFIGURAÇÃO
 * Configuração personalizada do endpoins.
 */
define("BASE_PARAMS_CONFIG", [
  // CONFIGURAÇÕES ENDPOINT
  // *********************
  'visita'    => true,        // Gravar registro de acesso.
  'bdParams'  => false,       // Parâmetros da controller vem do BD.
  'bdContent' => false,       // Conteúdo da página vem do BD.
  'versao'    => 'v1.0',      // Versão da controller atual.
  'feedback'  => true,        // FeedBack padrão de transações.
  'class'     => __CLASS__,   // Guarda classe atual


  // PAGES - INFORMAÇÕES ADICIONAIS PARA HEAD
  // *********************
  // Arquivo js ou css, o próprio código ou livre para acrescentar conteúdo na head.
  'head'           => '',   // Inclui antes de fechar a tag </head>
  'scriptHead'     => '',   // Escreve dentro de uma tag <script></script> antes da </head>.
  'scriptBody'     => '',   // Escreve dentro de uma tag <script></script> antes da </body>.
  'styleHead'      => '',   // Escreve dentro de uma tag <style></style> antes da </head>.
  'styleBody'      => '',   // Escreve dentro de uma tag <style></style> antes da </body>.


  // PAGES - INFORMAÇÕES DE SEO HTML
  // *********************
  // Informações que vão ser usadas para SEO na página.
  'title'            => 'Vindi',   // Título da página exibido na aba/janela navegador.

  'author'           => 'Mateus Brust',  // Autor do desenvolvimento da página ou responsável.
  'description'      => '',              // Resumo do conteúdo do site em até 90 carecteres.
  'keywords'         => '',              // palavras minúsculas separadas por "," em até 150 caracteres.
  'content_language' => 'pt-BR',         // Linguagem primária da página (pt-br).
  'content_type'     => 'text/html',     // Tipo de codificação da página.
  'reply_to'         => '',              // E-mail do responsável da página.
  'charset'          => 'utf-8',         // Charset da página.
  'image'            => 'logo.png',      // Imagem redes sociais.
  'url'              => '',              // Url para instagram.
  'site'             => '',              // Site para twitter.
  'creator'          => '',              // Perfil criador twitter.
  'author_article'   => '',              // Autor do artigo da página atual.
  'generator'        => 'vscode',        // Programa usado para gerar página.
  'refresh'          => false,           // Tempo para recarregar a página em segundos.
  'redirect'         => false,           // URL para redirecionar usuário após refresh.
  'favicon'          => 'favicon.ico',   // Imagem do favicon na página.
  'icon'             => 'favicon.ico',   // Imagem ícone da empresa na página.
  'appletouchicon'   => 'favicon.ico',   // Imagem da logo na página.

  // INFORMAÇÕES ADICIONAIS
  // *********************
  'campo'            => 'valor',         // Personalização
]);


/**
 * * PARÂMETROS DEFAULT - SEGURANÇA
 * Opções de segurança.
 */
define("BASE_PARAMS_SECURITY", [

  // Controller usará segurança.
  'ativo'             => false,

  // Acessar apenas logado.
  'session'           => false,

  // Tempo para sessão acabar.
  'sessionTimeOut'    => (60 * 60 * 24), // 24 horas.

  // Segurança por autorização no cabeçalho.
  'headers'            => [
    'key'   => '',   // Tipo de autorização (Bearer Token, API Key, JWT Bearer Basic Auth, etc.).
    'value' => '',   // Valor da autorização (Bearer valor_token, Basic e3t1c3VhcmlvfX06e3tzZW5oYX19, etc)
  ],

  // Caminho para página de login.
  'loginPage'         => 'login/',

  // Caminho para página restrita.
  'restrictPage'      => 'admin/', // Page admin dentro do modelo.

  // Permissões personalizadas da página atual. 
  // [1] Menu, [2] Início, [3] Adicionar, [4] Editar, [5] Listar (Básico), [6] Listar Completo, [7] Deletar, [8] API, [9] Testes.
  'permission'        => '000000000', // [1] Necessita de permissão, [0] Não necessita permissão.

  // Transações de dados (GET - POST) apenas com token. Usar classe Tokens. Exemplo: (<input name="token" type="text" value="{{token}}" hidden>').
  'token'             => false, // Só aceitar com token (definido na config "BASE_AUTH['token']").

  // FeedBack padrão de nível de acesso.
  'feedback'          => true, // true - mostra feedback de ações.

  // Receber transações externas. Dados de outras origens.
  'origin'            => [
    // 'site.com.br',  // URL teste.
  ],

  // Grupos que tem permissão TOTAL a esta controller. Usar apenas para teste.
  'groups'            => [
    // 1, // Grupo ID: 1.
  ],

  // IDs que tem permissão TOTAL a esta controller. Usar apenas para teste.
  'ids'            => [
    // 1, // Login ID: 1.
  ],
]);


/**
 * * PARÂMETROS DEFAULT - INFORMAÇÕES
 * Informações extras.
 */
define("BASE_PARAMS_INFO", [

  // INFORMAÇÕES GERAIS
  // *********************
  'empresa'         => 'CETRUS',
  'slogan'          => 'CETRUS',
  'nomeFantasia'    => 'CETRUS',
  'razaoSocial'     => 'CETRUS',
  'cnpj'            => '123456789',
  'ie'              => '123456789',
  'endereco'        => 'São Paulo/SP',
  'email'           => 'contato@CETRUS.com.br',
  'emailSuporte'    => 'contato@CETRUS.com.br',
  'telefoneSuporte' => '35 9 1234-1234',
  'telefone'        => '35 9 1234-1234',
  'whatsapp'        => '35 9 1234-1234',
  'since'           => '2019',                     // 10/04/2019
  'dataAtual'       => date('d/m/Y H:i:s'),
  'anoAtual'        => date('Y'),
  'logo'            => 'logo.png',
  'campo' => 'valor', // Adicional.
]);


/**
 * * PARÂMETROS DEFAULT - BANCO DE DADOS
 * Carrega controllers de bancos de dados.
 */
define("BASE_PARAMS_BDS", [
  // 'pasta/DataBase',
  'BdBills',
  'BdCrons',
  'BdLogsLoja',
  'BdlogsLyceum',
  'BdlogsSap',
  'BdLogsVindi',
  'BdLogsVindiNotifications',
  'BdSubscriptions',
  'BdVindiCronsErrors',
  'BdVindiCronsLogs',
]);


/**
 * * PARÂMETROS DEFAULT - CLASSES
 * Carrega classes de apoio.
 */
define("BASE_PARAMS_CLASSES", [
  'Logs',
  'loja/ApiLoja',
  'sap/ApiSap',
]);


/**
 * * PARÂMETROS DEFAULT - CONTROLLERS
 * Carrega controllers para reutilizar funções.
 */
define("BASE_PARAMS_CONTROLLERS", [
  // // Controllers de API
  'api' => [
    // 'pasta/Controller',
  ],

  // // Controllers de Páginas
  'pages' => [
    // 'pasta/Controller',
  ],
]);


/**
 * * PARÂMETROS DEFAULT - MENUS
 * Monta estrutura de parâmetros passados na url.
 */
define("BASE_PARAMS_MENUS", [
  // Função:
  'index' => [
    'title'      => 'Início',      // Nome exibido no menu. Somente pages.
    'permission' => '110000000',   // Permissões necessárias para acesso.
    'groups'     => [],            // Quais grupos tem acesso a esse menu.
    'ids'        => [],            // Quais ids tem acesso a esse menu.
  ],

  // Função:
  'test' => [
    'title'      => 'Teste',       // Nome exibido no menu. Somente pages.
    'permission' => '100000010',   // Permissões necessárias para acesso.
    'groups'     => [],            // Quais grupos tem acesso a esse menu.
    'ids'        => [],            // Quais ids tem acesso a esse menu.
  ],
]);


/**
 * * PARÂMETROS DEFAULT - STRUCTURE
 * Carrega estrutura html. Somente pages.
 */
define("BASE_PARAMS_STRUCTURE", [
  // Origem
  'html'        => 'default',   // Estrutura HTML geral.

  // Complementos
  'head'         => 'default',   // <head> da página.
  'top'          => 'default',   // Logo após a tag <body>.
  'header'       => 'default',   // Após a estrutura "top".
  'nav'          => 'default',   // Dentro do header ou personalizado.
  'content_top'  => 'default',   // Antes do conteúdo da página.
  'content_page' => 'default',   // Reservado para conteúdo da página. Sobrescrito depois.
  'content_end'  => 'default',   // Depois do conteúdo da página.
  'footer'       => 'default',   // footer da página.
  'end'          => 'default',   // Fim da página.
]);


/**
 * * PARÂMETROS DEFAULT - SCRIPTS
 * Carrega na página scripts (template/assets/js/) Somente pages.
 */
define("BASE_PARAMS_SCRIPTS", [
  'js' => [
    // 'jquery.min.js',   		// Exemplo.
  ],
  'libs' => [
    // 'lib/jquery.min.js',   		// Exemplo.
  ],
]);


/**
 * * PARÂMETROS DEFAULT - STYLES
 * Carrega na página estilos (template/assets/css/) Somente pages.
 */
define("BASE_PARAMS_STYLES", [
  // 'endpoint-min.css',   // Exemplo.
]);


/**
 * * PARÂMETROS DEFAULT - PLUGINS
 * Carrega na página plugins (template/assets/css/) Somente pages.
 */
define("BASE_PARAMS_PLUGINS", [
  // 'modelo',   // Exemplo.
]);





/**
 * * TESTES
 * Parte para verificação dos valores.
 */
// echo 'BASE_NAME: ' . BASE_NAME;
// echo '<br>';
// echo 'BASE_DOMAIN: ' . BASE_DOMAIN;
// echo '<br>';
// echo 'BASE_URL: ' . BASE_URL;
// echo '<br>';
// echo 'BASE_DIR: ' . BASE_DIR;
// echo '<br>';
// echo 'BASE_IP: ' . BASE_IP;
// echo '<br>';
// echo 'BASE_ENV: ' . BASE_ENV;
// echo '<br>';
// echo 'BASE_BDS: ';
// echo '<pre>';
// print_r(BASE_BDS);
// echo '</pre>';
// echo '<br>';
// echo 'BASE_CONFIG: ';
// echo '<pre>';
// print_r(BASE_CONFIG);
// echo '</pre>';
// echo '<br>';
// echo 'BASE_INFO: ';
// echo '<pre>';
// print_r(BASE_INFO);
// echo '</pre>';
// echo '<br>';
// exit;
