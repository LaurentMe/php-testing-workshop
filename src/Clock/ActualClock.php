<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop\Clock;

use DateInterval;
use DateTimeImmutable;

final class ActualClock implements Clock
{
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
