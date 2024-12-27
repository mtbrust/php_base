<?php


class AccessControl
{

    static public function logIn($login, $passWord)
    {
        // Trato o password.
        $passWord = self::trataPassWord($passWord);

        // Verifica usuário no banco de daos.
        $bdLogins = new \BdLogins();
        $user = $bdLogins->verificaLogin($login, $passWord);

        if (!$user){
            return self::response(true, 'Login ou Senha inválidos.');
        }

        // Verifica se usuário tem impedimentos.
        $chekUser = self::checkUser($user);
        if ($chekUser['error']) {
            return $chekUser;
        }

        // Criar o select que pega os grupos e permissões do usuáro.
        
        $bdPermissions = new \BdPermissions();
        $permissions = $bdPermissions->permissoesUsuario($user['id']);

        // $permissions = json_decode('['.$permissions[0]['especific'].']');
        // $permissions = json_decode('["a"'.$permissions[0]['especific'].']');
        // $array = array_merge($array[0], $array[1]);

        \classes\DevHelper::printr($permissions);

        $menu = [];

        // Crio a sessão com as informações de usuário.
        \classes\Session::create($user, $permissions, $menu);

        // Retorno positivo.
        return self::response(false, 
        'Usuário: ' . $login . '. Senha: ' . $passWord . '.<br>', 
        $user);
    }

    static public function logOut() {}

    static public function logOn() {}

    static public function checkCredentials($user, $passWord)
    {
        if ($user) {
            # code...
        }
    }

    static private function response($error, $msg, $data = null)
    {
        return [
            'error' => $error,
            'msg'   => $msg,
            'data'  => $data,
        ];
    }

    static private function trataPassWord($passWord)
    {
        return hash('sha256', $passWord);
    }

    static private function checkUser($user)
    {
        // todo -Verificar se usuário está ativo e ok para continuar.
        // Verificar no banco de dados, etc.
        return self::response(false, 'Usuário ' . $user['fullName'] . ' ok.');
    }
}
