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
class productinvoice extends \controllers\EndPoint
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
				'key'   => 'Authorization',                       // Tipo de autorização (Bearer Token, API Key, JWT Bearer Basic Auth, etc.).
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

		if (!isset($params['infoUrl']['attr'][0])) {
			$response['msg'] = 'Código do pedido não informado';
		} else {
			// Instancia base de dados local.
			$bdBills = new \BdBills();
			// Verifica se existe pedido criado.
			$r = $bdBills->selectByCode($params['infoUrl']['attr'][0]);

			if (!isset($r['response'])) {
				$response['msg'] = 'Código do pedido não encontrado.';
				// Finaliza a execução da função.
				self::$params['response'] = $response;
				return true;
			}

			// $response = json_decode($r['response'],true);
			$response = $r;
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
	 * Sequência
	 * 	1 - 							Obtém o cliente da requisição (customer).
	 * 		1.1 - 					Trata os campos do cliente.
	 * 	2 - 							Procura a fatura (bill) na base local.
	 * 		2.1 - 					Se tem a fatura (bill) já criada.
	 * 			2.1.1 - 			Monta retorno da API com a response bill.
	 * 		2.2 - 					Se não tem a fatura (bill) na base local.
	 * 			2.2.1 - 			Verifica se usuário está cadastrado na vindi.
	 * 				2.2.1.1 - 	Se existir atualiza o cliente na vindi.
	 * 				2.2.1.2 - 	Se não existir, cria o cliente na vindi.
	 * 			2.2.2 - 			Cria a fatura (bill) na vindi.
	 * 			2.2.3 - 			Insere a fatura na base local.
	 * 	3 -								Retorna as informações ($responseBill) para quem chamou.
	 *
	 * @param  mixed $params
	 */
	public function post($params)
	{

		// 1 - Tratar os campos.
		// 1.1 Tratar campos de responsável financeiro (cliente).
		$customerSite = $this->tratarCamposCostumer($_POST['customer']);

		// 2 - Verifica se cobrança já existe para o pedido atual.
		// Instancia base de dados local.
		$bdBills = new \BdBills();
		// Verifica se existe pedido criado.
		$localBill = $bdBills->selectByCode($_POST['bill']['cod_pedido']);

		// váriável de retorno da bill.
		$response = [];

		// 2.1 - Verifica se existe pedido criado.
		if ($localBill) {
			$response['origemBill'] = 'BDLOCAL';

			// 2.1.1 - Monta retorno da API com a response bill.
			// Pega o json da bill na base de dados local.
			$requestLocalBill['request'] = json_decode($localBill['request'], true);
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
				$customerVindi = NULL;

			// 2.2.1.1 - 	Se existir atualiza o cliente na vindi.
			if (isset($customerVindi)) {
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
			$response['customerVindi'] = $customerVindi;

			// Tratar campos de produto.
			$requestCreateBill = $this->tratarCamposBill($_POST['bill'], $customerVindi);

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
			// $response['insertBillSql'] = $bdBills::$sql;
		}


		// Salva a requisição
		// \classes\Logs::requestFromLoja($_POST, $response, $params['infoUrl']['url'], 'POST', 'Requisição de produto no e-commerce.');

		// 3 - Finaliza a execução da função.
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
	 * Função é chamada quando o metodo for get e o primeiros parametro for foo_personalizada.
	 * Recebe todos os parâmetros do endpoint em $params.
	 *
	 * @param  mixed $params
	 */
	public function foo_personalizada($params)
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
			"notes"         => $this->getDocumentCostumer($fields),
			"address"       => [
				"street"             => $fields['endereco'],
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

		// verifica código mocado.
		if (BASE_ENV == 'PROD') {
			$product_id = 1288466; // ID produto Produto.
		} else {
			$product_id = 209661; // ID produto Produto.
		}

		// Ajusta campos.
		$bill = [
			"customer_id"         => $customer['id'], // 1659448, ID do cliente na VINDI.
			"code"                => $bill['cod_pedido'], // "",
			"installments"        => $bill['forma_pagamento_parcelas'], // 0,
			"payment_method_code" => "credit_card",
			// "billing_at"          => $bill[''], // "10/02/2023", //Data opcional de emissão da cobrança no formato ISO 8601. Se não informada, a cobrança será imediata
			// "due_at"              => $bill[''], // "12/02/2023", //Data opcional de vencimento da cobrança no formato ISO 8601. Se não informada, o vencimento padrão será utilizado
			"metadata"            => "",
			"bill_items"          => [
				[
					"product_id"  => $product_id, // Produto cadastrado na vindi. (Produto)
					"amount"      => $bill['valor_final'], // 2000.5,
					"description" => $bill['itens'][0]['descricao'] // $bill[''] // "Teste Vindi"
				]
			]
		];

		// Retorna campos.
		return $bill;
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
