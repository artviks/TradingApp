<?php


namespace App\Controllers;

use App\Services\GetStockDataService;
use Twig\Environment;

class StockController
{

    private Environment $twig;
    private GetStockDataService $service;

    public function __construct(GetStockDataService $service, Environment $twig)
    {

        $this->twig = $twig;
        $this->service = $service;
    }

    public function search(): void
    {
        $this->twig->display('home.twig', [
            'price' => $this->service->price($_GET['symbol']),
            'symbol' => $_GET['symbol']
        ]);
    }

}