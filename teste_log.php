<?php
// Carrega o autoload
require_once 'config/autoload.php';
// Importa a classe Logger
use EletronicoVerde\Infrastructure\Logger;
// Chama o Logger para testar
Logger::info("Teste do Logger - Verifique se app.log foi atualizado");
Logger::error("Teste de erro no Logger");
// Mensagem de confirmação no navegador
echo "Teste executado! Verifique o arquivo storage/logs/app.log para ver as mensagens de log.";