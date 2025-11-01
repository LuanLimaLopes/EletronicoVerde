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
            
            $migrationFile = __DIR__ . '/migrations/create_table.sql';
            
            
            if (!file_exists($migrationFile)) {
                return false;
            }
            
            $sql = file_get_contents($migrationFile);
            
            if (empty($sql)) {
                return false;
            }
            
            // Remove comentários SQL
            $sql = preg_replace('/--.*$/m', '', $sql);
            
            // Divide os statements de forma inteligente
            $statements = self::parseSqlStatements($sql);
            
            $pdo->beginTransaction();
            
            try {
                foreach ($statements as $index => $statement) {
                    $statement = trim($statement);
                    if (!empty($statement)) {
                        Logger::info("Executando statement " . ($index + 1) . ": " . substr($statement, 0, 100) . "...");
                        $pdo->exec($statement);
                    }
                }
                
                $pdo->commit();
                Logger::info("Migrations executadas com sucesso!");
                
                // Verifica se os dados foram inseridos
                $result = $pdo->query("SELECT COUNT(*) as total FROM materiais");
                $count = $result->fetch(PDO::FETCH_ASSOC);
                
                $result = $pdo->query("SELECT COUNT(*) as total FROM usuarios");
                $count = $result->fetch(PDO::FETCH_ASSOC);
                
                return true;
                
            } catch (\Exception $e) {
                $pdo->rollBack();
                throw $e;
            }
            
        } catch (\Exception $e) {
            Logger::error("Erro ao executar migrations: " . $e->getMessage());
            Logger::error("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    /**
     * Parse SQL statements de forma inteligente, respeitando BEGIN/END
     */
    private static function parseSqlStatements(string $sql): array
    {
        $statements = [];
        $current = '';
        $inTrigger = false;
        $lines = explode("\n", $sql);
        
        foreach ($lines as $line) {
            $trimmed = trim($line);
            
            // Ignora linhas vazias e comentários
            if (empty($trimmed) || strpos($trimmed, '--') === 0) {
                continue;
            }
            
            $current .= $line . "\n";
            
            // Detecta início de trigger
            if (stripos($trimmed, 'CREATE TRIGGER') !== false || 
                stripos($trimmed, 'BEGIN') !== false) {
                $inTrigger = true;
            }
            
            // Detecta fim de trigger
            if ($inTrigger && stripos($trimmed, 'END;') !== false) {
                $inTrigger = false;
                $statements[] = trim($current);
                $current = '';
                continue;
            }
            
            // Se não está em trigger e tem ponto e vírgula, finaliza o statement
            if (!$inTrigger && substr($trimmed, -1) === ';') {
                $statements[] = trim($current);
                $current = '';
            }
        }
        
        // Adiciona o último statement se houver
        if (!empty(trim($current))) {
            $statements[] = trim($current);
        }
        
        return $statements;
    }
}