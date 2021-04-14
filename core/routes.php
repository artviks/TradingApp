<?php

use App\Controllers\PagesController;
use App\Controllers\StockController;
use App\Controllers\TransactionController;

return FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r)
{
    // PagesController
    $r->addRoute('GET', '/', [PagesController::class, 'home']);
    $r->addRoute('GET', '/table', [PagesController::class, 'table']);

    // StockController
    $r->addRoute('GET', '/search', [StockController::class, 'search']);
    $r->addRoute('GET', '/update', [StockController::class, 'update']);
    $r->addRoute('GET', '/price', [StockController::class, 'price']);

    // TransactionController
    $r->addRoute('POST', '/buy', [TransactionController::class, 'buy']);
    $r->addRoute('POST', '/sell', [TransactionController::class, 'sell']);
});