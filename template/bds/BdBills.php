<?php

use classes\DevHelper;

class BdBills extends \controllers\DataBase
{

    /**
     * Atribui a variavel tableName o valor do nome da tabela.
     * É usado em todas as funções para identificar qual a tabela das querys.
     *
     * @var string
     */
    protected $tableName = 'bills';


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
            "id"              => "int(11) NOT NULL AUTO_INCREMENT COMMENT 'campo referente ao identificador do registro.'",
            "sourceIP"        => "varchar(50) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'campo referente ao IP de origem do usuário.'",
            "dtCreate"        => "datetime DEFAULT NULL COMMENT 'campo referente a data de criação do registro.'",
            "code"            => "varchar(32) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'campo referente ao código da fatura na vindi.'",
            "type"            => "varchar(100) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'campo referente ao tipo de pedido. Ex: Loja e Site.'",
            "customerVindiId" => "int(11) DEFAULT NULL COMMENT 'campo referente ao identificador do cliente na vindi.'",
            "customerLojaId"  => "varchar(100) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'campo referente ao identificador do cliente na loja.'",
            "externalId"      => "int(11) DEFAULT NULL",
            "createdAt"       => "datetime DEFAULT NULL COMMENT 'campo referente a data de criação da fatura.'",
            "dueAt"           => "datetime DEFAULT NULL COMMENT 'campo referente a data de vencimento da fatura.'",
            "paymentMethod"   => "varchar(100) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'campo referente ao método de pagamento.'",
            "amount"          => "decimal(10,2) DEFAULT NULL COMMENT 'campo referente ao valor da fatura.'",
            "paid"            => "tinyint(1) DEFAULT NULL COMMENT 'campo referente ao status de pagamento. Ex: 0 [Não pago], 1 [Pago].'",
            "sentLoja"        => "tinyint(1) DEFAULT NULL COMMENT 'campo referente ao status de envio para a Loja. Ex: 0 [Não enviado], 1 [Enviado].'",
            "sentLyceum"      => "tinyint(1) DEFAULT NULL COMMENT 'campo referente ao status de envio para o Lyceum. Ex: 0 [Não enviado], 1 [Enviado].'",
            "sentSap"         => "tinyint(1) DEFAULT NULL COMMENT 'campo referente ao status de envio para o SAP. Ex: 0 [Não enviado], 1 [Enviado].'",
            "request"         => "longtext COLLATE latin1_general_ci COMMENT 'campo referente ao JSON de requisição.'",
            "response"        => "longtext COLLATE latin1_general_ci COMMENT 'campo referente ao JSON de resposta.'",
            "metadata"        => "longtext COLLATE latin1_general_ci COMMENT 'campo referente a campos personalizados.'",
            "obs"             => "varchar(255) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'campo referente a observações.'",
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
     * insertBill
     * 
     * Função de insert para cadastro de Bill(fatura).
     * Envie o resultado da criação de uma fatura pela Vindi.
     *
     * @param array $responseBill
     * @return int
     */
    public function insertBill($responseBill, $requestBill)
    {
        // Ajusta.
        $bill = $responseBill['bill'];

        // Prepara campos para insersão na base local.
        $fields = [
            'sourceIP'        => DevHelper::getRemoteIp(),
            'dtCreate'        => date('Y-m-d H:i:s'),
            'code'            => $bill['code'],
            'type'            => ($bill['code'][0] == 'P' ? 'Site' : 'Loja'),
            'customerVindiId' => $bill['customer']['id'],                              // id cliente na Vindi.
            'customerLojaId'  => $bill['customer']['code'],                            // id cliente na Loja.
            'externalId'      => $bill['id'],                                          // id da bill.
            'createdAt'       => date('Y-m-d H:i:s',strtotime($bill['created_at'])),
            'dueAt'           => date('Y-m-d H:i:s',strtotime($bill['due_at'])),
            'paymentMethod'   => $bill['charges'][0]['payment_method']['code'],        // Tipo de pagamento (cartão, boleto, pix)
            'amount'          => $bill['amount'],
            'paid'            => 0,

            'request'         => json_encode($requestBill),            // Retorno da criação da fatura avulsa.
            'response'        => json_encode($responseBill),           // Retorno da criação da fatura avulsa.
        ];

        // Retorno da função insert préviamente definida. (true, false)
        return parent::insert($fields);
    }


    /**
     * Função para cancelar a bill no banco local
     *
     * @param mixed $code
     * @param string $obs
     * 
     * @return bool
     * 
     */
    public function cancelBill($code, $obs = 'Cancelado')
    {
        // Monta os campos para atualizar como cancelado
        $fields = [
          // Data de cancelamento 
          'canceledAT' => date('Y-m-d H:i:s'),
          // Apenas uma observação caso a data acima falhe
          'obs'        => $obs
        ];

        // Retorno da função update préviamente definida. (true, false)
        return parent::update(null, $fields, 'code = '. $code);
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


    public function updateById($id, $fields, $where = null)
    {
        // Retorno da função update préviamente definida. (true, false)
        return parent::update(null, $fields, 'externalId = '. $id);
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
     * Função retorna bill por código (pedido).
     *
     * @param string $code
     * @return array|bool
     */
    public function selectByCode($code)
    {
        $r = parent::select('*', 'code="' . $code . '" and canceledAT IS NULL');

        if(empty($r))
        return false;

        // Retorno do select por code
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
