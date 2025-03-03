<?php

namespace classes;

/**
 * ManagerDataBase
 * 
 * Gerencia as funções básicas de todas as tabelas mapeadas.
 * É possível criar as tabelas, deletar e popular.
 */
class ManagerDataBase
{
    /**
     * tables
     * 
     * Classes das tabelas do bancos de dados que o sistema irá executar as ações em massa.
     *
     * @var array
     */
    static private $tables = [
        'BdLogDb',
        'BdLogins',
        'BdGroups',
        'BdLoginsGroups',
        'BdLoginsGroupsMenu',
        'BdPermissions',
        'BdStatus',
        'BdModelo',
    ];

    /**
     * tablesInstanses
     * 
     * Instancias das tabelas.
     *
     * @var array
     */
    static private $tablesInstanses = [];

    /**
     * createTables
     * 
     * Cria todas as tabelas mapeadas.
     *
     * @return void
     */
    public static function createTables($table = null)
    {
        self::instanseTables();
        self::functionTables('createTable', $table);
    }

    /**
     * dropTables
     * 
     * Deleta todas as tabelas mapeadas.
     *
     * @return void
     */
    public static function dropTables($table = null)
    {
        self::instanseTables();
        self::functionTables('dropTable', $table);
    }

    /**
     * seedsTables
     * 
     * Popula as tabelas.
     *
     * @return void
     */
    public static function seedsTables($table = null)
    {
        self::instanseTables();
        self::functionTables('seeds', $table);
    }

    /**
     * getTables
     * 
     * Retorna as classes de tabelas mapeadas.
     *
     * @return array
     */
    public static function getTables()
    {
        return self::$tables;
    }

    /**
     * getTables
     * 
     * Retorna as classes de tabelas mapeadas em formato html.
     *
     * @return string
     */
    public static function getTablesHtml()
    {
        $html = '<ul class="list-group">';
        foreach (self::$tables as $key => $value) {
            $html .= '<l1 class="list-group-item text-start">';
            $html .= '[ ' . $key . ' ] ' . $value;
            $html .= '</l1>';
        }
        $html .= '</ul><br>';
        return $html;
    }

    /**
     * functionTables
     * 
     * Chama uma função genérica da classe de tabela em massa.
     * Exemplo: 'createTable', 'dropTable', 'seeds', etc.
     *
     * @param  mixed $action // Nome da função da classe de tabela.
     * @param   int $table // Nome da tabela específica.
     * @return void
     */
    private static function functionTables($action, $table = null)
    {
        // Verifica se foi passada uma ação específica.
        if (!is_null($table)) {
            // Executa ação específica.
            self::$tablesInstanses[$table]->$action();
        } else {
            // Percorre cada instancia e chama a função
            foreach (self::$tablesInstanses as $key => $table) {
                $table->$action();
            }
        }
    }

    /**
     * instanseTables
     * 
     * Inicializa as instancias de todas as classes de tabela mapeadas.
     *
     * @return void
     */
    private static function instanseTables()
    {
        if (empty(self::$tablesInstanses)) {
            foreach (self::$tables as $key => $bd) {
                self::$tablesInstanses[] = new $bd();
            }
        }
    }
}
