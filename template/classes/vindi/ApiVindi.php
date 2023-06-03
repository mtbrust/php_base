<?php

namespace classes;

/**
 * Classe Modelo.
 * Usado para executar funções específicas de um determinado assunto.
 */
class ApiVindi
{

	/**
	 * token
	 *
	 * @var string
	 */
	static private $token = BASE_AUTH['vindi_token'];

	/**
	 * url
	 *
	 * @var string
	 */
	static private $url = BASE_AUTH['vindi_url'];


	// Transforma autenticação de login em base 64	
	/**
	 * authHeaders
	 *
	 * @return array
	 */
	static private function authHeaders()
	{

		$auth = base64_encode(self::$token . ':');
		// retorna cabeçalhos HTTPS:
		return [
			'Authorization: Basic ' . $auth,
			'Content-Type: application/json'
		];
	}

	static private function errors($r)
	{
		return $r;
	}

	/**
	 * getCustomers
	 *
	 * @param  mixed $document
	 * @return array|bool
	 */
	static public function getCustomers($document)
	{

		// Tratamento dos dados.
		$data = [
			'query' => 'registry_code=' . $document,
		];

		//Opções para envio da requisição.
		$options = [
			'url'     => self::$url . 'customers',   // Endpoint.
			'data'    => $data,                      // Dados POST ou GET.
			'method'  => 'GET',                      // Método GET,POST,PUT,DELETE,etc.
			'headers' => self::authHeaders(),        // Cabeçalhos HTTP.
		];

		// Envio da requisição.
		$r = \classes\HttpRequest::request($options);
		$r = json_decode($r, true);
		// Verifica e trata errors.
		if (isset($r['errors'])) {
			return self::errors($r);
		}
		// Retorna a resposta do servidor.
		return $r;
	}

	/**
	 * getCustomersByCode
	 * 
	 * Procura um cliente pelo código de responsável financeiro na loja.
	 *
	 * @param  mixed $document
	 * @return array|bool
	 */
	static public function getCustomersByCode($code)
	{

		// Tratamento dos dados.
		$data = [
			'query' => 'code=' . $code,
		];

		//Opções para envio da requisição.
		$options = [
			'url'     => self::$url . 'customers',   // Endpoint.
			'data'    => $data,                      // Dados POST ou GET.
			'method'  => 'GET',                      // Método GET,POST,PUT,DELETE,etc.
			'headers' => self::authHeaders(),        // Cabeçalhos HTTP.
		];

		// Envio da requisição.
		$r = \classes\HttpRequest::request($options);
		$r = json_decode($r, true);
		// Verifica e trata errors.
		if (isset($r['errors'])) {
			return self::errors($r);
		}
		// Retorna a resposta do servidor.
		return $r;
	}


	/**
	 * putCustomers
	 *
	 * @param  mixed $id
	 * @param  mixed $data
	 * @return array|bool
	 */
	static public function putCustomers($id, $data)
	{

		//Opções para envio da requisição.
		$options = [
			'url'     => self::$url . 'customers/' . $id,   // Endpoint.
			'data'    => $data,                               // Dados POST ou GET.
			'method'  => 'PUT',                               // Método GET,POST,PUT,DELETE,etc.
			'headers' => self::authHeaders(),                 // Cabeçalhos HTTP.
		];

		// Envio da requisição.
		$r = \classes\HttpRequest::request($options);
		$r = json_decode($r, true);

		// Verifica e trata errors.
		if (isset($r['errors'])) {
			return self::errors($r);
		}
		// Retorna a resposta do servidor.
		return $r;
	}

	/**
	 * postCustomers
	 *
	 * @param  mixed $data
	 * @return array|bool
	 */
	static public function postCustomers($data)
	{

		//Opções para envio da requisição.
		$options = [
			'url'     => self::$url . 'customers',   // Endpoint.
			'data'    => $data,                        // Dados POST ou GET.
			'method'  => 'POST',                       // Método GET,POST,PUT,DELETE,etc.
			'headers' => self::authHeaders(),          // Cabeçalhos HTTP.
		];

		// Envio da requisição.
		$r = \classes\HttpRequest::request($options);
		$r = json_decode($r, true);

		// Verifica e trata errors.
		if (isset($r['errors'])) {
			return self::errors($r);
		}
		// Retorna a resposta do servidor.
		return $r;
	}

	/**
	 * postBills
	 *
	 * @param  mixed $data
	 * @return array|bool
	 */
	static public function postBills($data)
	{
		//Opções para envio da requisição.
		$options = [
			'url'     => self::$url . 'bills',   // Endpoint.
			'data'    => $data,                    // Dados POST ou GET.
			'method'  => 'POST',                   // Método GET,POST,PUT,DELETE,etc.
			'headers' => self::authHeaders(),      // Cabeçalhos HTTP.
		];

		// Envio da requisição.
		$r = \classes\HttpRequest::request($options);
		$r = json_decode($r, true);

		// Verifica e trata errors.
		if (isset($r['errors'])) {
			return self::errors($r);
		}
		// Retorna a resposta do servidor.
		return $r;
	}

	/**
	 * deleteBill
	 *
	 * @param  mixed $id
	 * @return array|bool
	 */
	static public function deleteBill($id)
	{

		//Opções para envio da requisição.
		$options = [
			'url'     => self::$url . 'bills/' . $id,   // Endpoint.
			'method'  => 'DELETE',               // Método GET,POST,PUT,DELETE,etc.
			'headers' => self::authHeaders(),    // Cabeçalhos HTTP.
		];

		// Envio da requisição.
		$r = \classes\HttpRequest::request($options);
		$r = json_decode($r, true);

		// Verifica e trata errors.
		if (isset($r['errors'])) {
			return self::errors($r);
		}
		// Retorna a resposta do servidor.
		return $r;
	}

	/**
	 * postSubscriptions
	 *
	 * @param  mixed $data
	 * @return array|bool
	 */
	static public function postSubscriptions($data)
	{
		//Opções para envio da requisição.
		$options = [
			'url'     => self::$url . 'subscriptions',   // Endpoint.
			'data'    => $data,                            // Dados POST ou GET.
			'method'  => 'POST',                           // Método GET,POST,PUT,DELETE,etc.
			'headers' => self::authHeaders(),              // Cabeçalhos HTTP.
		];

		// Envio da requisição.
		$r = \classes\HttpRequest::request($options);
		$r = json_decode($r, true);

		// Verifica e trata errors.
		if (isset($r['errors'])) {
			// return self::errors($r);
			return $r;
		}
		// Retorna a resposta do servidor.
		return $r;
	}

	/**
	 * putSubscriptions
	 *
	 * @param  mixed $id
	 * @param  mixed $data
	 * @return array|bool
	 */
	static public function putSubscriptions($id, $data)
	{
		//Opções para envio da requisição.
		$options = [
			'url'     => self::$url . 'subscriptions/' . $id,   // Endpoint.
			'data'    => $data,                                   // Dados POST ou GET.
			'method'  => 'PUT',                                   // Método GET,POST,PUT,DELETE,etc.
			'headers' => self::authHeaders(),                     // Cabeçalhos HTTP.
		];

		// Envio da requisição.
		$r = \classes\HttpRequest::request($options);
		$r = json_decode($r, true);

		// Verifica e trata errors.
		if (isset($r['errors'])) {
			return self::errors($r);
		}
		// Retorna a resposta do servidor.
		return $r;
	}


	/**
	 * getBills
	 *
	 * @param  mixed $id
	 * @return array|bool
	 */
	static public function getBills($id)
	{

		//Opções para envio da requisição.
		$options = [
			'url'     => self::$url . 'bills/' . $id,   // Endpoint.
			'method'  => 'GET',                         // Método GET,POST,PUT,DELETE,etc.
			'headers' => self::authHeaders(),           // Cabeçalhos HTTP.
		];

		// Envio da requisição.
		$r = \classes\HttpRequest::request($options);
		$r = json_decode($r, true);

		// Verifica e trata errors.
		if (isset($r['errors'])) {
			return self::errors($r);
		}
		// Retorna a resposta do servidor.
		return $r;
	}


	/**
	 * getBillsCode
	 *
	 * @param  mixed $id
	 * @return array|bool
	 */
	static public function getBillsCode($code)
	{

		//Opções para envio da requisição.
		$options = [
			'url'     => self::$url . 'bills/?query=code=' . $code,   // Endpoint.
			'method'  => 'GET',                                       // Método GET,POST,PUT,DELETE,etc.
			'headers' => self::authHeaders(),                         // Cabeçalhos HTTP.
		];

		// Envio da requisição.
		$r = \classes\HttpRequest::request($options);
		$r = json_decode($r, true);

		// Verifica e trata errors.
		if (isset($r['errors'])) {
			return self::errors($r);
		}
		// Retorna a resposta do servidor.
		return $r;
	}


	/**
	 * getBillById
	 *
	 * @param  mixed $id
	 * @return array|bool
	 */
	static public function getBillById($id)
	{

		// Tratamento dos dados.
		$data = [];

		//Opções para envio da requisição .
		$options = [
			'url'     => self::$url . 'bills/' . $id,   // Endpoint.
			'data'    => $data,                    // Dados POST ou GET.
			'method'  => 'GET',                    // Método GET,POST,PUT,DELETE,etc.
			'headers' => self::authHeaders(),      // Cabeçalhos HTTP.
		];

		// Envio da requisição.
		$r = \classes\HttpRequest::request($options);
		$r = json_decode($r, true);

		// Verifica e trata errors.
		if (isset($r['errors'])) {
			return self::errors($r);
		}
		// Retorna a resposta do servidor.
		return $r;
	}


	/**
	 * getBillsSubscriptions
	 *
	 * @param  mixed $id
	 * @return array|bool
	 */
	static public function getBillsSubscriptions($id, $status)
	{

		// Tratamento dos dados.
		$data = [
			'query' => 'subscription_id=' . $id . ' AND status=' . $status,
		];

		//Opções para envio da requisição.
		$options = [
			'url'     => self::$url . 'bills',   // Endpoint.
			'data'    => $data,                    // Dados POST ou GET.
			'method'  => 'GET',                    // Método GET,POST,PUT,DELETE,etc.
			'headers' => self::authHeaders(),      // Cabeçalhos HTTP.
		];

		// Envio da requisição.
		$r = \classes\HttpRequest::request($options);
		$r = json_decode($r, true);

		// Verifica e trata errors.
		if (isset($r['errors'])) {
			return self::errors($r);
		}
		// Retorna a resposta do servidor.
		return $r;
	}

	/**
	 * getSubscriptionsCustomer
	 *
	 * @param  mixed $id
	 * @return array|bool
	 */
	static public function getSubscriptionsByCustomer($id)
	{

		// Tratamento dos dados.
		$data = [
			'query' => 'customer_id=' . $id,
		];

		//Opções para envio da requisição.
		$options = [
			'url'     => self::$url . 'subscriptions',   // Endpoint.
			'data'    => $data,                    // Dados POST ou GET.
			'method'  => 'GET',                    // Método GET,POST,PUT,DELETE,etc.
			'headers' => self::authHeaders(),      // Cabeçalhos HTTP.
		];

		// Envio da requisição.
		$r = \classes\HttpRequest::request($options);
		$r = json_decode($r, true);

		// Verifica e trata errors.
		if (isset($r['errors'])) {
			return self::errors($r);
		}
		// Retorna a resposta do servidor.
		return $r;
	}

	/**
	 * getSubscriptions
	 *
	 * @param  mixed $id
	 * @return array|bool
	 */
	static public function getSubscriptionsById($id)
	{

		//Opções para envio da requisição.
		$options = [
			'url'     => self::$url . 'subscriptions/' . $id,   // Endpoint.
			'data'    => null,                                    // Dados POST ou GET.
			'method'  => 'GET',                                   // Método GET,POST,PUT,DELETE,etc.
			'headers' => self::authHeaders(),                     // Cabeçalhos HTTP.
		];

		// Envio da requisição.
		$r = \classes\HttpRequest::request($options);
		$r = json_decode($r, true);

		// Verifica e trata errors.
		if (isset($r['errors'])) {
			return self::errors($r);
		}
		// Retorna a resposta do servidor.
		return $r;
	}


	/**
	 * deleteSubscriptions
	 *
	 * @param  mixed $id
	 * @return array|bool
	 */
	static public function deleteSubscriptions($id)
	{

		//Opções para envio da requisição.
		$options = [
			'url'     => self::$url . 'subscriptions/' . $id,   // Endpoint.
			'data'    => null,                                    // Dados POST ou GET.
			'method'  => 'DELETE',                                   // Método GET,POST,PUT,DELETE,etc.
			'headers' => self::authHeaders(),                     // Cabeçalhos HTTP.
		];

		// Envio da requisição.
		$r = \classes\HttpRequest::request($options);
		$r = json_decode($r, true);

		// Verifica e trata errors.
		if (isset($r['errors'])) {
			return self::errors($r);
		}
		// Retorna a resposta do servidor.
		return $r;
	}

	/**
	 * getPlansCode
	 *
	 * @param  mixed $id
	 * @return array|bool
	 */
	static public function getPlansCode($code)
	{

		//Opções para envio da requisição.
		$options = [
			'url'     => self::$url . 'plans/?query=code=' . $code,   // Endpoint.
			'method'  => 'GET',                                       // Método GET,POST,PUT,DELETE,etc.
			'headers' => self::authHeaders(),                         // Cabeçalhos HTTP.
		];

		// Envio da requisição.
		$r = \classes\HttpRequest::request($options);
		$r = json_decode($r, true);

		// Verifica e trata errors.
		if (isset($r['errors'])) {
			return self::errors($r);
		}
		// Retorna a resposta do servidor.
		return $r;
	}


	/**
	 * postSubscriptions
	 *
	 * @param  mixed $data
	 * @return array|bool
	 */
	static public function postPlans($data)
	{
		//Opções para envio da requisição.
		$options = [
			'url'     => self::$url . 'plans',   // Endpoint.
			'data'    => $data,                            // Dados POST ou GET.
			'method'  => 'POST',                           // Método GET,POST,PUT,DELETE,etc.
			'headers' => self::authHeaders(),              // Cabeçalhos HTTP.
		];

		// Envio da requisição.
		$r = \classes\HttpRequest::request($options);
		$r = json_decode($r, true);

		// Verifica e trata errors.
		if (isset($r['errors'])) {
			// return self::errors($r);
			return $r;
		}
		// Retorna a resposta do servidor.
		return $r;
	}
}
