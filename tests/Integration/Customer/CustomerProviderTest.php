<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop\Integration\Customer;

use Brammm\TestingWorkshop\Provider\CustomerProvider;
use Exception;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

abstract class CustomerProviderTest extends TestCase
{
    abstract protected function getProvider(): CustomerProvider;

    public function testItFindsAllCustomers(): void
    {
        $customers = $this->getProvider()->findAll();

        self::assertCount(4, $customers);
        self::assertEquals('Bruce', $customers[0]->name);
        self::assertEquals('Jane', $customers[1]->name);
        self::assertEquals('John', $customers[2]->name);
        self::assertEquals('Tina', $customers[3]->name);
    }

    public function testItFindsCustomerById(): void
    {
        $customer = $this->getProvider()->findById(Uuid::fromString('55943c45-a597-4c34-9a26-83f48fa659c6'));

        self::assertEquals('Bruce', $customer->name);
    }

    public function testItThrowsExceptionIfNotFound(): void
    {
        $this->expectException(Exception::class);
        $this->getProvider()->findById(Uuid::uuid4());
    }
}
