<?php

namespace classes;

/**
 * Session
 */
class Session
{

    /**
     * Inicia serviço de sessão.
     *
     * @return void
     */
    public static function start()
    {
        // Inicia serviço.
        session_start();
    }

    /**
     * create
     * 
     * Acrescenta na sessão as informações enviadas por parâmetro.
     *
     * @param  array $params
     * @return boolean
     */
    public static function create($params)
    {
        // Guarda os parâmetros default.
        $paramsDefault = [
            'timestampCreate' => time(), // Guarda o tempo atual que foi criada a sessão.
        ];

        // Mescla os parâmetros recebidos com os default.
        $params = array_merge_recursive($paramsDefault, $params);

        // Garante que não tem sessão aberta.
        $_SESSION = [];

        // Acrescenta na sessão as informações enviadas por parâmetro.
        $_SESSION = $params;

        // Finalização
        return true;
    }


    /**
     * check
     * 
     * Verifica se existe sessão.
     * Verifica se sessão está na validade.
     *
     * @param  int $sessionTimeDuration
     * @return bool
     */
    public static function check($sessionTimeDuration)
    {
        // Verifica se não existe sessão ou se está vazia e finaliza.
        if (!isset($_SESSION) || empty($_SESSION)) {
            return false;
        }

        // Caso tenha sessão, porém está vencida.
        // Verifica se não está na validade, destroy sessão e finaliza.
        if ((time() - $_SESSION['timestampCreate']) > $sessionTimeDuration) {
            $_SESSION = [];
            return false;
        }

        // Caso não tenha impeditivo a sessão está ok. Sessão válida.
        return true;
    }


    /**
     * destroy
     * 
     * Apaga uma posição específica ou toda a sessão.
     *
     * @param  string $key
     * @return void
     */
    public static function destroy($key = null)
    {
        if ($key) {
            unset($_SESSION[$key]);
        } else {
            session_destroy();
        }
    }


    /**
     * get
     * 
     * Obtém uma posição específica da sessão ou toda a sessão.
     *
     * @param  mixed $key
     * @return mixed
     */
    public static function get($key = null)
    {
        // Verifica se foi passada posição.
        if ($key) {
            // Retorna o valor na posição escolhida.
            return $_SESSION[$key];
        } else {
            // Retorna toda a sessão.
            return $_SESSION;
        }
    }


    /**
     * set
     * 
     * Grava na sessão um valor em uma posição específica.
     *
     * @param  mixed $key
     * @param  mixed $value
     * @return void
     */
    public static function set($key, $value)
    {
        // Verifica se foi passada posição.
        if ($key) {
            // Guarda o valor na posição escolhida.
            $_SESSION[$key] = $value;
        }
    }
}
