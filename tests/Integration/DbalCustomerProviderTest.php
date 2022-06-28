<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop\Integration;

use Brammm\TestingWorkshop\Provider\DbalCustomerProvider;
use Exception;
use Ramsey\Uuid\Uuid;

final class DbalCustomerProviderTest extends IntegrationTestCase
{
    private DbalCustomerProvider $provider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->provider = new DbalCustomerProvider(self::$connection);
    }

    public function testItFindsAllCustomers(): void
    {
        $customers = $this->provider->findAll();

        self::assertCount(4, $customers);
        self::assertEquals('Bruce', $customers[0]->name);
        self::assertEquals('Jane', $customers[1]->name);
        self::assertEquals('John', $customers[2]->name);
        self::assertEquals('Tina', $customers[3]->name);
    }

    public function testItFindsCustomerById(): void
    {
        $customer = $this->provider->findById(Uuid::fromString('55943c45-a597-4c34-9a26-83f48fa659c6'));

        self::assertEquals('Bruce', $customer->name);
    }

    public function testItThrowsExceptionIfNotFound(): void
    {
        $this->expectException(Exception::class);
        $this->provider->findById(Uuid::uuid4());
    }
}
