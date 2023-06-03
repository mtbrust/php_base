<?php

use classes\DevHelper;

class BdSubscriptions extends \controllers\DataBase
{

    /**
     * Atribui a variavel tableName o valor do nome da tabela.
     * É usado em todas as funções para identificar qual a tabela das querys.
     *
     * @var string
     */
    protected $tableName = 'subscriptions';


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
            "id"             => "int(11) NOT NULL AUTO_INCREMENT COMMENT 'campo referente ao identificador do registro.'",
            "sourceIP"       => "varchar(128) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'campo referente ao IP de origem do usuário.'",
            "dtCreate"       => "datetime DEFAULT NULL COMMENT 'campo referente a data de criação.'",
            "dtUpdate"       => "datetime DEFAULT NULL COMMENT 'campo referente a data de alteração.'",
            "idSubscription" => "int(11) NOT NULL COMMENT 'campo referente ao identificador da assinatura na vindi.'",
            "status"         => "varchar(100) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'campo referente ao status da assinatura.'",
            "start_at"       => "datetime DEFAULT NULL COMMENT 'campo referente a data de início da assinatura.'",
            "end_at"         => "datetime DEFAULT NULL COMMENT 'campo referente a data de encerramento da assinatura.'",
            "cancel_at"      => "datetime DEFAULT NULL COMMENT 'campo referente a data de cancelamento da assinatura.'",
            "billMatricula"  => "int(11) DEFAULT NULL",
            "code"           => "int(11) DEFAULT NULL COMMENT 'campo referente ao pedido na loja.'",
            "customerId"     => "int(11) DEFAULT NULL COMMENT 'campo referente ao cliente da assinatura.'",
            "planId"         => "int(11) DEFAULT NULL COMMENT 'campo referente ao identificador do plano na vindi.'",
            "paymentMethod"  => "varchar(100) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'campo referente ao método de pagamento.'",
            "request"        => "longtext COLLATE latin1_general_ci COMMENT 'campo referente ao JSON da requisição.'",
            "response"       => "longtext COLLATE latin1_general_ci COMMENT 'campo referente ao JSON de resposta.'",
            "metadata"       => "longtext COLLATE latin1_general_ci COMMENT 'campo referente a campos personalizados.'",
            "obs"            => "varchar(255) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'campo referente a observações.'",
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
     * insertSubscription
     * 
     * Função de insert para cadastro de Subscription(fatura).
     * Envie o resultado da criação de uma fatura pela Vindi.
     *
     * @param array $responseSubscription
     * @return int
     */
    public function insertSubscription($subscriptionsSite, $idMatricula)
    {
        // Obtem os dados da data
        $formatedData[0] = substr($subscriptionsSite['start_at'],6,4); // Ano
        $formatedData[1] = substr($subscriptionsSite['start_at'],3,2); // Mes
        $formatedData[2] = substr($subscriptionsSite['start_at'],0,2); // Dia

        // Obtem a data formatada
        $start_at = implode('-', $formatedData) . " 00:00:00";

        // Monta os campos para insersão.
        $fields = [
            'sourceIP'       => DevHelper::getRemoteIp(),
            'dtCreate'       => date('Y-m-d H:i:s'),
            'dtUpdate'       => date('Y-m-d H:i:s'),
            "idSubscription" => "",
            "status"         => "",
            "start_at"       => $start_at,
            "end_at"         => "",
            "cancel_at"      => "",
            "billMatricula"  => $idMatricula,
            'code'           => $subscriptionsSite['code'],
            "customerId"     => $subscriptionsSite['customer_id'],
            "planId"         => $subscriptionsSite['plan_id'],
            'paymentMethod'  => $subscriptionsSite['payment_method_code'],   // Tipo de pagamento (crédito, boleto, pix)
            'request'        => json_encode($subscriptionsSite),             // Retorno da criação da fatura avulsa.
            'response'       => '',                                          // Retorno da criação da fatura avulsa.
            "metadata"       => "",
            "obs"            => "",                                          // Retorno da criação da fatura avulsa.
        ];
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
     * selectByCode
     * 
     * Função retorna subscription por código (pedido).
     *
     * @param string $code
     * @return array|bool
     */
    public function selectByCode($code)
    {
        $r = parent::select('*', 'code="' . $code . '"');

        if (!isset($r[0]))
            return false;

        // Retorno do select por code
        return $r[0];
    }

    public function selectByBill($id)
    {
        $r = parent::select('*', 'billMatricula=' . $id);

        if (empty($r)) return false;

        return $r[0];
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
    public function consultaPersonalizada($id)
    {
        // Ajusta nome real da tabela.
        $table = parent::fullTableName();
        // $tableInnerMidia = parent::fullTableName('midia');
        // $tableInnerLogin = parent::fullTableName('login');
        // $tableInnerUsers = parent::fullTableName('users');

        // Monta SQL.
        $sql = "SELECT * FROM $table WHERE id = '$id' LIMIT 1;";

        // Executa o select
        $r = parent::executeQuery($sql);

        // Verifica se não teve retorno.
        if (!$r)
            return false;

        // Retorna primeira linha.
        return $r[0];
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
