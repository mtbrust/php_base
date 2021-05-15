<?php

class BdStatus extends Bd
{
    /**
     * Atribui a variavel tableName o valor do nome da tabela.
     * É usado em todas as funções para identificar qual a tabela das querys.
     *
     * @var string
     */
    private static $tableName = 'status';


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
     * Função que busca o grupo. (Tem que fazer.)
     * Retorna um array da linha.
     *
     * @param int $id
     * @param string $grupo
     * @param PDO $conn
     * @return array
     */
    public static function selecionaPorGrupo($grupo, $conn = null)
    {
        $tableName = Self::fullTableName(Self::$tableName);
        $sql = "SELECT * FROM $tableName WHERE statusGrupo LIKE '$grupo'";
        $r =  Self::executeQuery($sql);
        return $r;
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
