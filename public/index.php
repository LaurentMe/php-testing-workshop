<?php

declare(strict_types=1);

use Brammm\TestingWorkshop\Http\GetCustomers;
use Brammm\TestingWorkshop\Http\GetOrders;
use Brammm\TestingWorkshop\Http\GetProducts;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\ResponseFactory;

require __DIR__ . '/../vendor/autoload.php';

$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/../src/container.php');

$app = AppFactory::create(
    new ResponseFactory(),
    $builder->build()
);

$app->get('/customers', GetCustomers::class);
$app->get('/products', GetProducts::class);
$app->get('/orders', GetOrders::class);

$app->run();
