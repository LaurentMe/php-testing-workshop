<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop\Integration;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

trait ProvidesIntegrationTestConnection
{
    private static ?Connection $connection = null;

    public function getConnection(): Connection
    {
        if (! self::$connection) {
            self::$connection = DriverManager::getConnection([
                'user' => 'root',
                'password' => 'root',
                'host' => 'php-testing-workshop-mysql',
                'driver' => 'pdo_mysql',
            ]);

            self::$connection->executeStatement('DROP DATABASE IF EXISTS integration_tests');
            self::$connection->executeStatement('CREATE DATABASE integration_tests');
            self::$connection->executeStatement('USE integration_tests');
            self::$connection->executeStatement(file_get_contents(__DIR__ . '/../../setup.sql'));
        }

        return self::$connection;
    }

    protected function setUp(): void
    {
        $this->getConnection()->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->getConnection()->rollBack();
    }
}
