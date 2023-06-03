<?php

namespace api;

use classes\VindiPaymentHelper;

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
class courseinvoice extends \controllers\EndPoint
{

	/**
	 * * *******************************************************************************************
	 * PERSONALIZAÇÃO DO ENDPOINT
	 * * *******************************************************************************************
	 */

	/**
	 * is_credit_card
	 *
	 * @var bool
	 */
	private $is_credit_card = false;

	/**
	 * [Description for $is_credit_card]
	 *
	 * @var bool
	 */
	private $is_recurrence = false;


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
				'value' => 'Bearer ' . BASE_AUTH['token_loja'],   // Valor da autorização (Bearer valor_token, Basic e3t1c3VhcmlvfX06e3tzZW5oYX19, etc)
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
			'post' => [
				'title'      => 'Adicionar',   // Nome exibido no menu. Somente pages.
				'permission' => '101000000',   // Permissões necessárias para acesso.
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
		// Mensagem retorno padrão.
		$response['msg'] = 'API de Cobrança de Matrícula. Use o Method POST.';

		// Finaliza a execução da função.
		self::$params['response'] = $response;
	}


	/**
	 * post
	 * 
	 * Acessada via primeiro parâmetro ou pelo request method.
	 * Recebe todos os parâmetros do endpoint em $params.
	 * 
	 * Sequência
	 * 	1 - 							Obtém o cliente da requisição (customer).
	 * 		1.1 - 					Trata os campos do cliente.
	 * 	2 - 							Procura a fatura (bill) na base local.
	 * 		2.1 - 					Se tem a fatura (bill) já criada na base local.
	 * 			2.1.1 - 			Monta retorno da API com a response bill.
	 * 		2.2 - 					Se não tem a fatura (bill) já criada na base local.
	 * 			2.2.1 - 			Procura cliente na Vindi.
	 * 				2.2.1.1 - 	Se existir cliente, atualiza o cliente na Vindi.
	 * 				2.2.1.2 - 	Se não existir cliente, cria o cliente na Vindi.
	 * 			2.2.2 - 			Trata os campos da fatura (bill).
	 * 			2.2.3 - 			Cria a fatura (bill) na Vindi.
	 * 			2.2.4 - 			Insere a fatura na base local.
	 *      2.2.5 -       Cria Assinatura junto com a Vindi. (TEM QUE AVALIAR)
	 * 	3 -								Retorna as informações ($responseBill) para quem chamou.
	 *
	 * @param  mixed $params
	 */
	public function post($params)
	{
		// Mensagem retorno padrão.
		$response['msg'] = 'Cobrança de Matrícula.';

		// Identifica se é compra via crédito. (não entra em recorrência.)
		$this->is_credit_card = $_POST['bills'][VindiPaymentHelper::$creditCardId] == 1;

		// Identifica se é compra via crédito com recorrência.
		$this->is_recurrence = $_POST['bills'][VindiPaymentHelper::$creditCardRecurrenceId] == 1;

		// 1 - Tratar os campos.
		// 1.1 Tratar campos de responsável financeiro (cliente).
		$customerSite = $this->tratarCamposCostumer($_POST['customer']);

		// Pega informações para assinatura tbm.
		if ($this->is_recurrence && $_POST['bills']['parcelas'] > 1) {
			$subscriptionsSite = $this->tratarCamposSubscriptions($_POST['bills'], $_POST['customer']);
		}

		// 2 - Verifica se cobrança já existe para o pedido atual.
		// Instancia base de dados local.
		$bdBills = new \BdBills();
		$bdSubscriptions = new \BdSubscriptions();
		// Verifica se existe pedido criado.
		$localBill = $bdBills->selectByCode($_POST['bills']['cod_pedido']);

		// váriável de retorno da bill.
		$response = [];

		// 2.1 - Verifica se existe pedido criado.
		if ($localBill) {
			$response['origemBill'] = 'BDLOCAL';

			// 2.1.1 - Monta retorno da API com a response bill.
			// Pega o json da bill na base de dados local.
			$requestLocalBill['request']   = json_decode($localBill['request'], true);
			$responseLocalBill['response'] = json_decode($localBill['response'], true);

			$response['request'] = $requestLocalBill['request'];
			$response['bill'] = $responseLocalBill['response']['bill'];
		} else {

			// 2.2 Se não tem a fatura (bill) na base local.
			// 2.2.1 Verificar existência do responsável financeiro (cliente) na Vindi.
			$responseVindi = \classes\ApiVindi::getCustomersByCode($customerSite['code']);

			// Verifica se obteve registros.
			if (isset($responseVindi['customers'][0]['id']))
				$customerVindi = $responseVindi['customers'][0];
			else
				$customerVindi = false;

			// 2.2.1.1 - 	Se existir atualiza o cliente na vindi.
			if (isset($customerVindi['id'])) {
				// Seta id do telefone para não criar outro novo
				if (isset($customerVindi['phones'][0]['id']))
					$customerSite['phones'][0]['id'] = $customerVindi['phones'][0]['id'];

				// 2.1 Atualizar o responsável financeiro (cliente) na Vindi.
				$responseVindiUpdate = \classes\ApiVindi::putCustomers($customerVindi['id'], $customerSite);
				// $response['responseVindiUpdate'] = $responseVindiUpdate;

				// Verifico se teve erro.
				if (isset($responseVindiUpdate["errors"])) {
					$response['msg'] = 'Erro ao atualizar cliente.';
					$response['errors'] = $responseVindiUpdate["errors"];
					self::$params['response'] = $response;
					return false;
				}
				$customerVindi = $responseVindiUpdate['customer'];
			} else {
				// 2.2.1.2 - 	Cria o cliente na vindi.
				$responseVindiCreate = \classes\ApiVindi::postCustomers($customerSite);
				// $response['responseVindiCreate'] = $responseVindiCreate;

				// Verifico se teve erro.
				if (isset($responseVindiCreate["errors"])) {
					$response['msg'] = 'Erro ao criar cliente.';
					$response['errors'] = $responseVindiCreate["errors"];
					self::$params['response'] = $response;
					return false;
				}

				$customerVindi = $responseVindiCreate['customer'];
			}

			// Grava o cliente da vindi.
			// $response['customerVindi'] = $customerVindi;

			// Tratar campos de produto.
			$requestCreateBill = $this->tratarCamposBill($_POST['bills'], $customerVindi);

			// 2.2.2 - 			Cria a fatura (bill) na vindi.
			$responseCreateBill = \classes\ApiVindi::postBills($requestCreateBill);

			// Verifico se teve erro.
			if (isset($responseCreateBill['errors'])) {
				$response['msg'] = 'Erro ao criar fatura.';
				$response['errors'] = $responseCreateBill["errors"] ?? null;
				$response['request'] = $requestCreateBill;
				$response['response'] = $responseCreateBill;
				self::$params['response'] = $response;
				return false;
			}

			// Guarda o bill.
			$response['origemBill'] = 'VINDI ';
			$response['bill'] = $responseCreateBill['bill'];

			// 2.2.3 - Insere na base local uma fatura avulsa e guarda retorno.
			$response['idBillLocal'] = $bdBills->insertBill($responseCreateBill, $requestCreateBill);
			// 2.2.4 - Insere na base local a referência da assinatura e guarda retorno.
			// CRIA Prévia de ASSINATURA na BASE LOCAL
			if (!$this->is_credit_card && $_POST['bills']['parcelas'] > 1) {
				$subscriptionsSite['customer_id'] = $customerVindi['id'];
				$response['idSubscriptionsLocal'] = $bdSubscriptions->insertSubscription($subscriptionsSite, $response['bill']['id']);
			}
		}

		// Salva a requisição
		\classes\Logs::requestFromLoja($_POST, $response, $params['infoUrl']['url'], 'POST', 'Requisição de curso da loja.');

		// Finaliza a execução da função.
		self::$params['response'] = $response;
	}


	/**
	 * tratarCamposCostumer
	 * 
	 * Função de apoio para tratar campos.
	 *
	 * @param  array $fields
	 * @return mixed
	 */
	private function tratarCamposCostumer($fields)
	{
		// Verifica se tem valores.
		if (empty($fields)) {
			return false;
		}

		// Ajusta campos.
		$fields = [
			"name"          => $fields['nome'],
			"email"         => $fields["email"],
			"registry_code" => $fields['cpf'] ?? $fields['cnpj'],
			"code"          => $fields['cod_resp_site'],
			"notes"      => $this->getDocumentCostumer($fields),
			// "metadata"      => ['document' => $this->getDocumentCostumer($fields)], // Não funciona.
			"address"       => [
				"street"             => $fields['logradouro'],
				"number"             => $fields['numero'],
				"additional_details" => $fields['complemento'],
				"zipcode"            => str_replace(['-', '.', ','], '', $fields['cep']),
				"neighborhood"       => $fields['bairro'],
				"city"               => $fields['cidade'],
				"state"              => $fields['uf'],
				"country"            => "BR",
			],
			"phones"        => [
				[
					"phone_type" => "mobile",
					"number"     => "55" . $fields['celular_ddd'] . str_replace(['-', '.', ','], '', $fields['celular']),
				]
			]
		];

		// Retorna campos.
		return $fields;
	}




	/**
	 * tratarCamposBill
	 * 
	 * Função de apoio para tratar campos.
	 *
	 * @param  array $fields
	 * @return mixed
	 */
	private function tratarCamposBill($bill, $customer)
	{
		// Verifica se tem valores.
		if (empty($bill) || empty($customer)) {
			return false;
		}


		// Ajusta campos e retorna.
		$camposBill = [
			"customer_id"         => $customer['id'], // 1659448, ID do cliente na VINDI.
			"code"                => $bill['cod_pedido'], // "",
			"installments"        => 1, // Caso seja a matricula é a primeira parcela (apenas 1),
			"payment_method_code" => "credit_card",
			// "billing_at"          => $bill[''], // "10/02/2023", //Data opcional de emissão da cobrança no formato ISO 8601. Se não informada, a cobrança será imediata
			"metadata"            => "",
			"bill_items"          => $this->getBillItens($bill),
		];

		// Verifica se foi definido uma data de vencimento
		if (isset($bill['primeiro_vencimento'])) {
			// Pega a data de vencimento e converte para o formato ISO 8601 (Requisito da VINDI)
			$due_date = date(DATE_ISO8601, strtotime($bill['primeiro_vencimento']));
			// Atualiza a requisição com a data formatada em ISO 8601.
			$camposBill["due_at"] = $due_date;
		}

		// Caso seja pagamento no crédito, informa as parcelas.
		if ($this->is_credit_card) {
			$camposBill["installments"] = $bill['parcelas'];
		}

		// Devolta os campos tratados.
		return $camposBill;
	}

	/**
	 * getBillItens
	 * 
	 * Monta os itens da fatura avulsa.
	 *
	 * @param  mixed $bill
	 * @return array
	 */
	private function getBillItens($bill)
	{

		// Mapeamento de produtos.
		if (BASE_ENV == 'PROD') {
			$product_id = 1288464; // ID produto Matrícula.
		} else {
			$product_id = 200091; // ID produto Matrícula.
		}

		$products = [];


		foreach ($bill['itens'] as $iten) {
			$product = [
				"product_id"  => $product_id, // Produto cadastrado na vindi. (200091 = Matricula)
				// "amount"      => (!$this->is_credit_card?(float)$iten['valor'] * ($bill['percentual_entrada'] / 100):(float)$iten['valor']), // 2000.5,
				"description" => $iten['descricao'] // $bill[''] // "Teste Vindi"
			];

			// Caso seja tudo no cartão de crédito.
			if ($this->is_credit_card) {
				$product['amount'] = ((float)$iten['valor'] - (float)$iten['valor_desconto']);
			} else {

				// Caso seja recorrência e tenha percentual de entrada.
				if (!empty($bill['percentual_entrada'])) {
					$product['amount'] = ((float)$iten['valor'] - (float)$iten['valor_desconto']) * ($bill['percentual_entrada'] / 100);
				} else {
					// Caso seja recorrência e não tenha percentual de entrada.
					$product['amount'] = (float)(((float)$iten['valor'] - (float)$iten['valor_desconto']) / (float)$bill['parcelas']);
				}
			}

			array_push($products, $product);
		}

		return $products;
	}

	private function createPlan($planCode)
	{
		# code...
	}

	/**
	 * tratarCamposSubscriptions
	 *
	 * @param  mixed $subscription
	 * @return array|bool
	 */
	private function tratarCamposSubscriptions($bill, $costumer)
	{
		// Verifica se tem valores.
		if (empty($bill) || empty($costumer)) {
			return false;
		}

		// Monta o código do plano
		$planCode = 'plan' . ((int)$bill['parcelas'] - 1);

		// Id do plano na vindi
		$planId = 0;

		// Pesquisa plano.
		$plansVindi = \classes\ApiVindi::getPlansCode($planCode);

		// Caso não tenha plano, cria um.
		if (empty($plansVindi) || empty($plansVindi['plans']) || !isset($plansVindi['plans'][0])) {
			// Cria um novo plano
			$responseVindi = \classes\ApiVindi::postPlans(
				[
					"name" => "Plano " . ((int)$bill['parcelas'] - 1) . "x",
					"interval" => "months",
					"interval_count" => 1,
					"billing_trigger_type" => "day_of_month",
					"billing_trigger_day" => 1,
					"billing_cycles" => ((int)$bill['parcelas'] - 1),
					"code" => $planCode,
					"description" => "",
					"installments" => 1,
					"invoice_split" => false,
					"status" => "active",
					"plan_items" => [],
					"metadata" => null
				]
			);
			// Obtem o plano do post
			$planId = $responseVindi['plan']['id'];
		} else {
			// Obtem o id do plano ja existente
			$planId = $plansVindi['plans'][0]['id'];
		}

		$data = $bill['primeiro_vencimento'];
		$data = str_replace("/", "-", $data);
		$data = strtotime($data);
		$start = date("d/m/Y", strtotime("+1 Month", $data));

		$dia_formatado = str_pad($bill['proximo_vencimento'], 2, '0', STR_PAD_LEFT);

		// Ajusta vencimento
		$start[0] = $dia_formatado[0];
		$start[1] = $dia_formatado[1];

		// Ajusta campos e retorna.
		return [
			"start_at"            => $start,                        // "",  //data de inicio da assinatura, se não informada será iniciada imediatamente.
			"plan_id"             => $planId,            // 73973, //id do plano escolhido pelo cliente
			"customer_id"         => '',                            // 1703848, //id do cliente - acrescentado antes de inserir a assinatura
			"code"                => $bill['cod_pedido'],           // "P0003",  //código exeterno
			"payment_method_code" => "credit_card",                 // Método de pagamento desejado pelo cliente para pagamento
			"billing_trigger_day" => $bill['proximo_vencimento'],   // 10, //dia que o cliente escolhe para gerar a cobrança e ser cobrado
			"product_items"       => $this->getSubscriptionsItens($bill),
			"payment_profile" => []
		];
	}

	/**
	 * getBillItens
	 * 
	 * Monta os itens da fatura avulsa.
	 *
	 * @param  mixed $bill
	 * @return array
	 */
	private function getSubscriptionsItens($bill)
	{
		// Mapeamento de produtos.
		if (BASE_ENV == 'PROD') {
			$products = [
				'GRA'           => 1288460,   // ID produto GRA. - Esse tem.
				'Intensivo'     => 1288463,   // ID produto Intensivo.
				'Matrícula'     => 1288464,   // ID produto Matrícula.
				'POS' 			=> 1288465,   // ID produto POS. - Esse tem.
				'Produto'       => 1288466,   // ID produto Produto.
			];
		} else {
			$products = [
				'GRA'       => 200277,   // ID produto GRA. - Esse tem.
				'Intensivo' => 200090,   // ID produto Intensivo.
				'Matrícula' => 200091,   // ID produto Matrícula.
				'POS'       => 200278,   // ID produto POS. - Esse tem.
				'Produto'   => 209661,   // ID produto Produto.
			];
		}

		// Monta os itens.
		$itens = [];
		// foreach ($bill['itens'] as $iten) {
		// 	$product = [
		// 		"product_id"  => $products[$iten['tipo_curso']] ?? $products['Intensivo'], // Produto cadastrado na vindi. (200091 = Matricula)
		// 		"pricing_schema" => [
		// 			"price"      => (((float)$iten['valor'] - (float)$iten['valor_desconto']) - (((float)$iten['valor'] - (float)$iten['valor_desconto']) * ($bill['percentual_entrada'] / 100))) / ((int)$bill['parcelas'] - 1), // Entrada do item atual.
		// 			"schema_type" => "flat" //sempre enviar flat = valor fixo
		// 		]
		// 	];
		// 	array_push($itens, $product);
		// }

		// Item
		$itens[0] = [
			"product_id"  => $products['Intensivo'], // Produto cadastrado na vindi.
			"pricing_schema" => [
				"price"      => 0, // Entrada do item atual.
				"schema_type" => "flat" //sempre enviar flat = valor fixo
			]
		];

		if (isset($bill['percentual_entrada']) && $bill['percentual_entrada']) {
			$itens[0]['pricing_schema']['price'] = (($bill['valor_final'] - ($bill['valor_final'] * ($bill['percentual_entrada'] / 100))) / ($bill['parcelas'] - 1));
			// Resultado: 353.11916666667
		} else {
			$itens[0]['pricing_schema']['price'] = ($bill['valor_final'] / $bill['parcelas']);
		}

		return $itens;
	}

	/**
	 * getDocumentCostumer
	 * 
	 * Função que retorna o documento vigênte do cliente.
	 * CPF, PASSAPORTE, CNPJ ou RG
	 *
	 * @param  mixed $costumer
	 * @return string
	 */
	private function getDocumentCostumer($costumer)
	{
		// Caso cliente tenha CPF
		if (isset($costumer['cpf']) && !empty($costumer['cpf']))
			return 'cpf:' . $costumer['cpf'];

		// Caso cliente tenha passaporte
		if (isset($costumer['passaporte']) && !empty($costumer['passaporte']))
			return 'passaporte:' . $costumer['passaporte'];

		// Caso cliente tenha cnpj
		if (isset($costumer['cnpj']) && !empty($costumer['cnpj']))
			return 'cnpj:' . $costumer['cnpj'];

		// Caso cliente tenha rg
		if (isset($costumer['rg']) && !empty($costumer['rg']))
			return 'rg:' . $costumer['rg'];

		return '';
	}
}
