<?php

// src/Domain/Interfaces/UsuarioRepositoryInterface.php

namespace EletronicoVerde\Domain\Interfaces;

use EletronicoVerde\Domain\Entities\Usuario;

interface UsuarioRepositoryInterface
{
    public function salvar(Usuario $usuario): bool;
    public function atualizar(Usuario $usuario): bool;
    public function buscarPorId(int $id): ?Usuario;
    public function buscarPorEmail(string $email): ?Usuario;
    public function buscarPorNome(string $nome): ?Usuario; // novo
    public function listarTodos(): array;
    public function excluir(int $id): bool;
    public function emailExiste(string $email, ?int $excluirId = null): bool;
}