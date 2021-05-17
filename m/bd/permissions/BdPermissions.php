<?php

class BdPermissions extends Bd
{
    /**
     * Atribui a variavel tableName o valor do nome da tabela.
     * É usado em todas as funções para identificar qual a tabela das querys.
     *
     * @var string
     */
    private static $tableName = 'permissions';


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
        // Retorno da função selectAll préviamente definida. (true, false)
        return Self::selectAll(Self::$tableName, $posicao, $qtd, $conn);
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
        // Retorno da função selectById préviamente definida. (array)
        return Self::selectById(Self::$tableName, $id, $conn);
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
    public static function atualiza($fields, $conn = null)
    {
        // Retorno da função update préviamente definida. (true, false)
        return Self::update(Self::$tableName, $fields, $conn);
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


    /**
     * Obtém as permissões de user.
     *
     * @param int $id
     * @param string $urlPagina
     * @return void
     */
    public static function user($idLogin, $urlPagina)
    {
        $tableName = Self::fullTableName(Self::$tableName);
        $sql = "SELECT permissions FROM $tableName WHERE idLogin = $idLogin and urlPagina LIKE '$urlPagina'";

        $r =  Self::executeQuery($sql);
        if (!$r)
            $r = (string)"000000000";
        if (isset($r[0]) && isset($r[0]['permissions']))
            $r = (string)$r[0]['permissions'];
        return $r;
    }


    /**
     * Obtém as permissões de grupo.
     *
     * @param int $id
     * @param string $urlPagina
     * @return void
     */
    public static function grupo($idGrupo, $urlPagina)
    {
        $tableName = Self::fullTableName(Self::$tableName);
        $sql = "SELECT permissions FROM $tableName WHERE idGrupo = $idGrupo and urlPagina LIKE '$urlPagina'";

        $r =  Self::executeQuery($sql);
        if (!$r)
            $r = (string)"000000000";
        if (isset($r[0]) && isset($r[0]['permissions']))
            $r = (string)$r[0]['permissions'];
        return $r;
    }
}
