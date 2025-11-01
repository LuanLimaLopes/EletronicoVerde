<?php
// src/Infrastructure/Security/CSRF.php

namespace EletronicoVerde\Infrastructure\Security;

class CSRF
{
    private const TOKEN_KEY = 'csrf_token';
    private const TOKEN_TIME_KEY = 'csrf_token_time';
    private const TOKEN_LIFETIME = 3600; // 1 hora


    /*
    * Inicia sessão
    */
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }
    }

    /**
     * Gera um novo token CSRF
     */
    public function gerarToken(): string
    {
        $token = bin2hex(random_bytes(32));
        $_SESSION[self::TOKEN_KEY] = $token;
        $_SESSION[self::TOKEN_TIME_KEY] = time();
        return $token;
    }

    /**
     * Obtém o token CSRF atual ou gera um novo
     */
    public function getToken(): string
    {
        if (!isset($_SESSION[self::TOKEN_KEY]) || $this->tokenExpirou()) {
            return $this->gerarToken();
        }
        return $_SESSION[self::TOKEN_KEY];
    }

    /**
     * Valida o token CSRF
     */
    public function validarToken(string $token): bool
    {
        if (!isset($_SESSION[self::TOKEN_KEY])) {
            return false;
        }

        if ($this->tokenExpirou()) {
            return false;
        }

        return hash_equals($_SESSION[self::TOKEN_KEY], $token);
    }

    /**
     * Verifica se token expirou
     */
    private function tokenExpirou(): bool
    {
        if (!isset($_SESSION[self::TOKEN_TIME_KEY])) {
            return true;
        }

        return (time() - $_SESSION[self::TOKEN_TIME_KEY]) > self::TOKEN_LIFETIME;
    }

    /**
     * Gera campo input hidden com token
     */
    public function gerarCampoInput(): string
    {
        $token = $this->getToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
    }

    /**
     * Valida token de uma requisição POST
     */
    public function validarRequisicao(): bool
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return true; // Não validar em requisições não-POST
        }

        $token = $_POST['csrf_token'] ?? '';
        return $this->validarToken($token);
    }
}