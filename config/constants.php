<?php
// config/constants.php

// Caminhos da aplicação
define('ROOT_PATH', dirname(__DIR__));
define('SRC_PATH', ROOT_PATH . '/src');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('STORAGE_PATH', ROOT_PATH . '/storage');
define('VIEWS_PATH', SRC_PATH . '/Presentation/Views');

// URLs
define('BASE_URL', 'http://localhost');

// Configurações da aplicação
define('APP_NAME', 'Eletrônico Verde');
define('APP_VERSION', '2.0.0');
define('APP_ENV', 'development'); // production, development

// Configurações de sessão
define('SESSION_LIFETIME', 7200); // 2 horas

// Configurações de erro
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
    ini_set('error_log', STORAGE_PATH . '/logs/error.log');
}