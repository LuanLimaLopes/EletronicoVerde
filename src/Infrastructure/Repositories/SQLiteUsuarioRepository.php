<?php
// src/Infrastructure/Repositories/SQLiteUsuarioRepository.php

namespace EletronicoVerde\Infrastructure\Repositories;

use EletronicoVerde\Domain\Entities\Usuario;
use EletronicoVerde\Domain\Interfaces\UsuarioRepositoryInterface;
use EletronicoVerde\Infrastructure\Database\SQLiteConnection;
use PDO;
use EletronicoVerde\Infrastructure\Logger;

class SQLiteUsuarioRepository implements UsuarioRepositoryInterface
{
    private PDO $db;

    public function __construct()
    {
        $this->db = SQLiteConnection::getInstance();
    }

    //Salva um novo usuário
    public function salvar(Usuario $usuario): bool
    {
        try {
            $sql = "INSERT INTO usuarios (nome, email, senha) 
                    VALUES (:nome, :email, :senha)";

            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                ':nome' => $usuario->getNome(),
                ':email' => $usuario->getEmail(),
                ':senha' => $usuario->getSenha()
            ]);

            if ($result) {
                $usuario->setId((int) $this->db->lastInsertId());
            }

            return $result;

        } catch (\PDOException $e) {
            logger::error("Erro ao salvar usuário: " . $e->getMessage());
            return false;
        }
    }

    //Atualiza um usuário existente
    public function atualizar(Usuario $usuario): bool
    {
        try {
            $sql = "UPDATE usuarios SET
                    nome = :nome,
                    email = :email,
                    senha = :senha
                    WHERE id = :id";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':nome' => $usuario->getNome(),
                ':email' => $usuario->getEmail(),
                ':senha' => $usuario->getSenha(),
                ':id' => $usuario->getId()
            ]);

        } catch (\PDOException $e) {
            logger::error("Erro ao atualizar usuário: " . $e->getMessage());
            return false;
        }
    }

    //Busca um usuário por ID
    public function buscarPorId(int $id): ?Usuario
    {
        try {
            $sql = "SELECT * FROM usuarios WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            $dados = $stmt->fetch();

            if (!$dados) {
                return null;
            }

            return $this->converterParaEntidade($dados);

        } catch (\PDOException $e) {
            logger::error("Erro ao buscar usuário: " . $e->getMessage());
            return null;
        }
    }

    //Busca um usuário por email
    public function buscarPorEmail(string $email): ?Usuario
    {
        try {
            $sql = "SELECT * FROM usuarios WHERE email = :email";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':email' => $email]);
            
            $dados = $stmt->fetch();

            if (!$dados) {
                return null;
            }

            return $this->converterParaEntidade($dados);

        } catch (\PDOException $e) {
            logger::error("Erro ao buscar usuário por email: " . $e->getMessage());
            return null;
        }
    }

    //Busca um usuário por nome (username)
    public function buscarPorNome(string $nome): ?Usuario
    {
        try {
            $sql = "SELECT * FROM usuarios WHERE nome = :nome";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':nome' => $nome]);
            
            $dados = $stmt->fetch();

            if (!$dados) {
                return null;
            }

            return $this->converterParaEntidade($dados);

        } catch (\PDOException $e) {
            logger::error("Erro ao buscar usuário por nome: " . $e->getMessage());
            return null;
        }
    }

    //Lista todos os usuários
    public function listarTodos(): array
    {
        try {
            $sql = "SELECT * FROM usuarios ORDER BY nome ASC";
            $stmt = $this->db->query($sql);
            $resultados = $stmt->fetchAll();

            $usuarios = [];
            foreach ($resultados as $dados) {
                $usuarios[] = $this->converterParaEntidade($dados);
            }

            return $usuarios;

        } catch (\PDOException $e) {
            logger::error("Erro ao listar usuários: " . $e->getMessage());
            return [];
        }
    }

    //Exclui um usuário
    public function excluir(int $id): bool
    {
        try {
            $sql = "DELETE FROM usuarios WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);

        } catch (\PDOException $e) {
            logger::error("Erro ao excluir usuário: " . $e->getMessage());
            return false;
        }
    }

    //Verifica se email já está em uso
    public function emailExiste(string $email, ?int $excluirId = null): bool
    {
        try {
            $sql = "SELECT COUNT(*) FROM usuarios WHERE email = :email";
            
            if ($excluirId !== null) {
                $sql .= " AND id != :id";
            }

            $stmt = $this->db->prepare($sql);
            $params = [':email' => $email];
            
            if ($excluirId !== null) {
                $params[':id'] = $excluirId;
            }

            $stmt->execute($params);
            return $stmt->fetchColumn() > 0;

        } catch (\PDOException $e) {
            logger::error("Erro ao verificar email: " . $e->getMessage());
            return false;
        }
    }

    //Converte array do banco para Entidade
    private function converterParaEntidade(array $dados): Usuario
    {
        $usuario = new Usuario(
            $dados['nome'],
            $dados['email'],
            $dados['senha'],
            $dados['id']
        );

        $usuario->setCreatedAt($dados['created_at']);
        $usuario->setUpdatedAt($dados['updated_at']);

        return $usuario;
    }
}