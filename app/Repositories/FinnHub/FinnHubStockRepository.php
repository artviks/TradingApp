<?php


namespace App\Repositories\FinnHub;

use App\Models\Stock;
use App\Repositories\StockRepository;

class FinnHubStockRepository implements StockRepository
{
    private string $token;
    private array $error = [];

    public function __construct(string $token)
    {
        $this->token = '&token=' . $token;
    }

    public function getStock(string $symbol): ?Stock
    {
        try {
            $stock = json_decode(
                file_get_contents(
                    'https://finnhub.io/api/v1/search?q=' . $symbol . $this->token),
                false,
                512,
                JSON_THROW_ON_ERROR
            )->result[0];
        } catch (\JsonException $e) {
            $this->error[] = $e->getMessage();
            return null;
        }

        if (empty($stock)) {
            return null;
        }

        return new Stock(
            $stock->description, $stock->symbol
        );
    }

    public function getPrice(string $symbol): ?float
    {
        try {
            $price = json_decode(
                file_get_contents(
                    'https://finnhub.io/api/v1/quote?symbol=' . $symbol . $this->token),
                false,
                512,
                JSON_THROW_ON_ERROR
            )->c;
        } catch (\JsonException $e) {
            $this->error[] = $e->getMessage();
            return null;
        }

        if (empty($price)) {
            return null;
        }

        return $price;
    }


    public function getError(): array
    {
        return $this->error;
    }
}