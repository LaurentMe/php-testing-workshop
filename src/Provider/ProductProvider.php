<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop\Provider;

use Brammm\TestingWorkshop\Model\Product;
use Doctrine\DBAL\Connection;
use Money\Money;
use Ramsey\Uuid\Uuid;

class ProductProvider
{
    public function __construct(
        private readonly Connection $connection
    ) {
    }

    /**
     * @return Product[]
     */
    public function findAll(): array
    {
        return array_map(
            [$this, 'hydrate'],
            $this->connection->fetchAllAssociative('SELECT * FROM product ORDER BY name')
        );
    }

    /**
     * @param array{id: string, name: string, price: int} $row
     */
    private function hydrate(array $row): Product
    {
        return new Product(
            Uuid::fromString($row['id']),
            $row['name'],
            Money::EUR($row['price'])
        );
    }
}
