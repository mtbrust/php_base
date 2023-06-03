<?php

namespace classes;

/**
 * Classe 
 */
class JWT
{


  /**
   * createToken
   * Função que constroi o JWT Token e retorna o token.
   *
   * @param  array $headers_encoded
   * @param  array $payload_encoded
   * @param  string $key
   * @return string
   */
  public static function createToken($payload, $key = null)
  {
    // Gera uma chave de assinatura.
    $key = Self::createKey($key);

    // Valores JWT teste:
    $headers = [
      'typ' => 'JWT',
      'alg' => 'HS256'
    ];

    // To Json
    $headers_encoded = json_encode($headers);
    $payload_encoded = json_encode($payload);

    // To Base 64
    $headers_64 = base64_encode($headers_encoded);
    $payload_64 = base64_encode($payload_encoded);

    //build the signature 
    //$key = 'secret';
    $signature = hash_hmac('SHA256', "$headers_64.$payload_64", $key, true);
    $signature_64 = base64_encode($signature);

    //build and return the token 
    $token = "$headers_64.$payload_64.$signature_64";
    return $token;
  }


  /**
   * verificaToken
   * Função que verifica token e retorna o um array com o payload.
   *
   * @param  mixed $token
   * @return void
   */
  static function verificaToken($token, $key = null)
  {
    // Gera uma chave de assinatura.
    $key = Self::createKey($key);

    // Separa o token.
    $jwt = explode('.', $token);

    // Valores do token.
    $headers_64   = $jwt[0];
    $payload_64   = $jwt[1];
    $signature_64 = $jwt[2];
    
    // if (!$signature == base64_encode(hash_hmac('SHA256', $headers . $payload, $key, true)))
    //   return false;
    
    // Verifica a assinatura do token;
    $newSignature = base64_encode(hash_hmac('SHA256', "$headers_64.$payload_64", $key, true));
    if ($newSignature == $signature_64) {
      // Retorna o array do payload decodificado.
      $payload = json_decode(base64_decode($payload_64), true);
      // print_r($payload);
      return $payload;
    }
    
    // Tokem não confere.
    return false;
  
  }

  /**
   * Cria uma chave padrão.
   *
   * @param string $key
   * @return string
   */
  static function createKey($key = null){
    if (!$key) {
      $key = CONF_GERAL_JWT_TOKEN;
    }
    return $key;
  }


  /**
   * Cria o token para uso de api em uma controller.
   *
   * @return string
   */
  public static function formTokenApi()
  {
		// Parâmetros do token.
		$tokenDia      = date('d');                                     // Objetivo que token dure 1 dia.
		$tokenSenha    = "SetorTI";                                     // Único parâmetro interno.
	
		// Cria um token para POST da API fixo para ser usado em qualquer função (POST, PUT, GET, GETFULL, DELETE, TESTE. API).
		$formTokenApi = md5($tokenDia . 'api' . $tokenSenha);

    // Retorna token de API.
    return $formTokenApi;
  }



  /**
   * Função que cria o token da página.
   * Cria o token que segue as seguintes regras de segurança:
   *  Matrícula Logado. (opcional)
   *  Url da página acessada.
   *  Rest atual.
   *  ApiRest atual. (opcional)
   * 
   * @param array $payload
   * @param string $key
   * @return string
   */
  public static function createPageToken($options, $key = null)
  {
    // Parametro rest atual.
    $matricula = ControllerSecurity::getSession('matricula')?ControllerSecurity::getSession('matricula'):0;
    $urlPage = Core::getInfoDirUrl('path_dir') . Core::getInfoDirUrl('file');
    $rest = isset(Core::getInfoDirUrl('attr')[0]) ? Core::getInfoDirUrl('attr')[0] : 'index';

    // Monta as opções default.
    $payload = [
      'matricula' => $matricula, // Matricula usuário logado.
      'urlPage'   => $urlPage,   // Url da página atual.
      'rest'      => $rest,      // [index], [post], [put], [get], [getFull], [delete], [test], [api] 
      'apiRest'   => 'index',    // [index], [post], [put], [get], [getFull], [delete], [test], [api]
    ];
    // Sobrescreve as opções default.
    $payload = array_merge($payload, $options);

    // Valores headers padrão JWT
    $headers = [
      'typ' => 'JWT',
      'alg' => 'HS256'
    ];

    // Transforma em JSON.
    $headers_encoded = json_encode($headers);
    $payload_encoded = json_encode($payload);

    // Transforma em Base64.
    $headers_64 = base64_encode($headers_encoded);
    $payload_64 = base64_encode($payload_encoded);

    // Monta a assinatura. 
    $signature = hash_hmac('SHA256', "$headers_64.$payload_64", Self::createKey($key), true);
    $signature_64 = base64_encode($signature);

    // Monta o token.
    $token = "$headers_64.$payload_64.$signature_64";

    // Retorna o token.
    return $token;
  }
}
