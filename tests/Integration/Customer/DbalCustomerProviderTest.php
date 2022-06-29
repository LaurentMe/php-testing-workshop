<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop\Integration\Customer;

use Brammm\TestingWorkshop\Integration\Customer\CustomerProviderTest;
use Brammm\TestingWorkshop\Integration\ProvidesIntegrationTestConnection;
use Brammm\TestingWorkshop\Provider\CustomerProvider;
use Brammm\TestingWorkshop\Provider\DbalCustomerProvider;

final class DbalCustomerProviderTest extends CustomerProviderTest
{
    use ProvidesIntegrationTestConnection;

    protected function getProvider(): CustomerProvider
    {
        return new DbalCustomerProvider($this->getConnection());
    }
}
