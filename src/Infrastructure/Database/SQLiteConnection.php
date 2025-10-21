<?php
namespace EletronicoVerde\Infrastructure\Database;

use PDO;
use PDOException;

class SQLiteConnection
{
    private static ?PDO $instance = null;

    private function __construct()
    {
        try {
            self::$instance = new PDO('sqlite:' . DATABASE_PATH . '/eletronicoverde.db');
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->exec('PRAGMA foreign_keys = ON');
        } catch (PDOException $e) {
            die('Erro na conexão: ' . $e->getMessage());
        }
    }

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            new self();
        }
        return self::$instance;
    }
}