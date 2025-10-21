<?php

use EletronicoVerde\Infrastructure\Database\SQLiteConnection;
use EletronicoVerde\Presentation\Controllers\HomeController;
use EletronicoVerde\Presentation\Controllers\PontoColetaController;
use EletronicoVerde\Presentation\Controllers\MaterialController;
use EletronicoVerde\Presentation\Controllers\ReciclagemController;
use EletronicoVerde\Presentation\Controllers\AuthController;

// Obtém a URL atual
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base = '/eletronicoverde';
$route = str_replace($base, '/', $requestUri);

// Remove barra final se existir
$route = rtrim($route, '/');

// Obtém a conexão
$connection = SQLiteConnection::getInstance();

// Define a rota atual
$route = '/' . ($_GET['route'] ?? 'home');

// Suas rotas aqui
switch ($route) {
    case '':
    case '/':
    case '/home':
        $controller = new HomeController();
        $controller->index();
        break;

    // Pontos de Coleta
    case '/pontos-coleta':
        $controller = new PontoColetaController();
        $controller->index();
        break;

    case '/pontos-coleta/cadastro':
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
        require VIEWS_PATH . '/404.php';
        break;
}