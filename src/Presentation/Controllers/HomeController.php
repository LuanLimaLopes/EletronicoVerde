<?php
// src/Presentation/Controllers/HomeController.php

namespace EletronicoVerde\Presentation\Controllers;

class HomeController
{
    /**
     * Exibe a página inicial
     */
    public function index(): void
    {
        $pageTitle = 'Eletrônico Verde';
        require_once __DIR__ . '/../Views/home/index.php';
    }
}