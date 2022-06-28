<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop\Unit\Discount;

use Brammm\TestingWorkshop\Discount\Calculator;
use Brammm\TestingWorkshop\Model\Order;
use Brammm\TestingWorkshop\Model\OrderLine;
use Money\Money;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class CalculatorTest extends TestCase
{
    /**
     * @dataProvider providesOrders
     */
    public function testItReturnsTheCorrectDiscount(Order $order, Money $expectedDiscount): void
    {
        $calculator = new Calculator();

        $actualDiscount = $calculator->calculateDiscount($order);

        self::assertEquals($expectedDiscount, $actualDiscount);
    }

    /**
     * @return array<array{Order, Money}>
     */
    public function providesOrders(): array
    {
        return [
            [
                new Order(
                    Uuid::uuid4(),
                    Uuid::uuid4(),
                    [
                        new OrderLine('Some product', 100, Money::EUR(1000)),
                    ]
                ),
                Money::EUR(10000),
            ],
            [
                new Order(
                    Uuid::uuid4(),
                    Uuid::uuid4(),
                    [
                        new OrderLine('Some product', 50, Money::EUR(1000)),
                    ]
                ),
                Money::EUR(0),
            ],
            [
                new Order(
                    Uuid::uuid4(),
                    Uuid::uuid4(),
                    [
                        new OrderLine('Some product', 50, Money::EUR(1000)),
                        new OrderLine('Some other product', 51, Money::EUR(500)),
                    ]
                ),
                Money::EUR(2550),
            ],
            [
                new Order(
                    Uuid::uuid4(),
                    Uuid::uuid4(),
                    [
                        new OrderLine('Some product', 51, Money::EUR(500)),
                        new OrderLine('Some other product', 100, Money::EUR(1000)),
                    ]
                ),
                Money::EUR(2550),
            ],
        ];
    }
}
