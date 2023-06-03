<?php

namespace classes;


/**
 * Classe para controle de mensagens de feedback.
 */
class TokenPlataforma
{

    // Verifica se token está correto.
    static function check($token)
    {
        // Retorno padrão.
        $check = false;


        return $check;
    }

    // Verifica se token está correto.
    static function checkPage($token, $url, $func)
    {
        // Retorno padrão.
        $check = false;

        if ($token == self::createPage($url, $func)) {
            $check = true;
        }


        return $check;
    }

    // Cria um token está correto.
    static function create($options)
    {
        return true;
    }

    // Cria um token está correto.
    static function createPage($url, $func)
    {
        // Compita as informações.
        $dados = VC_INFO['empresa'] . $url . $func . date('Ymd');

        // Criptografa a chave.
        $token = hash('SHA256', $dados);

        // Devolve o token.
        return $token;
    }

    // Cria um token está correto.
    static function createApi($url)
    {
        // Compita as informações.
        $dados = VC_INFO['empresa'] . $url . date('Ymd');

        // Criptografa a chave.
        $token = hash('SHA256', $dados);

        // Devolve o token.
        return $token;
    }
}