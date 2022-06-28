<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop\Integration;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use PHPUnit\Framework\TestCase;

abstract class IntegrationTestCase extends TestCase
{
    protected static ?Connection $connection = null;

    protected function setUp(): void
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

        self::$connection->beginTransaction();
    }

    protected function tearDown(): void
    {
        self::$connection->rollBack();
    }
}
