<?php

// src/Application/UseCases/Usuario/CriarUsuarioUseCase.php

namespace EletronicoVerde\Application\UseCases\Usuario;

use EletronicoVerde\Domain\Entities\Usuario;
use EletronicoVerde\Domain\Interfaces\UsuarioRepositoryInterface;
use EletronicoVerde\Infrastructure\Security\PasswordHasher;
use EletronicoVerde\Application\DTOs\UsuarioDTO;

class CriarUsuarioUseCase
{
    private UsuarioRepositoryInterface $usuarioRepository;
    private PasswordHasher $passwordHasher;

    public function __construct(
        UsuarioRepositoryInterface $usuarioRepository,
        PasswordHasher $passwordHasher
    ) {
        $this->usuarioRepository = $usuarioRepository;
        $this->passwordHasher = $passwordHasher;
    }

    //Executa a criação de um novo usuário
    public function executar(UsuarioDTO $dto): array
    {
        try {
            // Validar dados
            $this->validarDados($dto);

            // Verificar se email já existe
            if ($this->usuarioRepository->emailExiste($dto->email)) {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Este email já está cadastrado.'
                ];
            }

            // Hash da senha
            $senhaHash = $this->passwordHasher->hash($dto->senha);

            // Criar entidade
            $usuario = new Usuario(
                $dto->nome,
                $dto->email,
                $senhaHash
            );

            // Salvar
            $sucesso = $this->usuarioRepository->salvar($usuario);

            if ($sucesso) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Usuário cadastrado com sucesso!',
                    'id' => $usuario->getId()
                ];
            }

            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao cadastrar usuário.'
            ];

        } catch (\InvalidArgumentException $e) {
            return [
                'sucesso' => false,
                'mensagem' => $e->getMessage()
            ];
        } catch (\Exception $e) {
            error_log("Erro ao criar usuário: " . $e->getMessage());
            return [
                'sucesso' => false,
                'mensagem' => 'Erro inesperado ao cadastrar usuário.'
            ];
        }
    }

    //Valida os dados do DTO
    private function validarDados(UsuarioDTO $dto): void
    {
        if (empty($dto->nome)) {
            throw new \InvalidArgumentException('Nome é obrigatório.');
        }

        if (empty($dto->email)) {
            throw new \InvalidArgumentException('Email é obrigatório.');
        }

        if (empty($dto->senha)) {
            throw new \InvalidArgumentException('Senha é obrigatória.');
        }

        if (strlen($dto->senha) < 6) {
            throw new \InvalidArgumentException('Senha deve ter no mínimo 6 caracteres.');
        }
    }
}