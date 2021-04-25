<?php

namespace App\Services;

use App\Models\Transaction;
use App\Repositories\StockRepository;
use App\Repositories\TransactionRepository;

class TransactionService
{
    private TransactionRepository $repository;
    private StockRepository $stockRepository;
    private float $balance = 1000;

    public function __construct(TransactionRepository $repository, StockRepository $stockRepository)
    {
        $this->repository = $repository;
        $this->stockRepository = $stockRepository;
    }

    public function storePurchase(array $post): void
    {
        $amount = $post['amount'];
        [$symbol, $price] = explode(' ', $post['stock']);
        $stock = $this->stockRepository->getStock($symbol);
        $transaction = new Transaction($stock, $price, $amount);

        $this->repository->storePurchase($transaction);
    }

    public function storeSold(int $id): void
    {
        $purchase = $this->repository->getPurchaseById($id);
        $price = $this->stockRepository->getPrice($purchase->stock()->symbol());
        $transaction = new Transaction(
            $purchase->stock(),
            $purchase->amount(),
            $price,
            $purchase->id()
        );

        $this->repository->storeSold($transaction);
    }

    public function portfolio(): array
    {
        return $this->repository->portfolio();
    }

    public function balance(): float
    {
        foreach ($this->repository->portfolio() as $trans) {
            $this->balance += $trans['profit'];
        }

        return $this->balance;
    }
}