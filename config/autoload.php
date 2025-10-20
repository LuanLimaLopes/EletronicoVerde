<?php
spl_autoload_register(function ($class) {
    // Remove 'EletronicoVerde' do namespace
    $class = str_replace('EletronicoVerde\\', '', $class);
    
    // Converte namespace em caminho de arquivo
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    
    // Define o caminho base
    $baseDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;
    
    // Monta o caminho completo do arquivo
    $file = $baseDir . $class . '.php';
    
    // Carrega o arquivo se ele existir
    if (file_exists($file)) {
        require_once $file;
    }
});