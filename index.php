<?php
// Debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Carrega configurações
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/config/autoload.php';

use EletronicoVerde\Infrastructure\Database\SQLiteConnection;

try {
    // Inicia a sessão
    session_start();
    
    // Conecta ao banco
    $connection = SQLiteConnection::getInstance();
    
    // Carrega rotas
    require_once __DIR__ . '/config/routes.php';
    
} catch (Exception $e) {
    // Log do erro
    error_log($e->getMessage());
    
    // Mensagem amigável
    http_response_code(500);
    echo "Desculpe, ocorreu um erro. Por favor, tente novamente mais tarde.";
    exit;
}

// Inicializa a aplicação
require_once __DIR__ . '/config/routes.php';

// Autoload 
spl_autoload_register(function ($class) {
    $prefix = 'EletronicoVerde\\';
    $base_dir = __DIR__ . '/src/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (!file_exists($file)) {
        $file = __DIR__ . '/config/' . basename($file);
    }

    if (file_exists($file)) {
        require $file;
    }
});

// Iniciar sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Roteamento simples
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Importar controllers
use EletronicoVerde\Presentation\Controllers\HomeController;
use EletronicoVerde\Presentation\Controllers\PontoColetaController;
use EletronicoVerde\Presentation\Controllers\MaterialController;
use EletronicoVerde\Presentation\Controllers\ReciclagemController;
use EletronicoVerde\Presentation\Controllers\AuthController;

