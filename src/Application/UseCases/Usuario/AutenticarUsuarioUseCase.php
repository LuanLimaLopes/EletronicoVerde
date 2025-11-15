<?php
// src/Application/UseCases/Usuario/AutenticarUsuarioUseCase.php

namespace EletronicoVerde\Application\UseCases\Usuario;

use EletronicoVerde\Domain\Interfaces\UsuarioRepositoryInterface;
use EletronicoVerde\Infrastructure\Security\Authentication;
use EletronicoVerde\Infrastructure\Logger;

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
            logger::info("=== INÍCIO AUTENTICAÇÃO ===");
            logger::info("Login tentado com: " . $emailOuUsername);
            logger::info("Senha recebida (length): " . strlen($senha));
            
            // Validar dados
            if (empty($emailOuUsername) || empty($senha)) {
                logger::error("❌ Validação falhou: campos vazios");
                return [
                    'sucesso' => false,
                    'mensagem' => 'Usuário e senha são obrigatórios.'
                ];
            }

            // LOG 2: Tentando buscar por email
            logger::info("🔍 Buscando por EMAIL: " . $emailOuUsername);
            $usuario = $this->usuarioRepository->buscarPorEmail($emailOuUsername);
            
            // Se não encontrou por email, tenta buscar por nome (username)
            if (!$usuario) {
                logger::error("⚠️ Não encontrado por email, tentando por NOME...");
                $usuario = $this->usuarioRepository->buscarPorNome($emailOuUsername);
            }

            // LOG 3: Resultado da busca
            if (!$usuario) {
                logger::error("❌ Usuário NÃO encontrado no banco");
                return [
                    'sucesso' => false,
                    'mensagem' => 'Usuário ou senha incorretos.'
                ];
            }
            
            logger::info("✅ Usuário encontrado: ID=" . $usuario->getId() . ", Nome=" . $usuario->getNome());
            logger::info("Hash no banco: " . substr($usuario->getSenha(), 0, 30) . "...");

            // LOG 4: Verificando senha
            logger::info("🔐 Verificando senha...");
            $senhaCorreta = $usuario->verificarSenha($senha);
            logger::info("Resultado verificação: " . ($senhaCorreta ? "✅ CORRETA" : "❌ INCORRETA"));
            
            if (!$senhaCorreta) {
                logger::error("❌ Senha incorreta para usuário: " . $usuario->getNome());
                
                // DEBUG EXTRA: Testar password_verify direto
                $testeDirecto = password_verify($senha, $usuario->getSenha());
                logger::info("Teste direto password_verify: " . ($testeDirecto ? "PASSOU" : "FALHOU"));
                
                return [
                    'sucesso' => false,
                    'mensagem' => 'Usuário ou senha incorretos.'
                ];
            }

            // LOG 5: Criando sessão
            logger::info("✅ Senha correta! Criando sessão...");
            $this->authentication->login($usuario);
            logger::info("✅ Login realizado com sucesso!");
            logger::info("=== FIM AUTENTICAÇÃO ===");

            return [
                'sucesso' => true,
                'mensagem' => 'Login realizado com sucesso!',
                'usuario' => $usuario->toArray()
            ];

        } catch (\Exception $e) {
            logger::info("💥 EXCEÇÃO na autenticação: " . $e->getMessage());
            logger::info("Stack trace: " . $e->getTraceAsString());
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