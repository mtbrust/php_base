<?php

namespace classes;

/**
 * Classe HttpRequest.
 * Usado para executar requisições HTTP via curl.
 * 
 */
class HttpRequest
{

	private static $cookies = [];
	private static $error = '';
	private static $info = []; 

	/**
	 * request
	 * 
	 * Função responsável por realizar uma requisição via http
	 * 
	 * @example $options Opções para a chamada http.
	 * $optionsDefault = [
	 * 	'url'     => '',      // Endpoint.
	 * 	'data'    => null,    // Dados POST ou GET.
	 * 	'method'  => 'GET',   // Método GET,POST,PUT,DELETE,etc.
	 * 	'params'  => null,    // Parâmetros via GET (caso use um metodo diferente de GET).
	 * 	'headers' => null,    // Cabeçalhos HTTP.
	 * ];
	 *
	 * @param  mixed $options
	 * @return string
	 */
	static function request($options)
	{
		// Valores default.
		$optionsDefault = [
			'url'     => '',      // Endpoint.
			'data'    => [],    // Dados POST ou GET. (array)
			'method'  => 'GET',   // Método GET,POST,PUT,DELETE,etc.
			'params'  => null,    // Parâmetros via GET (caso use um metodo diferente de GET).
			'headers' => [],    // Cabeçalhos HTTP.
		];
		
		// Junta e sobreescreve Default
		$options = array_replace_recursive($optionsDefault, $options);

		// Cria a sessão.
		$sessao_curl = curl_init(); //inicializando

		switch ($options['method']) {
			// Monta os valores get.
			case 'GET':
				// Verifica se o data não está vazio
				if(count($options['data']) > 0)
				$options['url'] .= '?' . http_build_query($options['data'], '', '&amp;');
				break;
			case 'POST':
				curl_setopt($sessao_curl, CURLOPT_POST, true);
				curl_setopt($sessao_curl, CURLOPT_POSTFIELDS, json_encode($options['data'], true));
				break;
			case 'PUT':
				curl_setopt($sessao_curl, CURLOPT_POST, true);
				curl_setopt($sessao_curl, CURLOPT_POSTFIELDS, json_encode($options['data'], true));
				break;
			case 'DELETE':
				curl_setopt($sessao_curl, CURLOPT_POST, true);
				curl_setopt($sessao_curl, CURLOPT_POSTFIELDS, json_encode($options['data'], true));
				break;
			case 'PATCH':
				// curl_setopt($sessao_curl, CURLOPT_HEADER, false);
				curl_setopt($sessao_curl, CURLOPT_POSTFIELDS, json_encode($options['data'], true));
				curl_setopt($sessao_curl, CURLOPT_ENCODING, "");
				curl_setopt($sessao_curl, CURLOPT_MAXREDIRS, 10);
				curl_setopt($sessao_curl, CURLOPT_TIMEOUT, 0);
				curl_setopt($sessao_curl, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($sessao_curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
				break;

			default:
				echo 'Método [' . $options['method'] . '] da Requisição HTML não suportado. Necessário implementar.';
				exit;
				// break;
		}

		// Acrescenta informações de parametros no get.
		if (!empty($options['params'])) {
			$options['url'] .= '?' . http_build_query($options['params'], '', '&amp;');
		}

		// Seta as demais opções.
		curl_setopt($sessao_curl, CURLOPT_HEADER, 1);
		curl_setopt($sessao_curl, CURLOPT_CUSTOMREQUEST, $options['method']);
		curl_setopt($sessao_curl, CURLOPT_URL, $options['url']);
		curl_setopt($sessao_curl, CURLOPT_HTTPHEADER, $options['headers']);
		curl_setopt($sessao_curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($sessao_curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($sessao_curl, CURLOPT_SSL_VERIFYPEER, false);
		
		// Guarda o retorno da requisição.
		$r = curl_exec($sessao_curl);
		
		// Caso tenha retornado erro na execução.
		$errorMessage = curl_error($sessao_curl);
		if ($errorMessage) {
			// Retorna false
			$r = false;
			// Guarda erro.
			self::$error = $errorMessage;
		}

		// Obtém todas as informações da requisição.
		self::$info = curl_getinfo($sessao_curl);	

		// Armazena os cookies na variavel
		self::$cookies = self::_getCookies($r);

		// Obtem os dados da resposta
		$r = self::_getData($r);

		// Fecha sessão http aberta.
		curl_close($sessao_curl);

		// Grava Log.
		\classes\Logs::request(json_encode($options['data'], JSON_UNESCAPED_UNICODE), $r, $options['url'], $options['method']);

		return $r;
	}

	/**
	 * Retorna um array contendo os cookies retornados da requisição
	 *
	 * @param mixed $requestResult
	 * 
	 * @return array
	 * 
	 */
	private static function _getCookies($requestResult)
    {
		// Obtem os cookies retornados na requisição
        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $requestResult, $matches);
        $cookies = array();
        foreach($matches[1] as $item) {
			parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }
       return $cookies;
    }

	/**
	 * Retorna uma string contendo os dados retornados da requisição
	 *
	 * @param mixed $requestResult
	 * 
	 * @return string
	 * 
	 */
	private static function _getData($requestResult)
    {
		// Quebra a resposta em linhas
        $lines = explode("\n", $requestResult);
		
		$isData = false;
		$data = '';
		foreach ($lines as $key => $line) {


			// $opt = explode(':',$line);

			// Separador entre cabeçalho e dados
			if(!$isData && (ord($line) == 13)) {
				$isData = true;
				// Pula a execução abaixo.
				continue;
			}
			
			if($isData) {
				$data .= $line."\n";
			}
		}
		
       return $data;
    }

	/**
	 * Retorna um array contendo os cookies retornados na última requisição
	 *
	 * @return array
	 * 
	 */
	public static function getCookies(){
		return self::$cookies;
	}

	/**
	 * Retorna uma string com a mensagem de erro
	 * 
	 * @return string
	 */
	public static function getError()
	{
		return self::$error;
	}

	/**
	 * getInfo
	 * 
	 * Retorna as informações da requisição.
	 *
	 * @return array
	 */
	public static function getInfo()
	{
		return self::$info;
	}
}
