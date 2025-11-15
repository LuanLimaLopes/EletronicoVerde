<?php
// src/Domain/Entities/Usuario.php

namespace EletronicoVerde\Domain\Entities;

class Usuario
{
    private ?int $id;
    private string $nome;
    private string $email;
    private string $senha;
    private ?string $createdAt;
    private ?string $updatedAt;

    public function __construct(
        string $nome,
        string $email,
        string $senha,
        ?int $id = null
    ) {
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->id = $id;
        
        $this->validate();
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getNome(): string { return $this->nome; }
    public function getEmail(): string { return $this->email; }
    public function getSenha(): string { return $this->senha; }
    public function getCreatedAt(): ?string { return $this->createdAt; }
    public function getUpdatedAt(): ?string { return $this->updatedAt; }

    // Setters
    public function setId(int $id): void { $this->id = $id; }
    
    public function setNome(string $nome): void 
    { 
        $this->nome = $nome;
        $this->validate();
    }
    
    public function setEmail(string $email): void 
    { 
        $this->email = $email;
        $this->validate();
    }
    
    public function setSenha(string $senha): void 
    { 
        $this->senha = $senha;
    }

    public function setCreatedAt(string $createdAt): void { $this->createdAt = $createdAt; }
    public function setUpdatedAt(string $updatedAt): void { $this->updatedAt = $updatedAt; }

    //Valida os dados da entidade
    private function validate(): void
    {
        if (empty($this->nome)) {
            throw new \InvalidArgumentException("Nome é obrigatório.");
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Email inválido.");
        }

        if (strlen($this->nome) < 3) {
            throw new \InvalidArgumentException("Nome deve ter pelo menos 3 caracteres.");
        }
    }

    //Verifica se a senha fornecida corresponde ao hash armazenado
    public function verificarSenha(string $senhaFornecida): bool
    {
        return password_verify($senhaFornecida, $this->senha);
    }

    //Define uma nova senha (já deve vir hasheada)
    public function alterarSenha(string $novaSenhaHash): void
    {
        $this->senha = $novaSenhaHash;
    }

    //Converte para array (sem incluir senha)
    public function toArray(bool $incluirSenha = false): array
    {
        $data = [
            'id' => $this->id,
            'nome' => $this->nome,
            'email' => $this->email,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt
        ];

        if ($incluirSenha) {
            $data['senha'] = $this->senha;
        }

        return $data;
    }
}