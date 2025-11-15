<?php
// src/Application/DTOs/MaterialDTO.php

namespace EletronicoVerde\Application\DTOs;

class MaterialDTO
{
    public string $nome;
    public ?string $descricao;
    

    public function __construct(array $dados)
    {
        $this->nome = $dados['nome'] ?? '';
        $this->descricao = $dados['descricao'] ?? null;
        
    }

    //Cria DTO a partir de dados POST
    public static function fromPost(array $post): self
    {
        return new self([
            'nome' => $post['material'] ?? $post['nome'] ?? '',
            'descricao' => $post['descricao'] ?? null,
            
        ]);
    }
}