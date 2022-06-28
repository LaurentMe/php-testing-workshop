<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop\Discount;

use Brammm\TestingWorkshop\Clock\Clock;
use Brammm\TestingWorkshop\Model\Order;
use Brammm\TestingWorkshop\Model\OrderLine;
use Brammm\TestingWorkshop\Provider\CustomerProvider;
use DateInterval;
use Money\Money;

final class TrustedCustomerDiscount implements Discount
{
    public function __construct(
        private readonly CustomerProvider $customerProvider,
        private readonly Clock $clock
    ) {
    }

    public function calculate(Order $order): Money
    {
        $customer = $this->customerProvider->findById($order->customerId);

        if ($customer->customerSince > $this->clock->now()->sub(new DateInterval('P2Y'))) {
            return Money::EUR(0);
        }

        $total = array_reduce(
            $order->lines,
            fn (Money $total, OrderLine $line) => $total->add($line->price->multiply($line->amount)),
            Money::EUR(0)
        );

        return $total->multiply('0.2');
    }
}
