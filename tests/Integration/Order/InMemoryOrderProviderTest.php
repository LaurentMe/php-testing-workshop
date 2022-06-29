<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop\Integration\Order;

use Brammm\TestingWorkshop\InMemoryOrderProvider;
use Brammm\TestingWorkshop\Provider\OrderProvider;

final class InMemoryOrderProviderTest extends OrderProviderTest
{
    protected function getProvider(): OrderProvider
    {
        return new InMemoryOrderProvider();
    }
}
