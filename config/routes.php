<?php
<?php

use EletronicoVerde\Infrastructure\Database\SQLiteConnection;

// Obtém a conexão
$db = SQLiteConnection::getInstance();
$connection = $db->getConnection();

// Define suas rotas aqui
// ...existing code...