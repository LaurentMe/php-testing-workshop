<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop;

use Brammm\TestingWorkshop\Http\GetCustomers;
use Brammm\TestingWorkshop\Provider\CustomerProvider;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Exception;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * @template T
 */
final class Container implements ContainerInterface
{
    /**
     * @var array<class-string<T>, T>
     */
    private static $services = [];

    public function __construct()
    {
        self::$services[CustomerProvider::class] = new CustomerProvider(self::connection());

        self::$services[GetCustomers::class] = new GetCustomers($this->get(CustomerProvider::class));
    }

    /**
     * @param class-string<T> $id
     *
     * @return T
     */
    public function get(string $id)
    {
        if ($this->has($id)) {
            return self::$services[$id];
        }

        throw new class extends Exception implements NotFoundExceptionInterface{};
    }

    /**
     * @param class-string<T> $id
     */
    public function has(string $id): bool
    {
        return array_key_exists($id, self::$services);
    }

    private static function connection(): Connection
    {
        static $connection;

        return $connection ?: DriverManager::getConnection([
            'dbname' => 'testing-workshop',
            'user' => 'root',
            'password' => 'root',
            'host' => 'php-testing-workshop-mysql',
            'driver' => 'pdo_mysql',
        ]);
    }
}
