<?php
// config/database.php

namespace EletronicoVerde\Config;

use EletronicoVerde\Infrastructure\Database\SQLiteConnection;

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
                error_log("Banco de dados SQLite criado com sucesso!");
            } else {
                error_log("Erro ao criar banco de dados SQLite");
            }
        } catch (\Exception $e) {
            error_log("Erro fatal ao inicializar banco: " . $e->getMessage());
            die("Erro ao inicializar banco de dados. Verifique os logs.");
        }
    }
}