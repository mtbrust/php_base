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
    public static function create($user, $permissions, $menu = [])
    {
        // Guarda os parâmetros default.
        $paramsDefault = [
            'timestampCreate' => time(),         // Guarda o tempo atual que foi criada a sessão.
            'timestampLife'   => 0,              // Tempo restante da session.
            'user'            => $user,          // Informações do usuário logado.
            'permissions'     => $permissions,   // Informações de permissões (páginas e permissões).
            'menu'            => $menu           // Menus personalizados (Grupo ou individual).
        ];

        // Garante que não tem sessão aberta.
        $_SESSION = [];

        // Acrescenta na sessão as informações enviadas por parâmetro.
        $_SESSION = $paramsDefault;

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
        if (!isset($_SESSION) || empty($_SESSION) || empty($_SESSION['timestampCreate'])) {
            return false;
        }

        // Caso tenha sessão, porém está vencida.
        // Verifica se não está na validade, destroy sessão e finaliza.
        if ((time() - $_SESSION['timestampCreate']) > $sessionTimeDuration) {
            Session::destroy();
            return false;
        }

        // Guarda os segundos que faltam para finalizar a sessão.
        $_SESSION['timestampLife'] = $sessionTimeDuration - (time() - $_SESSION['timestampCreate']);

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
    public static function getUser($key = null)
    {
        // Verifica se foi passada posição.
        if ($key) {
            // Retorna o valor na posição escolhida.
            if (isset($_SESSION['user'][$key]))
                return $_SESSION['user'][$key];
            else
                return null;
        } else {
            // Retorna toda a sessão.
            return $_SESSION['user'];
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
            if (isset($_SESSION[$key]))
                return $_SESSION[$key];
            else
                return null;
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
