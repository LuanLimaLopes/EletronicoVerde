<?php
// src/Infrastructure/Repositories/SQLiteMaterialRepository.php

namespace EletronicoVerde\Infrastructure\Repositories;

use EletronicoVerde\Domain\Entities\Material;
use EletronicoVerde\Domain\Interfaces\MaterialRepositoryInterface;
use EletronicoVerde\Infrastructure\Database\SQLiteConnection;
use PDO;
use EletronicoVerde\Infrastructure\Logger;

class SQLiteMaterialRepository implements MaterialRepositoryInterface
{
    private PDO $db;

    public function __construct()
    {
        $this->db = SQLiteConnection::getInstance();
    }

    //Salva um novo material
    public function salvar(Material $material): bool
    {
        try {
            $sql = "INSERT INTO materiais (nome, descricao, icone) 
                    VALUES (:nome, :descricao, :icone)";

            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                ':nome' => $material->getNome(),
                ':descricao' => $material->getDescricao(),
                ':icone' => $material->getIcone()
            ]);

            if ($result) {
                $material->setId((int) $this->db->lastInsertId());
            }

            return $result;

        } catch (\PDOException $e) {
            logger::error("Erro ao salvar material: " . $e->getMessage());
            return false;
        }
    }

    //Atualiza um material existente
    public function atualizar(Material $material): bool
    {
        try {
            $sql = "UPDATE materiais SET
                    nome = :nome,
                    descricao = :descricao,
                    icone = :icone
                    WHERE id = :id";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':nome' => $material->getNome(),
                ':descricao' => $material->getDescricao(),
                ':icone' => $material->getIcone(),
                ':id' => $material->getId()
            ]);

        } catch (\PDOException $e) {
            logger::error("Erro ao atualizar material: " . $e->getMessage());
            return false;
        }
    }

    //Busca um material por ID
    public function buscarPorId(int $id): ?Material
    {
        try {
            $sql = "SELECT * FROM materiais WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            $dados = $stmt->fetch();

            if (!$dados) {
                return null;
            }

            return $this->converterParaEntidade($dados);

        } catch (\PDOException $e) {
            logger::error("Erro ao buscar material: " . $e->getMessage());
            return null;
        }
    }

    //Busca um material por nome
    public function buscarPorNome(string $nome): ?Material
    {
        try {
            $sql = "SELECT * FROM materiais WHERE nome = :nome";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':nome' => $nome]);
            
            $dados = $stmt->fetch();

            if (!$dados) {
                return null;
            }

            return $this->converterParaEntidade($dados);

        } catch (\PDOException $e) {
            logger::error("Erro ao buscar material por nome: " . $e->getMessage());
            return null;
        }
    }

    //Lista todos os materiais
    public function listarTodos(): array
    {
        try {
            $sql = "SELECT * FROM materiais ORDER BY nome ASC";
            $stmt = $this->db->query($sql);
            $resultados = $stmt->fetchAll();

            $materiais = [];
            foreach ($resultados as $dados) {
                $materiais[] = $this->converterParaEntidade($dados);
            }

            return $materiais;

        } catch (\PDOException $e) {
            logger::error("Erro ao listar materiais: " . $e->getMessage());
            return [];
        }
    }

    //Busca materiais por IDs
    public function buscarPorIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        try {
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $sql = "SELECT * FROM materiais WHERE id IN ($placeholders) ORDER BY nome ASC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($ids);
            
            $resultados = $stmt->fetchAll();

            $materiais = [];
            foreach ($resultados as $dados) {
                $materiais[] = $this->converterParaEntidade($dados);
            }

            return $materiais;

        } catch (\PDOException $e) {
            logger::error("Erro ao buscar materiais por IDs: " . $e->getMessage());
            return [];
        }
    }

    //Exclui um material
    public function excluir(int $id): bool
    {
        try {
            $sql = "DELETE FROM materiais WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);

        } catch (\PDOException $e) {
            logger::error("Erro ao excluir material: " . $e->getMessage());
            return false;
        }
    }

    //Verifica se material existe por nome
    public function existePorNome(string $nome, ?int $excluirId = null): bool
    {
        try {
            $sql = "SELECT COUNT(*) FROM materiais WHERE nome = :nome";
            
            if ($excluirId !== null) {
                $sql .= " AND id != :id";
            }

            $stmt = $this->db->prepare($sql);
            $params = [':nome' => $nome];
            
            if ($excluirId !== null) {
                $params[':id'] = $excluirId;
            }

            $stmt->execute($params);
            return $stmt->fetchColumn() > 0;

        } catch (\PDOException $e) {
            logger::error("Erro ao verificar existência de material: " . $e->getMessage());
            return false;
        }
    }

    //Converte array do banco para Entidade
    private function converterParaEntidade(array $dados): Material
    {
        $material = new Material(
            $dados['nome'],
            $dados['descricao'],
            $dados['icone'],
            $dados['id']
        );

        $material->setCreatedAt($dados['created_at']);
        $material->setUpdatedAt($dados['updated_at']);

        return $material;
    }
}