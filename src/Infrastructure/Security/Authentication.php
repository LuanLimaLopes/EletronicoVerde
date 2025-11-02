<?php
// src/Infrastructure/Security/Authentication.php

namespace EletronicoVerde\Infrastructure\Security;

use EletronicoVerde\Domain\Entities\Usuario;

class Authentication
{
    private const SESSION_KEY = 'usuario_autenticado';
    private const SESSION_ID_KEY = 'usuario_id';
    private const SESSION_NOME_KEY = 'usuario_nome';
    private const SESSION_EMAIL_KEY = 'usuario_email';

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Realiza login do usuário
     */
    public function login(Usuario $usuario): void
    {
        $_SESSION[self::SESSION_KEY] = true;
        $_SESSION[self::SESSION_ID_KEY] = $usuario->getId();
        $_SESSION[self::SESSION_NOME_KEY] = $usuario->getNome();
        $_SESSION[self::SESSION_EMAIL_KEY] = $usuario->getEmail();
        
        // Regenerar ID da sessão por segurança
        session_regenerate_id(true);
    }

    /**
     * Realiza logout
     */
    public function logout(): void
    {
        session_unset();
        session_destroy();
    }

    /**
     * Verifica se usuário está autenticado
     */
    public function verificarAutenticacao(): bool
    {
        return isset($_SESSION[self::SESSION_KEY]) && $_SESSION[self::SESSION_KEY] === true;
    }

    /**
     * Obtém ID do usuário autenticado
     */
    public function getUsuarioId(): ?int
    {
        return $_SESSION[self::SESSION_ID_KEY] ?? null;
    }

    /**
     * Obtém nome do usuário autenticado
     */
    public function getUsuarioNome(): ?string
    {
        return $_SESSION[self::SESSION_NOME_KEY] ?? null;
    }

    /**
     * Obtém email do usuário autenticado
     */
    public function getUsuarioEmail(): ?string
    {
        return $_SESSION[self::SESSION_EMAIL_KEY] ?? null;
    }

    /**
     * Redireciona se não estiver autenticado
     */
    public function requerAutenticacao(string $redirectUrl = '/eletronicoverde/login'): void
    {
        if (!$this->verificarAutenticacao()) {
            header("Location: $redirectUrl");
            exit;
        }
    }

    /**
     * Redireciona se já estiver autenticado
     */
    public function redirecionarSeAutenticado(string $redirectUrl = '/eletronicoverde/acesso-restrito'): void
    {
        if ($this->verificarAutenticacao()) {
            header("Location: $redirectUrl");
            exit;
        }
    }
}