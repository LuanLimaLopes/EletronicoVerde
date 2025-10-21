<?php
// src/Presentation/Controllers/HomeController.php

namespace EletronicoVerde\Presentation\Controllers;

class HomeController
{
    public function index()
    {
        $pageTitle = 'Eletrônico Verde' . APP_NAME;
        require VIEWS_PATH . '/layouts/header.php';
        require VIEWS_PATH . '/home/index.php';
        require VIEWS_PATH . '/layouts/footer.php';
    }
}