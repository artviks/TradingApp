<?php

namespace App\Repositories;

use App\Models\Stock;


interface StockRepository
{
    public function getStock(string $symbol): ?Stock;

    public function getPrice(string $symbol): ?float;
}