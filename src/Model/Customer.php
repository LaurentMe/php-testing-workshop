<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop\Model;

use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;

class Customer
{
    public function __construct(
        public UuidInterface $id,
        public string $name,
        public DateTimeImmutable $customerSince
    ) {
    }
}
