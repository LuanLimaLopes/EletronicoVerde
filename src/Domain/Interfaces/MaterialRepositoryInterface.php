<?php

// src/Domain/Interfaces/MaterialRepositoryInterface.php

namespace EletronicoVerde\Domain\Interfaces;

use EletronicoVerde\Domain\Entities\Material;

interface MaterialRepositoryInterface
{
    public function salvar(Material $material): bool;
    public function atualizar(Material $material): bool;
    public function buscarPorId(int $id): ?Material;
    public function buscarPorNome(string $nome): ?Material;
    public function listarTodos(): array;
    public function buscarPorIds(array $ids): array;
    public function excluir(int $id): bool;
    public function existePorNome(string $nome, ?int $excluirId = null): bool;
}