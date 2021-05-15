<?php

class BdPermissionsInsert extends Bd
{
    
    /**
     * Atribui a variavel tableName o valor do nome da tabela.
     * É usado em todas as funções para identificar qual a tabela das querys.
     *
     * @var string
     */
    private static $tableName = 'permissions';


    public static function start()
    {
        // Popular páginas para teste;
        Self::insertAdmin();

        return true;
    }

    /**
     * Insere páginas para teste.
     *
     * @return bool
     */
    public static function insertAdmin()
    {
       
        // Campos e valores.
        $register = [
            'idGrupo'  => '5',     // Administrador
            'nome'  => 'Acesso Total',
            'urlPagina' => 'admin/',
            'obs' => 'Cadastro inicial.',
            'permissions' => '11111',
            'dtCreate' => date("Y-m-d H:i:s"),
        ];
        Self::Insert(Self::$tableName, $register);
        // Campos e valores.
        $register = [
            'idGrupo'  => '5',     // Administrador
            'nome'  => 'Acesso Total',
            'urlPagina' => 'admin/login/',
            'obs' => 'Cadastro inicial.',
            'permissions' => '11111',
            'dtCreate' => date("Y-m-d H:i:s"),
        ];
        Self::Insert(Self::$tableName, $register);
        // Campos e valores.
        $register = [
            'idGrupo'  => '5',     // Administrador
            'nome'  => 'Acesso Total',
            'urlPagina' => 'admin/seguranca/',
            'obs' => 'Cadastro inicial.',
            'permissions' => '11111',
            'dtCreate' => date("Y-m-d H:i:s"),
        ];
        Self::Insert(Self::$tableName, $register);
        // Campos e valores.
        $register = [
            'idGrupo'  => '5',     // Administrador
            'nome'  => 'Acesso Total',
            'urlPagina' => 'admin/status/',
            'obs' => 'Cadastro inicial.',
            'permissions' => '11111',
            'dtCreate' => date("Y-m-d H:i:s"),
        ];
        Self::Insert(Self::$tableName, $register);
        // Campos e valores.
        $register = [
            'idGrupo'  => '5',     // Administrador
            'nome'  => 'Acesso Total',
            'urlPagina' => 'admin/configuracoes/',
            'obs' => 'Cadastro inicial.',
            'permissions' => '11111',
            'dtCreate' => date("Y-m-d H:i:s"),
        ];
        Self::Insert(Self::$tableName, $register);
        
        return true;
    }
}
