<?php

use App\Controllers\PagesController;
use App\Controllers\StockController;
use App\Controllers\TransactionController;
use App\Repositories\Database\Connection;
use App\Repositories\Database\MySQLTransactionRepository;
use App\Repositories\FinnHub\FinnHubStockRepository;
use App\Repositories\StockRepository;
use App\Repositories\TransactionRepository;
use App\Services\GetStockDataService;
use App\Services\TransactionService;
use League\Container\Container;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;


$config = require '../config.php';

//twig setup
$twig = new Environment(new FilesystemLoader('./../public/Views'), [
    'debug' => true
]);
$twig->addExtension(new DebugExtension);


$container = new Container();

$container->add('twig', $twig);

//config
$container->add('token', $config['finnHub']['token']);
$container->add('pdo', Connection::make($config['database']));

//repositories
$container->add(StockRepository::class, FinnHubStockRepository::class)
    ->addArgument('token');
$container->add(TransactionRepository::class, MySQLTransactionRepository::class)
    ->addArgument('pdo');

//services
$container->add(GetStockDataService::class, GetStockDataService::class)
    ->addArgument(StockRepository::class);
$container->add(TransactionService::class, TransactionService::class)
    ->addArguments([TransactionRepository::class, StockRepository::class]);

// controllers
$container->add(PagesController::class, PagesController::class)
    ->addArguments([TransactionService::class, GetStockDataService::class, 'twig']);
$container->add(StockController::class, StockController::class)
    ->addArguments([GetStockDataService::class, 'twig']);
$container->add(TransactionController::class, TransactionController::class)
    ->addArgument(TransactionService::class);

return $container;