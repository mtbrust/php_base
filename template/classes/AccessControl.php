<?php

use classes\DevHelper;
use classes\Session;

class AccessControl
{
    static $user = [];

    static public function logIn($login, $passWord, $redirectUrl = '')
    {
        // Verifica se retornou usuário.
        if (!self::checkCredentials($login, $passWord)) {
            return self::response(true, 'Login ou Senha inválidos.');
        }

        // Verifica se usuário tem impedimentos.
        if (!self::checkUser()) {
            return self::response(true, 'Usuário ' . self::$user['fullName'] . ' com restrições de acesso. Procure o administrador da plataforma.');
        }

        // Obtém as permissões do usuário.
        $permissions = self::checkPermissions();

        // Acrescenta nas informações do usuário os grupos que ele faz parte.
        self::setGroupsInUser();

        // todo - montar o menu específico do usuário e grupo no BD. (cachear) (menu lateral com links específcos do que ele pode acessar)
        $menu = self::getMenuUser();

        // Crio a sessão com as informações de usuário.
        \classes\Session::create(self::$user, $permissions, $menu);

        // Redireciona caso tenha redirect.
        if ($redirectUrl) {
            self::redirect($redirectUrl);
        }

        // Retorno positivo.
        return self::response(false, 'Usuário: ' . $login . '. Nome: ' . self::$user['fullName'] . '. Logado com sucesso.', self::$user);
    }

    static public function logOut() {}

    /**
     * Retorna true do usuário logado ou false.
     *
     * @return bool
     * 
     */
    static public function logOn() {

        // Obtém os valores da sessão
        $session = Session::get();

        // Verifica se existe usuário logado.
        if(isset($session['timestampLife']))
        {
            // Retorna toda a sessão do usuário logaod.
            return true;
        }

        // Retorna false caso não tenha sessão.
        return false;
    }

    /**
     * Verifica se existe o login.
     *
     * @param string $login
     * @param string $passWord
     * 
     * @return bool
     * 
     */
    static public function checkCredentials($login, $passWord)
    {
        // Trato o password.
        $passWord = self::trataPassWord($passWord);

        // Verifica usuário no banco de daos.
        $bdLogins = new \BdLogins();
        self::$user = $bdLogins->verificaLogin($login, $passWord);

        // Verifica se retornou usuário.
        if (self::$user) {
            return true;
        }
        return false;
    }

    /**
     * Verifica se usuário tem alguma restrição.
     *
     * @return bool
     * 
     */
    static private function checkUser()
    {
        // todo -Verificar se usuário está ativo e ok para continuar. Verificar no banco de dados, etc.
        // todo - simula uma checagem ok.
        $checkUser = true;

        // retorna a checagem.
        return $checkUser;
    }


    /**
     * checa as permissões e trata o retorno.
     *
     * @return array
     * 
     */
    static private function checkPermissions()
    {
        // todo - (cachear permissões)
        // Obtém as permissões do usuário.
        $bdPermissions = new \BdPermissions();
        $permissions = $bdPermissions->permissoesUsuario(self::$user['id']);

        // Trata as permissões específicas.
        foreach ($permissions as $key => $permission) {
            $permissions[$key]['especific'] = self::trataEspecific($permission['especific']);
        }

        // Retorna as permissões tratadas.
        return $permissions;
    }


    /**
     * Seta nas informações do usuário, os grupos que ele pertence.
     *
     * @return void
     * 
     */
    static private function setGroupsInUser()
    {
        $bdLoginsGroups = new \BdLoginsGroups();
        self::$user['groups'] = $bdLoginsGroups->gruposUsuario(self::$user['id']);
    }

    /**
     * getMenuUser
     * 
     * Retorna os menus que usuário tem em forma de array.
     *
     * @return array
     * 
     */
    static private function getMenuUser()
    {
        // Verifica se tem algum menu para login ou grupo desse usuário.
        $bdLoginsGroupsMenu = new \BdLoginsGroupsMenu();
        $menus = $bdLoginsGroupsMenu->menuLoginGroup(self::$user['id'], self::$user['groups']);

        // Caso não tenha nenhum menu cadastrado para esse usuário retorna vazio.
        if (!is_array($menus)) 
        {
            return [];
        }

        // Ajuste o menu para array.
        $menu = [];
        foreach ($menus as $key => $value) {
            array_push($menu, json_decode($value['menu'], true));
        }

        // Retorna o menu em formato array.
        return $menu;
    }

    /**
     * Padrão de resposta.
     *
     * @param bool $error // true ou false
     * @param string $msg // Mensagem simplificada
     * @param mixed $data // Informações
     * 
     * @return array
     * 
     */
    static private function response($error, $msg, $data = null)
    {
        return [
            'error' => $error,
            'msg'   => $msg,
            'data'  => $data,
        ];
    }

    /**
     * Trata o password de acordo com a criptografia.
     *
     * @param string $passWord
     * 
     * @return string
     * 
     */
    static private function trataPassWord($passWord)
    {
        return hash('sha256', $passWord);
    }

    /**
     * Transforma uma lista de permissões específicas em um array para verificação.
     *
     * @param string $especific
     * 
     * @return array
     * 
     */
    static private function trataEspecific($especific)
    {
        // Transforma as permissões específicas em chaves do array.
        $especificTratado = array_flip(array_unique(explode(',', $especific)));

        // Transforma os valores em 1.
        foreach ($especificTratado as $key => $value) {
            $especificTratado[$key] = 1;
        }

        // Retorna um array tratado.
        return $especificTratado;
    }

    /**
     * Redireciona para uma url e passa uma mensagem.
     *
     * @param string $msg
     * 
     * @return void
     * 
     */
    private static function redirect($url, $msg = 'Redirecionado.')
    {
        // Monta url de redirecionamento para login e passa a url atual.
        $url = $url . '?redirect_msg=' . $msg;
        // Redireciona para url.
        header('location: ' . $url);
    }
}
