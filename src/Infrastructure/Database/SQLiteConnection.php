<?php
namespace EletronicoVerde\Infrastructure\Database;

use PDO;
use PDOException;
use EletronicoVerde\Infrastructure\Logger;

class SQLiteConnection
{
    private static ?PDO $instance = null;

    private function __construct()
    {
        try {
            // Garante que o diretório existe
            $dbDir = DATABASE_PATH;
            if (!is_dir($dbDir)) {
                mkdir($dbDir, 0755, true);
            }

            $dbPath = $dbDir . '/eletronicoverde.db';
            self::$instance = new PDO('sqlite:' . $dbPath);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->exec('PRAGMA foreign_keys = ON');
            
            Logger::info("Conexão SQLite estabelecida: " . $dbPath);
        } catch (PDOException $e) {
            Logger::error('Erro na conexão SQLite: ' . $e->getMessage());
            die('Erro na conexão com banco de dados. Verifique os logs.');
        }
    }

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            new self();
        }
        return self::$instance;
    }

    /**
     * Verifica se o banco de dados existe e tem as tabelas
     */
    public static function databaseExists(): bool
    {
        try {
            $dbPath = DATABASE_PATH . '/eletronicoverde.db';
            
            if (!file_exists($dbPath)) {
                return false;
            }

            // Verifica se tem tabelas
            $pdo = self::getInstance();
            $result = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'");
            $tables = $result->fetchAll(PDO::FETCH_COLUMN);
            
            return count($tables) > 0;
        } catch (\Exception $e) {
            Logger::error("Erro ao verificar banco: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Executa as migrations do banco de dados
     */
    public static function runMigrations(): bool
    {
        try {
            $pdo = self::getInstance();
            
            // Caminho correto: /src/Infrastructure/Database/migrations/create_tables.sql
            $migrationFile = __DIR__ . '/migrations/create_table.sql';
            
            Logger::info("Procurando migration em: " . $migrationFile);
            
            if (!file_exists($migrationFile)) {
                Logger::error("Arquivo de migration não encontrado: " . $migrationFile);
                return false;
            }
            
            $sql = file_get_contents($migrationFile);
            
            if (empty($sql)) {
                Logger::error("Arquivo de migration está vazio!");
                return false;
            }
            
            // Executa cada statement separadamente
            $statements = array_filter(
                explode(';', $sql),
                fn($stmt) => !empty(trim($stmt))
            );
            
            foreach ($statements as $statement) {
                $statement = trim($statement);
                if (!empty($statement)) {
                    $pdo->exec($statement);
                }
            }
            
            Logger::info("Migrations executadas com sucesso!");
            return true;
            
        } catch (\Exception $e) {
            Logger::error("Erro ao executar migrations: " . $e->getMessage());
            Logger::error("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }
}