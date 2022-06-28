<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop\Unit\Discount;

use Brammm\TestingWorkshop\Discount\TrustedCustomerDiscount;
use Brammm\TestingWorkshop\Model\Customer;
use Brammm\TestingWorkshop\Model\Order;
use Brammm\TestingWorkshop\Model\OrderLine;
use Brammm\TestingWorkshop\Provider\CustomerProvider;
use Brammm\TestingWorkshop\TestClock;
use DateTimeImmutable;
use Money\Money;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class TrustedCustomerDiscountTest extends TestCase
{
    private CustomerProvider|MockObject $customerProvider;

    private TestClock $clock;

    protected function setUp(): void
    {
        $this->customerProvider = $this->createMock(CustomerProvider::class);
        $this->clock            = new TestClock();
    }

    public function testItReturnsZeroOnNewCustomers(): void
    {
        $discount = new TrustedCustomerDiscount(
            $this->customerProvider,
            $this->clock,
        );

        $customerId = Uuid::uuid4();

        $this->customerProvider->expects($this->once())
            ->method('findById')
            ->willReturn(new Customer(
                $customerId,
                'John',
                new DateTimeImmutable('2022-06-28')
            ));
        $this->clock->setNow(new DateTimeImmutable('2022-06-29'));

        $discount = $discount->calculate(new Order(
            Uuid::uuid4(),
            $customerId,
            [
                new OrderLine(Uuid::uuid4(), 1, Money::EUR(15000)),
            ]
        ));

        self::assertEquals(Money::EUR(0), $discount);
    }

    public function testItReturnsDiscountForTrustedCustomers(): void
    {
        $discount = new TrustedCustomerDiscount(
            $this->customerProvider,
            $this->clock,
        );

        $customerId = Uuid::uuid4();

        $this->customerProvider->expects($this->once())
            ->method('findById')
            ->willReturn(new Customer(
                $customerId,
                'John',
                new DateTimeImmutable('2020-06-28')
            ));
        $this->clock->setNow(new DateTimeImmutable('2022-06-29'));

        $discount = $discount->calculate(new Order(
            Uuid::uuid4(),
            $customerId,
            [
                new OrderLine(Uuid::uuid4(), 1, Money::EUR(15000)),
            ]
        ));

        self::assertEquals(Money::EUR(3000), $discount);
    }
}
