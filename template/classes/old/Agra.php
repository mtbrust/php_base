<?php

namespace classes;
/**
 * Classe para controle da Agra com Whatsapp
 * Autor: Mateus Brust
 * Atualização: 07/04/2022
 * 
 * Exemplo de uso:
  $r = mclasses\Agra::sendText('5531993265491@c.us','Mens');
  print_r($r);
  ou
  $r = mclasses\Agra::sendTextTiGroup("API - AGRA");
  print_r($r);
 */

 
namespace mclasses;

class Agra
{

    /**
     * Envia uma mensagem para um telefone do whatsapp.
     *
     * @param string $tel
     * @param string $msg
     * @return array
     */
    public static function sendText($tel, $msg)
    {
        // Monta os parâmetros.
        $meuGet = [
            'func'   => 'sendText',   // função do client whatsapp
            'param1' => $tel,         // Exemplo: '5531993265491@c.us'
            'param2' => $msg,         // Exemplo: 'Texto com quebra. \n teste'
        ];

        // Faz a requisição e retorna.
        return Self::execCurl($meuGet);
    }


    /**
     * Envia uma mensagem para o grupo de TI do whatsapp.
     *
     * @param string $msg
     * @return array
     */
    public static function sendTextTiGroup($msg)
    {
        // Monta os parâmetros.
        $meuGet = [
            'func'   => 'sendText',                       // função do client whatsapp
            'param1' => '553598093297-1555070686@g.us',   // Número do grupo de TI. (pode ser que altere mais pra frente)
            'param2' => $msg,                             // Exemplo: 'Texto com quebra. \n teste'
        ];

        // Faz a requisição e retorna.
        return Self::execCurl($meuGet);
    }


    /**
     * Executa uma requisição enviando os parâmetros.
     *
     * @param array $meuGet
     * @return array
     */
    protected static function execCurl($meuGet = array())
    {
        // Gera token.
        $token = Self::getToken();
        // Monta URL API.
        $url = 'https://apps.coopama.com.br/whatsapp/' . $token . '/';

        // Trata array de parâmetros.
        $meuGet = http_build_query($meuGet);

        // Acrescenta parâmetros na URL.
        $url = $url . '?' . $meuGet;

        // Cria o CURL.
        $ch = curl_init($url . '?' . $meuGet);

        // Envio POST
        // curl_setopt($ch, CURLOPT_POST, 0);

        // Captura
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);

        // resultado transformado em array
        $result = json_decode($result, true);

        // Retorna o Array.
        return $result;
    }


    /**
     * Gera o token do minuto atual para uso da API.
     *
     * @param integer $minuto
     * @return string
     */
    public static function getToken($minuto = 0)
    {
        $dt_atual = date('d/m/Y H:i:s');
        $key = date('dmYHi', strtotime($dt_atual . " -$minuto minutes"));
        return md5('Senha' . $key . 'Forte');
    }
}
