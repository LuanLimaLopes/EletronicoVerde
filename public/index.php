<?php
// public/index.php

// Autoload (manual temporário - futuramente usar Composer)
spl_autoload_register(function ($class) {
    $prefix = 'EletronicoVerde\\';
    $base_dir = __DIR__ . '/../src/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (!file_exists($file)) {
        $file = __DIR__ . '/../config/' . basename($file);
    }

    if (file_exists($file)) {
        require $file;
    }
});

// Carregar configurações
require_once __DIR__ . '/../config/constants.php';

// Inicializar banco de dados
use EletronicoVerde\Config\Database;
Database::init();

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

// Rotas
switch ($uri) {
    // Home
    case '/':
    case '/index.php':
        $controller = new HomeController();
        $controller->index();
        break;

    // Pontos de Coleta
    case '/pontos-coleta':
    case '/pontos_coleta.php':
        $controller = new PontoColetaController();
        $controller->index();
        break;

    case '/cadastro-pontos':
    case '/cadastro_pontos.php':
        $controller = new PontoColetaController();
        $controller->cadastro();
        break;

    case '/ponto-coleta/salvar':
    case '/ponto_coleta.php':
        $controller = new PontoColetaController();
        $controller->salvar();
        break;

    case '/consultar-pontos':
    case '/consultar_pontos.php':
        $controller = new PontoColetaController();
        $controller->consultar();
        break;

    case '/editar-ponto':
    case '/editar_ponto.php':
        $controller = new PontoColetaController();
        $controller->editar();
        break;

    case '/ponto-coleta/atualizar':
    case '/alterar.php':
        $controller = new PontoColetaController();
        $controller->atualizar();
        break;

    case '/excluir-ponto':
    case '/excluir_ponto.php':
        $controller = new PontoColetaController();
        $controller->excluir();
        break;

    case '/sucesso-cadastro':
    case '/secesso_cadastro.php':
        $controller = new PontoColetaController();
        $controller->sucessoCadastro();
        break;

    case '/api/pontos/buscar-cep':
        $controller = new PontoColetaController();
        $controller->buscarPorCep();
        break;

    // Materiais
    case '/materiais-aceitos':
    case '/materiais_aceitos.php':
        $controller = new MaterialController();
        $controller->index();
        break;

    case '/api/materiais':
        $controller = new MaterialController();
        $controller->listar();
        break;

    // Reciclagem
    case '/reciclagem':
    case '/reciclagem.php':
        $controller = new ReciclagemController();
        $controller->index();
        break;

    // Autenticação
    case '/login':
    case '/login.php':
        $controller = new AuthController();
        $controller->login();
        break;

    case '/autenticar':
        $controller = new AuthController();
        $controller->autenticar();
        break;

    case '/logout':
        $controller = new AuthController();
        $controller->logout();
        break;

    case '/acesso-restrito':
    case '/acesso_restrito.php':
        $controller = new AuthController();
        $controller->acessoRestrito();
        break;

    // 404
    default:
        http_response_code(404);
        echo "<h1>404 - Página não encontrada</h1>";
        echo "<p><a href='/'>Voltar para a página inicial</a></p>";
        break;
}