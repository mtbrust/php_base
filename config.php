<?php


/**
 * Configurações de acesso ao banco de dados.
 */
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



/**
 * Configurações de controle do site.
 */
// Url raíz do site.
define("URL_RAIZ", "http://localhost/base_php/");

// Site vai utilizar views e controllers dos diretórios (v e c)?
define("VIEWS_DIR", true);
// Site vai utilizar views e controller do banco de dados?
define("VIEWS_BD", true);


/**
 * Caminho padrão para modelo MVC.
 * É possível personalizar a pasta para se adequar a estrutura de costume.
 */
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
define("PATH_MODEL_ASSETS", "m/assets/");
define("PATH_MODEL_CSS", "m/assets/css/");
define("PATH_MODEL_IMG", "m/assets/img/");
define("PATH_MODEL_JS", "m/assets/js/");



/**
 * PHP
 */
// Exibição de erros.
// ini_set('display_errors',1);
// ini_set('display_startup_erros',1);
// error_reporting(E_ALL);