<?php
// src/Presentation/Controllers/AuthController.php

namespace EletronicoVerde\Presentation\Controllers;

use EletronicoVerde\Application\UseCases\Usuario\AutenticarUsuarioUseCase;
use EletronicoVerde\Infrastructure\Repositories\SQLiteUsuarioRepository;
use EletronicoVerde\Infrastructure\Security\Authentication;
use EletronicoVerde\Infrastructure\Security\CSRF;

class AuthController
{
    private AutenticarUsuarioUseCase $autenticarUseCase;
    private Authentication $auth;
    private CSRF $csrf;
    private string $baseUrl = '/eletronicoverde'; 

    public function __construct()
    {
        $usuarioRepository = new SQLiteUsuarioRepository();
        $this->auth = new Authentication();
        $this->csrf = new CSRF();
        
        $this->autenticarUseCase = new AutenticarUsuarioUseCase(
            $usuarioRepository,
            $this->auth
        );
    }

    
    //Exibe página de login 
    public function login(): void
    {
        // Redireciona se já estiver autenticado
        $this->auth->redirecionarSeAutenticado();
        
        $pageTitle = 'Login - Eletrônico Verde';
        $csrfToken = $this->csrf->getToken();
        
        require_once __DIR__ . '/../Views/auth/login.php';
    }

    
    //Processa login
    public function autenticar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . $this->baseUrl . '/login');
            exit;
        }

        // Validar CSRF
        if (!$this->csrf->validarRequisicao()) {
            $_SESSION['erro'] = 'Token de segurança inválido. Tente novamente.';
            header('Location: ' . $this->baseUrl . '/login');
            exit;
        }

        $emailOuUsername = $_POST['username'] ?? $_POST['email'] ?? '';
        $senha = $_POST['password'] ?? $_POST['senha'] ?? '';

        $resultado = $this->autenticarUseCase->executar($emailOuUsername, $senha);

        if ($resultado['sucesso']) {
            header('Location: ' . $this->baseUrl . '/acesso-restrito');
        } else {
            $_SESSION['erro'] = $resultado['mensagem'];
            header('Location: ' . $this->baseUrl . '/login');
        }
        exit;
    }

    //Realiza logout
    public function logout(): void
    {
        $this->autenticarUseCase->logout();
        header('Location: ' . $this->baseUrl . '/');
        exit;
    }

    //Exibe página de acesso restrito
    public function acessoRestrito(): void
    {
        $this->auth->requerAutenticacao();
        
        $pageTitle = 'Acesso Restrito - Eletrônico Verde';
        $nomeUsuario = $this->auth->getUsuarioNome();
        
        require_once __DIR__ . '/../Views/auth/acesso-restrito.php';
    }

    public function redirecionarSeAutenticado(string $redirectUrl = null): void
{
    if ($this->verificarAutenticacao()) {
        $url = $redirectUrl ?? (defined('BASE_URL') ? BASE_URL . '/eletronicoverde/acesso-restrito' : '/eletronicoverde/acesso-restrito');
        header("Location: $url");
        exit;
    }
}
}