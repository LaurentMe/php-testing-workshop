<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop\Integration;

use Brammm\TestingWorkshop\Provider\DbalOrderProvider;
use Exception;
use Ramsey\Uuid\Uuid;

final class DbalOrderProviderTest extends IntegrationTestCase
{
    private DbalOrderProvider $provider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->provider = new DbalOrderProvider(self::$connection);
    }

    public function testItFindsAllCustomers(): void
    {
        $orders = $this->provider->findAll();

        self::assertCount(2, $orders);
    }

    public function testItFindsCustomerById(): void
    {
        $order = $this->provider->findById(Uuid::fromString('4c8e1ab4-bd81-43b1-aea8-0e0fb797b926'));

        self::assertCount(3, $order->lines);
    }

    public function testItThrowsExceptionIfNotFound(): void
    {
        $this->expectException(Exception::class);
        $this->provider->findById(Uuid::uuid4());
    }
}
