<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop;

use Brammm\TestingWorkshop\Model\Customer;
use Brammm\TestingWorkshop\Provider\CustomerProvider;
use DateTimeImmutable;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class InMemoryCustomerProvider implements CustomerProvider
{
    /** @var Customer[]  */
    private array $customers;

    public function __construct()
    {
        $this->customers = [
            new Customer(
                Uuid::fromString('55943c45-a597-4c34-9a26-83f48fa659c6'),
                'Bruce',
                new DateTimeImmutable('2022-05-01 12:00:00')
            ),
            new Customer(
                Uuid::fromString('7fe8d7bb-5935-4e12-a5cf-45c281f7af00'),
                'Jane',
                new DateTimeImmutable('2022-06-01 12:00:00')
            ),
            new Customer(
                Uuid::fromString('a231f5fa-b781-4b79-9aea-85840ce71911'),
                'John',
                new DateTimeImmutable('2021-04-25 12:00:00')
            ),
            new Customer(
                Uuid::fromString('b874a8fe-2f00-40e7-b68a-ed368c3ef12b'),
                'Tina',
                new DateTimeImmutable('2020-02-03 12:00:00')
            ),
        ];
    }

    public function findById(UuidInterface $id): Customer
    {
        foreach ($this->customers as $customer) {
            if ($customer->id->equals($id)) {
                return $customer;
            }
        }

        throw new Exception('Not found');
    }

    public function findAll(): array
    {
        return $this->customers;
    }
}
