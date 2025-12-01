<?php
// config/database.php

namespace EletronicoVerde\config;

use EletronicoVerde\Infrastructure\Database\SQLiteConnection;
use EletronicoVerde\Infrastructure\Logger;

class Database
{
    /**
     * Inicializa o banco de dados
     */
    public static function init(): void
    {
        
        // Verificar se banco existe, caso contrário criar
        if (!SQLiteConnection::databaseExists()) {
            self::createDatabase();
        } else {
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
            } else {
                throw new \Exception("Falha ao executar migrations");
            }
        } catch (\Exception $e) {
            Logger::error("Erro fatal ao inicializar banco: " . $e->getMessage());
            die("Erro ao inicializar banco de dados. Verifique os logs em: ");
        }
    }
}