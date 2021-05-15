<?php

class BdLogin extends Bd
{
    /**
     * Atribui a variavel tableName o valor do nome da tabela.
     * É usado em todas as funções para identificar qual a tabela das querys.
     *
     * @var string
     */
    private static $tableName = 'login';



    public static function verificaLogin($login, $senha, $conn = null)
    {

        // Verifica se tabela existe.
        if (!Self::getTables(Self::$tableName))
            return false;

        // Ajusta nome tabela.
        $table = Self::fullTableName(Self::$tableName);


        // Monta SQL.
        $sql = "SELECT `id`
        ,`matricula`
        ,`idUser`
        ,`idGrupo`
        ,`fullName`
        ,`firstName`
        ,`lastName`
        ,`email`
        ,`userName`
        ,`cpf`
        ,`telefone`
        ,`active`
        ,`idStatus`
        ,`obs`
        FROM $table 
        WHERE (
            email = '$login' OR
            userName = '$login' OR
            cpf = '$login' OR
            telefone = '$login'
            ) AND
            (senha = '$senha')
        LIMIT 1;";
        // Retorna
        $r = Self::executeQuery($sql);

        if (!$r)
            return false;
        return $r[0];
    }


    /**
     * Cria a função add passando as variaveis $fields e $coon como parametros
     *
     * @param array $fields
     * @param PDO $conn
     * @return bool
     */
    public static function Adicionar($fields, $conn = null)
    {
        // Retorno da função insert préviamente definida. (true, false)
        return Self::insert(Self::$tableName, $fields, $conn);
    }


    /**
     * Cria função getAll passando a posição, a quantidade e a conexão
     *
     * @param integer $posicao
     * @param integer $qtd
     * @param PDO $conn
     * @return bool
     */
    public static function selecionaTudo($posicao = null, $qtd = 10, $conn = null)
    {

        // Verifica se tabela existe.
        if (!Self::getTables(Self::$tableName))
            return false;

        // Ajusta nome tabela.
        $table = Self::fullTableName(Self::$tableName);

        // Monta SQL.
        $sql = "SELECT `id`
        ,`matricula`
        ,`idUser`
        ,`idGrupo`
        ,`fullName`
        ,`firstName`
        ,`lastName`
        ,`email`
        ,`userName`
        ,`cpf`
        ,`telefone`
        ,`active`
        ,`idStatus`
        ,`obs`
        FROM $table";

        // Retorna
        $r = Self::executeQuery($sql);

        if (!$r)
            return false;
        return $r;
    }


    /**
     * Cria função getById que busca por id
     * Retorna um array da linha.
     *
     * @param int $id
     * @param PDO $conn
     * @return array
     */
    public static function selecionaPorId($id, $conn = null)
    {

        // Verifica se tabela existe.
        if (!Self::getTables(Self::$tableName))
            return false;

        // Ajusta nome tabela.
        $table = Self::fullTableName(Self::$tableName);

        // Monta SQL.
        $sql = "SELECT `id`
        ,`matricula`
        ,`idUser`
        ,`idGrupo`
        ,`fullName`
        ,`firstName`
        ,`lastName`
        ,`email`
        ,`userName`
        ,`cpf`
        ,`telefone`
        ,`active`
        ,`idStatus`
        ,`obs`
        FROM $table 
        WHERE id = '$id' 
        LIMIT 1;";

        // Retorna
        $r = Self::executeQuery($sql);

        if (!$r)
            return false;
        return $r[0];
    }


    /**
     * Cria a função delete passando id e iniciando a conexão
     *
     * @param int $id
     * @param PDO $conn
     * @return bool
     */
    public static function deleta($id, $conn = null)
    {
        // Retorno da função delete préviamente definida. (true, false)
        return Self::delete(Self::$tableName, $id, $conn);
    }


    /**
     * Cria a função update que faz alterações em campos existentes
     *
     * @param array $fields
     * @param PDO $conn
     * @return bool
     */
    public static function atualiza($id, $fields, $conn = null)
    {
        // Retorno da função update préviamente definida. (true, false)
        return Self::update(Self::$tableName, $id, $fields, $conn);
    }


    /**
     * Cria a função quantidade que retorna a quantidade de registros na tabela.
     *
     * @param PDO $conn
     * @return int
     */
    public static function quantidade($conn = null)
    {
        // Retorno da função update préviamente definida. (true, false)
        return Self::count(Self::$tableName, $conn);
    }
}
