<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop\Model;

use DateTimeImmutable;
use Money\Money;
use Ramsey\Uuid\UuidInterface;

class Order
{
    public UuidInterface $id;
    public UuidInterface $customerId;
    /** @var OrderLine */
    public array $lines;
    public Money $discount;
    public DateTimeImmutable $refundedAt;
}
