<?php
// Caminhos do sistema
define('BASE_PATH', dirname(__DIR__));
define('PUBLIC_PATH', BASE_PATH . '/public');
define('BASE_URL', '/eletronicoverde');

// nova constante: URL pública do diretório public
define('PUBLIC_URL', rtrim(BASE_URL, '/') . '/public');


// nova constante: pasta de assets (css, js, images)
define('ASSETS_URL', PUBLIC_URL . '/assets');
define('VIEWS_URL', BASE_URL . '/src/Presentation/Views');
define('CONTROLLERS_URL', BASE_URL . '/src/Presentation/Controllers');

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

// remova/evite echo de debug aqui
//echo "Conexão com banco de dados estabelecida com sucesso!";
?>