<?php

declare(strict_types=1);

use Brammm\TestingWorkshop\Container;
use Brammm\TestingWorkshop\Http\GetCustomers;
use Brammm\TestingWorkshop\Http\GetProducts;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\ResponseFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create(
    new ResponseFactory(),
    new Container(),
);

$app->get('/customers', GetCustomers::class);
$app->get('/products', GetProducts::class);

$app->run();
