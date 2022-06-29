<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop\Integration\Customer;

use Brammm\TestingWorkshop\InMemoryCustomerProvider;
use Brammm\TestingWorkshop\Integration\Customer\CustomerProviderTest;
use Brammm\TestingWorkshop\Provider\CustomerProvider;

final class InMemoryCustomerProviderTest extends CustomerProviderTest
{
    protected function getProvider(): CustomerProvider
    {
        return new InMemoryCustomerProvider();
    }
}
