<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop;

use Brammm\TestingWorkshop\Model\Order;
use Brammm\TestingWorkshop\Model\OrderLine;
use Brammm\TestingWorkshop\Provider\OrderProvider;
use Exception;
use Money\Money;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class InMemoryOrderProvider implements OrderProvider
{
    /** @var Order[]  */
    private array $orders;

    public function __construct()
    {
        $this->orders = [
            new Order(
                Uuid::fromString('4c8e1ab4-bd81-43b1-aea8-0e0fb797b926'),
                Uuid::fromString('55943c45-a597-4c34-9a26-83f48fa659c6'),
                [
                    new OrderLine('Angle Connectors', 20, Money::EUR(100)),
                    new OrderLine('M4 Bolt', 80, Money::EUR(50)),
                    new OrderLine('M4 Nut', 80, Money::EUR(50)),
                ]
            ),
            new Order(
                Uuid::fromString('fd707e52-1ae3-4deb-9fdc-f81360e48d9e'),
                Uuid::fromString('b874a8fe-2f00-40e7-b68a-ed368c3ef12b'),
                [
                    new OrderLine('Screwdriver', 1, Money::EUR(1500)),
                ]
            ),
        ];
    }

    public function findById(UuidInterface $id): Order
    {
        foreach ($this->orders as $order) {
            if ($order->id->equals($id)) {
                return $order;
            }
        }

        throw new Exception('Not found');
    }

    public function findAll(): array
    {
        return $this->orders;
    }
}
