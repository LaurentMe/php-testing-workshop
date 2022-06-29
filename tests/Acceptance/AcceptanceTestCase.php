<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop\Acceptance;

use Brammm\TestingWorkshop\Http\GetCustomers;
use Brammm\TestingWorkshop\Http\GetOrderDiscount;
use Brammm\TestingWorkshop\Http\GetOrders;
use Brammm\TestingWorkshop\Http\GetProducts;
use Brammm\TestingWorkshop\InMemoryCustomerProvider;
use Brammm\TestingWorkshop\InMemoryOrderProvider;
use Brammm\TestingWorkshop\Provider\CustomerProvider;
use Brammm\TestingWorkshop\Provider\OrderProvider;
use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\ServerRequestFactory;

abstract class AcceptanceTestCase extends TestCase
{
    private static ?App $app = null;

    private function app(): App
    {
        if (! self::$app) {
            $builder = new ContainerBuilder();
            $builder->addDefinitions(__DIR__ . '/../../src/container.php');
            $builder->addDefinitions([
                CustomerProvider::class => fn () => new InMemoryCustomerProvider(),
                OrderProvider::class => fn () => new InMemoryOrderProvider(),
            ]);

            self::$app = AppFactory::create(
                new ResponseFactory(),
                $builder->build()
            );

            self::$app->get('/customers', GetCustomers::class);
            self::$app->get('/products', GetProducts::class);
            self::$app->get('/orders', GetOrders::class);
            self::$app->get('/orders/{id}', GetOrderDiscount::class);
        }

        return self::$app;
    }

    public function get(string $uri): ResponseInterface
    {
        return $this->request('GET', $uri);
    }

    public function request(string $method, string $uri, array $data = [], array $headers = []): ResponseInterface
    {
        $factory = new ServerRequestFactory();
        $request = $factory
            ->createServerRequest($method, $uri)
            ->withParsedBody($data);
        foreach ($headers as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        return $this->app()->handle($request);
    }

}
