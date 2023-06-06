<?php

/**
 * AMBIENTE DE PRODUÇÃO
 */

/**
 * * BANCO DE DADOS
 * Conexão com os bancos de dados de acordo com ambiente.
 */
define("BASE_BDS", [
    0 => [
        'TITLE'     => 'BD Principal DEV',
        'ACTIVE'    => true,
        'DBMANAGER' => 'mysql',
        'HOST'      => 'localhost',
        'PORT'      => '3306',
        'USERNAME'  => 'root',
        'PASSWORD'  => '',
        'DATABASE'  => 'base_php',
        'CHARSET'   => 'utf8',
        'PREFIX'    => 'v4',
    ],
    1 => [
        'TITLE'     => 'BD Secundario DEV',
        'ACTIVE'    => true,
        'DBMANAGER' => 'mysql',
        'HOST'      => 'localhost',
        'PORT'      => '3306',
        'USERNAME'  => 'root',
        'PASSWORD'  => '',
        'DATABASE'  => 'base_php',
        'CHARSET'   => 'utf8',
        'PREFIX'    => 'v4',
    ],
]);


/**
 * * AUTORIZAÇÕES
 * Autorizações de APIs, TOKENS, Terceiros, Logins, etc de acordo com ambiente.
 */
define("BASE_AUTH", [
    // Exemplo
    'CAMPO' => 'valor', // Campo personalizado.
  ]);


/**
 * * CONFIGURAÇÕES
 * Configurações personalizadas de acordo com ambiente.
 */
define("BASE_CONFIG", [
    'SHOW_ERRORS' => 0,         // [0] Não exibe erros php. [1] Exibe erros php na tela.
    'CAMPO'       => 'valor',   // Campo personalizado.
  ]);