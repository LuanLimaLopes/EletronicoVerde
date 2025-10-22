<?php
namespace EletronicoVerde\Infrastructure;

class Logger
{
    private static ?string $logFile = null;

    private static function getLogFile(): string
    {
        if (self::$logFile === null) {
            // Ajusta o caminho para Windows (converte / para \$
            self::$logFile = str_replace('/', '\\', __DIR__ . '/../../storage/logs/app.log');
        }
        return self::$logFile;
    }

    public static function log(string $message, string $level = 'INFO'): void
    {
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = "[$timestamp] [$level] $message" . PHP_EOL;
        
        $dir = dirname(self::getLogFile());
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        file_put_contents(self::getLogFile(), $logEntry, FILE_APPEND | LOCK_EX);
    }

    public static function error(string $message): void
    {
        self::log($message, 'ERROR');
    }

    public static function info(string $message): void
    {
        self::log($message, 'INFO');
    }
}