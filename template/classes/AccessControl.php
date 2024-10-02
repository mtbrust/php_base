<?php

class AccessControl
{

    static public function logIn($user, $passWord)
    {
        // Trato o password.
        $passWord = self::passWord($passWord);

        // Verifica usuário no banco de daos.
        $bdLogins = new \BdLogins();
        $user = $bdLogins->verificaLogin($user, $passWord);

        // Verifica se usuário tem impedimentos.
        $chekUser = self::checkUser($user);
        if ($chekUser['error']) {
            return $chekUser;
        }

        // Criar o select que pega os grupos e permissões do usuáro.
        $permissions = [];
        $menu = [];

        // Crio a sessão com as informações de usuário.
        \classes\Session::create($user, $permissions, $menu);

        \classes\DevHelper::printr($user);

        // Retorno positivo.
        return self::message(false, 'Usuário: ' . $user . '. Senha: ' . $passWord . '.<br>' . json_encode($user));
    }

    static public function logOut() {}

    static public function logOn() {}

    static public function checkCredentials($user, $passWord)
    {
        if ($user) {
            # code...
        }
    }

    static private function message($error, $msg)
    {
        return [
            'error' => $error,
            'msg' => $msg,
        ];
    }

    static private function passWord($passWord)
    {
        return hash('sha256', $passWord);
    }

    static private function checkUser($user)
    {
        // Verificar se usuário está ativo e ok para continuar.
        // Verificar no banco de dados, etc.
        return self::message(false, 'Usuário ' . $user['fullName'] . ' ok.');
    }
}
