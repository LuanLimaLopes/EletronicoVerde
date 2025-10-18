<?php
// src/Infrastructure/Database/SQLiteConnection.php

namespace EletronicoVerde\Infrastructure\Database;

use PDO;
use PDOException;

class SQLiteConnection
{
    private static ?PDO $instance = null;
    private string $dbPath;

    private function __construct()
    {
        $this->dbPath = __DIR__ . '/../../../storage/database/eletronico_verde.db';
        $this->ensureDatabaseDirectory();
    }

    /**
     * Singleton - Garante apenas uma instância de conexão
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $connection = new self();
            self::$instance = $connection->connect();
        }

        return self::$instance;
    }

    /**
     * Estabelece conexão com SQLite
     */
    private function connect(): PDO
    {
        try {
            $pdo = new PDO('sqlite:' . $this->dbPath);
            
            // Configurações do PDO
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            
            // Habilitar chaves estrangeiras no SQLite
            $pdo->exec('PRAGMA foreign_keys = ON;');
            
            return $pdo;
            
        } catch (PDOException $e) {
            error_log("Erro de conexão SQLite: " . $e->getMessage());
            throw new \RuntimeException("Não foi possível conectar ao banco de dados.");
        }
    }

    /**
     * Garante que o diretório do banco existe
     */
    private function ensureDatabaseDirectory(): void
    {
        $directory = dirname($this->dbPath);
        
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
    }

    /**
     * Executa a migration inicial (criação das tabelas)
     */
    public static function runMigrations(): bool
    {
        try {
            $pdo = self::getInstance();
            $migrationPath = __DIR__ . '/migrations/create_tables.sql';
            
            if (!file_exists($migrationPath)) {
                throw new \RuntimeException("Arquivo de migration não encontrado.");
            }
            
            $sql = file_get_contents($migrationPath);
            $pdo->exec($sql);
            
            return true;
            
        } catch (PDOException $e) {
            error_log("Erro ao executar migrations: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verifica se o banco de dados existe
     */
    public static function databaseExists(): bool
    {
        $connection = new self();
        return file_exists($connection->dbPath);
    }

    /**
     * Fecha a conexão (usado raramente devido ao Singleton)
     */
    public static function closeConnection(): void
    {
        self::$instance = null;
    }

    /**
     * Inicia uma transação
     */
    public static function beginTransaction(): bool
    {
        return self::getInstance()->beginTransaction();
    }

    /**
     * Confirma a transação
     */
    public static function commit(): bool
    {
        return self::getInstance()->commit();
    }

    /**
     * Reverte a transação
     */
    public static function rollBack(): bool
    {
        return self::getInstance()->rollBack();
    }
}