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

    /**
     * Exibe página de pontos de coleta (mapa)
     */
    public function index(): void
    {
        $pageTitle = 'Pontos de Coleta - Eletrônico Verde';
        
        // Buscar pontos para exibir no mapa
        $resultado = $this->listarUseCase->executar(true);
        $pontosColeta = $resultado['dados'] ?? [];
        
        require_once __DIR__ . '/../Views/pontos-coleta/index.php';
    }

    /**
     * Exibe formulário de cadastro
     */
    public function cadastro(): void
    {
        $this->auth->requerAutenticacao();
        
        $pageTitle = 'Cadastrar Ponto de Coleta - Eletrônico Verde';
        $materiais = $this->materialRepository->listarTodos();
        $csrfToken = $this->csrf->getToken();
        
        require_once __DIR__ . '/../Views/pontos-coleta/cadastro.php';
    }

    /**
     * Processa cadastro de ponto
     */
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

    /**
     * Exibe lista de pontos (admin)
     */
    public function consultar(): void
    {
        $this->auth->requerAutenticacao();
        
        $pageTitle = 'Consultar Pontos de Coleta - Eletrônico Verde';
        
        $resultado = $this->listarUseCase->executar(false);
        $pontosColeta = $resultado['dados'] ?? [];
        
        require_once __DIR__ . '/../Views/pontos-coleta/consultar.php';
    }

    /**
     * Exibe formulário de edição
     */
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

    /**
     * Processa atualização de ponto
     */
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

    /**
     * Exclui um ponto de coleta
     */
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
     * Busca pontos por CEP (AJAX)
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

    /**
     * Página de sucesso
     */
    public function sucessoCadastro(): void
    {
        $this->auth->requerAutenticacao();
        
        $pageTitle = 'Cadastro Realizado - Eletrônico Verde';
        require_once __DIR__ . '/../Views/pontos-coleta/sucesso.php';
    }
}