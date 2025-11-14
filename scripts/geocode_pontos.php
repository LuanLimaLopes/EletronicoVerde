<?php
/**
 * Script para Geocodificar Pontos de Coleta Existentes
 * 
 * Como usar:
 * 1. Coloque este arquivo em: scripts/geocode_pontos.php
 * 2. Execute: php scripts/geocode_pontos.php
 * 
 * OU execute de onde estiver ajustando os caminhos abaixo
 */

// ========================================
// AJUSTE AUTOMÁTICO DE CAMINHO
// ========================================
$currentDir = __DIR__;

// Detecta se está em scripts/ ou em outro lugar
if (basename($currentDir) === 'scripts') {
    // Está em scripts/
    require_once __DIR__ . '/../config/constants.php';
    require_once __DIR__ . '/../config/autoload.php';
} elseif (basename(dirname($currentDir)) === 'assets') {
    // Está em public/assets/js/
    require_once __DIR__ . '/../../../config/constants.php';
    require_once __DIR__ . '/../../../config/autoload.php';
} else {
    // Caminho genérico - suba até encontrar config/
    $depth = 0;
    $path = $currentDir;
    while (!file_exists($path . '/config/constants.php') && $depth < 5) {
        $path = dirname($path);
        $depth++;
    }
    
    if (file_exists($path . '/config/constants.php')) {
        require_once $path . '/config/constants.php';
        require_once $path . '/config/autoload.php';
    } else {
        die("❌ ERRO: Não foi possível encontrar config/constants.php\n");
    }
}

use EletronicoVerde\Infrastructure\Repositories\SQLitePontoColetaRepository;

echo "\n";
echo "╔══════════════════════════════════════════════════════════╗\n";
echo "║   GEOCODIFICAÇÃO DE PONTOS DE COLETA - OpenStreetMap    ║\n";
echo "║                  Eletrônico Verde v2.0                   ║\n";
echo "╚══════════════════════════════════════════════════════════╝\n";
echo "\n";

try {
    $repository = new SQLitePontoColetaRepository();
    $pontos = $repository->listarTodos(false);

    if (empty($pontos)) {
        echo "⚠️  Nenhum ponto de coleta encontrado no banco de dados.\n";
        echo "   Cadastre alguns pontos antes de executar este script.\n\n";
        exit(0);
    }

    echo "📍 Total de pontos encontrados: " . count($pontos) . "\n\n";
    
    $sucessos = 0;
    $erros = 0;
    $jaExistentes = 0;

    foreach ($pontos as $index => $ponto) {
        $numero = $index + 1;
        echo "──────────────────────────────────────────────────────────\n";
        echo "[$numero/" . count($pontos) . "] Processando: {$ponto->getEmpresa()}\n";
        
        // Se já tem coordenadas, pula
        if ($ponto->getLatitude() && $ponto->getLongitude()) {
            echo "   ✓ Já possui coordenadas: ({$ponto->getLatitude()}, {$ponto->getLongitude()})\n";
            $jaExistentes++;
            continue;
        }
        
        // Monta endereço completo
        $endereco = sprintf(
            "%s, %s, CEP %s, Brasil",
            $ponto->getEndereco(),
            $ponto->getNumero(),
            $ponto->getCep()
        );
        
        echo "   🔍 Endereço: {$endereco}\n";
        echo "   ⏳ Buscando coordenadas...\n";
        
        // Geocodifica usando Nominatim (OpenStreetMap)
        $url = "https://nominatim.openstreetmap.org/search?" . http_build_query([
            'q' => $endereco,
            'format' => 'json',
            'limit' => 1,
            'countrycodes' => 'br' // Apenas Brasil
        ]);
        
        // Headers obrigatórios do Nominatim
        $options = [
            'http' => [
                'header' => "User-Agent: EletronicoVerde/2.0 (Sistema de Reciclagem)\r\n"
            ]
        ];
        $context = stream_context_create($options);
        
        $response = @file_get_contents($url, false, $context);
        
        if ($response === false) {
            echo "   ✗ Erro na requisição ao servidor\n";
            $erros++;
            sleep(1);
            continue;
        }
        
        $data = json_decode($response, true);
        
        if (!empty($data) && isset($data[0]['lat']) && isset($data[0]['lon'])) {
            $lat = (float) $data[0]['lat'];
            $lng = (float) $data[0]['lon'];
            
            $ponto->setLatitude($lat);
            $ponto->setLongitude($lng);
            
            if ($repository->atualizar($ponto)) {
                echo "   ✓ Coordenadas encontradas: ({$lat}, {$lng})\n";
                echo "   ✓ Salvo no banco de dados!\n";
                $sucessos++;
            } else {
                echo "   ✗ Erro ao salvar no banco de dados\n";
                $erros++;
            }
        } else {
            echo "   ✗ Não foi possível geocodificar este endereço\n";
            echo "   ℹ️  Verifique se o endereço está correto no cadastro\n";
            $erros++;
        }
        
        // Aguarda 1 segundo entre requisições (política do Nominatim)
        sleep(1);
    }

    echo "══════════════════════════════════════════════════════════\n";
    echo "\n";
    echo "╔══════════════════════════════════════════════════════════╗\n";
    echo "║                   RELATÓRIO FINAL                        ║\n";
    echo "╠══════════════════════════════════════════════════════════╣\n";
    echo "║  ✓ Sucessos:        " . str_pad($sucessos, 3, ' ', STR_PAD_LEFT) . "                                  ║\n";
    echo "║  ✗ Erros:           " . str_pad($erros, 3, ' ', STR_PAD_LEFT) . "                                  ║\n";
    echo "║  ⊙ Já existentes:   " . str_pad($jaExistentes, 3, ' ', STR_PAD_LEFT) . "                                  ║\n";
    echo "║  ━ Total:           " . str_pad(count($pontos), 3, ' ', STR_PAD_LEFT) . "                                  ║\n";
    echo "╚══════════════════════════════════════════════════════════╝\n";
    echo "\n";

    if ($sucessos > 0) {
        echo "✅ Geocodificação concluída com sucesso!\n";
        echo "   Os pontos já podem ser visualizados no mapa.\n\n";
    } elseif ($jaExistentes === count($pontos)) {
        echo "ℹ️  Todos os pontos já possuem coordenadas.\n";
        echo "   Nenhuma atualização necessária.\n\n";
    } else {
        echo "⚠️  Geocodificação concluída com alguns erros.\n";
        echo "   Verifique os endereços dos pontos que falharam.\n\n";
    }

} catch (\Exception $e) {
    echo "\n❌ ERRO FATAL: " . $e->getMessage() . "\n";
    echo "Verifique:\n";
    echo "  - Se o banco de dados está configurado corretamente\n";
    echo "  - Se as tabelas foram criadas (migrations)\n";
    echo "  - Se há pontos de coleta cadastrados\n\n";
    exit(1);
}