<?php

class BdLogins extends \controllers\DataBase
{

    /**
     * Atribui a variavel tableName o valor do nome da tabela.
     * É usado em todas as funções para identificar qual a tabela das querys.
     *
     * @var string
     */
    protected $tableName = 'logins';


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
            // Identificador Padrão (obrigatório).
            "id" => "INT NOT NULL AUTO_INCREMENT primary key",

            // Identificadores.
            "matricula" => "INT NULL",
            "idUser"    => "INT NULL",   // Id do usuário. Tabela com informações detalhadas da entidade.
            "idOld"     => "INT NULL",   // Id identificador de tabela antiga.

            // Chaves externas" => "
            "idMenu" => "INT NULL", // Menu personalizado.

            // Informações básicas
            "fullName"  => "VARCHAR(160) NULL",   // Nome Completo.
            "firstName" => "VARCHAR(40) NULL",    // Primeiro nome.
            "lastName"  => "VARCHAR(40) NULL",    // Último nome.

            // Login - Pode ser usado para realizar o login.
            "userName" => "VARCHAR(32) NULL",    // User para logar.
            "email"    => "VARCHAR(160) NULL",   // E-mail principal da coopama.
            "telefone" => "VARCHAR(11) NULL",    // Telefone (numero only).
            "cpf"      => "VARCHAR(11) NULL",    // CPF.
            "cnpj"     => "VARCHAR(11) NULL",    // CNPJ.

            // Senha
            "senha"          => "VARCHAR(64) NOT NULL",   // criptografia hash('sha256', $senha).
            "expirationDays" => "INT(11) NULL",
            "strongPass"     => "BOOLEAN NULL",
            "dateChangePass" => "DATETIME NULL",

            // Controle
            "initialUrl" => "VARCHAR(255) NOT NULL",   // Redireciona para esta URL após logado. (Personalização)
            "menu"       => "MEDIUMTEXT NOT NULL",     // Menu Personalizado serialize.


            // CRIADO AUTOMATICAMENTE
            // // Observações do registro (obrigatório)
            // "obs" => "VARCHAR(255) NULL",

            // // Controle padrão do registro (obrigató
            // "idStatus"      => "INT NULL",
            // "idLoginCreate" => "INT NULL",
            // "dtCreate"      => "DATETIME NULL",
            // "idLoginUpdate" => "INT NULL",
            // "dtUpdate"      => "DATETIME NULL",

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
     * Modelo para criação de uma query personalizada.
     * É possível fazer inner joins e filtros personalizados.
     * ATENÇÃO: Não deixar brechas para SQL Injection.
     *
     * @param PDO $conn
     * @return int
     */
    public function verificaLogin($login, $senha)
    {
        // Limpa valores
        $login = parent::limpaInject($login);
        $senha = parent::limpaInject($senha);

        // Obtém select padrão.
        $sql = $this->fullSelect();

        // Acrescenta where no SQL.
        $sql .= "
        WHERE (
            email = $login OR
            userName = $login OR
            matricula = $login
            ) AND
            (senha = $senha)
            AND
            idStatus != 2
        LIMIT 1;
        ";
        
        // Executa query.
        $r = parent::executeQuery($sql);

        // Verifica se não teve retorno.
        if (!$r)
            return false;

        // Retorna primeira linha.
        return $r[0];
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
     * SQL padrão.
     * Monta select padrão com todos os campos e junções.
     *
     * @return string
     */
    private function fullSelect()
    {
        // Ajusta nome real da tabela.
        $tableName = parent::fullTableName();

        // Monta select padrão com todos os campos e junções.
        $sql = "
        SELECT
            id,
            matricula,
            idUser,
            idOld,
            idMenu,
            fullName,
            firstName,
            lastName,
            userName,
            email,
            telefone,
            cpf,
            cnpj,
            expirationDays,
            strongPass,
            dateChangePass,
            initialUrl,
            menu,
            obs,
            idStatus,
            idLoginCreate,
            dtCreate,
            idLoginUpdate,
            dtUpdate

        FROM $tableName 

        ";

        return $sql;
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
        $r = true;

        // Insert modelo.
        $r = parent::insert([
            // Informações do registro.
            'matricula' => '2142',

            'fullName'  => 'Mateus Rocha Brust',
            'firstName' => 'Mateus',
            'lastName'  => 'Brust',

            'userName' => 'brust',
            'email'    => 'mateus.brust@coopama.com.br',
            'telefone' => '31993265491',
            'cpf'      => '10401141640',

            'senha'          => hash('sha256', '123456'),
            'expirationDays' => '360',
            'strongPass'     => false,
            'dateChangePass' => '2023-05-23',

            // Observações do registro (obrigatório).
            'obs'           => 'Insert Automático.',

            // Controle padrão do registro (obrigatório).
            'idStatus'      => 1,
            'idLoginCreate' => 1,
            'dtCreate'      => date("Y-m-d H:i:s"),
            'idLoginUpdate' => 1,
            'dtUpdate'      => date("Y-m-d H:i:s"),
        ]);


        // Finaliza a função.
        return $r;
    }
}
