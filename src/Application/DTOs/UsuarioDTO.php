<?php
// src/Application/DTOs/UsuarioDTO.php

namespace EletronicoVerde\Application\DTOs;

class UsuarioDTO
{
    public string $nome;
    public string $email;
    public string $senha;

    public function __construct(array $dados)
    {
        $this->nome = $dados['nome'] ?? '';
        $this->email = $dados['email'] ?? '';
        $this->senha = $dados['senha'] ?? '';
    }

    //Cria DTO a partir de dados POST
    public static function fromPost(array $post): self
    {
        return new self([
            'nome' => $post['nome'] ?? '',
            'email' => $post['email'] ?? $post['username'] ?? '',
            'senha' => $post['senha'] ?? $post['password'] ?? ''
        ]);
    }
}