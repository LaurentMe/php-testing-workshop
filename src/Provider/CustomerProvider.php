<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop\Provider;

use Brammm\TestingWorkshop\Model\Customer;
use Doctrine\DBAL\Connection;
use Ramsey\Uuid\Uuid;

class CustomerProvider
{
    public function __construct(
        private readonly Connection $connection
    ) {
    }

    /**
     * @return Customer[]
     */
    public function findAll(): array
    {
        return array_map(
            [$this, 'mapData'],
            $this->connection->fetchAllAssociative('SELECT * FROM customer ORDER BY name')
        );
    }

    /**
     * @param array{id: string, name: string} $row
     */
    private function mapData(array $row): Customer
    {
        return new Customer(
            Uuid::fromString($row['id']),
            $row['name']
        );
    }
}
