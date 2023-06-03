<?php

namespace classes;

/**
 * Classe Modelo.
 * Usado para executar funções específicas de um determinado assunto.
 */
class ApiLoja
{

	/**
	 * token
	 *
	 * @var string
	 */
	static private $token = BASE_AUTH['token_loja'];

	/**
	 * url
	 *
	 * @var string
	 */
	static private $url = BASE_AUTH['loja_url'];


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
	

	/**
	 * erros
	 *
	 * @param  mixed $r
	 * @return bool
	 */
	static private function erros($r)
	{
		return $r;
	}


	/**
	 * getCustomers
	 *
	 * @param  array $bill
	 * @return array|bool
	 */
	static public function postNotificationVindi($bill)
	{

		//Opções para envio da requisição.
		$options = [
			'url'     => self::$url . 'notificationvindi',   // Endpoint.
			'data'    => $bill,                              // Dados POST ou GET.
			'method'  => 'POST',                             // Método GET,POST,PUT,DELETE,etc.
			'headers' => self::authHeaders(),                // Cabeçalhos HTTP.
		];

		// Envio da requisição.
		$r = \classes\HttpRequest::request($options);

		$array = json_decode($r, true);
		if ($array)
			$r = $array;
			
		// Verifica e trata erros.
		if (isset($r['erros'])) {
			return self::erros($r);
		}
		// Retorna a resposta do servidor.
		return $r;
	}
}
