<?php

use classes\DevHelper;

class BdLoginsGroupsMenu extends \controllers\DataBase
{

    /**
     * Atribui a variavel tableName o valor do nome da tabela.
     * É usado em todas as funções para identificar qual a tabela das querys.
     *
     * @var string
     */
    protected $tableName = 'loginsGroupsMenu';


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

            // Informações básicas
            "idLogin" => "INT NULL",
            "idGroup" => "INT NULL",

            // Menu formato json.
            "menu"       => "TEXT NULL",


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
     * Seleciona os registros pelo id de login.
     *
     * @param int $idLogin
     * @return bool|array
     */
    public static function selecionarPorLogin($idLogin)
    {
        // Ajusta nome real da tabela.
        $table = parent::fullTableName();

        // Monta SQL.
        $sql = "SELECT * FROM $table WHERE idLogin = $idLogin";

        // Executa o select
        $r = parent::executeQuery($sql);

        // Verifica se não teve retorno.
        if (!$r)
            return false;

        // Retorna registros.
        return $r;
    }

    


    /**
     * consultaPersonalizada
     * 
     * Retorna os menus cadastrados para esse login ou grupo.
     *
     * @return bool|array
     */
    public function menuLoginGroup($idLogin, $idsGroup)
    {
        // Ajusta nome real da tabela.
        $table = parent::fullTableName();
        // $tableInnerMidia = parent::fullTableName('midia');
        // $tableInnerLogin = parent::fullTableName('login');
        // $tableInnerUsers = parent::fullTableName('users');

        // Monta SQL.
        $sql = "SELECT menu FROM $table WHERE idLogin = '$idLogin' or idGroup in($idsGroup)";

        // Executa o select
        $r = parent::executeQuery($sql);

        // Verifica se não teve retorno.
        if (!$r)
            return false;

        // Retorna primeira linha.
        return $r;
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
     * Realização de testes.
     * Apenas para testes.
     *
     * @return bool
     */
    public static function teste()
    {
        // Teste.
        echo '<hr>';
        echo '<b>Arquivo</b>: ' . __FILE__ . '.<br><b>função</b>: ' . __FUNCTION__;
        echo '<br><br>';
        echo 'Controller da Plataforma.';
        echo '<hr>';

        // Finaliza a função.
        return true;
    }











    /**
     * ********************************************************************************************
     * FUNÇÕES DE APOIO DA CLASSE
     * ********************************************************************************************
     */


    /**
     * Realização dos inserts iniciais.
     *
     * @return bool
     */
    public function seeds()
    {
        // Retorno padrão.
        $r = true;


        $menuUser = [
            'icon' => '',
            'title' => 'Usuário',
            'type' => '',
            'submenu' => [
                [
                    'title' => 'Início',
                    'url_relative' => 'admin/',
                    'icon' => '',
                    'type' => '',
                ],
                [
                    'title' => 'Parâmetros da Página',
                    'url_relative' => 'admin/parametros-pagina/',
                    'icon' => '',
                    'type' => '',
                ],
                [
                    'title' => 'Login',
                    'url_relative' => 'admin/login/',
                    'icon' => '',
                    'type' => '',
                ],
                [
                    'title' => 'Teste',
                    'url_relative' => 'admin/teste/',
                    'icon' => '',
                    'type' => '',
                ],
            ]
        ];

        $menuPublic = [
            'icon' => '',
            'title' => 'Público',
            'type' => '',
            'submenu' => [
                [
                    'title' => 'Início',
                    'url_relative' => 'admin/',
                    'icon' => '',
                    'type' => '',
                ],
                [
                    'title' => 'Login',
                    'url_relative' => 'admin/login/',
                    'icon' => '',
                    'type' => '',
                ],
                [
                    'title' => 'Teste',
                    'url_relative' => 'admin/teste/',
                    'icon' => '',
                    'type' => '',
                ],
            ]
        ];

        $menuAdmin = [
            'icon' => '',
            'title' => 'Administração',
            'type' => '',
            'submenu' => [
                [
                    'title' => 'Início',
                    'url_relative' => 'admin/',
                    'icon' => '',
                    'type' => '',
                ],
                [
                    'title' => 'Login',
                    'url_relative' => 'admin/login/',
                    'icon' => '',
                    'type' => '',
                ],
                [
                    'title' => 'Teste',
                    'url_relative' => 'admin/teste/',
                    'icon' => '',
                    'type' => '',
                ],
            ]
        ];

        $menuUser = json_encode($menuUser);
        $menuPublic = json_encode($menuPublic);
        $menuAdmin = json_encode($menuAdmin);

        // Menu a um login.
        $this->loginMenu(1, $menuUser);
        $this->loginMenu(2, $menuUser);

        // Menu a um grupo.
        $this->groupMenu(1, $menuPublic);
        $this->groupMenu(2, $menuAdmin);

        // Finaliza a função.
        return $r;
    }

    /**
     * Função que associa login a um menu.
     *
     * @param int $id
     * @param int $menu
     * @return bool
     */
    private function loginMenu($id, $menu)
    {
        // Administradores
        parent::insert([
            'idLogin' => $id,
            'menu' => $menu,
        ]);

        return true;
    }

    /**
     * Função que associa grupo a um menu.
     *
     * @param int $id
     * @param int $menu
     * @return bool
     */
    private function groupMenu($id, $menu)
    {
        // Administradores
        parent::insert([
            'idGroup' => $id,
            'menu' => $menu,
        ]);

        return true;
    }
}
