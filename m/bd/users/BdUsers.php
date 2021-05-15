<?php

class BdUsers extends Bd
{
    /**
     * Atribui a variavel tableName o valor do nome da tabela.
     * É usado em todas as funções para identificar qual a tabela das querys.
     *
     * @var string
     */
    private static $tableName = 'users';


    /**
     * Cria a função add passando as variaveis $fields e $coon como parametros
     *
     * @param array $fields
     * @param PDO $conn
     * @return int
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
     * Cria função getById que busca por id
     * Retorna um array da linha.
     *
     * @param int $id
     * @param PDO $conn
     * @return array
     */
    public static function selecionaPorIdCompleto($id, $conn = null)
    {


        // Verifica se tabela existe.
        if (!Self::getTables(Self::$tableName))
            return false;

        // Ajusta nome tabela.
        $tableUsers = Self::fullTableName(Self::$tableName);
        $tableMidias = Self::fullTableName('midia');
        $tableStatus = Self::fullTableName('status');

        // Monta SQL.
        $sql = "SELECT 
            user.id, 
            user.idLogin, 
            user.idStatusRh, 
            user.idStatusMarketing, 
            user.idStatusTi, 
            user.idStatusContabilidade, 
            user.idStatusPontuacao, 
            user.idArea, 
            user.nome, 
            user.dataNascimento, 
            user.sexo, 
            user.estadoCivil, 
            user.nomeConjuge, 
            user.idConjuge, 
            user.naturalidade, 
            user.naturalidade_uf, 
            user.nacionalidade, 
            midia.urlMidia,
            user.idFoto, 
            user.escolaridade, 
            user.cep, 
            user.endereco, 
            user.numero, 
            user.complemento, 
            user.bairro, 
            user.cidade, 
            user.estadoUf, 
            user.pais, 
            user.telefone1, 
            user.whatsapp1, 
            user.telefone2, 
            user.whatsapp2, 
            user.emailProfissional, 
            user.emailPessoal, 
            user.rg, 
            user.dataEmissao, 
            user.emissor, 
            user.cpf, 
            user.categoriaCnh, 
            user.nomePai, 
            user.nomeMae, 
            user.idPai, 
            user.idMae, 
            user.instagram, 
            user.facebook, 
            user.linkedin, 
            user.twitter, 
            user.lattes, 
            user.obsGeral, 
            user.pontuacao, 
            user.dtCreate
        FROM $tableUsers as user 
        LEFT JOIN $tableMidias as midia
            ON user.idFoto = midia.id
        LEFT JOIN $tableStatus as sRh
            ON user.idStatusRh = sRh.id
        LEFT JOIN $tableStatus as sMerketing
            ON user.idStatusMarketing = sMerketing.id
        LEFT JOIN $tableStatus as sTi
            ON user.idStatusTi = sTi.id
        LEFT JOIN $tableStatus as sContabilidade
            ON user.idStatusContabilidade = sContabilidade.id
        LEFT JOIN $tableStatus as sPontuacao
            ON user.idStatusPontuacao = sPontuacao.id
        WHERE user.id = $id
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
