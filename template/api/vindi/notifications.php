<?php

namespace api;

use classes\DevHelper;

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
class notifications extends \controllers\EndPoint
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
      //     'value' => 'Bearer ' .  BASE_AUTH['token_integrador_vindi'],   // Valor da autorização (Bearer valor_token, Basic e3t1c3VhcmlvfX06e3tzZW5oYX19, etc)
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
      'BdSubscriptions'
    ];

    // Carrega classes de apoio.
    self::$params['classes']     = [
      // 'Midia',
      'loja/ApiLoja',
      'vindi/ApiVindi',
    ];

    // Carrega controllers para reutilizar funções.
    self::$params['controllers'] = [
      // Controllers de API
      'api' => [
        // 'v1/default',
        // 'modulo/controller',
        // 'modellimpo',
      ],

      // // Controllers de Páginas
      // 'pages' => [
      //     'teste/index',
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
    $response['msg'] = 'notificação salva em: notification.txt';

    $filename = "template/assets/midias/tmp/notification.txt";
    $content = file_get_contents($filename);
    $response['notification'] = json_decode($content, true);

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

  public function billPaidAction($notification)
  {
    // Pega a bill da notificação
    $bill = $notification['event']['data']['bill'];

    // atualiza banco vindi com pagamento para status pago
    $bdBills = new \BdBills;
    $localBills = $bdBills->selectByCode($bill['code']);

    // Se existir o primeiro registro e for pago, encerra a execução
    // Isso garante que a loja já foi notificada
    if (isset($localBills['paid']) && $localBills['paid']) {
      $r['api_msg'] = 'Registro já pago.';
      $r['api_loja_error'] = true;
      $r['api_loja'] = $localBills;
      return $r;
    }

    // Atualiza o status local para pago
    $bdBills->updateById($bill['id'], ['paid' => 1]);

    // Remove job da tabela de cron (que valida se fatura venceu) e adiciona em log
    $dataBaseCron = new \BdCrons;
    $dataBaseCronLogs = new \BdVindiCronsLogs;

    $cronBill = $dataBaseCron->selectJobByBillId($bill['id']);

    // Verifica se tem registro na base local
    if ($cronBill) {
      $dataBaseCron->delete($cronBill['id']);
      $dataBaseCronLogs->insert($cronBill);
    }

    // Mapeamento de produtos LOJA.
    if (BASE_ENV == 'PROD') {
      $product_id = 1288464; // ID produto Matrícula.
    } else {
      $product_id = 200091; // ID produto Matrícula.
    }

    // Mapeamento de produtos SITE.
		if (BASE_ENV == 'PROD') {
			$product_id_site = 1288466; // ID produto Produto.
		} else {
			$product_id_site = 209661; // ID produto Produto.
		}

    // Construção dos campos.
    $fields = [
      'title'       => "Notificação de Pagamento",
      'description' => "Reenvia notificação de pagamento para loja, pedido: " . $bill['code'],
      'endpoint'    => "notificationLojaPending",
      'nextRun'     => date('Y-m-d H:i:s', strtotime("+10 min")),
      'externalId'  => $bill['id'],
      'tryes'       => 0,
      'jsonPost'    => json_encode($notification['event']['data'])
    ];

    // Insere o job e obtem o id
    $jobNotificationID = $dataBaseCron->insert($fields);


    // Cria job para garantir notificação para o sap.
    $jobNotificationSapID = $this->creatJobSendSAP();
    // Cria job para garantir notificação para o Lyceum.
    $jobNotificationLyceumID = $this->creatJobSendLyceum();


    // Inicializa a variável de retorno.
    $r = [];

    /**
     * Caso seja um pedido feito pela LOJA (MATRICULA)
     */
    // VERIFICA SE ESSA FATURA AVULSA QUE FOI PAGA É REFERÊNTE A UMA ASSINATURA (matricula) na base local.
    if (
      !empty($bill['bill_items']) &&
      !empty($bill['bill_items'][0]['product']) &&
      $bill['bill_items'][0]['product']['id'] == $product_id
    ) {
      
      // CRIA A ASSINATURA COM AS INFORMAÇÕES DA ASSINATURA NA TABELA LOCAL SIGNATURES.
      $dataBaseSubscriptions = new \BdSubscriptions;
      $currentSubscription = $dataBaseSubscriptions->selectByBill($bill['id']);

      // Verifica se essa fatura avulsa tem uma assinatura.
      if ($currentSubscription) {
        // Construção dos campos.
        $fields = [
          'title'       => "Criação de Assinatura",
          'description' => "Retentativa de criação de assinatura do pedido: " . $bill['code'],
          'endpoint'    => "createSubscriptionPending",
          'nextRun'     => date('Y-m-d H:i:s', strtotime("+10 min")),
          'externalId'  => $bill['id'],
          'tryes'       => 0,
        ];

        // Insere o job e obtem o id
        $jobSubscriptionID = $dataBaseCron->insert($fields);

        $request = json_decode($currentSubscription['request'], true);
        $signature = \classes\ApiVindi::postSubscriptions($request);

        // Verifica se não teve erro ao criar a assinatura.
        if (!isset($signature['errors'])) {

          // Caso não haja erros armazena a response e o id da assinatura
          $fields = [
            'idSubscription' => $signature['subscription']['id'],
            'response'       => json_encode($signature),
          ];

          // Caso sucesso remove o job de retentativa
          $jobSubscription = $dataBaseCron->selectById($jobSubscriptionID);
          $dataBaseCron->delete($jobSubscriptionID);
          $dataBaseCronLogs->insert($jobSubscription);
        } else {

          // Caso ocorra um erro, armazena na response
          $fields = [
            'response'  => json_decode($signature, JSON_UNESCAPED_UNICODE),
          ];
        }

        // Atualiza assinatura com a resposta (response).
        $dataBaseSubscriptions->update($currentSubscription['id'], $fields);

        $r['api_vindi'] = $signature;
      }

      // Envia notificação para o sap.
      $sendSAP = $this->sendSAP($bill);
      // Deleta job para garantir notificação para o sap.
      $this->deletJobSendSAP($sendSAP, $jobNotificationSapID);

      // Envia notificação para o Lyceum.
      $sendLyceum = $this->sendLyceum($bill);
      // Deleta job para garantir notificação para o Lyceum.
      $this->deletJobSendLyceum($sendLyceum, $jobNotificationLyceumID);

      // Envia dados para a loja
      $responseLoja = \classes\ApiLoja::postNotificationVindi($notification['event']['data']);

      if (!isset($responseLoja) || (isset($responseLoja['error']) && $responseLoja['error'])) {
        $r['api_loja_error'] = true;
        return $r['api_loja'] = $responseLoja;
      }
      
      // Caso sucesso remove o job de retentativa de notificação
      $jobNotification = $dataBaseCron->selectById($jobNotificationID);
      $dataBaseCron->delete($jobNotificationID);
      $dataBaseCronLogs->insert($jobNotification);

      // Adiciona a reposta da loja na resposta da requisição
      $r['api_loja_error'] = false;
      $r['api_loja'] = $responseLoja;


      /**
       * Caso seja um pedido feito pelo SITE (E-commerce.)
       */
    }elseif(
      isset($bill['bill_items'][0]['product']['id']) &&
      $bill['bill_items'][0]['product']['id'] == $product_id_site
    ){
      
      // Envia dados para a loja
      $responseLoja = \classes\ApiLoja::postNotificationVindi($notification['event']['data']);

      if (!isset($responseLoja) || (isset($responseLoja['error']) && $responseLoja['error'])) {
        $r['api_loja_error'] = true;
        return $r['api_loja'] = $responseLoja;
      }

      // Adiciona a reposta da loja na resposta da requisição
      $r['api_loja_error'] = false;
      $r['api_loja'] = $responseLoja;

    }

    // Finaliza devolvendo o resultado do processamento.
    return $r;
  }

  public function billCreatedAction($notification)
  {
    $data = $notification['event']['data']['bill'];

    $created_at = new \DateTime($data['created_at']);
    $due_at = new \DateTime($data['due_at']);

    $bdBills = new \BdBills;

    $bill_exist = $bdBills->selectByCode($data['code']);

    // Verifica se já existe e não precisa criar.
    if (isset($bill_exist['code'])) {
      return true;
    }

    // Cria no banco vindi a fatura
    $dataBills = [
      "sourceIP"        => DevHelper::getRemoteIp(),
      "dtCreate"        => date('Y-m-d H:i:s'),
      "code"            => $data['code'],
      'type'            => ($data['code'][0] == 'P' ? 'Site' : 'Loja'),
      "customerVindiId" => $data['customer']['id'],
      "customerLojaId"  => $data['customer']['code'],
      "externalId"      => $data['id'],
      "createdAt"       => $created_at->format('Y-m-d H:i:s'),                    //Validar
      "dueAt"           => $due_at->format('Y-m-d H:i:s'),
      "paymentMethod"   => $data['charges'][0]['payment_method']['code'],
      "amount"          => $data['amount'],
      "paid"            => 0,
      "sentLoja"        => 0,                                               //Validar
      "sentLyceum"      => 0,                                               //Validar
      "sentSap"         => 0,                                               //Validar
      "metadata"        => json_encode($data['metadata']),
      'response'        => json_encode($notification),                      // Retorno da criação da fatura avulsa.
      "obs"             => null,
    ];
    $bdBills->insert($dataBills);

    if (empty($data['subscription'])) {
      return $notification;
    }
    //Insere job na cron para validar vencimento
    $dataBaseCron = new \BdCrons;
    $dataBaseCron->insert([
      'title'       => "Fatura criada: " . $data['id'],
      'description' => "Validar se fatura não foi paga na data de vencimento",
      'endpoint'    => "dueDateBillExpired",
      'nextRun'     => $due_at->format('Y-m-d H:i:s'),
      'tryes'       => 0,
      'externalId'  => $data['id']
    ]);

    return $notification;
  }

  public function post($params)
  {
    // Recebe a notificação.
    $notification = $params[strtolower(__FUNCTION__)];
    $response['notification'] = $notification;

    // Guarda a notification.
    $BdLogsVindiNotifications = new \BdLogsVindiNotifications();
    $fields = [
      'dtCreate' => date("Y-m-d H:i:s"),
      'request' => json_encode($notification),
    ];
    $BdLogsVindiNotifications->insert($fields);

    // Verifica qual categoria da notificação.
    switch ($notification['event']['type']) {
      case 'bill_created':
        $response['bill_created'] = $this->billCreatedAction($notification);
        break;
      case 'bill_paid':
        $response['bill_paid'] = $this->billPaidAction($notification);
        break;
      case 'bill_canceled':
        $response['bill_canceled'] = $this->billCanceledAction($notification);
        break;
      default:
        break;
    }

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
  public function put($params)
  {
    // Quanto conteúdo é passado por body (normalmente Json).
    $response['method'] = __FUNCTION__;
    $response[__FUNCTION__] = $params[strtolower(__FUNCTION__)];
    $response['$_GET'] = $_GET;
    $response['$_POST'] = $_POST;
    $response['token'] = BASE_AUTH['token'];

    // Finaliza a execução da função.
    self::$params['response'] = $response;
  }

  /**
   * foo_personalizada
   * 
   * Função é chamada quando o evento de cancelamento é recebido pela vindi.
   *
   * @param  mixed $params
   */
  public function billCanceledAction($notification)
  {
    $bdBills = new \BdBills();
    return $bdBills->cancelBill($notification['event']['data']['bill']['code']);
  }

  
  /**
   * creatJobSendLyceum
   * 
   * Cria um job para rodar posteriormente, garantindo que o Lyceum será avisado do pagamento caso aconteça algum erro.
   *
   * @return void
   */
  private function creatJobSendLyceum()
  {
    // insere e obtém id do job na cron.
    $id = 0;

    return $id;
  }
  
  /**
   * sendLyceum
   * 
   * Envia notificação de mensalidade paga para o lyceum.
   *
   * @param  mixed $notification
   * @return void
   */
  private function sendLyceum($notification)
  {
    // Envia notifivação para o Lyceum. e se recebeu resposta ok retorna true.
    $r = true;
    return $r;
  }

    
  /**
   * deletJobSendLyceum
   * 
   * Caso tenha realizado com sucesso a notificação de pago, exclui o log.
   *
   * @param  mixed $sendLyceum
   * @param  mixed $jobNotificationLyceumID
   * @return void
   */
  private function deletJobSendLyceum($sendLyceum, $jobNotificationLyceumID)
  {
    // Caso tenha enviado com sucesso a notificação para o Lyceum.
    if ($sendLyceum){
      // Deleta job na tabela cron.

    }
  }

  
  /**
   * creatJobSendSAP
   * 
   * Cria um job para rodar posteriormente, garantindo que o SAP será avisado do pagamento caso aconteça algum erro.
   *
   * @return void
   */
  private function creatJobSendSAP()
  {
    // insere e obtém id do job na cron.
    $id = 0;

    return $id;
  }
  
  /**
   * sendSAP
   * 
   * Envia notificação de mensalidade paga para o SAP.
   * 
   * 1- Buscar a ordem (pedido) aberta (get).
   * 1.1- Pegar a ordem aberta correta (analisar como fazer isso).
   * 2- Gerar a nota futura (post).
   * 2.1- Verifica se deu tudo certo.
   * 3- Gerar o contas a receber (post).
   * 3.1- Verifica se deu tudo certo.
   *
   * @param  mixed $notification
   * @return array|string
   */
  private function sendSAP($notification)
  {
    // Envia notifivação para o sap. e se recebeu resposta ok retorna true.
    $r = true;

    // 1- Buscar a ordem (pedido) aberta (get).
    $orders = \classes\ApiSap::getOrdersCardCode('43059665818C');
      // 1.1 - Pegar a ordem aberta correta (analisar como fazer isso).
    foreach ($orders as $key => $order) {
      # code...
    }

    // 2- Gerar a nota futura (post).
    $fields = [
      'campo' => 'valor',
      'CardCode' => '43059665818C', // CPF + C
    ];
    $response_nf = \classes\ApiSap::postNotaFutura($fields);
    //  2.1- Verifica se deu tudo certo.
    // code...

    // 3- Gerar o contas a receber (post).
    $fields = [
      'campo' => 'valor',
      'CardCode' => '43059665818C', // CPF + C
    ];
    $response_cr = \classes\ApiSap::postParcelaContasReceber($fields);
    //  3.1- Verifica se deu tudo certo.
    // code...


    return $r;
  }

  
  /**
   * deletJobSendSAP
   * 
   * Caso tenha realizado com sucesso a notificação de pago, exclui o log.
   *
   * @param  mixed $sendSAP
   * @param  mixed $jobNotificationSapID
   * @return void
   */
  private function deletJobSendSAP($sendSAP, $jobNotificationSapID)
  {
    // Caso tenha enviado com sucesso a notificação para o SAP.
    if ($sendSAP){
      // Deleta job na tabela cron.

    }
  }
}
