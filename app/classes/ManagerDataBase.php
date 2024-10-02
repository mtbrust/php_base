<?php

namespace classes;

/**
 * ManagerDataBase
 */
class ManagerDataBase
{
    static private $tables = [];

    public static function createTables()
    {
        self::entityTables();

        // Crio as tabelas.
        self::$tables['bdLogDb']->createTable();
        self::$tables['bdLogins']->createTable();
        self::$tables['bdGroups']->createTable();
        self::$tables['bdLoginsGroups']->createTable();
        self::$tables['bdPermissions']->createTable();
        self::$tables['bdStatus']->createTable();
        self::$tables['bdModelo']->createTable();
    }

    private static function entityTables()
    {
        if (empty(self::$tables)) {
            self::$tables = [
                'bdLogDb'        => new \BdLogDb(),
                'bdLogins'       => new \BdLogins(),
                'bdGroups'       => new \BdGroups(),
                'bdLoginsGroups' => new \BdLoginsGroups(),
                'bdPermissions'  => new \BdPermissions(),
                'bdStatus'       => new \BdStatus(),
                'bdModelo'       => new \BdModelo(),
            ];
        }
    }
}
