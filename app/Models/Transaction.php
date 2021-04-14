<?php


namespace App\Models;


class Transaction
{
    private Stock $stock;
    private float $price;
    private float $amount;
    private ?int $id;

    public function __construct(Stock $stock, float $price, float $amount, int $id = null)
    {
        $this->stock = $stock;
        $this->price = $price;
        $this->amount = $amount;
        $this->id = $id;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function price(): float
    {
        return $this->price;
    }

    public function stock(): Stock
    {
        return $this->stock;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function totalPrice(): float
    {
        return $this->amount * $this->price;
    }

    public function date(): string
    {
        return (new \DateTime('now', new \DateTimeZone('Europe/Riga')))
            ->format('Y-m-d H:i:s');
    }
}