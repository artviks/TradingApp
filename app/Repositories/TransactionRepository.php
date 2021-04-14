<?php

namespace App\Repositories;

use App\Models\Transaction;

interface TransactionRepository
{
    public function storePurchase(Transaction $transaction): void;

    public function storeSold(Transaction $transaction): void;

    public function getPurchaseById(int $id): Transaction;
}