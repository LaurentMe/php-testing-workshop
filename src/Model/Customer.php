<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop\Model;

use Ramsey\Uuid\UuidInterface;

class Customer
{
    public UuidInterface $id;
    public string $name;
}
