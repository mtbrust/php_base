<?php


class ControllerSecurity
{
    /**
     * Guarda os níveis de acesso do usuário.
     */
    private static array $permissions;



    /**
     * Inicia sessão.
     *
     */
    public static function start()
    {
        session_start();
    }


    /**
     * Caso não tenha logado redireciona para login.
     * Função que verifica se session foi inicializada.
     *
     * @return void
     */
    public static function on($parmissionsPage, $urlPage)
    {
        if (!isset($_SESSION['user'])) {
            header("location: " . URL_RAIZ . "login/");
        }

        // Carrega as permissões.
        if (Self::upPermissions($parmissionsPage, $urlPage))
            return true;

        return false;
    }


    /**
     * Cria sessão do usuário logado.
     *
     * @param array $user
     * @return string
     */
    public static function create($user)
    {
        // Verifica se existe dados de usuário.
        if ($user) {
            // Cria a sessão.
            $_SESSION['user'] = $user;

            // Redireciona para paindel administrativo.
            header("location: " . URL_RAIZ . "admin/");
        }

        return 'Dados de usuáio não conferem.';
    }


    /**
     * Atualiza sessão do usuário logado.
     *
     * @param array $user
     * @return string
     */
    public static function atualiza($user)
    {
        // Verifica se existe dados de usuário.
        if ($user) {
            // Cria a sessão.
            $_SESSION['user'] = $user;
        }

        return 'Dados de usuáio não conferem.';
    }


    /**
     * Caso solicite encerrar sessão, elimina a sessão e volta para login.
     *
     * @return void
     */
    public static function sair()
    {
        unset($_SESSION['user']);
        header("location:" . URL_RAIZ . "login");
    }


    /**
     * Retorna array da sessão ou valor específico.
     *
     * @return array
     */
    public static function getSession($session = null)
    {
        if ($session)
            return $_SESSION['user'][$session];
        return $_SESSION['user'];
    }


    /**
     * Seta um parametro de sessão.
     *
     * @param string $param
     * @param string $value
     * @return boolean
     */
    public static function setSession($param, $value)
    {
        $_SESSION['user'][$param] = $value;
        return true;
    }


    /**
     * Carrega as permissões para usuário atual.
     * Verifica as permissões de usuário e de grupo.
     * [0] menu         -> Página Início ou Menu.
     * [1] index        -> Página Início ou Menu.
     * [2] post         -> Página Adicionar.
     * [3] put          -> Página Atualizar.
     * [4] get          -> Página Listar Básico.
     * [5] getFull      -> Página Listar Completo.
     * [6] delete       -> Página Deletar.
     * [7] api          -> Página Api.
     * [8] test         -> Página Testes.
     *
     * @param int $idUser
     * @return boolean
     */
    public static function upPermissions($parmissionsPage, $urlPage, $publico = false)
    {

        if ($publico)
        {
        // Pega os dados da sessão.
        $idUser = Self::getSession('idUser');
        $idGrupo = Self::getSession('idGrupo');

        // Carrega as permissões de Usuário. //Não colocar esse caso não retorne.
        $temp_permissions_user = BdPermissions::user($idUser, $urlPage);

        // Carrega as permissões de grupo.
        $temp_permissions_grupo = BdPermissions::grupo($idGrupo, $urlPage);
        }else
        {
            $temp_permissions_user = '000000000';
            $temp_permissions_grupo = '000000000';
        }

        /**
         * Salva as permissões.
         * Prioridade das permissões:
         *  Permissões de usuário.
         *  Permissões de Grupo.
         *  Permissões da Página Atual.
         * 
         */
        Self::$permissions = [
            'menu'      => ($temp_permissions_user[0]) ? $temp_permissions_user[0] : (($temp_permissions_grupo[0]) ? $temp_permissions_grupo[0] : $parmissionsPage[0]),
            'index' => ($temp_permissions_user[1]) ? $temp_permissions_user[1] : (($temp_permissions_grupo[1]) ? $temp_permissions_grupo[1] : $parmissionsPage[1]),
            'post'      => ($temp_permissions_user[2]) ? $temp_permissions_user[2] : (($temp_permissions_grupo[2]) ? $temp_permissions_grupo[2] : $parmissionsPage[2]),
            'put'       => ($temp_permissions_user[3]) ? $temp_permissions_user[3] : (($temp_permissions_grupo[3]) ? $temp_permissions_grupo[3] : $parmissionsPage[3]),
            'get'       => ($temp_permissions_user[4]) ? $temp_permissions_user[4] : (($temp_permissions_grupo[4]) ? $temp_permissions_grupo[4] : $parmissionsPage[4]),
            'getFull'   => ($temp_permissions_user[5]) ? $temp_permissions_user[5] : (($temp_permissions_grupo[5]) ? $temp_permissions_grupo[5] : $parmissionsPage[5]),
            'delete'    => ($temp_permissions_user[6]) ? $temp_permissions_user[6] : (($temp_permissions_grupo[6]) ? $temp_permissions_grupo[6] : $parmissionsPage[6]),
            'api'       => ($temp_permissions_user[7]) ? $temp_permissions_user[7] : (($temp_permissions_grupo[7]) ? $temp_permissions_grupo[7] : $parmissionsPage[7]),
            'test'      => ($temp_permissions_user[8]) ? $temp_permissions_user[8] : (($temp_permissions_grupo[8]) ? $temp_permissions_grupo[8] : $parmissionsPage[8]),
        ];

        return true;
    }


    /**
     * Retorna a permissão selecionada ou tudo.
     *
     * @param array $permission
     * @return array
     */
    public static function getPermissions($permission = null)
    {
        if ($permission)
            return Self::$permissions[$permission];
        return Self::$permissions;
    }
}
