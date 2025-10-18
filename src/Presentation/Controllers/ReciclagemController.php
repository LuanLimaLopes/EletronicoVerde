<?php
// src/Presentation/Controllers/ReciclagemController.php

namespace EletronicoVerde\Presentation\Controllers;

class ReciclagemController
{
    /**
     * Exibe página sobre reciclagem
     */
    public function index(): void
    {
        $pageTitle = 'Reciclagem - Eletrônico Verde';
        require_once __DIR__ . '/../Views/reciclagem/index.php';
    }
}