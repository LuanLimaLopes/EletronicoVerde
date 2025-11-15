<?php
// src/Domain/Entities/Material.php

namespace EletronicoVerde\Domain\Entities;

class Material
{
    private ?int $id;
    private string $nome;
    private ?string $descricao;
    private ?string $icone;
    private ?string $createdAt;
    private ?string $updatedAt;

    public function __construct(
        string $nome,
        ?string $descricao = null,
        ?string $icone = null,
        ?int $id = null
    ) {
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->icone = $icone;
        $this->id = $id;
        
        $this->validate();
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getNome(): string { return $this->nome; }
    public function getDescricao(): ?string { return $this->descricao; }
    public function getIcone(): ?string { return $this->icone; }
    public function getCreatedAt(): ?string { return $this->createdAt; }
    public function getUpdatedAt(): ?string { return $this->updatedAt; }

    // Setters
    public function setId(int $id): void { $this->id = $id; }
    
    public function setNome(string $nome): void 
    { 
        $this->nome = $nome;
        $this->validate();
    }
    
    public function setDescricao(?string $descricao): void 
    { 
        $this->descricao = $descricao; 
    }
    
    public function setIcone(?string $icone): void 
    { 
        $this->icone = $icone; 
    }

    public function setCreatedAt(string $createdAt): void { $this->createdAt = $createdAt; }
    public function setUpdatedAt(string $updatedAt): void { $this->updatedAt = $updatedAt; }

    //Valida os dados da entidade
    private function validate(): void
    {
        if (empty($this->nome)) {
            throw new \InvalidArgumentException("Nome do material é obrigatório.");
        }

        if (strlen($this->nome) < 3) {
            throw new \InvalidArgumentException("Nome do material deve ter pelo menos 3 caracteres.");
        }
    }

    //Retorna o ícone FontAwesome completo
    public function getIconeCompleto(): string
    {
        if ($this->icone) {
            return 'fa-solid ' . $this->icone;
        }
        return 'fa-solid fa-microchip'; // ícone padrão
    }

    //Converte para array
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'icone' => $this->icone,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt
        ];
    }
}