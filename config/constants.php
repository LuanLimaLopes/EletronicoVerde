<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

if (!defined('PUBLIC_PATH')) {
    define('PUBLIC_PATH', BASE_PATH . '/public');
}

if (!defined('BASE_URL')) {
    define('BASE_URL', '/EletronicoVerde/public');
}

// Outras constantes necessárias
define('VIEWS_PATH', BASE_PATH . '/src/Presentation/Views');
define('STORAGE_PATH', BASE_PATH . '/storage');
define('DATABASE_PATH', STORAGE_PATH . '/database');

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

// Garante que o arquivo do banco existe
if (!file_exists(DATABASE_PATH . '/database.sqlite')) {
    if (!is_dir(DATABASE_PATH)) {
        mkdir(DATABASE_PATH, 0777, true);
    }
    touch(DATABASE_PATH . '/database.sqlite');
}

echo "Conexão com banco de dados estabelecida com sucesso!";
?>