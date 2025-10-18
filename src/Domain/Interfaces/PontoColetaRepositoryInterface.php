<?php
// src/Domain/Interfaces/PontoColetaRepositoryInterface.php
namespace EletronicoVerde\Domain\Interfaces;

use EletronicoVerde\Domain\Entities\PontoColeta;

interface PontoColetaRepositoryInterface
{
    public function salvar(PontoColeta $pontoColeta): bool;
    public function atualizar(PontoColeta $pontoColeta): bool;
    public function buscarPorId(int $id): ?PontoColeta;
    public function listarTodos(bool $apenasAtivos = true): array;
    public function buscarPorCep(string $cep): array;
    public function excluir(int $id): bool;
}