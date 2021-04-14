<?php


namespace App\Services;


use App\Models\Stock;
use App\Repositories\StockRepository;

class GetStockDataService
{
    private StockRepository $repository;

    public function __construct(StockRepository $repository)
    {
        $this->repository = $repository;
    }

    public function stock(string $symbol): Stock
    {
        return $this->repository->getStock($symbol);
    }

    public function price(string $symbol): float
    {
        return $this->repository->getPrice($symbol);
    }
}