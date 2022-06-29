<?php

namespace Brammm\TestingWorkshop\Unit\Model;

use Brammm\TestingWorkshop\Model\Order;
use Brammm\TestingWorkshop\Model\OrderLine;
use Money\Money;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class OrderTest extends TestCase
{
    /**
     * @dataProvider providesTestData
     */
    public function testItReturnsTotal(array $orderLines, Money $expectedDiscount): void
    {
        $order = new Order(
            Uuid::uuid4(),
            Uuid::uuid4(),
            $orderLines
        );

        self::assertEquals($expectedDiscount, $order->total());
    }

    /**
     * @return array<array{Orderline[], Money}>
     */
    public function providesTestData(): array
    {
        return [
            [
                [new OrderLine('Some product', 50, Money::EUR(5000))],
                Money::EUR(250000)
            ],
            [
                [
                    new OrderLine('Some product', 51, Money::EUR(50))
                ],
                Money::EUR(2550)
            ]
        ];
    }
}
