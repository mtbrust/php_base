<?php

namespace classes;

/**
 * DevHelper
 * Classe com métodos de apoio ao desenvolvimento
 * 
 * @since 1.1.0
 * 
 * @author Wender <paulo.wender@cetrus.com.br>
 */
class DevHelper
{
    /**
     * Valor padrão utilizado nos prints quando nenhum dado é recebido
     *
     * @var string
     */
    private static string $defaultValue = 'Opa, chegou aqui 😬';

    public static function printr($value = null)
    {
        echo ('<pre>');
        print_r($value ?? self::$defaultValue);
        echo ('</pre>');
        exit;
    }
    public static function echo($value = null)
    {
        echo ($value ?? self::$defaultValue);
        exit;
    }

    public static function printrOnly($value = null)
    {
        echo ('<pre>');
        print_r($value ?? self::$defaultValue);
    }

    /**
     * Printa um Json e encerra o fluxo
     *
     * @param mixed $array // Dados para serem encodados e exibidos
     * 
     * @return void
     * 
     */
    public static function printJson($array): void
    {
        self::printEncodedJson(json_encode($array));
    }

    public static function printEncodedJson($encodedJson)
    {
        header("Content-Type: application/json");
        echo ($encodedJson);
        exit;
    }

    /**
     * Pega um json recebido no body e retorna um objeto
     */
    public static function getJsonBody($associative = null)
    {
        // Pega os dados da request e decoda
        return json_decode(self::getRequestParamns(), $associative);
    }

    /**
     * Retorna o body da request
     */
    public static function getRequestParamns()
    {
        // Pega os dados da request
        $paramns = file_get_contents('php://input');
        return $paramns;
    }
        
    /**
     * Retorna os headers da request
     *
     * @param string|null $key
     * 
     * @return array|mixed
     * 
     */
    public static function getRequestHeaders($key = null)
    {
        // Pega os headers da request
        $headers = getallheaders();
        if($key) {
            return $headers[$key];
        } else {
            return $headers;
        }
    }

    /**
     * Pega os parametros passados por get e retorna em um array
     * Se informado uma postion irá retornar o valor encontrado nessa posição
     */
    public static function getUrlParamns(int $position = null)
    {
        $paramns = explode("/", str_replace("?", "/", $_SERVER["REQUEST_URI"]));
        if ($position) {
            return $paramns[$position];
        }

        return $paramns;
    }

    /**
     * Retorna a url base atual
     */
    public static function getBaseUrl()
    {
        return $_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER["HTTP_HOST"];
    }

    /**
     * Retorna um array contendo os cookies retornados da requisição
     * É necessário setar antes da requisição o valor:
     *  `curl_setopt($sessao_curl, CURLOPT_HEADER, 1);`
     *
     * @param string $requestResult
     * 
     * @return array
     * 
     */
    private static function getResponseCookies(string $requestResult)
    {
        // Obtem os cookies retornados na requisição
        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $requestResult, $matches);
        $cookies = array();
        foreach ($matches[1] as $item) {
            parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }
        return $cookies;
    }

    /**
     * Retorna uma string contendo os dados retornados da requisição
     * É necessário setar antes da requisição o valor:
     *  `curl_setopt($sessao_curl, CURLOPT_HEADER, 1);`
     *
     * @param string $requestResult
     * 
     * @return string
     * 
     */
    private static function getResponseData(string $requestResult)
    {
        // Quebra a resposta em linhas
        $lines = explode("\n", $requestResult);

        $isData = false;
        $data = '';
        foreach ($lines as $key => $line) {
            // Separador entre cabeçalho e dados
            if (ord($line) == 13) {
                $isData = true;
            }

            if ($isData) {
                $data .= $line . "\n";
            }
        }

        return $data;
    }

    /**
     * getRemoteIp
     *
     * @return string
     */
    public static function getRemoteIp()
    {
        // Se preferir usar sempre a variável $_SERVER['REMOTE_ADDR'], você pode verificar e setar antes.
        if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            return $_SERVER['HTTP_CF_CONNECTING_IP'];
        }
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     */
    public function __construct($defaultValue)
    {
        $this->defaultValue = $defaultValue;
    }
}
