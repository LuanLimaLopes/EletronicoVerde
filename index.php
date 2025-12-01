<?php

// Carrega configurações
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/config/autoload.php';

// Autoload 
spl_autoload_register(function ($class) {
    $prefix = 'EletronicoVerde\\';
    $len = strlen($prefix);

    
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $class_path = str_replace('\\', '/', $relative_class) . '.php';

   
    if (strpos($class_path, 'config/') === 0) {
        $file = __DIR__ . '/' . $class_path; // Procura diretamente na pasta 'config' na raiz
    } 
   
    else {
        $file = __DIR__ . '/src/' . $class_path; // Procura dentro da pasta 'src'
    }

    if (file_exists($file)) {
        require $file;
    }
});

// Importar todas as classes necessárias ANTES do try-catch
use EletronicoVerde\Infrastructure\Database\SQLiteConnection;
use EletronicoVerde\Infrastructure\Logger;
use EletronicoVerde\config\database;
use EletronicoVerde\Presentation\Controllers\HomeController;
use EletronicoVerde\Presentation\Controllers\PontoColetaController;
use EletronicoVerde\Presentation\Controllers\MaterialController;
use EletronicoVerde\Presentation\Controllers\ReciclagemController;
use EletronicoVerde\Presentation\Controllers\AuthController;

try {
    // Iniciar sessão
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Inicializa o banco de dados (cria se não existir)
    Database::init();
    
    // Conecta ao banco
    $connection = SQLiteConnection::getInstance();
    
    
    // Roteamento simples
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    
    // Carrega rotas
    require_once __DIR__ . '/config/routes.php';
    
} catch (Exception $e) {
    
    // Mensagem amigável
    http_response_code(500);
    echo "Desculpe, ocorreu um erro. Por favor, tente novamente mais tarde.";
    
    if (ini_get('display_errors')) {
        echo "<br><br><strong>Erro técnico:</strong> " . htmlspecialchars($e->getMessage());
    }
    exit;
}