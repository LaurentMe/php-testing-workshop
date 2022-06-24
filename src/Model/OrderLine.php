<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop\Model;

use Money\Money;
use Ramsey\Uuid\UuidInterface;

class OrderLine
{
    public UuidInterface $productId;
    public int $amount;
    public Money $price;
}
