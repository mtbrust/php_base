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
    public static function on()
    {
        if (!isset($_SESSION['user'])) {
            header("location: " . URL_RAIZ . "login/");
        }
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

            // Verificar qual o nível de segurança.


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
     * Retorna a sessão.
     *
     * @return array
     */
    public static function getSession()
    {
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
     * Carrega as permissões do usuário.
     * Verifica as permissões de usuário e de grupo.
     * menu     -> Página Início ou Menu.
     * post     -> Página Adicionar.
     * put      -> Página Atualizar.
     * get      -> Página Listar.
     * delete   -> Página Deletar.
     *
     * @param int $idUser
     * @return boolean
     */
    public static function setPermissions($parmissionsPage, $idUser, $idGrupo, $urlPage)
    {
        
        // Carrega as permissões de Usuário. //Não colocar esse caso não retorne.
        $temp_permissions_user = BdPermissions::user($idUser, $urlPage);
        // print_r($temp_permissions_user);
        

        // Carrega as permissões de grupo.
        $temp_permissions_grupo = BdPermissions::grupo($idGrupo, $urlPage);
        // print_r($temp_permissions_grupo);
        
        // Gera as permissões com prioridades.
        Self::$permissions = [
            'menu'   => ($temp_permissions_user[0])?$temp_permissions_user[0]:(($temp_permissions_grupo[0])?$temp_permissions_grupo[0]:$parmissionsPage[0]),
            'post'   => ($temp_permissions_user[1])?$temp_permissions_user[1]:(($temp_permissions_grupo[1])?$temp_permissions_grupo[1]:$parmissionsPage[1]),
            'put'    => ($temp_permissions_user[2])?$temp_permissions_user[2]:(($temp_permissions_grupo[2])?$temp_permissions_grupo[2]:$parmissionsPage[2]),
            'get'    => ($temp_permissions_user[3])?$temp_permissions_user[3]:(($temp_permissions_grupo[3])?$temp_permissions_grupo[3]:$parmissionsPage[3]),
            'delete' => ($temp_permissions_user[4])?$temp_permissions_user[4]:(($temp_permissions_grupo[4])?$temp_permissions_grupo[4]:$parmissionsPage[4]),
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
