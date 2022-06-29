<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop\Integration\Order;

use Brammm\TestingWorkshop\Provider\OrderProvider;
use Exception;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

abstract class OrderProviderTest extends TestCase
{
    abstract protected function getProvider(): OrderProvider;

    public function testItFindsAllCustomers(): void
    {
        $orders = $this->getProvider()->findAll();

        self::assertCount(2, $orders);
    }

    public function testItFindsCustomerById(): void
    {
        $order = $this->getProvider()->findById(Uuid::fromString('4c8e1ab4-bd81-43b1-aea8-0e0fb797b926'));

        self::assertCount(3, $order->lines);
    }

    public function testItThrowsExceptionIfNotFound(): void
    {
        $this->expectException(Exception::class);
        $this->getProvider()->findById(Uuid::uuid4());
    }
}
