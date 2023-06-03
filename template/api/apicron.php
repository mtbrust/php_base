<?php

namespace api;

use classes\ApiLoja;
use classes\DevHelper;

class apicron extends \controllers\EndPoint
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
      // 'ativo'             => true,

      // // Usuário só acessa logado.
      // 'session'           => true,

      // // Tempo para sessão acabar nesta página.
      // 'sessionTimeOut'    => (60 * 30), // 30 min.

      // // Segurança por autorização no cabeçalho.
      // 'headers'            => [
      //     'key'   => 'Authorization',        // Tipo de autorização (Bearer Token, API Key, JWT Bearer Basic Auth, etc.).
      //     'value' => 'Bearer valor_token',   // Valor da autorização (Bearer valor_token, Basic e3t1c3VhcmlvfX06e3tzZW5oYX19, etc)
      // ],

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
      'vindi/ApiVindi',
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

      // Função:
      'put' => [
        'title'      => 'Atualizar',   // Nome exibido no menu. Somente pages.
        'permission' => '100100000',   // Permissões necessárias para acesso.
        'groups'     => [],            // Quais grupos tem acesso a esse menu.
        'ids'        => [],            // Quais ids tem acesso a esse menu.
      ],
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
    $response['method'] = __FUNCTION__;
    $response[__FUNCTION__] = $params[strtolower(__FUNCTION__)];
    $response['$_GET'] = $_GET;

    self::$params['response'] = \classes\ApiVindi::getCustomers($response['$_GET']['registry_code']);
  }
  
  /**
   * dueDateBillExpiredFunc
   *
   * @param  mixed $job
   * @return array
   */
  public function dueDateBillExpiredFunc($job)
  {
    //traz os dados da fatura;
    $currentBill = \classes\ApiVindi::getBillById($job['externalId']);

    $r = [];

    // Verifica se já foi pago.
    if ($currentBill['bill']['status'] == 'paid') {
      $this->insertLog($job, null);
    }

    $strDueDate = $currentBill['bill']['due_at'];
    $dueDate = new \DateTime($strDueDate);
    
    //Valida se data de hoje é maior que data de vencimento e se data de pagamento e null;
    if (
      strtotime(date("Y-m-d")) > strtotime("+5 days",strtotime($dueDate->format('Y-m-d'))) &&
      $currentBill['bill']['status'] != 'paid'
    ) {
      //Cancela a assinatura;
      $r = \classes\ApiVindi::deleteSubscriptions($currentBill['bill']['subscription']['id']);

      if (isset($r['errors']) || $r == false) {
        $this->insertLogErros($job, $r);
      } else {
        $this->insertLog($job, $r);
      }
    }

    return $r;
  }
  
  /**
   * createSubscriptionPending
   *
   * @param  mixed $job
   * @return array
   */
  public function createSubscriptionPending($job)
  {
    // Instancia a classe de jobs
    $bdCron = new \BdCrons;
    // Adiciona +10 min para a próxima tentativa
    $bdCron->update($job['id'], [
      'nextRun'     => date('Y-m-d H:i:s', strtotime("+10 min")),
      'tryes'       => $job['tryes'] + 1,
    ]);

    //traz os dados da assinatura;
    $bdSubscription = new \BdSubscriptions;
    $subscription = $bdSubscription->selectByBill($job['externalId']);

    // Verifica se já foi criada assinatura
    if (isset($subscription['idSubscription'])) {
      $this->insertLog($job, $subscription);
      $bdCron->delete($job['id']);
      return [];
    }

    // Cria a assinatura na vindi
    $vindiResponse = \classes\ApiVindi::postSubscriptions(json_decode($subscription['request'], true));

    // Monta os campos para atualizar local
    $fields = ["response" => json_encode($vindiResponse)];

    // Verifica se retornou erro
    if (isset($vindiResponse['errors']) || $vindiResponse == false) {

      // Caso falhe insere nos logs de erros
      $this->insertLogErros($job, $vindiResponse);
    } else {
      // Caso sucesso adiciona o log
      $this->insertLog($job, $vindiResponse);
      // Adiciona o id criado na subscription local
      $fields["idSubscription"] = $vindiResponse["subscription"]["id"];
      // Caso ocorra tudo certo remove o job
      $bdCron->delete($job['id']);
    }

    // Atualiza a subscription local com a resposta ou erros
    $bdSubscription->update($subscription['id'], $fields);

    return $vindiResponse;
  }

  public function sendNotificationPending($job)
  {
    // Instancia a classe de jobs
    $bdCron = new \BdCrons;
    // Adiciona +10 min para a próxima tentativa
    $bdCron->update($job['id'], [
      'nextRun'     => date('Y-m-d H:i:s', strtotime("+10 min")),
      'tryes'       => $job['tryes'] + 1,
    ]);
    
    //Envia dados para a loja
    $responseLoja = ApiLoja::postNotificationVindi(json_decode($job['jsonPost'], true));

    // Verifica se não houve resposta da loja
    if (!isset($responseLoja)) {
      // Adiciona o log de erro
      $this->insertLogErros($job, $responseLoja);
      return false;
    }

    // Adiciona o log de sucesso
    $this->insertLog($job, $responseLoja);
    // Remove o job
    $bdCron->delete($job['id']);

    return $responseLoja;
  }

  public function insertLogErros($job, $r)
  {
    $dataBaseCron = new \BdCrons;
    $dataBaseCronErros = new \BdVindiCronsErrors;

    if (empty($job['attempts']) || $job['attempts'] < 2) {
      if (empty($job['attempts']))  $job['attempts'] = 0;
      $job['attempts'] = $job['attempts'] + 1;
      $dataBaseCron->update($job['id'], $job);
    }

    $job['logError'] = json_encode($r, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    $dataBaseCronErros->insert($job);
    $dataBaseCron->delete($job['id']);
  }

  public function insertLog($job, $r)
  {
    $dataBaseCron = new \BdCrons;
    $dataBaseCronLogs = new \BdVindiCronsLogs;

    $job['logResponse'] = json_encode($r, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    $dataBaseCronLogs->insert($job);
    $dataBaseCron->delete($job['id']);
  }
  
  /**
   * default
   *
   * @param  mixed $job
   * @return array
   */
  public function default($job)
  {
    $r = \classes\HttpRequest::request(json_decode($job['endpoint'], true));
    $r = json_decode($r, true);

    if (isset($r['erros']) || $r == false) {
      $this->insertLogErros($job, $r);
    } else {
      $this->insertLog($job, $r);
    }

    return $r;
  }
  
  /**
   * executeJobs
   *
   * @param  mixed $jobs
   * @return array
   */
  public function executeJobs($jobs)
  {
    $r = [];

    // Se não tem jobs, encerra.
    if (!$jobs) {
      $r[0]['id'] = 0;
      $r[0]['title'] = 'Sem jobs.';
      return $r;
    }

    // Percorre cada JOB.
    foreach ($jobs as $job) {

      switch ($job['endpoint']) {
        case 'dueDateBillExpired':
          $responseArray = $this->dueDateBillExpiredFunc($job);
          break;
        case 'notificationLojaPending':
          $responseArray = $this->sendNotificationPending($job);
          break;
        case 'createSubscriptionPending':
          $responseArray = $this->createSubscriptionPending($job);
          break;
        default:
          $responseArray = $this->default($job);
          break;
      }

      // Prepara o resultado do processamento.
      $jobResult['id']          = $job['id'];
      $jobResult['title']       = $job['title'];
      $jobResult['description'] = $job['description'];
      $jobResult['endpoint']    = $job['endpoint'];
      $jobResult['info']        = \classes\HttpRequest::getInfo();
      $jobResult['cookies']     = \classes\HttpRequest::getCookies();
      $jobResult['result']      = $responseArray;
      $jobResult['status']      = $jobResult['info']['http_code'];
      // Acrescenta o resultado do processamento no retorno.
      array_push($r, $jobResult);
    }

    return $r;
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
    $dataBaseCron = new \BdCrons;

    $response['execution'] = date('Y-m-d H:i:s');

    $response['jobs'] = $dataBaseCron->selectCurrentJobs();

    $response['execute'] = $this->executeJobs($response['jobs']);

    self::$params['response'] = $response;
  }
}
