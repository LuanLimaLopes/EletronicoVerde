<?php
// src/Presentation/Controllers/PontoColetaController.php

namespace EletronicoVerde\Presentation\Controllers;

use EletronicoVerde\Application\UseCases\PontoColeta\CriarPontoColetaUseCase;
use EletronicoVerde\Application\UseCases\PontoColeta\ListarPontosColetaUseCase;
use EletronicoVerde\Application\UseCases\PontoColeta\EditarPontoColetaUseCase;
use EletronicoVerde\Application\UseCases\PontoColeta\ExcluirPontoColetaUseCase;
use EletronicoVerde\Application\DTOs\PontoColetaDTO;
use EletronicoVerde\Infrastructure\Repositories\SQLitePontoColetaRepository;
use EletronicoVerde\Infrastructure\Repositories\SQLiteMaterialRepository;
use EletronicoVerde\Infrastructure\Security\Authentication;
use EletronicoVerde\Infrastructure\Security\CSRF;
use EletronicoVerde\Infrastructure\Logger;

class PontoColetaController
{
    private CriarPontoColetaUseCase $criarUseCase;
    private ListarPontosColetaUseCase $listarUseCase;
    private EditarPontoColetaUseCase $editarUseCase;
    private ExcluirPontoColetaUseCase $excluirUseCase;
    private SQLiteMaterialRepository $materialRepository;
    private Authentication $auth;
    private CSRF $csrf;

    public function __construct()
    {
        $pontoColetaRepository = new SQLitePontoColetaRepository();
        $this->materialRepository = new SQLiteMaterialRepository();
        
        $this->criarUseCase = new CriarPontoColetaUseCase(
            $pontoColetaRepository,
            $this->materialRepository
        );
        
        $this->listarUseCase = new ListarPontosColetaUseCase($pontoColetaRepository);
        
        $this->editarUseCase = new EditarPontoColetaUseCase(
            $pontoColetaRepository,
            $this->materialRepository
        );
        
        $this->excluirUseCase = new ExcluirPontoColetaUseCase($pontoColetaRepository);
        
        $this->auth = new Authentication();
        $this->csrf = new CSRF();
    }

    //Exibe página de pontos de coleta (mapa)
    public function index(): void
    {
        $pageTitle = 'Pontos de Coleta - Eletrônico Verde';
        
        // Buscar pontos para exibir no mapa
        $resultado = $this->listarUseCase->executar(true);
        $pontosColeta = $resultado['dados'] ?? [];
        
        require_once __DIR__ . '/../Views/pontos-coleta/index.php';
    }

    //Exibe formulário de cadastro
    public function cadastro(): void
    {
        $this->auth->requerAutenticacao();
        
        $pageTitle = 'Cadastrar Ponto de Coleta - Eletrônico Verde';
        $materiais = $this->materialRepository->listarTodos();
        $csrfToken = $this->csrf->getToken();
        
        require_once __DIR__ . '/../Views/pontos-coleta/cadastro.php';
    }

    //Processa cadastro de ponto
    public function salvar(): void
    {
        $this->auth->requerAutenticacao();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /eletronicoverde/cadastro-pontos');
            exit;
        }

        // Validar CSRF
        if (!$this->csrf->validarRequisicao()) {
            $_SESSION['erro'] = 'Token de segurança inválido. Tente novamente.';
            header('Location: /eletronicoverde/cadastro-pontos');
            exit;
        }

        $dto = PontoColetaDTO::fromPost($_POST);
        $resultado = $this->criarUseCase->executar($dto);

        if ($resultado['sucesso']) {
            $_SESSION['sucesso'] = $resultado['mensagem'];
            header('Location: /eletronicoverde/sucesso-cadastro');
        } else {
            $_SESSION['erro'] = $resultado['mensagem'];
            header('Location: /eletronicoverde/cadastro-pontos');
        }
        exit;
    }

    //Exibe lista de pontos (admin)
    public function consultar(): void
    {
        $this->auth->requerAutenticacao();
        
        $pageTitle = 'Consultar Pontos de Coleta - Eletrônico Verde';
        
        $resultado = $this->listarUseCase->executar(false);
        $pontosColeta = $resultado['dados'] ?? [];
        
        require_once __DIR__ . '/../Views/pontos-coleta/consultar.php';
    }

    //Exibe formulário de edição
    public function editar(): void
    {
        $this->auth->requerAutenticacao();
        
        if (!isset($_GET['id'])) {
            header('Location: /eletronicoverde/consultar-pontos');
            exit;
        }

        $id = (int) $_GET['id'];
        $resultado = $this->editarUseCase->buscarPorId($id);

        if (!$resultado['sucesso']) {
            $_SESSION['erro'] = $resultado['mensagem'];
            header('Location: /eletronicoverde/consultar-pontos');
            exit;
        }

        $pageTitle = 'Editar Ponto de Coleta - Eletrônico Verde';
        $pontoColeta = $resultado['dados'];
        $materiais = $this->materialRepository->listarTodos();
        $csrfToken = $this->csrf->getToken();
        
        require_once __DIR__ . '/../Views/pontos-coleta/editar.php';
    }

    //Processa atualização de ponto
    public function atualizar(): void
    {
        $this->auth->requerAutenticacao();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /eletronicoverde/consultar-pontos');
            exit;
        }

        // Validar CSRF
        if (!$this->csrf->validarRequisicao()) {
            $_SESSION['erro'] = 'Token de segurança inválido.';
            header('Location: /eletronicoverde/consultar-pontos');
            exit;
        }

        if (!isset($_POST['id'])) {
            header('Location: /eletronicoverde/consultar-pontos');
            exit;
        }

        $id = (int) $_POST['id'];
        $dto = PontoColetaDTO::fromPost($_POST);
        $resultado = $this->editarUseCase->executar($id, $dto);

        if ($resultado['sucesso']) {
            $_SESSION['sucesso'] = $resultado['mensagem'];
            header('Location: /eletronicoverde/sucesso-cadastro');
        } else {
            $_SESSION['erro'] = $resultado['mensagem'];
            header("Location: /eletronicoverde/editar-ponto?id=$id");
        }
        exit;
    }

    //Exclui um ponto de coleta
    public function excluir(): void
    {
        $this->auth->requerAutenticacao();
        
        if (!isset($_GET['id'])) {
            header('Location: /eletronicoverde/consultar-pontos');
            exit;
        }

        $id = (int) $_GET['id'];
        $resultado = $this->excluirUseCase->executar($id);

        if ($resultado['sucesso']) {
            $_SESSION['sucesso'] = $resultado['mensagem'];
        } else {
            $_SESSION['erro'] = $resultado['mensagem'];
        }

        header('Location: /eletronicoverde/consultar-pontos');
        exit;
    }

    /**
     * Busca pontos por CEP (AJAX) - DEPRECATED
     * Use buscarProximos() ao invés deste método
     */
    public function buscarPorCep(): void
    {
        header('Content-Type: application/json');
        
        if (!isset($_GET['cep'])) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'CEP não fornecido']);
            exit;
        }

        $cep = $_GET['cep'];
        $resultado = $this->listarUseCase->buscarPorCep($cep);
        
        echo json_encode($resultado);
        exit;
    }

    //API: Busca pontos próximos a uma localização (lat/lng)
    public function buscarProximos(): void
{
    header('Content-Type: application/json');
    
    $latitude = $_GET['lat'] ?? null;
    $longitude = $_GET['lng'] ?? null;
    $raio = $_GET['raio'] ?? 10;
    
    if (!$latitude || !$longitude) {
        echo json_encode([
            'sucesso' => false,
            'mensagem' => 'Latitude e longitude são obrigatórias'
        ]);
        exit;
    }
    
    try {
        logger::info("🔍 Buscando pontos próximos a: lat=$latitude, lng=$longitude, raio=$raio km");
        
        // Buscar todos os pontos ativos
        $resultado = $this->listarUseCase->executar(true);
        $pontos = $resultado['dados'] ?? [];
        
        logger::info("📍 Total de pontos ativos: " . count($pontos));
        
        // Filtrar pontos próximos usando fórmula de Haversine
        $pontosProximos = array_filter($pontos, function($ponto) use ($latitude, $longitude, $raio) {
            if (!$ponto['latitude'] || !$ponto['longitude']) {
                logger::info("⚠️ Ponto sem coordenadas: " . $ponto['empresa']);
                return false;
            }
            
            $distancia = $this->calcularDistancia(
                $latitude, 
                $longitude, 
                $ponto['latitude'], 
                $ponto['longitude']
            );
            
            logger::info("📏 Distância de '{$ponto['empresa']}': {$distancia} km (limite: {$raio} km)");
            
            return $distancia <= $raio;
        });
        
        logger::info("✅ Pontos dentro do raio: " . count($pontosProximos));
        
        // Adicionar distância a cada ponto
        $pontosComDistancia = array_map(function($ponto) use ($latitude, $longitude) {
            $ponto['distancia'] = round($this->calcularDistancia(
                $latitude, 
                $longitude, 
                $ponto['latitude'], 
                $ponto['longitude']
            ), 2);
            return $ponto;
        }, $pontosProximos);
        
        // Ordenar por distância
        usort($pontosComDistancia, fn($a, $b) => $a['distancia'] <=> $b['distancia']);
        
        echo json_encode([
            'sucesso' => true,
            'dados' => array_values($pontosComDistancia),
            'total' => count($pontosComDistancia)
        ]);
        
    } catch (\Exception $e) {
        logger::error("💥 Erro ao buscar pontos próximos: " . $e->getMessage());
        echo json_encode([
            'sucesso' => false,
            'mensagem' => 'Erro ao buscar pontos de coleta.'
        ]);
    }
    exit;
}

    //API: Lista todos os pontos de coleta (JSON)
    public function listarTodos(): void
    {
        header('Content-Type: application/json');
        
        try {
            $resultado = $this->listarUseCase->executar(true);
            echo json_encode($resultado);
        } catch (\Exception $e) {
            logger::error("Erro ao listar pontos: " . $e->getMessage());
            echo json_encode([
                'sucesso' => false,
                'mensagem' => 'Erro ao buscar pontos de coleta.',
                'dados' => []
            ]);
        }
        exit;
    }

    //Página de sucesso
    public function sucessoCadastro(): void
    {
        $this->auth->requerAutenticacao();
        
        $pageTitle = 'Cadastro Realizado - Eletrônico Verde';
        require_once __DIR__ . '/../Views/pontos-coleta/sucesso.php';
    }

    /**
     * Calcula distância entre dois pontos usando fórmula de Haversine
     * 
     * @param float $lat1 Latitude do ponto 1
     * @param float $lon1 Longitude do ponto 1
     * @param float $lat2 Latitude do ponto 2
     * @param float $lon2 Longitude do ponto 2
     * @return float Distância em quilômetros
     */
    private function calcularDistancia($lat1, $lon1, $lat2, $lon2): float
    {
        $raioTerra = 6371; // Raio da Terra em km
        
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        
        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon/2) * sin($dLon/2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distancia = $raioTerra * $c;
        
        return $distancia;
    }
}