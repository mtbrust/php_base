<?php

class BdLoginInsert extends Bd
{

    public static function start()
    {
        // Popular páginas para teste;
        Self::insertTest();

        return true;
    }

    /**
     * Insere páginas para teste.
     *
     * @return bool
     */
    public static function insertTest()
    {
        // Campos e valores.
        $register = [
            'matricula'  => '2108',
            'fullName'  => 'Mateus Rocha Brust',
            'firstName' => 'Mateus',
            'lastName'  => 'Brust',
            'userName'  => 'mateus.brust',
            'email'      => 'mateus.brust@coopama.com.br',
            'senha'      => md5('123456'),
            'cpf'        => '10401141640',
            'telefone'   => '31993265491',
            'active'     => true,
            'idStatus'  => '1',
            'idGrupo'  => '5',
            'obs'        => 'Login criado para teste.',
        ];
        Self::Insert('login', $register);
        // $register = [
        //     'matricula'  => '2109',
        //     'fullName'  => 'João da silva',
        //     'firstName' => 'João',
        //     'lastName'  => 'da Silva',
        //     'email'      => 'joao.silva@coopama.com.br',
        //     'userName'  => 'jsilva',
        //     'senha'      => md5('123456'),
        //     'cpf'        => '12312312312',
        //     'telefone'   => '35912341234',
        //     'active'     => true,
        //     'idStatus'  => '1',
        //     'obs'        => 'Login criado para teste.',
            
        // ];
        // Self::Insert('login', $register);
        $register = [
            'matricula'  => '2059',
            'fullName'  => 'Rafael Santos',
            'firstName' => 'Rafael',
            'lastName'  => 'Santos',
            'userName'  => 'rafael.santos',
            'email'      => 'rafael.santos@coopama.com.br',
            'senha'      => md5('123456'),
            'cpf'        => '12312312313',
            'telefone'   => '35912341235',
            'active'     => true,
            'idStatus'  => '1',
            'idGrupo'  => '5',
            'obs'        => 'Login criado para teste.',
            
        ];
        Self::Insert('login', $register);
        
        return true;
    }
}
