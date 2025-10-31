<?php
// src/Application/UseCases/Usuario/AutenticarUsuarioUseCase.php

namespace EletronicoVerde\Application\UseCases\Usuario;

use EletronicoVerde\Domain\Interfaces\UsuarioRepositoryInterface;
use EletronicoVerde\Infrastructure\Security\Authentication;

class AutenticarUsuarioUseCase
{
    private UsuarioRepositoryInterface $usuarioRepository;
    private Authentication $authentication;

    public function __construct(
        UsuarioRepositoryInterface $usuarioRepository,
        Authentication $authentication
    ) {
        $this->usuarioRepository = $usuarioRepository;
        $this->authentication = $authentication;
    }

    /**
     * Executa a autenticação do usuário
     */
    public function executar(string $emailOuUsername, string $senha): array
    {
        try {
            // Validar dados
            if (empty($emailOuUsername) || empty($senha)) {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Email e senha são obrigatórios.'
                ];
            }

            // Buscar usuário por email
            $usuario = $this->usuarioRepository->buscarPorEmail($emailOuUsername);

            if (!$usuario) {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Email ou senha incorretos.'
                ];
            }

            // Verificar senha
            if (!$usuario->verificarSenha($senha)) {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Email ou senha incorretos.'
                ];
            }

            // Criar sessão
            $this->authentication->login($usuario);

            return [
                'sucesso' => true,
                'mensagem' => 'Login realizado com sucesso!',
                'usuario' => $usuario->toArray()
            ];

        } catch (\Exception $e) {
            error_log("Erro na autenticação: " . $e->getMessage());
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao realizar login. Tente novamente.'
            ];
        }
    }

    /**
     * Verifica se usuário está autenticado
     */
    public function verificarAutenticacao(): bool
    {
        return $this->authentication->verificarAutenticacao();
    }

    /**
     * Realiza logout
     */
    public function logout(): void
    {
        $this->authentication->logout();
    }
}