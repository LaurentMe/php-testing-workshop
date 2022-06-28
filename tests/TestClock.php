<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop;

use Brammm\TestingWorkshop\Clock\Clock;
use DateTimeImmutable;
use InvalidArgumentException;

final class TestClock implements Clock
{
    private ?DateTimeImmutable $now = null;

    public function setNow(DateTimeImmutable $now): void
    {
        $this->now = $now;
    }

    public function now(): DateTimeImmutable
    {
        if (!$this->now) {
            throw new InvalidArgumentException('Now not set yet');
        }

        return $this->now;
    }
}
