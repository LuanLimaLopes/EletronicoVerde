<?php
// config/database.php

namespace EletronicoVerde\Config;

use EletronicoVerde\Infrastructure\Database\SQLiteConnection;
use EletronicoVerde\Infrastructure\Logger;

class Database
{
    /**
     * Inicializa o banco de dados
     */
    public static function init(): void
    {
        Logger::info("Iniciando verificação do banco de dados...");
        
        // Verificar se banco existe, caso contrário criar
        if (!SQLiteConnection::databaseExists()) {
            Logger::info("Banco de dados não encontrado. Criando...");
            self::createDatabase();
        } else {
            Logger::info("Banco de dados já existe.");
        }
    }

    /**
     * Cria o banco de dados e executa migrations
     */
    private static function createDatabase(): void
    {
        try {
            $sucesso = SQLiteConnection::runMigrations();
            
            if ($sucesso) {
                Logger::info("Banco de dados SQLite criado com sucesso!");
            } else {
                Logger::error("Erro ao criar banco de dados SQLite");
                throw new \Exception("Falha ao executar migrations");
            }
        } catch (\Exception $e) {
            Logger::error("Erro fatal ao inicializar banco: " . $e->getMessage());
            die("Erro ao inicializar banco de dados. Verifique os logs em: ");
        }
    }
}