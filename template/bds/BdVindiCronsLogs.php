<?php

class BdVindiCronsLogs extends \controllers\DataBase
{

    /**
     * Atribui a variavel tableName o valor do nome da tabela.
     * É usado em todas as funções para identificar qual a tabela das querys.
     *
     * @var string
     */
    protected $tableName = 'vindiCronsLogs';


    /**
     * Conexão padrão do banco de dados.
     * Verificar conexão na config.
     *
     * @var int
     */
    protected $conn = 0;


    /**
     * createTable
	 * 
     * Cria tabela no banco de dados.
	 * Função genérica para criação de tabelas conforme os parâmetros passados.
	 * Preencha o nome da tabela.
	 * Preencha o array $fields com "nome_campo" => "tipo_campo".
     * Cria se não existir.
	 *
	 * @param array $fields
	 * @return bool
     */
    public function createTable($fields = null)
    {
        // Monta os campos da tabela.
        $fields = [
            "id"          => "int(11) NOT NULL AUTO_INCREMENT COMMENT 'campo referente ao identificador da cron.'",
            "title"       => "varchar(100) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'campo referente ao título da cron.'",
            "description" => "varchar(255) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'campo referente a descrição da cron.'",
            "endpoint"    => "longtext COLLATE latin1_general_ci DEFAULT NULL COMMENT 'campo referente a URL.'",
            "jsonGet"     => "longtext COLLATE latin1_general_ci COMMENT 'campo referente aos valores do GET que serão acrescentados na URL.'",
            "jsonPost"    => "longtext COLLATE latin1_general_ci COMMENT 'campo referente aos valores do POST enviados na requisição.'",
            "nextRun"     => "datetime DEFAULT NULL COMMENT 'campo referente a próxima execução da cron.'",
            "minutes"     => "varchar(100) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'campo referente a recorrência em minutos da execução da cron. Ex: 5,10,45 executa no minuto 5, 10 e 45.'",
            "hours"       => "varchar(100) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'campo referente a recorrência em horas da execução da cron. Ex: 0,12 executa na hora 0, e 12.'",
            "days"        => "varchar(100) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'campo referente a recorrência em dias da execução da cron. Ex: 15,30 executa no dia 15, e 30.'",
            "months"      => "varchar(100) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'campo referente a recorrência em meses da execução da cron. Ex: 1,6 executa no mês de Janeiro e Junho.'",
            "weekdays"    => "varchar(100) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'campo referente a recorrência em dias da semanas. Ex: 2,6 executa na Segunda e Sexta.'",
            "years"       => "varchar(100) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'campo referente a recorrência em anos. Ex: 2023 executa apenas em 2023.'",
            "tryes"       => "int(11) DEFAULT NULL COMMENT 'campo referente a quantidade de tentativas de execução em caso de erros.'",
            "status"      => "varchar(100) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'campo referente ao status da execução da cron. Ex: Processando, Sucesso, Erro.'",           
            "logResponse" => "longtext COLLATE latin1_general_ci DEFAULT NULL COMMENT 'campo referente ao log de erro.'",
            "externalId"  => "int(11) DEFAULT NULL COMMENT 'campo referente ao identificador do job na vindi.'",
        ];
        return parent::createTable($fields);
    }


    /**
     * dropTable
     * 
     * Deleta tabela no banco de dados.
     *
     * @return bool
     */
    public function dropTable()
    {
        // Deleta a tabela.
        return parent::dropTable();
    }


    /**
     * insert
	 * 
	 * Função genérica para inserts.
	 * Preencha o nome da tabela.
	 * Preencha o array $fields com "nome_campo" => "valor_campo".
	 *
	 * @param array $fields
	 * @return int
     */
    public function insert($fields)
    {
        // Retorno da função insert préviamente definida. (true, false)
        return parent::insert($fields);
    }


    /**
     * update
	 * 
	 * Função genérica para update.
	 * Preencha o nome da tabela.
	 * Preencha o array com nome_campo => valor_campo somenta das colunas que vão ser alteradas.
	 *
	 * @param  mixed $id
	 * @param  mixed $fields
	 * @param  mixed $where
	 * @return bool
     */
    public function update($id, $fields, $where = null)
    {
        // Retorno da função update préviamente definida. (true, false)
        return parent::update($id, $fields, $where);
    }


    /**
	 * delete
	 * 
	 * Função que deleta registro por id ou where.
	 * É necessário preencher um dos dois parâmetros.
	 *
	 * @param int $id
	 * @param string $where
	 * @return bool
     */
    public function delete($id = null, $where = null)
    {
        // Retorno da função delete préviamente definida. (true, false)
        return parent::delete($id, $where);
    }


    /**
	 * deleteStatus
	 * 
	 * Função que deleta registro por status (0) id ou where.
	 * É necessário preencher um dos dois parâmetros.
	 *
	 * @param int $id
	 * @param string $where
	 * @return bool
     */
    public function deleteStatus($id = null, $where = null)
    {
        // Retorno da função delete préviamente definida. (true, false)
        return parent::deleteStatus($id, $where);
    }


    /**
     * selecionarTudo
     * 
     * Função selecionar tudo, retorna todos os registros.
     * É possível passar a posição inicial que exibirá os registros.
     * É possível passar a quantidade de registros retornados.
     *
     * @param integer $posicao
     * @param integer $qtd
     * @return bool
     */
    public function selectAll($qtd = 10, $posicao = 0)
    {
        // Retorno da função selectAll préviamente definida. (true, false)
        return parent::selectAll($qtd, $posicao);
    }


    /**
	 * selectById
	 * 
	 * Função que busca registro por id.
	 * Retorna um array da linha.
     * Retorna um array com os campos da linha.
	 * É necessário preencher um dos dois parâmetros.
	 *
	 * @param int $id
	 * @param string $where
	 * @return bool|array
	 */
	public function selectById($id = null, $where = null)
    {
        // Função que busca registro por id.
        return parent::selectById($id, $where);
    }


    /**
	 * count
	 * 
	 * Função genérica para retornar a quantidade de registros da tabela.
	 *
	 * @return int
	 */
    public function count()
    {
        // Retorna a quantidade de registros na tabela.
        return parent::count();
    }


    /**
     * consultaPersonalizada
     * 
     * Modelo para criação de uma consulta personalizada.
     * É possível fazer inner joins e filtros personalizados.
     * User sempre que possível a função "select()" em vez de "executeQuery()".
     * ATENÇÃO: Não deixar brechas para SQL Injection.
     *
     * @param PDO $conn
     * @return bool|array
     */
    public function selectCurrentJobs()
    {
        // Ajusta nome real da tabela.
        $table = parent::fullTableName('crons');


        // Monta SQL.
        $sql = "SELECT * FROM $table WHERE nextRun <= CURDATE();";

        // Executa o select
        $r = parent::executeQuery($sql);

        // Verifica se não teve retorno.
        if (!$r)
            return false;

        // Retorna primeira linha.
        return $r;
    }


    /**
     * insertsIniciais
     * 
     * Realização dos inserts iniciais.
     *
     * @return bool|array
     */
    public function seeds()
    {
        // Retorno padrão.
        $r = false;

        // Insert 1.
        $r = parent::insert([
            // Observações do registro (obrigatório).
            'obs' => 'Status ativo Geral',
        ]);


        // Finaliza a função.
        return $r;
    }
}
