<?php
// src/Infrastructure/Repositories/SQLitePontoColetaRepository.php

namespace EletronicoVerde\Infrastructure\Repositories;

use EletronicoVerde\Domain\Entities\PontoColeta;
use EletronicoVerde\Domain\Entities\Material;
use EletronicoVerde\Domain\Interfaces\PontoColetaRepositoryInterface;
use EletronicoVerde\Infrastructure\Database\SQLiteConnection;
use PDO;
use EletronicoVerde\Infrastructure\Logger;

class SQLitePontoColetaRepository implements PontoColetaRepositoryInterface
{
    private PDO $db;

    public function __construct()
    {
        $this->db = SQLiteConnection::getInstance();
    }

    //Salva um novo ponto de coleta
    public function salvar(PontoColeta $pontoColeta): bool
    {
        try {
            $this->db->beginTransaction();

            $sql = "INSERT INTO pontos_coleta 
                    (empresa, endereco, numero, complemento, cep, cidade, estado, bairro,
                     hora_inicio, hora_encerrar, telefone, email, latitude, longitude, ativo) 
                    VALUES 
                    (:empresa, :endereco, :numero, :complemento, :cep, :cidade, :estado, :bairro,
                     :hora_inicio, :hora_encerrar, :telefone, :email, :latitude, :longitude, :ativo)";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':empresa' => $pontoColeta->getEmpresa(),
                ':endereco' => $pontoColeta->getEndereco(),
                ':numero' => $pontoColeta->getNumero(),
                ':complemento' => $pontoColeta->getComplemento(),
                ':cep' => $pontoColeta->getCep(),
                ':cidade' => $pontoColeta->getCidade(),
                ':estado' => $pontoColeta->getEstado(),
                ':bairro' => $pontoColeta->getBairro(),
                ':hora_inicio' => $pontoColeta->getHoraInicio(),
                ':hora_encerrar' => $pontoColeta->getHoraEncerrar(),
                ':telefone' => $pontoColeta->getTelefone(),
                ':email' => $pontoColeta->getEmail(),
                ':latitude' => $pontoColeta->getLatitude(),
                ':longitude' => $pontoColeta->getLongitude(),
                ':ativo' => $pontoColeta->isAtivo() ? 1 : 0
            ]);

            $pontoColetaId = (int) $this->db->lastInsertId();
            $pontoColeta->setId($pontoColetaId);

            // Salvar materiais relacionados
            if (!empty($pontoColeta->getMateriais())) {
                $this->vincularMateriais($pontoColetaId, $pontoColeta->getMateriais());
            }

            $this->db->commit();
            return true;

        } catch (\PDOException $e) {
            $this->db->rollBack();
            logger::error("Erro ao salvar ponto de coleta: " . $e->getMessage());
            return false;
        }
    }

    //Atualiza um ponto de coleta existente
    public function atualizar(PontoColeta $pontoColeta): bool
    {
        try {
            $this->db->beginTransaction();

            $sql = "UPDATE pontos_coleta SET
                    empresa = :empresa,
                    endereco = :endereco,
                    numero = :numero,
                    complemento = :complemento,
                    cep = :cep,
                    cidade = :cidade,
                    estado = :estado,
                    bairro = :bairro,
                    hora_inicio = :hora_inicio,
                    hora_encerrar = :hora_encerrar,
                    telefone = :telefone,
                    email = :email,
                    latitude = :latitude,
                    longitude = :longitude,
                    ativo = :ativo
                    WHERE id = :id";

            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                ':empresa' => $pontoColeta->getEmpresa(),
                ':endereco' => $pontoColeta->getEndereco(),
                ':numero' => $pontoColeta->getNumero(),
                ':complemento' => $pontoColeta->getComplemento(),
                ':cep' => $pontoColeta->getCep(),
                ':cidade' => $pontoColeta->getCidade(),
                ':estado' => $pontoColeta->getEstado(),
                ':bairro' => $pontoColeta->getBairro(),
                ':hora_inicio' => $pontoColeta->getHoraInicio(),
                ':hora_encerrar' => $pontoColeta->getHoraEncerrar(),
                ':telefone' => $pontoColeta->getTelefone(),
                ':email' => $pontoColeta->getEmail(),
                ':latitude' => $pontoColeta->getLatitude(),
                ':longitude' => $pontoColeta->getLongitude(),
                ':ativo' => $pontoColeta->isAtivo() ? 1 : 0,
                ':id' => $pontoColeta->getId()
            ]);

            // Atualizar materiais relacionados
            $this->removerTodosMateriais($pontoColeta->getId());
            if (!empty($pontoColeta->getMateriais())) {
                $this->vincularMateriais($pontoColeta->getId(), $pontoColeta->getMateriais());
            }

            $this->db->commit();
            return $result;

        } catch (\PDOException $e) {
            $this->db->rollBack();
            logger::error("Erro ao atualizar ponto de coleta: " . $e->getMessage());
            return false;
        }
    }

    //Busca um ponto de coleta por ID
    public function buscarPorId(int $id): ?PontoColeta
    {
        try {
            $sql = "SELECT * FROM pontos_coleta WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            $dados = $stmt->fetch();

            if (!$dados) {
                return null;
            }

            $pontoColeta = $this->converterParaEntidade($dados);
            
            // Carregar materiais relacionados
            $materiais = $this->buscarMateriaisPorPontoColeta($id);
            foreach ($materiais as $material) {
                $pontoColeta->adicionarMaterial($material);
            }

            return $pontoColeta;

        } catch (\PDOException $e) {
            logger::error("Erro ao buscar ponto de coleta: " . $e->getMessage());
            return null;
        }
    }

    //Lista todos os pontos de coleta
    public function listarTodos(bool $apenasAtivos = true): array
    {
        try {
            $sql = "SELECT * FROM pontos_coleta";
            
            if ($apenasAtivos) {
                $sql .= " WHERE ativo = 1";
            }
            
            $sql .= " ORDER BY empresa ASC";

            $stmt = $this->db->query($sql);
            $resultados = $stmt->fetchAll();

            $pontosColeta = [];
            foreach ($resultados as $dados) {
                $pontoColeta = $this->converterParaEntidade($dados);
                
                // Carregar materiais relacionados
                $materiais = $this->buscarMateriaisPorPontoColeta($pontoColeta->getId());
                foreach ($materiais as $material) {
                    $pontoColeta->adicionarMaterial($material);
                }
                
                $pontosColeta[] = $pontoColeta;
            }

            return $pontosColeta;

        } catch (\PDOException $e) {
            logger::error("Erro ao listar pontos de coleta: " . $e->getMessage());
            return [];
        }
    }

    //Busca pontos por CEP
    public function buscarPorCep(string $cep): array
    {
        try {
            $cepLimpo = preg_replace('/[^0-9]/', '', $cep);
            
            $sql = "SELECT * FROM pontos_coleta 
                    WHERE cep = :cep AND ativo = 1 
                    ORDER BY empresa ASC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([':cep' => $cepLimpo]);
            
            $resultados = $stmt->fetchAll();

            $pontosColeta = [];
            foreach ($resultados as $dados) {
                $pontoColeta = $this->converterParaEntidade($dados);
                
                // Carregar materiais relacionados
                $materiais = $this->buscarMateriaisPorPontoColeta($pontoColeta->getId());
                foreach ($materiais as $material) {
                    $pontoColeta->adicionarMaterial($material);
                }
                
                $pontosColeta[] = $pontoColeta;
            }

            return $pontosColeta;

        } catch (\PDOException $e) {
            error_log("Erro ao buscar por CEP: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Exclui um ponto de coleta
     */
    public function excluir(int $id): bool
    {
        try {
            $sql = "DELETE FROM pontos_coleta WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);

        } catch (\PDOException $e) {
            logger::error("Erro ao excluir ponto de coleta: " . $e->getMessage());
            return false;
        }
    }

    //Vincula materiais a um ponto de coleta
    private function vincularMateriais(int $pontoColetaId, array $materiais): void
    {
        $sql = "INSERT INTO ponto_coleta_materiais (ponto_coleta_id, material_id) 
                VALUES (:ponto_coleta_id, :material_id)";
        
        $stmt = $this->db->prepare($sql);

        foreach ($materiais as $material) {
            $stmt->execute([
                ':ponto_coleta_id' => $pontoColetaId,
                ':material_id' => $material->getId()
            ]);
        }
    }

    //Remove todos os materiais de um ponto de coleta
    private function removerTodosMateriais(int $pontoColetaId): void
    {
        $sql = "DELETE FROM ponto_coleta_materiais WHERE ponto_coleta_id = :ponto_coleta_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':ponto_coleta_id' => $pontoColetaId]);
    }

    //Busca materiais relacionados a um ponto de coleta
    private function buscarMateriaisPorPontoColeta(int $pontoColetaId): array
    {
        $sql = "SELECT m.* FROM materiais m
                INNER JOIN ponto_coleta_materiais pcm ON m.id = pcm.material_id
                WHERE pcm.ponto_coleta_id = :ponto_coleta_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':ponto_coleta_id' => $pontoColetaId]);
        
        $resultados = $stmt->fetchAll();
        $materiais = [];

        foreach ($resultados as $dados) {
            $material = new Material(
                $dados['nome'],
                $dados['descricao'],
                $dados['icone'],
                $dados['id']
            );
            $material->setCreatedAt($dados['created_at']);
            $material->setUpdatedAt($dados['updated_at']);
            
            $materiais[] = $material;
        }

        return $materiais;
    }

    //Converte array do banco para Entidade
    private function converterParaEntidade(array $dados): PontoColeta
    {
        $pontoColeta = new PontoColeta(
            $dados['empresa'],
            $dados['endereco'],
            $dados['numero'],
            $dados['cep'],
            $dados['hora_inicio'],
            $dados['hora_encerrar'],
            $dados['telefone'],
            $dados['email'],
            $dados['complemento'],
            $dados['latitude'],
            $dados['longitude'],
            $dados['cidade'] ?? null,
            $dados['estado'] ?? null,
            $dados['bairro'] ?? null,
            (bool) $dados['ativo'],
            $dados['id']
        );

        $pontoColeta->setCreatedAt($dados['created_at']);
        $pontoColeta->setUpdatedAt($dados['updated_at']);

        return $pontoColeta;
    }
}