<?php
// src/Presentation/Controllers/MaterialController.php

namespace EletronicoVerde\Presentation\Controllers;

use EletronicoVerde\Infrastructure\Repositories\SQLiteMaterialRepository;

class MaterialController
{
    private SQLiteMaterialRepository $materialRepository;

    public function __construct()
    {
        $this->materialRepository = new SQLiteMaterialRepository();
    }

    /**
     * Exibe página de materiais aceitos
     */
    public function index(): void
    {
        $pageTitle = 'Materiais Aceitos - Eletrônico Verde';
        $materiais = $this->materialRepository->listarTodos();
        
        require_once __DIR__ . '/../Views/materiais/index.php';
    }

    /**
     * API para listar materiais (JSON)
     */
    public function listar(): void
    {
        header('Content-Type: application/json');
        
        $materiais = $this->materialRepository->listarTodos();
        $dados = array_map(fn($m) => $m->toArray(), $materiais);
        
        echo json_encode([
            'sucesso' => true,
            'dados' => $dados
        ]);
        exit;
    }
}