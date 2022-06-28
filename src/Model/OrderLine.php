<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop\Model;

use Money\Money;

class OrderLine
{
    public function __construct(
        public string $description,
        public int $amount,
        public Money $price,
    ) {
    }
}
