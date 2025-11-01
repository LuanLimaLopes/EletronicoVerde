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
            // LOG 1: Dados recebidos
            error_log("=== INÍCIO AUTENTICAÇÃO ===");
            error_log("Login tentado com: " . $emailOuUsername);
            error_log("Senha recebida (length): " . strlen($senha));
            
            // Validar dados
            if (empty($emailOuUsername) || empty($senha)) {
                error_log("❌ Validação falhou: campos vazios");
                return [
                    'sucesso' => false,
                    'mensagem' => 'Usuário e senha são obrigatórios.'
                ];
            }

            // LOG 2: Tentando buscar por email
            error_log("🔍 Buscando por EMAIL: " . $emailOuUsername);
            $usuario = $this->usuarioRepository->buscarPorEmail($emailOuUsername);
            
            // Se não encontrou por email, tenta buscar por nome (username)
            if (!$usuario) {
                error_log("⚠️ Não encontrado por email, tentando por NOME...");
                $usuario = $this->usuarioRepository->buscarPorNome($emailOuUsername);
            }

            // LOG 3: Resultado da busca
            if (!$usuario) {
                error_log("❌ Usuário NÃO encontrado no banco");
                return [
                    'sucesso' => false,
                    'mensagem' => 'Usuário ou senha incorretos.'
                ];
            }
            
            error_log("✅ Usuário encontrado: ID=" . $usuario->getId() . ", Nome=" . $usuario->getNome());
            error_log("Hash no banco: " . substr($usuario->getSenha(), 0, 30) . "...");

            // LOG 4: Verificando senha
            error_log("🔐 Verificando senha...");
            $senhaCorreta = $usuario->verificarSenha($senha);
            error_log("Resultado verificação: " . ($senhaCorreta ? "✅ CORRETA" : "❌ INCORRETA"));
            
            if (!$senhaCorreta) {
                error_log("❌ Senha incorreta para usuário: " . $usuario->getNome());
                
                // DEBUG EXTRA: Testar password_verify direto
                $testeDirecto = password_verify($senha, $usuario->getSenha());
                error_log("Teste direto password_verify: " . ($testeDirecto ? "PASSOU" : "FALHOU"));
                
                return [
                    'sucesso' => false,
                    'mensagem' => 'Usuário ou senha incorretos.'
                ];
            }

            // LOG 5: Criando sessão
            error_log("✅ Senha correta! Criando sessão...");
            $this->authentication->login($usuario);
            error_log("✅ Login realizado com sucesso!");
            error_log("=== FIM AUTENTICAÇÃO ===");

            return [
                'sucesso' => true,
                'mensagem' => 'Login realizado com sucesso!',
                'usuario' => $usuario->toArray()
            ];

        } catch (\Exception $e) {
            error_log("💥 EXCEÇÃO na autenticação: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
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