<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop\Integration\Order;

use Brammm\TestingWorkshop\Integration\ProvidesIntegrationTestConnection;
use Brammm\TestingWorkshop\Provider\DbalOrderProvider;
use Brammm\TestingWorkshop\Provider\OrderProvider;

final class DbalOrderProviderTest extends OrderProviderTest
{
    use ProvidesIntegrationTestConnection;

    protected function getProvider(): OrderProvider
    {
        return new DbalOrderProvider($this->getConnection());
    }
}
