<?php

namespace classes;
use BdLogsLoja;

/**
 * Classe Modelo.
 * Usado para executar funções específicas de um determinado assunto.
 */
class Logs
{
	/**
	 * httpRequest
	 * 
	 * Responsável por verificar e gravar os logs.
	 *
	 * @param mixed $request
	 * @param mixed $response
	 * @param mixed $url
	 * @param mixed $method
	 * 
	 * @return mixed
	 * 
	 */
	public static function request($request, $response, $url, $method)
	{
		// Regras da Vindi
		if (str_contains($url, 'vindi.com.br'))
			return self::requestVindi($request, $response, $url, $method);

		// Regras da Loja
		if (str_contains($url, BASE_AUTH['loja_url']))
			return self::responseToLoja($request, $response, $url, $method);

		return true;
	}


	private static function requestVindi($request, $response, $url, $method)
	{
		// Campos para insert na tabela.
		$fields = [
			'sourceIP' => DevHelper::getRemoteIp(),
			'request' => $request,
			'response' => $response,
			'dtCreate' => date('Y-m-d H:i:s'),
			'url' => $url,
			'method' => $method,
		];
		// insert tabela logVindi.
		$bdLogsVindi = new \BdLogsVindi();
		$bdLogsVindi->insert($fields);
	}

	private static function responseToLoja($request, $response, $url, $method)
	{
		// Campos para insert na tabela.
		$fields = [
			'sourceIP' => DevHelper::getRemoteIp(),
			'dtCreate' => date('Y-m-d H:i:s'),
			'code' => json_decode($request)->bill->code,
			'url' => $url,
			'method' => $method,
			'response' => $response,
			'request' => $request,
		];
		// insert tabela logLoja.
		$BdLogsLoja = new BdLogsLoja();
		$BdLogsLoja->insert($fields);
	}

	public static function requestFromLoja($request, $response, $url, $method, $obs = 'Requisição da Loja para o integrador.')
	{
		// Campos para insert na tabela.
		$fields = [
			'sourceIP' => DevHelper::getRemoteIp(),
			'dtCreate' => date('Y-m-d H:i:s'),
			'code'     => $request['bills']['cod_pedido'],
			'url'      => $url,
			'method'   => $method,
			'response' => json_encode($response, JSON_UNESCAPED_UNICODE),
			'request'  => json_encode($request, JSON_UNESCAPED_UNICODE),
			'obs'      => $obs,
		];
		// insert tabela logLoja.
		$BdLogsLoja = new BdLogsLoja();
		$BdLogsLoja->insert($fields);
	}
}
