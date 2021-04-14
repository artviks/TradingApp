<?php


namespace App\Controllers;

use App\Services\TransactionService;
use Twig\Environment;


class TransactionController
{
    private TransactionService $service;

    public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }

    public function buy(): void
    {
        $this->service->storePurchase($_POST);

        header('Location: /');
    }

    public function sell(): void
    {
        $this->service->storeSold($_POST['stock']);

        header('Location: /table');
    }
}