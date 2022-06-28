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
    public function testItReturnsTheCorrectDiscountIfMoreThanFifty(): void
    {
        $order = new Order(
            Uuid::uuid4(),
            Uuid::uuid4(),
            [
                new OrderLine(Uuid::uuid4(), 100, Money::EUR(1000)),
            ]
        );

        $calculator = new Calculator();

        $discount = $calculator->calculateDiscount($order);

        self::assertEquals(Money::EUR(10000), $discount);
    }

    public function testItReturnsNoDiscountOnFifty(): void
    {
        $order = new Order(
            Uuid::uuid4(),
            Uuid::uuid4(),
            [
                new OrderLine(Uuid::uuid4(), 50, Money::EUR(1000)),
            ]
        );

        $calculator = new Calculator();

        $discount = $calculator->calculateDiscount($order);

        self::assertEquals(Money::EUR(0), $discount);
    }
}
