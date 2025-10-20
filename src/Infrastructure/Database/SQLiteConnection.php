<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

namespace EletronicoVerde\Infrastructure\Database;

use PDO;
use PDOException;

class SQLiteConnection
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        try {
            $this->connection = new PDO('sqlite:' . DATABASE_PATH . '/database.sqlite');
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->exec('PRAGMA foreign_keys = ON');
        } catch (PDOException $e) {
            die('Erro na conexão: ' . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}