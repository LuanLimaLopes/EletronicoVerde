<?php

use EletronicoVerde\Infrastructure\Database\SQLiteConnection;
use EletronicoVerde\Presentation\Controllers\HomeController;
use EletronicoVerde\Presentation\Controllers\PontoColetaController;
use EletronicoVerde\Presentation\Controllers\MaterialController;
use EletronicoVerde\Presentation\Controllers\ReciclagemController;
use EletronicoVerde\Presentation\Controllers\AuthController;
use EletronicoVerde\Infrastructure\Logger;

// 1. CAPTURA MÉTODO HTTP
$method = $_SERVER['REQUEST_METHOD'];

// 2. PROCESSA A ROTA
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base = '/eletronicoverde';

// Remove o base path
$route = str_replace($base, '', $requestUri);

// Se a rota estiver vazia ou for apenas "/", define como "/"
if (empty($route) || $route === '') {
    $route = '/';
}

// Remove barra final (exceto se for a rota raiz)
if ($route !== '/' && substr($route, -1) === '/') {
    $route = rtrim($route, '/');
}

// 3. CONEXÃO COM BANCO
$connection = SQLiteConnection::getInstance();

// 4. ROTEAMENTO
switch ($route) {
    case '/':
    case '/home':
    case '/index.php':
        $controller = new HomeController();
        $controller->index();
        break;

    // PONTOS DE COLETA
    case '/pontos-coleta':
        $controller = new PontoColetaController();
        $controller->index();
        break;

    case '/pontos-coleta/cadastro':
    case '/cadastro-pontos':
        $controller = new PontoColetaController();
        $controller->cadastro();
        break;

    case '/pontos-coleta/salvar':
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
    case '/sucesso_cadastro.php':
        $controller = new PontoColetaController();
        $controller->sucessoCadastro();
        break;

    // APIs DE PONTOS DE COLETA
    
    // API: Busca pontos próximos (por coordenadas)
    case '/api/pontos/buscar-proximos':
        $controller = new PontoColetaController();
        $controller->buscarProximos();
        break;

    // API: Lista todos os pontos ativos
    case '/api/pontos/listar-todos':
        $controller = new PontoColetaController();
        $controller->listarTodos();
        break;

    // API: Busca por CEP (deprecated - use buscar-proximos)
    case '/api/pontos/buscar-cep':
        $controller = new PontoColetaController();
        $controller->buscarPorCep();
        break;

    // MATERIAIS
    case '/materiais-aceitos':
    case '/materiais_aceitos.php':
        $controller = new MaterialController();
        $controller->index();
        break;

    case '/api/materiais':
        $controller = new MaterialController();
        $controller->listar();
        break;

    // RECICLAGEM
    case '/reciclagem':
    case '/reciclagem.php':
        $controller = new ReciclagemController();
        $controller->index();
        break;


    // AUTENTICAÇÃO 
    case '/login':
    case '/login.php':
        $controller = new AuthController();
        
        if ($method === 'POST') {
            // Processa o login quando for POST
            logger::info("🔐 Processando autenticação via POST");
            $controller->autenticar();
        } else {
            // Exibe o formulário quando for GET
            logger::info("📄 Exibindo formulário de login via GET");
            $controller->login();
        }
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

    // 404 - NÃO ENCONTRADO
    default:
        logger::error("⚠️ Rota não encontrada: " . $route);
        http_response_code(404);
        require VIEWS_PATH . '/404.php';
        break;
}