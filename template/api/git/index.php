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
 * O método padrão para visualização é a get().
 * Na função get, é realizada toda a programação das informações do endpoint.
 * É possível chamar outras funções (Sub-Menus) usando parâmetros (Url e LoadParams).
 * Outras funções (Sub-Menus) são chamados de acordo com a estrutura personalizada no parâmetros "menus".
 * 
 * O nome da controller é o mesmo que o endpoint da url sem os "-".
 * Porém é possível passar pela url o endpoint "/quem-somos", pois o sistema irá tirar os "-".
 * O nome da controller vai ficar como "quemsomos".
 * 
 */
class index extends \controllers\EndPoint
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
      // 'cacheTime'    => (60 * 30),            // Tempo para renovar cache em segundos. (30 Minutos).
      // 'cacheParams'    => true,       // Cache por parametros (attr).
      // 'content_type' => 'application/json',   // * Tipo do retorno padrão do cabeçalho http.
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
    ];

    // Opções de segurança.
    self::$params['security']    = [

      // // Controller usará controller de segurança.
      'ativo'             => true,

      // // Usuário só acessa logado.
      // 'session'           => true,

      // // Tempo para sessão acabar nesta página.
      // 'sessionTimeOut'    => (60 * 30), // 30 min.

      // // Segurança por autorização no cabeçalho.
      'headers'            => [
          'key'   => 'Authorization',        // Tipo de autorização (Bearer Token, API Key, JWT Bearer Basic Auth, etc.).
          'value' => 'Bearer ' . BASE_AUTH['token_git'],   // Valor da autorização (Bearer valor_token, Basic e3t1c3VhcmlvfX06e3tzZW5oYX19, etc)
      ],

      // // Caminho para página de login.
      // 'loginPage'         => "api/login/", // Page login dentro do modelo.

      // // Permissões personalizadas da página atual. 
      // // [1] Menu, [2] Início, [3] Adicionar, [4] Editar, [5] Listar (Básico), [6] Listar Completo, [7] Deletar, [8] API, [9] Testes.
      // 'permission'        => '111111111', // [1] Necessita de permissão, [0] Não necessita permissão.

      // // Transações de dados (GET - POST) apenas com token. Usar classe Tokens. Exemplo: (<input name="token" type="text" value="{{token}}" hidden>').
      // 'token'             => true, // Só aceitar com token (definido na config "BASE_AUTH['token']").

      // // FeedBack padrão de nível de acesso.
      // 'feedback'          => false,

      // // Receber transações externas. Dados de outras origens.
      // 'origin'            => [
      //     '*',                        // Permitir tudas as origens.
      //     'http://www.site.com.br/',  // URL teste.
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

    // Carrega controllers de bancos de dados.
    self::$params['bds']         = [
      // 'BdTeste',
    ];

    // Carrega classes de apoio.
    self::$params['classes']     = [
      // 'Midia',
    ];

    // Carrega controllers para reutilizar funções.
    self::$params['controllers'] = [
      // // Controllers de API
      // 'api' => [
      //     'pasta/controller', // Sintax.
      //     'modellimpo',
      // ],

      // // Controllers de Páginas
      // 'pages' => [
      //     'pasta/controller', // Sintax.
      //     'modulo/controller',
      // ],
    ];

    // Monta estrutura de parâmetros passados na url ou metodo.
    self::$params['menus']       = [
      // Função:
      'get' => [
          'title'      => 'Listar',      // Nome exibido no menu. Somente pages.
          'permission' => '100010000',   // Permissões necessárias para acesso.
          'groups'     => [],            // Quais grupos tem acesso a esse menu.
          'ids'        => [],            // Quais ids tem acesso a esse menu.
      ],

      // Função:
      'post' => [
          'title'      => 'Adicionar',   // Nome exibido no menu. Somente pages.
          'permission' => '101000000',   // Permissões necessárias para acesso.
          'groups'     => [],            // Quais grupos tem acesso a esse menu.
          'ids'        => [],            // Quais ids tem acesso a esse menu.
      ],

      // // Função:
      // 'put' => [
      //     'title'      => 'Atualizar',   // Nome exibido no menu. Somente pages.
      //     'permission' => '100100000',   // Permissões necessárias para acesso.
      //     'groups'     => [],            // Quais grupos tem acesso a esse menu.
      //     'ids'        => [],            // Quais ids tem acesso a esse menu.
      // ],
    ];
  }


  /**
   * get
   * 
   * Função principal.
   * Recebe todos os parâmetros do endpoint em $params.
   * Retorna todas as informações em return.
   *
   * @param  mixed $params
   */
  public function get($params)
  {
    // // Quanto conteúdo é passado por body (normalmente Json).
    // $response['method'] = __FUNCTION__;
    // $response[__FUNCTION__] = $params[strtolower(__FUNCTION__)];
    // $response['$_GET'] = $_GET;
    // $response['token'] = BASE_AUTH['token_git']; // Token para transações de dados na plataforma.

    $response['msg'] = "Envie comandos GIT via POST. Necessário token válido.";

    // Finaliza a execução da função.
    self::$params['response'] = $response;
  }
  
  /**
   * post
   * 
   * Acessada via primeiro parâmetro ou pelo request method.
   * Recebe todos os parâmetros do endpoint em $params.
   *
   * @param  mixed $params
   */
  public function post($params)
  {
    // Comandos permitidos
    $allowedCommands = ['status', 'pull'];

    // Obtem o comando
    $command = $params['infoUrl']['attr'][0];
    // Normaliza o comando
    $command = strtolower($command);

    // Monta a resposta
    $response['command'] = 'git ' . $command;
    $response['OS'] = PHP_OS;
    $response['ENV'] = BASE_ENV;
    
    // Verifica se o comando passado é válido
    if(in_array($command, $allowedCommands)) {
        // Executa o comando e obtem o resultado
        $response['msg'] = $this->execCommand($command);
    } else {
        // Informa que o comando não é permitido
        $response['msg'] = "Comando não permitido";
    }

    // Finaliza a execução da função.
    self::$params['response'] = $response;
  }

  /**
   * Executa o camando informado e retorna o resultado  
   *
   * @param string $command
   * 
   * @return mixed
   * 
   */
  public function execCommand(string $command)
  {

    // Verifica o tipo de SO onde está sendo sendo executado
    // switch (PHP_OS) {
    //     // Caso seja Windows
    //     case 'WINNT':
    //         exec('git ' . $command, $result, $result_code);
    //         break;
            
    //     // Por padrão é (linux)
    //     default:
    //         // exec('git ' . $command, $result, $result_code);
    //         $result = shell_exec('/usr/bin/git ' . $command);
    //         $result_code = $result == null;
    //         break;
    // }

    exec('git ' . $command, $result, $result_code);

    $response['result'] = $result;
    $response['error'] = $result_code == 1;
    if($result_code) {
        $response['msg'] = 'Erro ao executar o comando, provavel falha de autenticação do git';
    }

    return $response;
  }
}