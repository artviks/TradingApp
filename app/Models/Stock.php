<?php


namespace App\Models;


class Stock
{
    private string $description;
    private string $symbol;

    public function __construct(string $description, string $symbol)
    {
        $this->description = $description;
        $this->symbol = $symbol;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function symbol(): string
    {
        return $this->symbol;
    }
}