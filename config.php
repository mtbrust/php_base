<?php


/**
 * Configurações de acesso ao banco de dados.
 */

// True para coopama. False para pessoal.
$host = 3;
switch ($host) {
    case '1':
        define("URL_RAIZ", "https://novo-site.coopama.com.br/");
        // Acesso ao banco de dados PDO 01.
        define("DB1", true);                  // Conexão será usada?
        define("DB1_DBMANAGER", "mysql");
        define("DB1_HOST", "localhost");
        define("DB1_PORT", "3306");
        define("DB1_USER", "coopamamc_novoSiteUser");
        define("DB1_PASSWORD", "_Q]4}8(.0IFG");
        define("DB1_DBNAME", "coopamamc_novoSite");
        define("DB1_CHARSET", "utf8");
        define("DB1_PREFIX_TABLE", "coopama_");
        break;
    case '2':
        define("URL_RAIZ", "http://sitecoopama.local/");
        // Acesso ao banco de dados PDO 01.
        define("DB1", true);                  // Conexão será usada?
        define("DB1_DBMANAGER", "mysql");
        define("DB1_HOST", "localhost");
        define("DB1_PORT", "3306");
        define("DB1_USER", "root");
        define("DB1_PASSWORD", "");
        define("DB1_DBNAME", "coopama_sitecoopama");
        define("DB1_CHARSET", "utf8");
        define("DB1_PREFIX_TABLE", "coopama_");
        break;
    case '3':
        define("URL_RAIZ", "http://localhost/base_php/");
        // Acesso ao banco de dados PDO 01.
        define("DB1", true);                  // Conexão será usada?
        define("DB1_DBMANAGER", "mysql");
        define("DB1_HOST", "localhost");
        define("DB1_PORT", "3306");
        define("DB1_USER", "root");
        define("DB1_PASSWORD", "");
        define("DB1_DBNAME", "base_php");
        define("DB1_CHARSET", "utf8");
        define("DB1_PREFIX_TABLE", "db1_");
        break;
}

// Definição do horário padrão.
date_default_timezone_set('America/Sao_Paulo');


// Acesso ao banco de dados PDO 02.
define("DB2", false);                  // Conexão será usada?
define("DB2_DBMANAGER", "mysql");
define("DB2_HOST", "localhost");
define("DB2_PORT", "3306");
define("DB2_USER", "");
define("DB2_PASSWORD", "");
define("DB2_DBNAME", "");
define("DB2_CHARSET", "utf8");
define("DB2_PREFIX_TABLE", "db2_");



// Site vai utilizar views e controllers dos diretórios (v e c)?
define("VIEWS_DIR", true);
// Site vai utilizar views e controller do banco de dados?
define("VIEWS_BD", true);


/**
 * Caminho padrão para modelo MVC.
 * É possível personalizar a pasta para se adequar a estrutura de costume.
 */


// Caminho desde pasta raiz. (c:, var, etc.)
define("DIR_RAIZ", str_replace('\\', '/', getcwd()) . '/');


// Define caminhos para as pastas de conteúdo html.
define("PATH_VIEW", "v/");
define("PATH_VIEW_API", "v/api/");
define("PATH_VIEW_PAGES", "v/pages/");
define("PATH_VIEW_TEMPLATES", "v/templates/");

// Define caminhos para as pastas de controle.
define("PATH_CONTROLLER", "c/");
define("PATH_CONTROLLER_CLASS", "c/class/");
define("PATH_CONTROLLER_PAGES", "c/pages/");
define("PATH_CONTROLLER_API", "c/api/");

// Define caminhos para as pastas de modelo.
define("PATH_MODEL", "m/");
define("PATH_MODEL_BD", "m/bd/");
define("PATH_MODEL_UPLOAD", 'm/midia/upload/');
define("PATH_MODEL_MIDIA", "m/midia/");
define("PATH_MODEL_CLASSES", "m/classes/");
define("PATH_MODEL_ASSETS", "m/assets/");
define("PATH_MODEL_CSS", "m/assets/css/");
define("PATH_MODEL_IMG", "m/assets/img/");
define("PATH_MODEL_JS", "m/assets/js/");
define("PATH_MODEL_ADMIN", "m/assets/admin/");



/**
 * PHP
 */
// Exibição de erros.
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);
