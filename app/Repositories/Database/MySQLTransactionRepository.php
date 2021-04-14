<?php

namespace App\Repositories\Database;

use App\Models\Stock;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use PDO;

class MySQLTransactionRepository implements TransactionRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function storePurchase(Transaction $transaction): void
    {
        $sql = sprintf(
            /** @lang text */
            "insert into portfolio (
                 description, symbol, price, amount, total, added
                 )
                    values ('%s', '%s', '%s', '%s', '%s', '%s')",
            $transaction->stock()->description(),
            $transaction->stock()->symbol(),
            $transaction->price(),
            $transaction->amount(),
            $transaction->totalPrice(),
            $transaction->date()
        );

        $this->pdo->exec($sql);
    }

    public function portfolio(): array
    {
        $sql = /** @lang text */ "select * from portfolio";
        $statement = $this->pdo->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function storeSold(Transaction $transaction): void
    {
        $sql = sprintf(
        /** @lang text */
            "Update portfolio set selling_price_total = '%s', profit = selling_price_total - total, 
            sold = '%s' where id = '%s'",
            $transaction->totalPrice(),
            $transaction->date(),
            $transaction->id(),
        );

        $this->pdo->exec($sql);
    }

    public function getPurchaseById(int $id): Transaction
    {
        $sql = /** @lang text */ "select * from portfolio where id = $id";
        $statement = $this->pdo->query($sql);
        $transaction = $statement->fetch();

        return new Transaction(
            new Stock($transaction['description'], $transaction['symbol']),
            $transaction['price'],
            $transaction['amount'],
            $transaction['id']
        );
    }
}