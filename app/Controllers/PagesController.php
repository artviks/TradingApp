<?php

namespace App\Controllers;

use App\Services\GetStockDataService;
use App\Services\TransactionService;
use Twig\Environment;

class PagesController
{
    private Environment $twig;
    private TransactionService $service;
    private GetStockDataService $stockService;

    public function __construct(
        TransactionService $service,
        GetStockDataService $stockService,
        Environment $twig)
    {
        $this->twig = $twig;
        $this->service = $service;
        $this->stockService = $stockService;
    }

    public function home(): void
    {
        $this->twig->display('home.twig');
    }

    public function table(): void
    {
        $this->twig->display('table.twig', [
            'portfolio' => $this->service->portfolio(),
            'finnHub' => $this->stockService
        ]);
    }
}