<?php
namespace EletronicoVerde\Presentation\Controllers;

use EletronicoVerde\Infrastructure\Logger;

class GeocodingController
{
    /**
     * Endpoint público: busca coordenadas via HTTP
     */
    public function buscarCoordenadas(): void
    {
        header('Content-Type: application/json');

        $cep = $_GET['cep'] ?? '';
        $cep = preg_replace('/\D/', '', $cep);

        if (empty($cep) || strlen($cep) !== 8) {
            echo json_encode([
                'sucesso' => false,
                'mensagem' => 'CEP inválido. Deve conter 8 dígitos.'
            ]);
            exit;
        }

        try {
            Logger::info("🔍 Buscando CEP: $cep");

            // 1. Buscar CEP
            $cepData = $this->buscarCepComFallback($cep);

            if (!$cepData) {
                Logger::error("❌ CEP não encontrado: $cep");
                echo json_encode([
                    'sucesso' => false,
                    'mensagem' => 'CEP não encontrado. Verifique e tente novamente.'
                ]);
                exit;
            }

            Logger::info("✅ CEP encontrado: " . json_encode($cepData));

            // 2. Geocodificação
            $coords = $this->geocodificarComFallback($cepData);

            if (!$coords) {
                Logger::error("❌ Falha ao geocodificar");
                echo json_encode([
                    'sucesso' => false,
                    'mensagem' => 'Endereço encontrado, mas não foi possível localizar no mapa.'
                ]);
                exit;
            }

            Logger::info("✅ Coordenadas encontradas: lat={$coords['lat']}, lng={$coords['lng']}");

            echo json_encode([
                'sucesso' => true,
                'latitude' => $coords['lat'],
                'longitude' => $coords['lng'],
                'endereco' => $cepData
            ]);

        } catch (\Exception $e) {
            Logger::error("💥 Erro ao buscar coordenadas: " . $e->getMessage());
            echo json_encode([
                'sucesso' => false,
                'mensagem' => 'Erro ao buscar localização.'
            ]);
        }
        exit;
    }

    /**
     * Busca CEP com fallback
     */
    private function buscarCepComFallback(string $cep): ?array
    {
        if ($data = $this->buscarViaCep($cep)) return $data;
        if ($data = $this->buscarBrasilAPI($cep)) return $data;
        if ($data = $this->buscarApiCep($cep)) return $data;

        Logger::error("❌ CEP não encontrado em nenhuma API");
        return null;
    }

    private function buscarViaCep(string $cep): ?array
    {
        $url = "https://viacep.com.br/ws/{$cep}/json/";
        Logger::info("🔍 ViaCEP: $url");

        $data = $this->fazerRequisicao($url);

        if ($data && !isset($data['erro'])) {
            return [
                'cep' => $data['cep'] ?? $cep,
                'logradouro' => $data['logradouro'] ?? '',
                'complemento' => $data['complemento'] ?? '',
                'bairro' => $data['bairro'] ?? '',
                'localidade' => $data['localidade'] ?? '',
                'uf' => $data['uf'] ?? ''
            ];
        }
        return null;
    }

    private function buscarBrasilAPI(string $cep): ?array
    {
        $url = "https://brasilapi.com.br/api/cep/v1/{$cep}";
        Logger::info("🔍 BrasilAPI: $url");

        $data = $this->fazerRequisicao($url);

        if ($data && !isset($data['errors'])) {
            return [
                'cep' => $data['cep'] ?? $cep,
                'logradouro' => $data['street'] ?? '',
                'bairro' => $data['neighborhood'] ?? '',
                'localidade' => $data['city'] ?? '',
                'uf' => $data['state'] ?? ''
            ];
        }
        return null;
    }

    private function buscarApiCep(string $cep): ?array
    {
        $url = "https://cdn.apicep.com/file/apicep/{$cep}.json";
        Logger::info("🔍 API CEP: $url");

        $data = $this->fazerRequisicao($url);

        if ($data && isset($data['address'])) {
            return [
                'cep' => $data['code'] ?? $cep,
                'logradouro' => $data['address'] ?? '',
                'bairro' => $data['district'] ?? '',
                'localidade' => $data['city'] ?? '',
                'uf' => $data['state'] ?? ''
            ];
        }
        return null;
    }

    /**
     * Requisição HTTP
     */
    private function fazerRequisicao(string $url): ?array
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT => 'EletronicoVerde/1.0'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        curl_close($ch);

        if ($error || $httpCode !== 200 || !$response) {
            Logger::error("HTTP ERROR [$httpCode]: $error");
            return null;
        }

        return json_decode($response, true);
    }

    /**
     * Geocodificação com fallback
     */
    private function geocodificarComFallback(array $cepData): ?array
    {
        return $this->geocodificarNominatim($cepData) ?? null;
    }

    /**
     * Geocodificar com Nominatim
     */
    private function geocodificarNominatim(array $cepData): ?array
    {
        $endereco = sprintf(
            "%s, %s, %s, %s, Brasil",
            $cepData['logradouro'],
            $cepData['bairro'],
            $cepData['localidade'],
            $cepData['uf']
        );

        $url = "https://nominatim.openstreetmap.org/search?" . http_build_query([
            'q' => $endereco,
            'format' => 'json',
            'limit' => 1,
            'addressdetails' => 1,
        ]);

        Logger::info("🔍 Nominatim: $url");

        $data = $this->fazerRequisicao($url);

        if ($data && isset($data[0])) {
            return [
                'lat' => (float) $data[0]['lat'],
                'lng' => (float) $data[0]['lon']
            ];
        }

        return null;
    }
}
